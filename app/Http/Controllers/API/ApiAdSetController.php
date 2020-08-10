<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\ApiCampaignsController;
use DateTime;
use FacebookAds\Object\AdAccount;
use FacebookAds\Object\Campaign;

class ApiAdSetController extends ApiCampaignsController
{
    public $ad_set;
    public $billing_event;
    public $daily_budget;
    public $end_time;
    public $id_campaign;
    public $name;
    public $optimization_goal;
    public $start_time;
    // Constante de los eventos de facturación
    public const BILLING_EVENTS = [
        // 'APP_INSTALLS',
        // 'CLICKS',
        'IMPRESSIONS',
        // 'LINK_CLICKS',
        // 'NONE',
        // 'OFFER_CLAIMS',
        // 'PAGE_LIKES',
        // 'POST_ENGAGEMENT',
        // 'THRUPLAY',
    ];
    // Constante de los objetivos de optimización
    public const OPTIMIZATION_GOALS = [
        // 'AD_RECALL_LIFT',
        // 'APP_DOWNLOADS',
        // 'APP_INSTALLS',
        // 'BRAND_AWARENESS',
        // 'CLICKS',
        // 'DERIVED_EVENTS',
        // 'ENGAGED_USERS',
        // 'EVENT_RESPONSES',
        // 'IMPRESSIONS',
        // 'LANDING_PAGE_VIEWS',
        // 'LEAD_GENERATION',
        // 'LINK_CLICKS',
        // 'NONE',
        // 'OFFER_CLAIMS',
        // 'OFFSITE_CONVERSIONS',
        // 'PAGE_ENGAGEMENT',
        'PAGE_LIKES',
        // 'POST_ENGAGEMENT',
        // 'QUALITY_LEAD',
        // 'REACH',
        // 'REPLIES',
        // 'SOCIAL_IMPRESSIONS',
        // 'THRUPLAY',
        // 'TWO_SECOND_CONTINUOUS_VIDEO_VIEWS',
        // 'VALUE',
        // 'VISIT_INSTAGRAM_PROFILE',
    ];
    /**
     * Crea el grupo de anuncios ligado a una campaña
     */
    public function createAdSet()
    {
        // 2019-12-12T23:41:41-0800
        // $start_time = (new \DateTime("+1 week"))->format(DateTime::ISO8601);
        // $end_time = (new \DateTime("+2 week"))->format(DateTime::ISO8601);
        $fields = array();
        $params = array(
            'campaign_id' => $this->id_campaign,
            'name' => $this->name,
            'start_time' => $this->start_time . "T00:00:00-0500",
            'end_time' => $this->end_time . "T00:00:00-0500",
            'optimization_goal' => $this->optimization_goal,
            'billing_event' => $this->billing_event,
            'daily_budget' => $this->daily_budget,
            'bid_amount' => '20',
            'promoted_object' => array('page_id' =>  $this->page_id),
            // 'promoted_object' => array('page_id' => self::PAGE_ID),
            'targeting' => array('geo_locations' => array('countries' => array('US'))),
            'status' => 'PAUSED',
        );

        $data = [
            // Crea el grupo
            "function_call_back" => function () use ($fields, $params) {
                $this->ad_set = (new AdAccount($this->ad_account_id))->createAdSet(
                    $fields,
                    $params
                );
                return ($this->ad_set) ? true : false;
            },
            "message" => "Error al crear el grupo de anuncios {$this->name}",
        ];

        return $this->executeAction($data);
    }
    /**
     * Elimina un grupo
     * @param number $id Id del grupo a eliminar
     */
    public function deleteAdSet($id)
    {
        // Búsca el grupo
        $found = $this->getAdSet($id);
        // Grupo encontrado
        if ($found) {

            $data = [
                // Elimina el grupo
                "function_call_back" => function () {
                    $this->ad_set->delete();
                },
                "message" => "Error al eliminar la grupo",
            ];

            $this->executeAction($data);

            $deleted = true;
        } else {
            $deleted = false;
        }

        return $deleted;
    }
    /**
     * Obtiene un grupo en base a su id. Almacena el resultado encontrado en una variable local
     * @param number $id Id del grupo a búscar
     * @return boolean $found Indica si fue encontrado
     */
    public function getAdSet($id)
    {
        $ad_sets = $this->getAdSets(true);

        $found = false;

        foreach ($ad_sets as $ad_set) {

            if ($ad_set->id == $id) {
                $this->ad_set = $ad_set;
                $found = true;
            }
        }

        return $found;
    }
    /**
     * Consulta todos los grupos de una campaña. Se requiere del id de la camapaña
     * @param boolean $return_obj Si se requiere retornar un objeto o un array
     * @return object|array $list_ad_sets Objeto o arreglo dependiendo del parámetro
     */
    public function getAdSets($return_obj = false)
    {
        // Campos a traer
        $fields = array(
            'name',
            'start_time',
            'end_time',
            'daily_budget',
            'optimization_goal',
            'billing_event',
        );
        $params = array();

        // Retorna el objeto
        $list_ad_sets = (new Campaign($this->id_campaign))->getAdSets(
            $fields,
            $params
        );
        // Retorna un arrego con los datos
        if (!$return_obj) {
            $list_ad_sets = $list_ad_sets->getResponse()->getContent();
        }

        return $list_ad_sets;
    }
    /**
     * Actualiza el grupo de anuncios ligado a una campaña
     * @param number $id Id del grupo a actualizar
     */
    public function updateAdSet($id)
    {
        $found = $this->getAdSet($id);

        if (!$found) {
            $updated = false;
        } else {
            $fields = array();
            $params = array(
                'name' => $this->name,
                'start_time' => $this->start_time . "T00:00:00-0500",
                'end_time' => $this->end_time . "T00:00:00-0500",
                'optimization_goal' => $this->optimization_goal,
                'billing_event' => $this->billing_event,
                'daily_budget' => $this->daily_budget,
                'bid_amount' => '20',
                // 'promoted_object' => array('page_id' => self::PAGE_ID),
                'targeting' => array('geo_locations' => array('countries' => array('US'))),
                'status' => 'PAUSED',
            );

            $data = [
                // Actualiza el grupo
                "function_call_back" => function () use ($fields, $params) {
                    $this->ad_set->updateSelf($fields, $params);
                },
                "message" => "Error al actualizar el grupo de anuncios {$this->name}",
            ];

            $this->executeAction($data);

            $updated = true;
        }

        return $updated;
    }
}
