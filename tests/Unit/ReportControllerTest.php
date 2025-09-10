<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\reportController;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Mockery;
use PHPUnit\Framework\Attributes\Test;

class ReportControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function report_general_devuelve_vista_reporte_con_todos_los_registros(): void
    {
        $user = User::factory()->create();
        Attendance::factory()->for($user)->count(3)->create([
            'date'      => Carbon::today()->format('Y-m-d'),
            'check_in'  => '08:00:00',
            'check_out' => '18:00:00',
        ]);

        $request    = Request::create('/report', 'GET', []);
        $controller = new reportController();
        $view       = $controller->report($request);

        $this->assertEquals('reporte', $view->name());
        $data = $view->getData();
        $this->assertCount(3, $data['attendances']);
        $this->assertCount(1, $data['users']);
        $this->assertEquals('general', $data['tipo'] ?? 'general');
        $this->assertEmpty($data['inasistencias']);
    }

    #[Test]
    public function report_filtra_atrasos_check_in_mayor_0930(): void
    {
        $user = User::factory()->create();
        Attendance::factory()->for($user)->create(['check_in' => '10:00:00']);
        Attendance::factory()->for($user)->create(['check_in' => '09:00:00']);

        $request    = Request::create('/report', 'GET', ['tipo' => 'atrasos']);
        $controller = new reportController();
        $view       = $controller->report($request);

        $att = $view->getData()['attendances'];
        $this->assertCount(1, $att);
        $this->assertEquals('10:00:00', $att->first()->check_in);
    }

    #[Test]
    public function report_filtra_salidas_check_out_menor_1730(): void
    {
        $user = User::factory()->create();
        Attendance::factory()->for($user)->create(['check_out' => '17:00:00']);
        Attendance::factory()->for($user)->create(['check_out' => '18:00:00']);

        $request    = Request::create('/report', 'GET', ['tipo' => 'salidas']);
        $controller = new reportController();
        $view       = $controller->report($request);

        $att = $view->getData()['attendances'];
        $this->assertCount(1, $att);
        $this->assertEquals('17:00:00', $att->first()->check_out);
    }

    #[Test]
    public function report_detecta_inasistencias_en_rango_de_fechas_para_un_usuario(): void
    {
        $user = User::factory()->create();
        Attendance::factory()->for($user)->create(['date' => '2025-09-01']);

        $params = [
            'query'       => $user->id,
            'fechaInicio' => '2025-09-01',
            'fechaFin'    => '2025-09-03',
            'tipo'        => 'inasistencias',
        ];
        $request    = Request::create('/report', 'GET', $params);
        $controller = new reportController();
        $view       = $controller->report($request);

        $inas = $view->getData()['inasistencias'];
        $this->assertCount(2, $inas);
        $fechas = $inas->pluck('date')->all();
        $this->assertContains('2025-09-02', $fechas);
        $this->assertContains('2025-09-03', $fechas);
    }

#[Test]
public function exportpdf_llama_pdf_download_con_nombre_correcto(): void
{
    $user = User::factory()->create();
    Attendance::factory()->for($user)->count(2)->create();

    // Crear un mock parcial del facade
    Pdf::partialMock()
        ->shouldReceive('loadView')
        ->once()
        ->with('report-pdf', \Mockery::type('array'))
        ->andReturnSelf();

    Pdf::shouldReceive('download')
        ->once()
        ->with('reporte_asistencia.pdf')
        ->andReturn(new Response('PDF-CONTENT', 200, [
            'Content-Disposition' => 'attachment; filename=reporte_asistencia.pdf',
            'Content-Type'        => 'application/pdf',
        ]));

    $params     = ['query' => $user->id];
    $request    = Request::create('/export-pdf', 'GET', $params);
    $controller = new reportController();
    $response   = $controller->exportPdf($request);

    $this->assertEquals(200, $response->getStatusCode());
    $this->assertEquals('PDF-CONTENT', $response->getContent());
    $this->assertEquals('attachment; filename=reporte_asistencia.pdf', $response->headers->get('Content-Disposition'));
    $this->assertEquals('application/pdf', $response->headers->get('Content-Type'));
}

}