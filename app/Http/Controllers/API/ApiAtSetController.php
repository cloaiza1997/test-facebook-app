<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\ApiCampaignsController;
use Illuminate\Http\Request;
use DateTime;
use FacebookAds\Object\AdAccount;

class ApiAtSetController extends ApiCampaignsController
{
    public function createAdSet($campaign_id)
    {

        $start_time = (new \DateTime("+1 week"))->format(DateTime::ISO8601);
        $end_time = (new \DateTime("+2 week"))->format(DateTime::ISO8601);

        $fields = array();
        $params = array(
            'name' => 'My AdSet',
            'optimization_goal' => 'PAGE_LIKES',
            'start_time' => '2019-12-12T23:41:41-0800',
            'end_time' => '2019-12-19T23:41:41-0800',
            'billing_event' => 'IMPRESSIONS',
            'bid_amount' => '20',
            // 'promoted_object' => array('page_id' => self::PAGE_ID),
            'daily_budget' => '4000',
            'campaign_id' => $campaign_id,
            'targeting' => array('geo_locations' => array('countries' => array('US'))),
            'status' => 'PAUSED',
        );
        $ad_set = (new AdAccount($this->ad_account_id))->createAdSet(
            $fields,
            $params
        );
        return $ad_set;
    }
}
