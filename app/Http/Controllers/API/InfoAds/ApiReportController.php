<?php

namespace App\Http\Controllers\API\InfoAds;

use App\Http\Controllers\API\FacebookController;
use Illuminate\Http\Request;

use FacebookAds\Object\AdAccount;
use FacebookAds\Object\Campaign;

class ApiReportController extends FacebookController
{
    public $level;
    public $since;
    public $until;

    public const LEVELS = [
        ["level" => "ad", "name" => "Anuncios"],
        ["level" => "campaign", "name" => "Campaña"],
        ["level" => "account", "name" => "Cuenta"],
        ["level" => "adset", "name" => "Grupo de Anuncios"],
    ];
    /**
     * Obtiene un reporte en base al nivel
     */
    public function getInsights()
    {
        $fields = array(
            'date_start',
            'date_stop',
            'account_id',
            'account_name',
            'campaign_name',
            'campaign_id',
        );
        $params = array(
            'time_range' => array('since' => $this->since, 'until' => $this->until),
            'filtering' => array(),
            'level' => $this->level,
            'breakdowns' => array(),
        );

        $data = [
            // Crea el grupo
            "function_call_back" => function () use ($fields, $params) {
                $report = (new AdAccount($this->ad_account_id))->getInsights(
                    $fields,
                    $params
                )->getResponse()->getContent();

                return $report;
            },
            "message" => "Error al generar el reporte",
        ];

        return $this->executeAction($data);
    }
}
