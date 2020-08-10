<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contenido extends Model
{
    protected $table = "contenido";

    protected $fillable = [
        "id_fb",
        "nombre",
        "titulo",
        "url_imagen",
        "cuerpo",
        "id_publicacion",
    ];
}
