<?php

namespace App\Http\Controllers\PromotePage;

use App\Http\Controllers\API\ApiAdCreativeController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\FunctionsController;
use App\Models\Contenido;
use Illuminate\Http\Request;

class AdCreativeController extends Controller
{
    // Constante con la ruta de la carpeta de las vistas
    private const FOLDER = "promocionar-pagina.adcreatives";
    /**
     * Muestra el formulario de creación
     */
    public function create()
    {
        return view(self::FOLDER . ".crear");
    }
    /**
     *
     */
    public function store(Request $request)
    {
        $inputs = $request->all();

        $fb = new ApiAdCreativeController();
        $fb->name = $inputs["name"];
        $fb->title = $inputs["title"];
        $fb->image_url = $inputs["image_url"];
        $fb->body = $inputs["body"];
        $fb->id_post = $inputs["id_post"];

        $success = $fb->createAdCreative();
        // + Contenido creado en la API
        if ($success) {
            // Se crea en la base de datos
            $obj_creative = new Contenido();
            $obj_creative->id_fb = $fb->creative->id;
            $obj_creative->nombre = $fb->name;
            $obj_creative->titulo = $fb->title;
            $obj_creative->url_imagen = $fb->image_url;
            $obj_creative->cuerpo = $fb->body;
            $obj_creative->id_publicacion = $fb->id_post;

            $success = $obj_creative->save();
        }

        $data = [
            "success" => $success,
            "text" => "Creación de Contenido",
            "return_function" => function () {
                $param = Session()->get('url-back');
                return redirect()->route("ad-set.edit", $param);
            }
        ];

        return FunctionsController::returnWithMessageValidation($data);
    }
    /**
     * Elimina un contenido de la base de datos y la API
     * @param number $id Id del elemento a eliminar
     */
    public function destroy($id)
    {
        // Se elimina de la API
        $fb = new ApiAdCreativeController();
        $fb->deleteAdCreative($id);
        // Se consulta en la base de datos
        $content = Contenido::where("id_fb", $id)->first();
        // Se elimina
        $deleted = ($content) ? $content->delete() : false;

        $data = [
            "success" => $deleted,
            "text" => "Eliminación del Contenido \"{$id}\"",
            "return_function" => function () {
                $param = Session()->get('url-back');
                return redirect()->route("ad-set.edit", $param);
            }
        ];

        return FunctionsController::returnWithMessageValidation($data);
    }
}
