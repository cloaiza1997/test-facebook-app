<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\FacebookController;
use FacebookAds\Object\AdAccount;
use FacebookAds\Object\AdCreative;
use Illuminate\Http\Request;

class ApiAdCreativeController extends FacebookController
{
    public $body;
    public $id_post;
    public $image_url;
    public $name;
    public $title;
    public $creative;
    /**
     * Crea un contenido en la API
     */
    public function createAdCreative()
    {
        $fields = array();
        $params = array(
            'name' => $this->name,
            'object_story_id' => $this->page_id . "_" . $this->id_post,
            'title' => $this->title,
            'body' => $this->body,
            'image_url' => $this->image_url,
        );

        $data = [
            // Crea el contenido
            "function_call_back" => function () use ($fields, $params) {
                $this->creative = (new AdAccount($this->ad_account_id))->createAdCreative(
                    $fields,
                    $params
                );

                return ($this->creative) ? true : false;
            },
            "message" => "Error al crear el contenido",
        ];

        return $this->executeAction($data);
    }
    /**
     * Elimina un contenido
     * @param number $id Id del elemento a borrar
     */
    public function deleteAdCreative($id)
    {
        (new AdCreative($id))->deleteSelf(
            [],
            []
        );
    }
    /**
     * Obtiene el listado de contenidos creados
     */
    public function getAdCreatives()
    {
        $fields = array(
            'name',
            'object_story_id',
            'image_url',
            'title',
        );
        $params = array();

        $list_creatives = (new AdAccount($this->ad_account_id))->getAdCreatives(
            $fields,
            $params
        )->getResponse()->getContent();

        return $list_creatives;
    }



    public function getAdCreative()
    {

        $fields = array(
            'name',
            'object_story_id',
            'image_url',
        );
        $params = array();
        $ad = (new AdCreative(120330000024732904))->getSelf(
            $fields,
            $params
        );
        dd($ad);
    }
}
