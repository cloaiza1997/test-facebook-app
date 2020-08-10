<?php

namespace App\Http\Controllers\API\PromotePage;

use App\Http\Controllers\API\FacebookController;
use FacebookAds\Object\AdAccount;
use FacebookAds\Object\AdCreative;

class ApiAdCreativeController extends FacebookController
{
    public $ad_creative;
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
     * @return boolean $deleted Indica si fue eliminado
     */
    public function deleteAdCreative($id)
    {
        $data = [
            // Elimina el contenido
            "function_call_back" => function () use ($id) {

                $deleted = false;
                (new AdCreative($id))->deleteSelf(
                    [],
                    []
                );
                $deleted = true;

                return $deleted;
            },
            "message" => "Error al eliminar la anuncio",
        ];

        $deleted = $this->executeAction($data);

        return $deleted;
    }
    /**
     * Obtiene un anuncio
     * @param number $id Id del anuncio
     * @return boolean $found Indica si el anuncio fue encontrado
     */
    public function getCreative($id)
    {
        // Se obtienen los anuncios
        $ad_creatives = $this->getAdCreatives(true);

        $found = false;
        // Se recorren para buscar el anuncio
        foreach ($ad_creatives as $ad_creative) {
            if ($ad_creative->id == $id) {
                $this->ad_creative = $ad_creative;
                $found = true;
            }
        }

        return $found;
    }
    /**
     * Obtiene el listado de contenidos creados
     * @param boolean $return_object Indica si se retorna un objeto o un arreglo
     */
    public function getAdCreatives($return_object = false)
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
        );
        if (!$return_object) {
            $list_creatives = $list_creatives->getResponse()->getContent();
        }

        return $list_creatives;
    }
}
