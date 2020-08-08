<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parametros extends Model
{
    protected $table = "parametros";

    protected $fillable = [
        "nombre",
        "valor",
        "created_at",
        "updated_at"
    ];
}
