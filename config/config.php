<?php

/*
 * PROPRIETS SYSTEM
 */
define('CONF_NAME_SYSTEM', 'ShopExpert');
define('CONF_VERSION_CURRENT', '1.0.0');
define('CONF_ACCOUNT_ADMINISTRATOR', 'admin');

/*
 * URL
 * Info: add slash the final URL in (CONF_URL_SITE, CONF_URL_BASE)
 */
define('CONF_URL_SITE', "127.0.0.1");
define('CONF_URL_BASE', "http://127.0.0.1/rain");
define('CONF_URL_INDEX', 'panel/index');

/*
 * SESSION
 */
define('CONF_SESSION_MENU', 'menu_pages');
define('CONF_SESSION_LOGIN', 'logged_user');
define('CONF_SESSION_DESCONNECT', 'desconnect');

/*
 * PROJECT
 */
define('CONF_PROJECT_PATH_NAME', "shopexpert");
define('CONF_LOCAL_PROJECT', '/var/www/html/' . CONF_PROJECT_PATH_NAME);
define('CONF_NAMESPACE_DEFAULT', 'app\\controllers\\');
define('CONF_NAME_CONTROLLER_DEFAULT', 'Controller');
define('CONF_FILE_DEFAULT', 'index.php');
define('CONF_CONTROLLER_DEFAULT', 'Index');
define('CONF_METHOD_DEFAULT', 'index');

/*
 * PATH BOT
 */
define('CONF_PATH_BOT', CONF_LOCAL_PROJECT . "/scripts/bot/");

/*
 * LOGGER
 */
define('CONF_LOGGER_ATIVE', true);
define('CONF_LOGGER_PATH', __DIR__ . "/../logger/");
define('CONF_LOGGER_MODEL', 'model');
define('CONF_LOGGER_CONTROLLER', 'controller');

/*
 * TEAMPLATE 
 */
define('CONF_TEMPLATE_DEFAULT', 'template');
define('CONF_DIR_TEMPLATE', 'app/views/');
define('CONF_EXTESAO_TEMPLATE', '.php');

/*
 * MESSAGE
 */
define('CONF_MESSAGE_CLASS', 'alert alert-');
define('CONF_MESSAGE_DEFAULT', 'default');
define('CONF_MESSAGE_INFO', 'info');
define('CONF_MESSAGE_SUCCESS', 'success');
define('CONF_MESSAGE_DANGER', 'danger');
define('CONF_MESSAGE_WARNING', 'warning');
define('CONF_RETURN_AJAX_SUCCESS', 'SUCCESS;');
define('CONF_RETURN_AJAX_FAIL', 'FAIL;');

/*
 * LOGOS
 */
define('CONF_MAIN_LOGO', CONF_URL_BASE . '/public/img/main/logo/logo_login.png');
define('CONF_NAV_LOGO', CONF_URL_BASE . '/public/img/main/logo/logo_header.png');
define('CONF_LOGO_MAIL_HEADER', CONF_URL_BASE . '/public/img/mail/mail_header.png');
define('CONF_LOGO_MAIL_FOOTER', CONF_URL_BASE . '/public/img/mail/mail_footer.png');
define('CONF_PROFILE_IMG', CONF_URL_BASE . '/public/img/perfil/I_love_game.png');

/**
 * DATE
 */
define('CONF_DATE_BR', 'd/m/Y');
define('CONF_DATE_HOUR_BR', 'd/m/Y H:i:s');
define('CONF_DATE_APP', 'Y-m-d');
define('CONF_DATE_HOUR_APP', 'Y-m-d H:i:s');

/*
 * MAIL
 */
define('CONF_MAIL_HOST', 'smtp.gmail.com');
define('CONF_MAIL_PORT', '587');
define('CONF_MAIL_USER', 'shopexpert@gmail.com');
define('CONF_MAIL_PASSWD', '123456');
define('CONF_MAIL_OPTION_CHARSET', 'UTF8');
define('CONF_MAIL_OPTION_AUTH', 'true');
define('CONF_MAIL_OPTION_SECURE', 'tls');
define('CONF_MAIL_OPTION_TITLE', 'ShopExpert');
define('CONF_MAIL_LOG', 'mailing');

/*
 * MAILING
 */
define('CONF_MAILING_TEMP_VALIDACAO', __DIR__ . '/../public/mailing/validateaccount.html');
define('CONF_MAILING_TEMP_RECUPERAR', __DIR__ . '/../public/mailing/recoveraccount.html');

/*
 *  DATA BASE
 */
define('CONF_DB_DRIVER', 'pgsql');
define('CONF_DB_HOST', '127.0.0.1');
define('CONF_DB_PORT', '5432');
define('CONF_DB_BASE', 'shopexpert');
define('CONF_DB_USER', 'shopexpert');
define('CONF_DB_PASSWD', 'shopexpert');
define('CONF_DB_OPTIONS', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
    PDO::ATTR_CASE => PDO::CASE_NATURAL
]);