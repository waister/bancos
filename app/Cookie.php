<?php
class Cookie {

    const INSTAGRAM_CODE = "INSTAGRAM_CODE";
    const INSTAGRAM_TOKEN = "INSTAGRAM_TOKEN";
    const REGISTER_FINISHED = "REGISTER_FINISHED";
    const AUTH = "AUTH";
    const FINISH = "FINISH";
    const USER_ID = "USER_ID";

    public static function makeName($name) {
        return "me_waister_" . $name;
    }

    public static function get($name, $default = "") {
        $name = self::makeName($name);

        return isset($_COOKIE[$name]) ? $_COOKIE[$name] : $default;
    }

    public static function set($name, $value) {
        $name = self::makeName($name);

        $date = new DateTime();
        $date->modify("+10 years");
        $time = $date->getTimestamp();

        setcookie($name, $value, $time, false, false, false, true);
    }

    public static function delete($name) {
        $name = self::makeName($name);

        return setcookie($name, "", time() - 3600, false, false, false, true);
    }
}



// Cookie::set(Cookie::USER_ID, 111);
// echo Cookie::get(Cookie::USER_ID, 222);
