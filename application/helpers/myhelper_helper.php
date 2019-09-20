<?php
function loadtemplate($file, $data){
    return str_replace(array_keys($data), array_values($data), file_get_contents("application/views/template/".$file));
}