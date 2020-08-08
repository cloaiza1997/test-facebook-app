<?php

namespace App\Http\Controllers\PromotePage;

use App\Http\Controllers\API\ApiAdSetController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\FunctionsController;
use App\Models\Campanhas;
use App\Models\GruposAnuncios;
use Illuminate\Http\Request;

class AdSetController extends Controller
{
    private const FOLDER = "promocionar-pagina.adsets";

    private const BILLING_EVENTS = [
        'APP_INSTALLS',
        'CLICKS',
        'IMPRESSIONS',
        'LINK_CLICKS',
        'NONE',
        'OFFER_CLAIMS',
        'PAGE_LIKES',
        'POST_ENGAGEMENT',
        'THRUPLAY',
    ];

    private const OPTIMIZATION_GOALS = [
        'AD_RECALL_LIFT',
        'APP_DOWNLOADS',
        'APP_INSTALLS',
        'BRAND_AWARENESS',
        'CLICKS',
        'DERIVED_EVENTS',
        'ENGAGED_USERS',
        'EVENT_RESPONSES',
        'IMPRESSIONS',
        'LANDING_PAGE_VIEWS',
        'LEAD_GENERATION',
        'LINK_CLICKS',
        'NONE',
        'OFFER_CLAIMS',
        'OFFSITE_CONVERSIONS',
        'PAGE_ENGAGEMENT',
        'PAGE_LIKES',
        'POST_ENGAGEMENT',
        'QUALITY_LEAD',
        'REACH',
        'REPLIES',
        'SOCIAL_IMPRESSIONS',
        'THRUPLAY',
        'TWO_SECOND_CONTINUOUS_VIDEO_VIEWS',
        'VALUE',
        'VISIT_INSTAGRAM_PROFILE',
    ];

    public function show($id_campaign)
    {
        $fb = new ApiAdSetController();
        $fb->getCampaign($id_campaign);

        return view(self::FOLDER . ".crear")->with([
            "campaign" => $fb->campaign,
            "billing_events" => self::BILLING_EVENTS,
            "optimization_goals" => self::OPTIMIZATION_GOALS,
        ]);
    }

    public function store(Request $request)
    {
        $inputs = $request->all();

        $fb = new ApiAdSetController();

        $fb->id_campaign = $inputs["id_campaign"];
        $fb->name = $inputs["name"];
        $fb->start_time = $inputs["start_time"];
        $fb->end_time = $inputs["end_time"];
        $fb->billing_event = $inputs["billing_event"];
        $fb->optimization_goal = $inputs["optimization_goal"];
        $fb->daily_budget = $inputs["daily_budget"];

        $success = $fb->createAdSet();

        if ($success) {

            $id_ad = $fb->ad_set->id;
            $id_campaign = $fb->id_campaign;

            $campaign = Campanhas::where("id_fb", $fb->id_campaign)->first();

            $obj_ad_set = new GruposAnuncios();

            $obj_ad_set->id_fb = $id_ad;
            $obj_ad_set->id_campanha = $campaign->id;
            $obj_ad_set->nombre = $fb->name;
            $obj_ad_set->inicio = $fb->start_time;
            $obj_ad_set->fin = $fb->end_time;
            $obj_ad_set->evento_facturacion = $fb->billing_event;
            $obj_ad_set->objetivo_optimizacion = $fb->optimization_goal;
            $obj_ad_set->presupuesto_diario = $fb->daily_budget;

            $success = $obj_ad_set->save();

        } else {
            $id_ad = "";
            $id_campaign = "";
        }

        $data = [
            "success" => $success,
            "text" => "Creación de Grupo de Anuncios \"{$id_ad}\"",
            "return_function" => function () use ($id_campaign) {
                return redirect()->route("ad-set.show", $id_campaign);
            }
        ];

        return FunctionsController::returnWithMessageValidation($data);
    }
}
