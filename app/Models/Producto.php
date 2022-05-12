<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $primaryKey = 'idProducto';//cambio el id predeterminado
    public $timestamps = false; //desactivo created_at y updated_at

    #### Metodos de relacion ######

    public function getMarca()
    {
        return $this->belongsTo(
            Marca::class,
            foreignKey: 'idMarca',
            ownerKey: 'idMarca'
        );
    }

    public function getCategoria()
    {
        return $this->belongsTo(
            Categoria::class,
            foreignKey: 'idCategoria',
            ownerKey: 'idCategoria'
        );
    }
}
