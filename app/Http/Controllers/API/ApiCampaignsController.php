<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\FacebookController;
use FacebookAds\Object\AdAccount;

class ApiCampaignsController extends FacebookController
{
    public $campaign;
    // https://github.com/facebook/facebook-php-business-sdk/blob/master/src/FacebookAds/Object/Values/CampaignObjectiveValues.php?fbclid=IwAR2uSzt-n4uKajPyYHLvWx9C7n1-_FwO8R_kDnfUGN4rA0Jo8QN6GKzn0RY
    public const OBJECTIVES = [
        // 'APP_INSTALLS',
        // 'BRAND_AWARENESS',
        // 'CONVERSIONS',
        // 'EVENT_RESPONSES',
        // 'LEAD_GENERATION',
        // 'LINK_CLICKS',
        // 'MESSAGES',
        // 'OFFER_CLAIMS',
        'PAGE_LIKES',
        // 'POST_ENGAGEMENT',
        // 'REACH',
        // 'VIDEO_VIEWS'
        // ** Requieren otros parámetros
        // 'LOCAL_AWARENESS',
        // 'STORE_VISITS',
        // 'PRODUCT_CATALOG_SALES',
    ];
    /**
     * Crear campañas en la API
     * @param string $name Nombre de la campañas
     * @param const $objective Objetivo de la campaña
     * @return object Campaña creada
     */
    public function createCampaign($name, $objective)
    {
        $fields = array();
        $params = array(
            'name' => $name,
            'buying_type' => 'AUCTION',
            'objective' => $objective,
            'status' => 'PAUSED',
            'special_ad_categories' => '[]',
        );

        $data = [
            // Crea la campaña
            "function_call_back" => function () use ($fields, $params) {
                $campaign = (new AdAccount($this->ad_account_id))->createCampaign(
                    $fields,
                    $params
                );

                return $campaign;
            },
            "message" => "Error al crear la campaña {$name}",
        ];

        return $this->executeAction($data);
    }
    /**
     * Elimina una campaña seleccinoada
     * @param number $id Id de la campaña a eliminar
     * @return boolean $deleted Confirmación de la eliminación
     */
    public function deleteCampaign($id)
    {
        $found = $this->getCampaign($id);
        // + Campaña encontrada | - No encontrada
        if ($found) {

            $data = [
                // Elimina la campaña
                "function_call_back" => function () {
                    $this->campaign->delete();
                },
                "message" => "Error al eliminar la campaña",
            ];

            $this->executeAction($data);

            $deleted = true;
        } else {
            $deleted = false;
        }

        return $deleted;
    }
    /**
     * Obtiene una campaña en base a su ID
     * @param number $id Id de la campaña a búscar
     */
    public function getCampaign($id)
    {
        $found = false;
        // Se obtienen todas las campañas y se recibe un array de objetos
        $campaigns = $this->getCampaigns(true);
        // Se recrren las campañas para comparar con el id
        foreach ($campaigns as $campaign) {
            // + Campaña encontrada
            if ($campaign->id == $id) {
                // Se almacena en la variable de la clase
                $this->campaign = $campaign;
                $found = true;
            }
        }

        return $found;
    }
    /**
     * Consultar las campañas
     * @param  boolean $return_obj Si es verdadero el método retorna un objeto de lo contrario retorna un arreglo
     * @return object|array $list_campaigns Lista de campañas como objeto o arreglo
     */
    public function getCampaigns($return_obj = false)
    {
        // Campos a extraer
        $fields = array(
            'name',
            'objective',
        );
        $params = array(
            'effective_status' => array('ACTIVE', 'PAUSED'),
        );
        // Retorna el objeto
        $list_campaigns = (new AdAccount($this->ad_account_id))->getCampaigns(
            $fields,
            $params
        );
        // Retorna un arrego con los datos
        if (!$return_obj) {
            $list_campaigns = $list_campaigns->getResponse()->getContent();
        }

        return $list_campaigns;
    }
    /**
     * Actualiza una campaña en la API y la base de datos
     * @param number $id Id de la campaña actualizar
     * @param string $name Nombre de la campaña
     * @param string $objective Objetivo de la camapaña
     */
    public function updateCampaign($id, $name, $objective)
    {
        $found = $this->getCampaign($id);

        if ($found) {
            $fields = array();
            $params = array(
                'name' => $name,
                'objective' => $objective,
            );

            $data = [
                // Actualiza la campaña
                "function_call_back" => function () use ($fields, $params) {
                    $this->campaign->updateSelf($fields, $params);
                },
                "message" => "Error al editar la campaña {$name}",
            ];

            $this->executeAction($data);

            $updated = true;
        } else {
            $updated = false;
        }

        return $updated;
    }
}
