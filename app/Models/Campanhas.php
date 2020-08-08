<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campanhas extends Model
{
    protected $table = "campanhas";

    protected $fillable = [
        "id_fb",
        "nombre",
        "objetivo",
        "created_at",
        "updated_at"
    ];
}
