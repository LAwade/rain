<?php

// *****************************************************************************
// *                                 CORE                                      *
// *****************************************************************************

function session(): app\core\Session {
    return new app\core\Session();
}

function message(): app\core\Message {
    return new app\core\Message();
}

function logger($name = null, $active = true): app\shared\Logger {
    return new app\shared\Logger(($name ? $name . "_" . date('Ymd') : 'logger_' . date('Ymd')), $active, __DIR__ . '/../storage/logs/');
}

function api(array $data){
    header('Access-Control-Allow-Origin: *');
    header('Accept: application/json');
    header('Content-Type: application/json');
    echo json_encode($data, true);
    exit(0);
}

function getToken($info = null){
    $token = null;
    if($info){
        $token = $info . "_";
    }
    return md5($token . time() . rand(999, 9999999));
}

function config(string $conf){
    if(strpos('.php', $conf) !== false){
        return include $conf;
    }
    return include $conf . '.php';
}

// *****************************************************************************
// *                                DATE                                       *
// *****************************************************************************

function date_hours_now() {
    return date(CONF_DATE_HOUR_APP);
}

function date_now() {
    return date(CONF_DATE_APP);
}

function date_hours_br($time, $strtime = false) {
    if (!$strtime) {
        return date(CONF_DATE_HOUR_BR, strtotime($time));
    } else {
        return date(CONF_DATE_HOUR_BR, $time);
    }
}

function date_br($date) {
    return date(CONF_DATE_BR, strtotime($date));
}

function date_hours_br_incrase($date, $incrase) {
    return date(CONF_DATE_HOUR_BR, strtotime($date . " $incrase"));
}

function date_incrase_days($date, $days) {
    return date(CONF_DATE_APP, strtotime($date . " +{$days} days"));
}

function date_decrase_days($date, $days) {
    return date(CONF_DATE_APP, strtotime($date . " -{$days} days"));
}

function validate_date_default($date) {
    $data = explode('-', $date);
    /**
     * ckechdate (MM/DD/YYYY)
     */
    return checkdate($data[1], $data[2], $data[0]);
}

// *****************************************************************************
// *                               VALIDATE                                    *
// *****************************************************************************

function filter_data($data) {
    $filter = [];
    foreach ($data as $key => $value) {
        if (!is_null($value)) {
            $filter[$key] = filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);
        }
    }
    return $filter;
}

function is_email(string $email): bool {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function is_postback() {
    return filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
}

function is_base64($s) {
    return (bool) preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $s);
}

// *****************************************************************************
// *                          STRING MANIPULATION                              *
// *****************************************************************************

function str_slug(string $string): string {
    $string = filter_var(mb_strtolower($string), FILTER_SANITIZE_STRIPPED);
    $formats = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]/?;:.,\\\'<>°ºª';
    $replace = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                 ';

    $slug = str_replace(["-----", "----", "---", "--"], "-",
            str_replace(" ", "-", trim(strstr($string, utf8_decode($formats), $replace)))
    );

    return $slug;
}

function str_studly_case(string $string): string {
    $string = str_slug($string);
    $studlyCase = str_replace(" ", "",
            mb_convert_case(str_replace("-", " ", $string), MB_CASE_TITLE));

    return $studlyCase;
}

function str_camel_case(string $string): string {
    return lcfirst(str_studly_case($string));
}

function url(string $path): string {
    return CONF_URL_BASE . ($path[0] == "/" ? mb_substr($path, 1) : $path);
}

function redirect(string $url = "") {
    header("HTTP/1.1 302 Redirect");
    if (filter_var($url, FILTER_VALIDATE_URL)) {
        header("Location: {$url}");
        exit;
    }

    $location = url($url);
    header("Location: {$location}");
    exit;
}

function str_format_reais($valor) {
    return number_format($valor, 2, ',', '.');
}

function str_format_float($valor) {
    return number_format($valor, 2, '.', '.');
}

function str_numbers($str) {
    return preg_replace("/[^0-9]/", "", $str);
}

function str_juststr($str) {
    return trim(preg_replace("/[^A-Za-zá-üÁ-Ü ]/", "", $str));
}

function str_coin($coin) {
    return trim(preg_replace("(\d{1,3}(\.\d{3})*|\d+)(\,\d{2})?$", "", $coin));
}

function str_slash($str) {
    if (substr($str, -1) != '/') {
        return $str . '/';
    } else {
        return $str;
    }
}

function str_scape_asp($string) {
    return $string; //str_replace("'", "\'", $string);
}

function specialCharName($name) {
    return filter_var(trim($name), FILTER_SANITIZE_SPECIAL_CHARS);
}

function str_scape_html($string) {
    return html_entity_decode($string, ENT_QUOTES, "UTF-8");
}

function str_name_file($file){
    return strtolower(str_replace('.php','',$file));
}

// *****************************************************************************
// *                              HTTP REQUEST                                 *
// *****************************************************************************

function csrf_input(): string {
    if (!session()->csrf_token) {
        session()->csrf();
    }
    return sprintf("<input type='text' name='csrf' value='%s' hidden/>", session()->csrf_token);
}

function csrf_verify($request): bool {
    if (empty(session()->csrf_token) || empty($request['csrf']) || $request['csrf'] != session()->csrf_token) {
        return false;
    }
    session()->csrf();
    return true;
}

// *****************************************************************************
// *                            UTIL FUNCTIONS                                 *
// *****************************************************************************
function rand_key($min = 10000, $max = 99999) {
    return rand($min, $max);
}

function generateAccountHash($param, $separator = "|") {
    return md5(rand_key() . $separator . rand_key() . $separator . $param);
}

function keepdata($session, $action, $data) {
    if ($action == CONF_SESSION_DESCONNECT) {
        session()->unset($session);
    }

    if (session()->has($session)) {
        $data = (array) session()->data($session);
    } else {
        session()->set($session, $data);
    }

    return $data ?? null;
}

/**
 * Compara entre array por level
 * array1 => Array antigo
 * array2 => Array novo
 * @param type $a
 * @param type $b
 * @return type
 */
function compare($array1, $array2, $indice) {
    return array_udiff($array2, $array1, $indice . 'udiff');
}

function leveludiff($a, $b) {
    return $a['level'] - $b['level'];
}

function nameudiff($a, $b) {
    return $a['name'] - $b['name'];
}

function print_html($data){
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}

// *****************************************************************************
// *                            CONVERSOR TIMERS                               *
// *****************************************************************************

function convertSecondsToStrTime($seconds) {
    $conv_time = convertSecondsToArrayTime($seconds);
    return $conv_time['days'] . 'd ' . $conv_time['hours'] . 'h ' . $conv_time['minutes'] . 'm ' . $conv_time['seconds'] . 's';
}

function convertSecondsToArrayTime($seconds) {
    $conv_time = array();
    $conv_time['days'] = floor($seconds / 86400);
    $conv_time['hours'] = floor(($seconds - ($conv_time['days'] * 86400)) / 3600);
    $conv_time['minutes'] = floor(($seconds - (($conv_time['days'] * 86400) + ($conv_time['hours'] * 3600))) / 60);
    $conv_time['seconds'] = floor(($seconds - (($conv_time['days'] * 86400) + ($conv_time['hours'] * 3600) + ($conv_time['minutes'] * 60))));
    return $conv_time;
}

function convertSecondsToDay($seconds) {
    $conv_day = floor($seconds / 86400000);
    $conv_time = floor($seconds / 1000);
    return $conv_day . " Dias " . gmdate("H:i:s", $conv_time);
}
