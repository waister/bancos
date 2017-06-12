<?php

include "../config/app.php";

require_once BASE_PATH . "vendor/autoload.php";

$pageName = "";
$pageTitle = "";
$pageDescription = "";
$pageUrl = SERVER_URL;

$uri = $_SERVER["REQUEST_URI"];

if (strstr($uri, "?")) {
    $explode = explode("?", $uri);
    $uri = $explode[0];
}

if ($uri == "/") {
    $pageName = "home";
    $pageDescription = "Um lugar onde a vida acontece. Prepare-se para conhecer o ponto mais privilegiado de Goiânia. Um dos setores com maior valorização, entre o Parque Vaca Brava e o Parque Areião e perto das maiores facilidades. Descubra o DOT Bueno Residence.";
} else {
    if (strstr($uri, "/api")) {
        require VIEWS_PATH . "api.php";
        die;
    } else {
        $pageName = "error";
        $pageTitle = "Erro 404";
        $pageUrl .= "erro";

        header('HTTP/1.0 404 Not Found');
    }
}

if (!file_exists(VIEWS_PATH . $pageName . ".php")) {
    $pageName = "error";
    $pageTitle = "Erro";

    header('HTTP/1.0 404 Not Found');
}

include VIEWS_PATH . "layout.php";
