<?php

namespace App\Http\Controllers\InfoAds;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\InfoAds\ApiReportController;

class ReportController extends Controller
{
    // Constante con la ruta de la carpeta de las vistas
    private const FOLDER = "informes-anuncios";
    public function create(){

        $fb = new ApiReportController();

        return view(self::FOLDER . ".crear")->with([
            "levels" => $fb::LEVELS
        ]);
    }
    /**
     * Genera el reporte
     */
    public function store(Request $request) {
        $inputs = $request->all();

        $fb = new ApiReportController();
        $fb->level = $inputs["level"];
        $fb->since = $inputs["since"];
        $fb->until = $inputs["until"];

        $report = $fb->getInsights();

        dd("Reporte", $report);
    }
}
