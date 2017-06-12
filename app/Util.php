<?php

class Util {

    public static function getArray($name) {
        if (!empty($_GET[$name])) {
            $data = $_GET[$name];

            if (strstr($data, ',')) {
                $data = trim($data, ',');

                return explode(',', $data);
            } else {
                return [$data];
            }
        }

        return [];
    }

    public static function date($value) {
        $date = new DateTime($value);
        return $date->format('d/m/Y H\hi');
    }

    public static function dateHuman($value) {
        return strftime('%A, %d de %B de %Y', strtotime('today'));
    }

    public static function actionUrl($action = "", $add = [], $useGetData = true) {
        $base = SERVER_URL . $action;

        if ($add == null) return $base;
        
        $data = [];

        if ($useGetData) {
            $data = $_GET;
        }

        if (empty($data) && empty($add)) {
            return $base;
        }
        
        foreach ($add as $key => $value) {
            $data[$key] = $value;
        }

        return $base . "?" . http_build_query($data);
    }

    public static function paginate($total, $perPage = 25) {
        $links = 4;
        $page = empty($_GET["page"]) ? 1 : $_GET["page"];
        $last = ceil($total / $perPage);
        $totalFormatted = number_format($total, 0, ",", ".");

        $start = (($page - $links) > 0) ? $page - $links : 1;
        $end = (($page + $links) < $last) ? $page + $links : $last;

        $html = '<footer id="pagination">';
        $html .= '<div class="pagination-count">Total de registros: <strong>' . $totalFormatted . '</strong></div>';

        $html .= '<ul class="pagination pagination-sm">';

        if ($page == 1) {
            $html .= '<li class="disabled"><a href="#" onclick="return false">&laquo;</a></li>';
        } else {
            $html .= '<li><a href="' . self::actionUrl("admin", ["page" => ($page - 1)]) . '">&laquo;</a></li>';
        }

        if ($start > 1) {
            $html .= '<li><a href="?page=1">1</a></li>';
            $html .= '<li class="disabled"><span>...</span></li>';
        }

        for ($i = $start ; $i <= $end; $i++) {
            $class = ($page == $i) ? "active" : "";
            $html .= '<li class="' . $class . '"><a href="' . self::actionUrl("admin", ["page" => $i]) . '">' . $i . '</a></li>';
        }

        if ($end < $last) {
            $html .= '<li class="disabled"><span>...</span></li>';
            $html .= '<li><a href="' . self::actionUrl("admin", ["page" => $last]) . '">' . $last . '</a></li>';
        }

        if ($page == $last) {
            $html .= '<li class="disabled"><a href="#" onclick="return false">&raquo;</a></li>';
        } else {
            $html .= '<li><a href="' . self::actionUrl("admin", ["page" => ($page + 1)]) . '">&raquo;</a></li>';
        }

        $html .= '</ul>';
        $html .= '</footer>';

        return $html;
    }

}
