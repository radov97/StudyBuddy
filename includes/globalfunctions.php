<?php
// Used to insert mustache templates
function getTemplate(string $path): string 
{
    ob_start();
    require_once $path;
    return ob_get_clean();
}
// Used to redirect to other page
function redirectTo(string $url): void 
{
    header('Location: ' . $url);
    exit();
}
// Used to debug code
function debug($variable): string 
{
    return highlight_string("<?php\n\$data =\n" . var_export($variable, true) . ";\n?>");
}

?>