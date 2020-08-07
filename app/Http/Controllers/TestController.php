<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use FacebookAds\Api;
use FacebookAds\Logger\CurlLogger;
use FacebookAds\Object\AdAccount;
use FacebookAds\Object\Campaign;
use FacebookAds\Object\Fields\CampaignFields;

class TestController extends Controller
{
    public function index() {
        $app_id = "579968309556091";
        $app_secret = "6750bdc982ab2a94cc4497591fa91a5a";
        $access_token = "EAAIPemUSc3sBAKv6YO2doyZAc3qy1tWxI4o3g7OCPzhRajbET2AODGQVMbiiBu9S0ZA40AlAhB49QZB4XXAylYdZA95wLCFOS9KNndsWZBdaD7klLAn1jnokg1QVUZBZBr7hqf1Uut8KoDC32VQZC27AlmyZASrBSpYUiKVB2eeDh1zGfcoG2LJdZCIRwqPHlVUb0ZD";
        $account_id = "960712221058799";

        Api::init($app_id, $app_secret, $access_token);

        $account = new AdAccount($account_id);
        $cursor = $account->getCampaigns();

        // Loop over objects
        foreach ($cursor as $campaign) {
            echo $campaign->{CampaignFields::NAME} . PHP_EOL;
        }
    }
}
