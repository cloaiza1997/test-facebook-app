<?php

namespace App\Http\Controllers\PromotePage;

use App\Http\Controllers\API\ApiAdSetController;
use App\Http\Controllers\API\ApiCampaignsController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\FunctionsController;
use App\Models\Campanhas;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    // Constante con la ruta de la carpeta de las vistas
    private const FOLDER = "promocionar-pagina.campanhas";
    /**
     * Muesta el listado de campañas creadas
     * @return view index Vista del listado de campañas
     */
    public function index()
    {
        $fb = new ApiCampaignsController();

        $campaigns = $fb->getCampaigns()["data"];

        for ($i = 0; $i < count($campaigns); $i++) {
            $campaign_db = Campanhas::where("id_fb", $campaigns[$i]["id"])->first();

            $campaigns[$i]["created_at"] = ($campaign_db) ? $campaign_db->created_at : "";
        }

        return view(self::FOLDER . ".index")->with([
            "campaigns" => $campaigns
        ]);
    }
    /**
     * @return view Muestra el formulario de creación
     */
    public function create()
    {
        $fb = new ApiCampaignsController();

        return view(self::FOLDER . ".crear")->with([
            "objectives" => $fb::OBJECTIVES
        ]);
    }
    /**
     * Elina una campaña
     * @param number $id Id de la campaña a eliminar
     */
    public function destroy($id)
    {
        // Se elimina de la API la campaña
        $fb = new ApiCampaignsController();
        $deleted = $fb->deleteCampaign($id);
        // + Se elimina de la base de datos
        if ($deleted) {
            $campaign = Campanhas::where("id_fb", $id)->first();
            $success = ($campaign) ? $campaign->delete() : false;
        } else {
            $success = false;
        }

        $data = [
            "success" => $success,
            "text" => "Eliminación de Campañana \"{$id}\"",
            "return_function" => function () {
                return redirect("campaign");
            }
        ];

        return FunctionsController::returnWithMessageValidation($data);
    }
    /**
     * @param number $id Id de la campaña a búsca
     * @return view Muestra una campaña seleccionada
     */
    public function edit($id)
    {
        // Se instancia obtienen los datos de la campaña a editar
        $fb_campaign = new ApiCampaignsController();
        $found = $fb_campaign->getCampaign($id);
        // + Campaña encontrada | - Campaña no encontrada
        if ($found) {
            // Se obtienen los grupos de la campaña
            $fb_ad_set = new AdSetController();
            // Se pasa el id de la campaña
            $fb_ad_set->id_campaign = $id;
            // Se obtienen los grupos de la campaña
            $ad_sets = $fb_ad_set->getAdSets();

            return view(self::FOLDER . ".ver")->with([
                "objectives" => $fb_campaign::OBJECTIVES,
                "campaign" => $fb_campaign->campaign,
                "ad_sets" => $ad_sets,
            ]);
        } else {
            return redirect("campaign");
        }
    }
    /**
     * Almacena una campaña en la API y en la base de datos
     * @param Request $request Datos recibidos por POST
     * @return route edit
     */
    public function store(Request $request)
    {
        $inputs = $request->all();
        $name = $inputs["name"];
        $objective = $inputs["objective"];
        // Crea la campaña con la API
        $fb = new ApiCampaignsController();
        $campaign = $fb->createCampaign($name, $objective);
        // + Campaña creada se guarda en la base de datos | - No creada
        if ($campaign) {

            $obj_campaign = new Campanhas();
            $obj_campaign->id_fb = $campaign->id;
            $obj_campaign->nombre = $name;
            $obj_campaign->objetivo = $objective;

            $success = $obj_campaign->save();

            $id = $campaign->id;
        } else {
            $id = "";
            $success = false;
        }

        $data = [
            "success" => $success,
            "text" => "Creación de Campañana \"{$id}\"",
            "return_function" => function () use ($id) {
                return redirect()->route("campaign.edit", $id);
            }
        ];

        return FunctionsController::returnWithMessageValidation($data);
    }
    /**
     * Actualiza una campaña en la API y en la base de datos
     * @param Request $request Datos recibidos por PUT
     * @return route edit
     */
    public function update(Request $request, $id)
    {
        $inputs = $request->all();
        $name = $inputs["name"];
        $objective = $inputs["objective"];

        $fb = new ApiCampaignsController();
        $updated = $fb->updateCampaign($id, $name, $objective);

        if ($updated) {
            $campaign = Campanhas::where("id_fb", $id)->first();
            $campaign->nombre = $name;
            $campaign->objetivo = $objective;
            $success = ($campaign) ? $campaign->save() : false;
        } else {
            $success = false;
        }

        $data = [
            "success" => $success,
            "text" => "Edición de Campañana \"{$id}\"",
            "return_function" => function () use ($id) {
                return redirect()->route("campaign.edit", $id);
            }
        ];

        return FunctionsController::returnWithMessageValidation($data);
    }
}
