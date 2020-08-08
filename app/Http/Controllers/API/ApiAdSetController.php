<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\ApiCampaignsController;
use Illuminate\Http\Request;
use DateTime;
use FacebookAds\Object\AdAccount;

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

    public function createAdSet()
    {
        try {
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
                // 'promoted_object' => array('page_id' => self::PAGE_ID),
                'targeting' => array('geo_locations' => array('countries' => array('US'))),
                'status' => 'PAUSED',
            );
            $this->ad_set = (new AdAccount($this->ad_account_id))->createAdSet(
                $fields,
                $params
            );
            return ($this->ad_set) ? true : false;
        } catch (\Throwable $th) {
            dd("Error al crear el grupo de anuncios {$this->name}", $th);
        }
    }
}
