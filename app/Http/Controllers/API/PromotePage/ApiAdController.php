<?php

namespace App\Http\Controllers\API\PromotePage;

use App\Http\Controllers\API\PromotePage\ApiAdSetController;
use FacebookAds\Object\Ad;
use FacebookAds\Object\AdAccount;
use FacebookAds\Object\AdSet;
use Illuminate\Http\Request;

class ApiAdController extends ApiAdSetController
{
    public $ad;
    public $creative_id;
    public $id_ad_set;
    public $name;
    /**
     * Crea un anuncio en la API
     */
    public function createAd()
    {
        $fields = array();
        $params = array(
            'name' => $this->name,
            'adset_id' => $this->id_ad_set,
            'creative' => array('creative_id' => $this->creative_id),
            'status' => 'PAUSED',
        );

        $data = [
            // Crea el grupo
            "function_call_back" => function () use ($fields, $params) {
                $this->ad = (new AdAccount($this->ad_account_id))->createAd(
                    $fields,
                    $params
                );
                return ($this->ad) ? true : false;
            },
            "message" => "Error al crear el anuncio {$this->name}",
        ];

        return $this->executeAction($data);
    }
    /**
     * Elimina un anuncio de la API
     */
    public function delete($id)
    {
        (new Ad($id))->deleteSelf(
            [],
            []
        );
    }
    /**
     * Obtiene el listado de anuncios de una grupo
     * @param boolean $return_obj Indica si se retorna un objeto o un arreglo
     */
    public function getAds($return_obj = false)
    {
        $fields = array(
            "name",
            "creative"
        );
        $params = array();
        $list_ads = (new AdSet($this->ad_set->id))->getAds(
            $fields,
            $params
        );

        // Retorna un arrego con los datos
        if (!$return_obj) {
            $list_ads = $list_ads->getResponse()->getContent();
        }

        return $list_ads;
    }
    /**
     * Obtiene la vista previa del anuncio
     * @param number $id Id del anuncio a mostrar
     */
    function getPreviews($id)
    {
        $fields = array();
        $params = array(
            'ad_format' => 'DESKTOP_FEED_STANDARD',
        );
        $response = (new Ad($id))->getPreviews(
            $fields,
            $params
        )->getResponse()->getContent();

        return $response;
    }
}
