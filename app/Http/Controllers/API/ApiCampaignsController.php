<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\FacebookController;
use FacebookAds\Object\AdAccount;

class ApiCampaignsController extends FacebookController
{
    public $campaign;

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

        try {
            $campaign = (new AdAccount($this->ad_account_id))->createCampaign(
                $fields,
                $params
            );

            return $campaign;
        } catch (\Throwable $th) {
            dd("Error al crear la campaña {$name}", $th);
        }
    }
    /**
     * Consultar las campañas
     * @param  boolean $return_obj Si es verdadero el método retorna un objeto de lo contrario retorna un arreglo
     * @return object|array $list_campaigns Lista de campañas como objeto o arreglo
     */
    public function getCampaigns($return_obj = false)
    {

        $fields = array(
            'name',
            'objective',
        );
        $params = array(
            'effective_status' => array('ACTIVE', 'PAUSED'),
        );

        $list_campaigns = (new AdAccount($this->ad_account_id))->getCampaigns(
            $fields,
            $params
        );

        if (!$return_obj) {
            $list_campaigns = $list_campaigns->getResponse()->getContent();
        }

        return $list_campaigns;
    }

    public function getCampaign($id)
    {
        $campaigns = $this->getCampaigns(true);

        $found = false;

        foreach ($campaigns as $campaign) {

            if ($campaign->id == $id) {
                $this->campaign = $campaign;
                $found = true;
            }
        }

        return $found;
    }

    public function updateCampaign($id, $name, $objective)
    {

        try {
            $found = $this->getCampaign($id);

            if ($found) {
                $fields = array();
                $params = array(
                    'name' => $name,
                    'objective' => $objective,
                );
                $this->campaign->updateSelf($fields, $params);

                $updated = true;
            } else {
                $updated = false;
            }

            return $updated;
        } catch (\Throwable $th) {
            dd("Error al editar la campaña {$name}", $th);
        }
    }

    /**
     * Elimina una campaña seleccinoada
     * @param number $id Id de la campaña a eliminar
     * @return boolean $deleted Confirmación de la eliminación
     */
    public function deleteCampaign($id)
    {
        $found = $this->getCampaign($id);

        if ($found) {

            try {
                $this->campaign->delete();
            } catch (\Throwable $th) {
                dd("Error al eliminar la campaña", $th);
            }

            $deleted = true;
        } else {
            $deleted = false;
        }

        return $deleted;
    }
}
