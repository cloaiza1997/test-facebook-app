## Prueba de Desarrollo API Facebook

Se implementa el CRUD del API de Marketing para Promocionar una Página, el CRUD está ligado a una base de datos en MySQL.

Aplicación desarrollada en Laravel

Prueba Desarrollada por Cristian Loaiza

• <a target="_blank" href="https://www.facebook.com/Andr%C3%A9s-Arias-592692364752928/?__tn__=kC-R&eid=ARAsCQcN275_4MSx90hFJAYInRnka13F3BctOiSyrwx5Oio7y9gMDtLIgXAD60UP-8vbfKXJrXtTbA_r&hc_ref=ARSr30RB-yNIIaBtboJ_qfI0Wd0bOtnfkC0m6AwNfE9lBY78t_c-LoqOCyzk-j5ANm0&fref=nf">
Página de Facebook utilizada
</a>

• Nota

    Se requiere del Id de la publicación de Facebook para crear un AdCreative

• <a target="_blank"  href="https://www.facebook.com/592692364752928/photos/a.594977174524447/595049877850510/?type=3&eid=ARAbRKn-XczsnqDa1Y6zNjtO_EGmzqvlG_69sTHhoWHdTFbmPQtcrXX3nej-LscG83vW9BXob1STTjlW&__tn__=EHH-R">
Ejemplo de publicación
</a>

• Ids de Publicaciones de prueba

    592729028082595
    595050024517162

• En el archivo data_base.sql se encuentra la base de datos

• Los selects de Objetivos de Campaña, Evento de Facturación, Objeto de Optimización solo muestran una opción ya que desde el controlador están inhabilitadas las demás debido a que cada opción requiere de unos parámetros adicionales lo cual conlleva a tener un formulario más dinámico que reaccione de acuerdo a cada selección, haciendo la prueba más extensa.
