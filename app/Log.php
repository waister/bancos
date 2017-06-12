<?php

class Log {

    public static function insert($msg){
        $msg = "[" . date("d-m-Y, H:i:s") . "] " . $msg . "\r\n";
        $fp = fopen(BASE_PATH . "/database.log", "a");
        fwrite($fp, $msg);
        fclose($fp);
    }

}
