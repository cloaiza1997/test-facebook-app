<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use FacebookAds\Api;
use FacebookAds\Logger\CurlLogger;
use FacebookAds\Object\Ad;
use FacebookAds\Object\AdAccount;
use FacebookAds\Object\AdCreative;
use FacebookAds\Object\AdPreview;
use FacebookAds\Object\AdSet;
use FacebookAds\Object\Campaign;
use FacebookAds\Object\CustomAudience;
use Mockery\Undefined;

class TestController extends Controller
{
    public function index() {

        $access_token = 'EAAIPemUSc3sBAKv6YO2doyZAc3qy1tWxI4o3g7OCPzhRajbET2AODGQVMbiiBu9S0ZA40AlAhB49QZB4XXAylYdZA95wLCFOS9KNndsWZBdaD7klLAn1jnokg1QVUZBZBr7hqf1Uut8KoDC32VQZC27AlmyZASrBSpYUiKVB2eeDh1zGfcoG2LJdZCIRwqPHlVUb0ZD';
        $app_secret = '6750bdc982ab2a94cc4497591fa91a5a';
        $ad_account_id = 'act_960712221058799';
        $audience_name = 'Publico';
        $audience_retention_days = '30';
        $pixel_id = '279905923309525';
        $app_id = '579968309556091';

        $api = Api::init($app_id, $app_secret, $access_token);
        $api->setLogger(new CurlLogger());

        $fields = array();
        $params = array(
            'name' => 'My Campaign',
            'buying_type' => 'AUCTION',
            'objective' => 'PAGE_LIKES',
            'status' => 'PAUSED',
            'special_ad_categories' => '[]',
        );
        $campaign = (new AdAccount($ad_account_id))->createCampaign(
            $fields,
            $params
        );
        $campaign_id = $campaign->id;
        echo 'campaign_id: ' . $campaign_id . "\n\n";

        $fields = array();
        $params = array(
            'pixel_id' => $pixel_id,
            'name' => $audience_name,
            'subtype' => 'WEBSITE',
            'retention_days' => $audience_retention_days,
            'rule' => array('url' => array('i_contains' => '')),
            'prefill' => true,
        );
        $custom_audience = (new AdAccount($ad_account_id))->createCustomAudience(
            $fields,
            $params
        );
        $custom_audience_id = $custom_audience->id;
        echo 'custom_audience_id: ' . $custom_audience_id . "\n\n";

        $fields = array();
        $params = array(
            'name' => 'My AdSet',
            'optimization_goal' => 'REACH',
            'billing_event' => 'IMPRESSIONS',
            'bid_amount' => '20',
            'daily_budget' => '1000',
            'campaign_id' => $campaign_id,
            'targeting' => array('custom_audiences' => array(array('id' => $custom_audience_id)), 'geo_locations' => array('countries' => array('US'))),
            'status' => 'PAUSED',
        );
        $ad_set = (new AdAccount($ad_account_id))->createAdSet(
            $fields,
            $params
        );
        $ad_set_id = $ad_set->id;
        echo 'ad_set_id: ' . $ad_set_id . "\n\n";

        $fields = array();
        $params = array(
            'name' => 'My Creative',
            'title' => 'My Page Like Ad',
            'body' => 'Like My Page',
            'object_url' => 'www.facebook.com',
            'link_url' => 'www.facebook.com',
            'image_url' => 'http://www.facebookmarketingdevelopers.com/static/images/resource_1.jpg',
        );
        $creative = (new AdAccount($ad_account_id))->createAdCreative(
            $fields,
            $params
        );
        $creative_id = $creative->id;
        echo 'creative_id: ' . $creative_id . "\n\n";

        $fields = array();
        $params = array(
            'name' => 'My Ad',
            'adset_id' => $ad_set_id,
            'creative' => array('creative_id' => $creative_id),
            'status' => 'PAUSED',
        );
        $ad = (new AdAccount($ad_account_id))->createAd(
            $fields,
            $params
        );
        $ad_id = $ad->id;
        echo 'ad_id: ' . $ad_id . "\n\n";

        $fields = array();
        $params = array(
            'ad_format' => 'DESKTOP_FEED_STANDARD',
        );
        echo json_encode((new Ad($ad_id))->getPreviews(
            $fields,
            $params
        )->getResponse()->getContent(), JSON_PRETTY_PRINT);

        // $app_id = "579968309556091";
        // $app_secret = "6750bdc982ab2a94cc4497591fa91a5a";
        // $access_token = "EAAIPemUSc3sBAKv6YO2doyZAc3qy1tWxI4o3g7OCPzhRajbET2AODGQVMbiiBu9S0ZA40AlAhB49QZB4XXAylYdZA95wLCFOS9KNndsWZBdaD7klLAn1jnokg1QVUZBZBr7hqf1Uut8KoDC32VQZC27AlmyZASrBSpYUiKVB2eeDh1zGfcoG2LJdZCIRwqPHlVUb0ZD";
        // $account_id = "960712221058799";

        // Api::init($app_id, $app_secret, $access_token);

        // $account = new AdAccount($account_id);
        // $cursor = $account->getCampaigns();

        // // Loop over objects
        // foreach ($cursor as $campaign) {
        //     echo $campaign->{CampaignFields::NAME} . PHP_EOL;
        // }

        // **** sample

        // $access_token = 'EAAKFpgw9rvsBACUzc6Dmi3aRPjvnud7ZBmKoUpKxGGZCdvvVA2ePbz4lfiN2TgZATpKZCOpMDXRFexblaiObpvB9qhajc2C3gYT8H9zT2xk0exYc6fYf2gvOA6JeDqczvmZCD07vJC45M6C0lvTax9J1JZC6rOwRTFAutuoFazIZAJpZAEDiyZAPR9oHAi8w3jUkZD';
        // $ad_account_id = 'act_619392338972716';
        // $app_secret = 'f9b579fdad6fffe9f2acccdeb8d16694';
        // $page_id = '634308330532740';
        // $app_id = '709898169855739';

        // $access_token = 'EAAKFpgw9rvsBACUzc6Dmi3aRPjvnud7ZBmKoUpKxGGZCdvvVA2ePbz4lfiN2TgZATpKZCOpMDXRFexblaiObpvB9qhajc2C3gYT8H9zT2xk0exYc6fYf2gvOA6JeDqczvmZCD07vJC45M6C0lvTax9J1JZC6rOwRTFAutuoFazIZAJpZAEDiyZAPR9oHAi8w3jUkZD';
        // $ad_account_id = 'act_619392338972716';
        // $app_secret = 'f9b579fdad6fffe9f2acccdeb8d16694';
        // $page_id = '634308330532740';
        // $app_id = '709898169855739';

        // $access_token = 'EAAIPemUSc3sBAKv6YO2doyZAc3qy1tWxI4o3g7OCPzhRajbET2AODGQVMbiiBu9S0ZA40AlAhB49QZB4XXAylYdZA95wLCFOS9KNndsWZBdaD7klLAn1jnokg1QVUZBZBr7hqf1Uut8KoDC32VQZC27AlmyZASrBSpYUiKVB2eeDh1zGfcoG2LJdZCIRwqPHlVUb0ZD';
        // $app_secret = '6750bdc982ab2a94cc4497591fa91a5a';
        // $ad_account_id = 'act_960712221058799';
        // $audience_name = 'Publico';
        // $audience_retention_days = '30';
        // $pixel_id = '279905923309525';
        // $app_id = '579968309556091';

        // $api = Api::init($app_id, $app_secret, $access_token);
        // $api->setLogger(new CurlLogger());

        // $fields = array();
        // $special_ad_categories = [];
        // $params = array(
        //     'name' => 'My Campaign',
        //     'buying_type' => 'AUCTION',
        //     'objective' => 'PAGE_LIKES',
        //     'status' => 'PAUSED',
        //     'special_ad_categories' => '[]',
        // );
        // $campaign = (new AdAccount($ad_account_id))->createCampaign(
        //     $fields,
        //     $params
        // );
        // $campaign_id = $campaign->id;
        // echo 'campaign_id: ' . $campaign_id . "\n\n";

        // $fields = array();
        // $params = array(
        //     'name' => 'My AdSet',
        //     'optimization_goal' => 'PAGE_LIKES',
        //     'billing_event' => 'IMPRESSIONS',
        //     'bid_amount' => '20',
        //     'promoted_object' => array('page_id' =>  $page_id),
        //     'daily_budget' => '4000',
        //     'campaign_id' => $campaign_id,
        //     'targeting' => array('geo_locations' => array('countries' => array('US'))),
        //     'status' => 'PAUSED',
        // );

        // $ad_set = (new AdAccount($ad_account_id))->createAdSet(
        //     $fields,
        //     $params
        // );

        // $ad_set_id = $ad_set->id;
        // echo 'ad_set_id: ' . $ad_set_id . "\n\n";

        // $fields = array();
        // $params = array(
        //     'name' => 'My Creative',
        //     'object_story_id' => $page_id . "_634387967191443",
        //     'title' => 'My Page Like Ad',
        //     'body' => 'Like My Page',
        //     'image_url' => 'https://lh3.googleusercontent.com/ogw/ADGmqu92J_XEZey-4rOcy8dB637oHg6gfRG7b7QKTQhb=s83-c-mo',
        // );
        // $creative = (new AdAccount($ad_account_id))->createAdCreative(
        //     $fields,
        //     $params
        // );
        // $creative_id = $creative->id;
        // echo 'creative_id: ' . $creative_id . "\n\n";

        // $fields = array();
        // $params = array(
        //     'name' => 'My Ad',
        //     'adset_id' => $ad_set_id,
        //     'creative' => array('creative_id' => $creative_id),
        //     'status' => 'PAUSED',
        // );
        // $ad = (new AdAccount($ad_account_id))->createAd(
        //     $fields,
        //     $params
        // );
        // $ad_id = $ad->id;
        // echo 'ad_id: ' . $ad_id . "\n\n";

        // $fields = array();
        // $params = array(
        //     'ad_format' => 'DESKTOP_FEED_STANDARD',
        // );

        // $response = json_encode((new Ad($ad_id))->getPreviews(
        //     $fields,
        //     $params
        // )->getResponse()->getContent(), JSON_PRETTY_PRINT);

        // $response = json_encode((new Ad($ad_id))->getPreviews(
        //     $fields,
        //     $params
        // )->getResponse()->getContent());

        // $hmtl = (new Ad($ad_id))->getPreviews(
        //     $fields,
        //     $params
        // )->getResponse()->getContent();

        // // echo "<div>" . $response["data"][0]["body"] . "</div>";

        // // dd($response["data"][0]["body"]);

        // // dd($hmtl, $response);

        // return view("index")->with([
        //     "html" => html_entity_decode($hmtl["data"][0]["body"]),
        //     "post" => $response,
        // ]);

    }
}
