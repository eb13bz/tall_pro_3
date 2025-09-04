<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_completo',
        'cedula_nit',
        'direccion',
        'telefono',
        'correo_electronico',
    ];

    /**
     * Un cliente puede tener muchas ventas.
     */
    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }
}
