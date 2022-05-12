<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;

    //si quiero usar un nombre de tabla que no cumpla la convencion de nombres de laravel
    // protected $table = 'nombredelatabla';
    protected $primaryKey = 'idMarca'; //para usar un campo id, que no cumple con la convencion de laravel (id)
    public $timestamps = false; //para no usar los campos created_at y updated_ad, que usa laravel por defecto

}
