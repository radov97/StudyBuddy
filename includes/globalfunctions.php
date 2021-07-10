<?php

function getTemplate(string $path): string 
{
    ob_start();
    require_once $path;
    return ob_get_clean();
}

?>