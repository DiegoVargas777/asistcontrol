<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'attendances'; // asegúrate de usar plural

    protected $fillable = [
        'user_id',
        'date',
        'check_in',
        'check_out',
    ];

    /**
     * Relación: una asistencia pertenece a un usuario
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 🔍 Scopes útiles para reportes

    // Entradas después de las 09:30
    public function scopeLate($query)
    {
        return $query->where('check_in', '>', '09:30:00');
    }

    // Salidas antes de las 17:30
    public function scopeEarlyLeaves($query)
    {
        return $query->where('check_out', '<', '17:30:00');
    }
}
