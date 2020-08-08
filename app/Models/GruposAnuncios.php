<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Campanhas;

class GruposAnuncios extends Model
{
    protected $table = "grupos_anuncios";

    protected $fillable = [
        "id_campanha",
        "id_fb",
        "nombre",
        "inicio",
        "fin",
        "evento_facturacion",
        "objetivo_facturacion",
        "presupuesto_diario",
        "created_at",
        "updated_at"
    ];

    public function getCampanha() {
        return $this->belongsTo(Campanhas::class, 'id_campanha');
    }
}
