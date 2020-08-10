<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use FacebookAds\Api;
use FacebookAds\Logger\CurlLogger;
use FacebookAds\Object\Ad;
use FacebookAds\Object\AdAccount;
use FacebookAds\Object\AdCreative;
use FacebookAds\Object\AdPreview;
use FacebookAds\Object\AdSet;
use FacebookAds\Object\Campaign;
use FacebookAds\Object\Fields\CampaignFields;

use App\Models\Parametros;

class FacebookController extends Controller
{

    // https://developers.facebook.com/docs/marketing-api/reference/ad-campaign-group/#Updating
    // https://developers.facebook.com/docs/marketing-apis/get-started/#campaign
    // https://developers.facebook.com/docs/marketing-api/campaign-structure

    public $access_token;
    public $ad_account_id;
    public $api;
    public $app_id;
    public $app_secret;
    public $page_id;

    public function __construct()
    {
        // Se consulta en la base de datos los datos de la conexión
        $this->access_token = Parametros::where("nombre", "access_token")->first()["valor"];
        $this->ad_account_id = Parametros::where("nombre", "ad_account_id")->first()["valor"];
        $this->app_secret = Parametros::where("nombre", "app_secret")->first()["valor"];
        $this->page_id = Parametros::where("nombre", "page_id")->first()["valor"];
        $this->app_id = Parametros::where("nombre", "app_id")->first()["valor"];
        // Inicializa la API
        $api = Api::init($this->app_id, $this->app_secret, $this->access_token);
        $api->setLogger(new CurlLogger());
    }
    /**
     * Ejecuta una función de la API la cual puede generar una excepción. Evita utilizar el try catch en cada método que ejecuta una acción con la API
     * @param array $data[function_call_back,message]
     *  function_call_back: Función a ejecutar dentro del try catch
     *  message: Mensaje a mostrar en caso de error
     */
    public function executeAction($data)
    {
        try {
            // Ejecuta la función de callback
            return $data["function_call_back"]();
        } catch (\Throwable $th) {
            dd($data["message"], $th);
        }
    }
}
