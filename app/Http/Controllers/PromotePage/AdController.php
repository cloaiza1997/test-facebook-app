<?php

namespace App\Http\Controllers\PromotePage;

use App\Http\Controllers\API\PromotePage\ApiAdController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\FunctionsController;
use App\Models\Anuncios;
use App\Models\Contenido;
use App\Models\GruposAnuncios;
use Illuminate\Http\Request;

class AdController extends Controller
{
    // Constante con la ruta de la carpeta de las vistas
    private const FOLDER = "promocionar-pagina.ads";
    /**
     * Formulario de creación de anuncio
     */
    public function create()
    {
        // Extrae la url de la sesión que se crea en el método edit de AdSetController
        $params = Session()->get("url-back");
        $params = explode("-", $params);
        // Se obtienen los parámetros
        $id_campaign = $params[0];
        $id_ad_set = $params[1];
        // Se consulta el grupo
        $fb = new ApiAdController;
        $fb->id_campaign = $id_campaign;
        $fb->getAdSet($id_ad_set);
        // Se extraen todos los registros de la tabla
        $ad_creatives = Contenido::all();

        return view(self::FOLDER . ".crear")->with([
            "ad_creatives" => $ad_creatives,
            "ad_set" => $fb->ad_set
        ]);
    }
    /**
     * Elimina un anuncio de la API y la base de datos
     * @param number $id Id del elemento a eliminar
     */
    public function destroy($id)
    {
        $fb = new ApiAdController();
        $fb->delete($id);

        $ad = Anuncios::where("id_fb", $id)->first();
        // Se elimina
        $deleted = ($ad) ? $ad->delete() : false;

        $data = [
            "success" => $deleted,
            "text" => "Eliminación del Anuncio",
            "return_function" => function () {
                $param = Session()->get('url-back');
                return redirect()->route("ad-set.edit", $param);
            }
        ];

        return FunctionsController::returnWithMessageValidation($data);
    }
    /**
     * Guarda el anuncio
     */
    public function store(Request $request)
    {
        $inputs = $request->all();

        $fb = new ApiAdController();
        $fb->name = $inputs["name"];
        $fb->id_ad_set = $inputs["id_ad_set"];
        $fb->creative_id = $inputs["creative_id"];

        $success = $fb->createAd();

        if ($success) {

            $group = GruposAnuncios::where("id_fb", $fb->id_ad_set)->first();
            $creative = Contenido::where("id_fb", $fb->creative_id)->first();

            $obj_ad = new Anuncios();
            $obj_ad->id_fb = $fb->ad->id;
            $obj_ad->id_grupo = $group->id;
            $obj_ad->id_contenido = $creative->id;
            $obj_ad->nombre = $fb->name;

            $success = $obj_ad->save();
        }

        $data = [
            "success" => $success,
            "text" => "Creación de Anuncio",
            "return_function" => function () {
                $param = Session()->get('url-back');
                return redirect()->route("ad-set.edit", $param);
            }
        ];

        return FunctionsController::returnWithMessageValidation($data);
    }
    /**
     * Muestra la vista previa del anuncio
     * @param number $id Id del anuncio a mostrar
     */
    public function show($id)
    {
        $fb = new ApiAdController();
        // Se obtien la avista previa del anuncio
        $preview = $fb->getPreviews($id)["data"][0]["body"];
        // Se reemplaza un caracter &
        $preview = str_replace("&amp;", "&", $preview);

        return view(self::FOLDER . ".ver")->with([
            "preview" => $preview
        ]);
    }
}
