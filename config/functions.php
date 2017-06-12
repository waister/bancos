<?php

function js($name) {
    include_file(JS_PATH . $name . ".js");
}

function css($name) {
    $path = CSS_PATH . $name . ".css";

    if (file_exists($path)) {
        $css = str_replace("../img/", IMG_URL, file_get_contents($path));
        $css = str_replace("../uploads/", UPLOADS_URL, $css);
        echo $css;
    }
}

function view($name) {
    $path = $name . ".php";

    if ($name == "error") {
        $path = "errors/404.php";
    }

    include_file(VIEWS_PATH . $path);
}

function element($name) {
    include_file(ELEMENTS_PATH . $name . ".php");
}

function include_file($path) {
    if (file_exists($path)) {
        include($path);
    }
}

function pr($data) {
    echo "<pre>";
        print_r($data);
    echo "</pre>";
}

function imageShare($name) {
    $path = "share/" . $name . ".jpg";

    if (file_exists(PUBLIC_PATH . $path)) {
        return SERVER_URL . $path;
    }

    return "";
}
