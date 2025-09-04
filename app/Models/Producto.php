<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo_unico',
        'nombre',
        'descripcion',
        'categoria_id',
        'precio_unitario',
        'stock_actual',
        'unidad_medida',
        'proveedor',
    ];

    // Definir la relación con la categoría
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    /**
     * Un producto puede estar en muchos detalles de venta.
     */
    public function detallesVenta()
    {
        return $this->hasMany(DetalleVenta::class);
    }
}