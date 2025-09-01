<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = ['cliente_id', 'user_id', 'subtotal', 'descuentos', 'total', 'estado'];

    // Una venta pertenece a un cliente (opcional)
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    // Una venta pertenece a un usuario (quien la registró)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Una venta tiene muchos detalles de venta
    public function detalles()
    {
        return $this->hasMany(DetalleVenta::class);
    }
}
