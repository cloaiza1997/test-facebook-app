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


    public function createAdCreative($id_post)
    {
        $fields = array();
        $params = array(
            'name' => 'My Creative',
            'object_story_id' => self::PAGE_ID . "_" . $id_post,
            'title' => 'My Page Like Ad',
            'body' => 'Like My Page',
            'image_url' => 'https://lh3.googleusercontent.com/ogw/ADGmqu92J_XEZey-4rOcy8dB637oHg6gfRG7b7QKTQhb=s83-c-mo',
        );
        $creative = (new AdAccount(self::AD_ACCOUNT_ID))->createAdCreative(
            $fields,
            $params
        );
        return $creative;
    }

    public function createAd($ad_set_id, $creative_id)
    {
        $fields = array();
        $params = array(
            'name' => 'My Ad',
            'adset_id' => $ad_set_id,
            'creative' => array('creative_id' => $creative_id),
            'status' => 'PAUSED',
        );
        $ad = (new AdAccount(self::AD_ACCOUNT_ID))->createAd(
            $fields,
            $params
        );
        return $ad;
    }

    function getPreviews($ad_id)
    {
        $fields = array();
        $params = array(
            'ad_format' => 'DESKTOP_FEED_STANDARD',
        );
        $response = json_encode((new Ad($ad_id))->getPreviews(
            $fields,
            $params
        )->getResponse()->getContent(), JSON_PRETTY_PRINT);

        return $response;
    }
}
