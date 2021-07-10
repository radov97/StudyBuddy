<?php

function getTemplate(string $path): string 
{
    ob_start();
    require_once $path;
    $template = ob_get_clean();
    ob_end_clean();
    return $template;
}

?>