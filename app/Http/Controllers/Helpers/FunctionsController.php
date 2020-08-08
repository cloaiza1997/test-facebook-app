<?php

namespace App\Http\Controllers\Helpers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FunctionsController extends Controller
{
    /**
     * Ejecuta una función de retorno cuando se cumple con una condición
     * @param array[success,text,return_function] $data
     */
    public static function returnWithMessageValidation($data)
    {

        if ($data["success"]) {
            $message = "{$data["text"]} ejecutada correctamente";
        } else {
            $message = "{$data["text"]} no se ejecutó correctamente";
        }

        return $data["return_function"]()->with([
            "message" => $message
        ]);
    }
}
