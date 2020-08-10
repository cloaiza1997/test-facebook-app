<?php

namespace App\Http\Controllers\PromotePage;

use App\Http\Controllers\API\ApiAdController;
use App\Http\Controllers\API\ApiAdSetController;
use App\Http\Controllers\API\ApiAdCreativeController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\FunctionsController;
use App\Models\Campanhas;
use App\Models\GruposAnuncios;
use Illuminate\Http\Request;

class AdSetController extends Controller
{
    // Constante con la ruta de la carpeta de las vistas
    private const FOLDER = "promocionar-pagina.adsets";
    /**
     * Elimina la campaña de la API y la base de datos
     * @param string $id[id_campaign-id_ad_set] Cadena de texto que concatena el id de la campaña con el del grupo
     */
    public function destroy($id)
    {
        // Se divide la cadena
        $param = explode("-", $id);
        // Se extrae el id de la campaña que viene de la url
        $id_campaign = $param[0];
        $id_ad_set = $param[1];
        // Se elimina de la API la campaña
        $fb = new ApiAdSetController();
        $fb->id_campaign = $id_campaign;
        $deleted = $fb->deleteAdSet($id_ad_set);
        // + Se ha eliminado de la API y se elimina de la base de datos
        if ($deleted) {
            // Se obtiene el grupo de la base de datos
            $ad_set = GruposAnuncios::where("id_fb", $id_ad_set)->first();
            $success = ($ad_set) ? $ad_set->delete() : false;
        } else {
            $success = false;
        }

        $data = [
            "success" => $success,
            "text" => "Eliminación de Grupo \"{$id_ad_set}\"",
            "return_function" => function () use ($id_campaign) {
                return redirect()->route("campaign.edit", $id_campaign);
            }
        ];

        return FunctionsController::returnWithMessageValidation($data);
    }
    /**
     * Muestra la vista de edición de grupo
     * @param string $id[id_campaign-id_ad_set] Cadena de texto que concatena el id de la campaña con el del grupo
     */
    public function edit($id)
    {
        // Se divide la cadena
        $param = explode("-", $id);
        // Se extrae el id de la campaña que viene de la url
        $id_campaign = $param[0];
        $id_ad_set = $param[1];
        // Se instancia la clase del API del anuncio que hereda de Ad_Set y Ad_Set de Campaign
        $fb = new ApiAdController();
        // Se pasa el id de la campaña
        $fb->id_campaign = $id_campaign;
        // Se obtiene la campaña a la que pertenece el grupo
        $fb->getCampaign($id_campaign);
        $fb->getAdSet($id_ad_set);
        // De la fecha se obtiene solo se obtiene el YYYY-MM-DD
        $fb->ad_set->start_time = explode("T", $fb->ad_set->start_time)[0];
        $fb->ad_set->end_time = explode("T", $fb->ad_set->end_time)[0];
        // Se obtiene el listado de anuncios del grupo
        $ads = $fb->getAds()["data"];
        // Se extraen los contenidos
        $ad_creatives = (new ApiAdCreativeController())->getAdCreatives()["data"];

        Session()->put("url-back", "{$fb->campaign->id}-{$fb->ad_set->id}");

        return view(self::FOLDER . ".ver")->with([
            "campaign" => $fb->campaign,
            "ad_set" => $fb->ad_set,
            "ads" => $ads,
            "ad_creatives" => $ad_creatives,
            "billing_events" => $fb::BILLING_EVENTS,
            "optimization_goals" => $fb::OPTIMIZATION_GOALS,
        ]);
    }
    /**
     * Obtiene el listado de todos los grupos relacionados a una campaña
     */
    public function getAdSets()
    {
        // Conexión con la API
        $fb = new ApiAdSetController();
        // Se pasa el id de la campaña
        $fb->id_campaign = $this->id_campaign;
        // Se obtienen los grupos
        $ad_sets = $fb->getAdSets()["data"];
        // Se recorren los grupos para añadir la fecha de creación en la base de datos
        for ($i = 0; $i < count($ad_sets); $i++) {
            $ad_set_db = GruposAnuncios::where("id_fb", $ad_sets[$i]["id"])->first();
            $ad_sets[$i]["created_at"] = ($ad_set_db) ? $ad_set_db->created_at : "";
        }

        return $ad_sets;
    }
    /**
     * Muestra el formulario de creación del grupo de anuncios
     * @param number $id_campaign Id de la campaña a la que debe de pertenecer el grupo
     * @return view Formulario de creación
     */
    public function show($id_campaign)
    {
        $fb = new ApiAdSetController();
        // Se obtiene la campaña a la que pertenece el grupo
        $fb->getCampaign($id_campaign);

        return view(self::FOLDER . ".crear")->with([
            "campaign" => $fb->campaign,
            "billing_events" => $fb::BILLING_EVENTS,
            "optimization_goals" => $fb::OPTIMIZATION_GOALS,
        ]);
    }
    /**
     * Se almacena un grupo de avisos en la API y en la base de datos
     * @param Request $request Datos del formulario
     */
    public function store(Request $request)
    {
        $inputs = $request->all();
        // Se instancia la clase
        $fb = new ApiAdSetController();
        // Se pasan los datos a la clase
        $fb->id_campaign = $id_campaign = $inputs["id_campaign"];
        $fb->name = $inputs["name"];
        $fb->start_time = $inputs["start_time"];
        $fb->end_time = $inputs["end_time"];
        $fb->billing_event = $inputs["billing_event"];
        $fb->optimization_goal = $inputs["optimization_goal"];
        $fb->daily_budget = $inputs["daily_budget"];

        $success = $fb->createAdSet();
        // + Grupo creado en la API | - Grupo no creado
        if ($success) {
            // Se obtienen los id
            $id_ad = $fb->ad_set->id;
            // Se busca la campaña en la base de datos
            $campaign = Campanhas::where("id_fb", $id_campaign)->first();
            // Se crea el objeto del grupo
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
        }

        $data = [
            "success" => $success,
            "text" => "Creación de Grupo de Anuncios \"{$id_ad}\"",
            "return_function" => function () use ($id_campaign, $id_ad) {
                return redirect()->route("ad-set.edit", "$id_campaign-$id_ad");
            }
        ];

        return FunctionsController::returnWithMessageValidation($data);
    }
    /**
     * Actualiza un grupo de avisos en la API y en la base de datos
     * @param Request $request Datos del formulario
     */
    public function update(Request $request, $id)
    {
        $inputs = $request->all();
        // Se instancia la clase
        $fb = new ApiAdSetController();
        // Se pasan los datos a la clase
        $fb->id_campaign = $id_campaign = $inputs["id_campaign"];
        $fb->name = $inputs["name"];
        $fb->start_time = $inputs["start_time"];
        $fb->end_time = $inputs["end_time"];
        $fb->billing_event = $inputs["billing_event"];
        $fb->optimization_goal = $inputs["optimization_goal"];
        $fb->daily_budget = $inputs["daily_budget"];

        $success = $fb->updateAdSet($id);
        // + Grupo creado en la API. Se crea en la base de datos
        if ($success) {
            // Se búsca el objeto
            $ad_set = GruposAnuncios::where("id_fb", $id)->first();
            // Se actualizan los campos
            $ad_set->nombre = $fb->name;
            $ad_set->inicio = $fb->start_time;
            $ad_set->fin = $fb->end_time;
            $ad_set->evento_facturacion = $fb->billing_event;
            $ad_set->objetivo_optimizacion = $fb->optimization_goal;
            $ad_set->presupuesto_diario = $fb->daily_budget;

            $success = $ad_set->save();
        }

        $data = [
            "success" => $success,
            "text" => "Actualización de Grupo de Anuncios \"{$id}\"",
            "return_function" => function () use ($id_campaign, $id) {
                return redirect()->route("ad-set.edit", "$id_campaign-$id");
            }
        ];

        return FunctionsController::returnWithMessageValidation($data);
    }
}
