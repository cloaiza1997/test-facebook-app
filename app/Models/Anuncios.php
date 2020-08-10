<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anuncios extends Model
{
    protected $table = "anuncios";

    protected $fillable = [
        "id_fb",
        "id_grupo",
        "id_contenido",
        "nombre"
    ];
}
