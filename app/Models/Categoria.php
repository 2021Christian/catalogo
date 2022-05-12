<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $primaryKey = 'idCategoria'; //cuando no uso un campo 'id' como PK
    public $timestamps = false; //para no usar los campos created_at y updated_at
}
