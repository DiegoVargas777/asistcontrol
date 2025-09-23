<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Attendance;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\Test;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function puede_crear_un_usuario(): void
    {
        $user = User::factory()->create([
            'name' => 'Víctor Álvarez',
            'email' => 'victor@example.com',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'victor@example.com',
        ]);
    }

    #[Test]
    public function puede_generar_iniciales_correctas(): void
    {
        $user = User::factory()->make(['name' => 'Víctor Álvarez']);
        $this->assertEquals('VÁ', $user->initials());
    }

    #[Test]
    public function puede_relacionarse_con_asistencias(): void
    {
        $user = User::factory()->create();
        $attendance = Attendance::factory()->for($user)->create();

        $this->assertTrue($user->attendances->contains($attendance));
    }

    #[Test]
    public function atributos_fillable_permiten_asignacion_masiva(): void
    {
        $data = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'secret',
        ];

        $user = new User($data);

        $this->assertEquals('Test User', $user->name);
        $this->assertEquals('test@example.com', $user->email);
    }

    #[Test]
    public function atributos_hidden_no_se_serializan(): void
    {
        $user = User::factory()->make([
            'password' => 'secret',
            'remember_token' => 'token123',
        ]);

        $array = $user->toArray();

        $this->assertArrayNotHasKey('password', $array);
        $this->assertArrayNotHasKey('remember_token', $array);
    }

    #[Test]
    public function atributos_casts_funcionan_correctamente(): void
    {
        $user = User::factory()->make([
            'email_verified_at' => now(),
        ]);

        $this->assertInstanceOf(\Carbon\Carbon::class, $user->email_verified_at);
    }

    #[Test]
    public function puede_asignar_roles_con_spatie(): void
    {
        $role = Role::create(['name' => 'admin']);
        $user = User::factory()->create();

        $user->assignRole('admin');

        $this->assertTrue($user->hasRole('admin'));
    }
}