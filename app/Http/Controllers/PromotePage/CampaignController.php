<?php

namespace App\Http\Controllers\PromotePage;

use App\Http\Controllers\API\ApiCampaignsController;
use App\Http\Controllers\Controller;
use App\Models\Campanhas;
use FacebookAds\Object\AdAccount;
use Illuminate\Http\Request;

use App\Http\Controllers\Helpers\FunctionsController;

use Facebook\FacebookResponse;

class CampaignController extends Controller
{

    private const FOLDER = "promocionar-pagina";
    // https://github.com/facebook/facebook-php-business-sdk/blob/master/src/FacebookAds/Object/Values/CampaignObjectiveValues.php?fbclid=IwAR2uSzt-n4uKajPyYHLvWx9C7n1-_FwO8R_kDnfUGN4rA0Jo8QN6GKzn0RY
    private $objectives = [
        // 'APP_INSTALLS',
        // 'BRAND_AWARENESS',
        // 'CONVERSIONS',
        // 'EVENT_RESPONSES',
        // 'LEAD_GENERATION',
        'LINK_CLICKS',
        // 'LOCAL_AWARENESS',
        // 'MESSAGES',
        // 'OFFER_CLAIMS',
        'PAGE_LIKES',
        // 'POST_ENGAGEMENT',
        // 'PRODUCT_CATALOG_SALES',
        // 'REACH',
        // 'STORE_VISITS',
        // 'VIDEO_VIEWS'
    ];

    public function index()
    {
        $fb = new ApiCampaignsController();

        $campaigns = $fb->getCampaigns()["data"];

        for ($i = 0; $i < count($campaigns); $i++) {
            $campaign_db = Campanhas::where("id_fb", $campaigns[$i]["id"])->first();

            $campaigns[$i]["created_at"] = ($campaign_db) ? $campaign_db->created_at : "";
        }

        return view(self::FOLDER . ".campanhas.index")->with([
            "campaigns" => $campaigns
        ]);
    }
    /**
     * @return view Muestra el formulario de creación
     */
    public function create()
    {
        return view(self::FOLDER . ".campanhas.crear")->with([
            "objectives" => $this->objectives
        ]);
    }
    /**
     * Elina una campaña
     * @param number $id Id de la campaña a eliminar
     */
    public function delete($id)
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
            "return_function" => function () use ($id) {
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
        $fb = new ApiCampaignsController();
        $found = $fb->getCampaign($id);

        if ($found) {
            return view(self::FOLDER . ".campanhas.ver")->with([
                "objectives" => $this->objectives,
                "campaign" => $fb->campaign
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
