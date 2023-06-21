<?php

/*
 * PROPRIETS SYSTEM
 */
define('CONF_NAME_SYSTEM', 'Lendários TeaM');
define('CONF_VERSION_CURRENT', '0.0.1 BETA');
define('CONF_ACCOUNT_ADMINISTRATOR', 'admin');
define('CONF_VALUE_PERMISSION_MASTER', 100);
define('CONF_DEFAULT_PERMISSION', 3);

/*
 * URL
 * Info: add slash the final URL in (CONF_URL_SITE, CONF_URL_BASE)
 */
define('CONF_URL_SITE', "127.0.0.1");
define('CONF_URL_BASE', "http://127.0.0.1/");
define('CONF_URL_URI', substr($_SERVER['REQUEST_URI'], 1));
define('CONF_URL_INDEX', 'panel/index');

/*
 * SESSION
 */
define('CONF_SESSION_MENU', 'menu_pages');
define('CONF_SESSION_LOGIN', 'logged_user');
define('CONF_SESSION_DESCONNECT', 'desconnect');
define('CONF_SESSION_CART', 'mycart');
define('CONF_SESSION_SHOP_TOKEN', 'shop_token');

/*
 * PROJECT
 */
define('CONF_PROJECT_PATH_NAME', "Rain");
define('CONF_LOCAL_PROJECT', '/var/www/html/'. CONF_PROJECT_PATH_NAME);
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
define('CONF_MESSAGE_FILE', 'messages');

/*
 * LOGOS
 */
define('CONF_MAIN_LOGO', CONF_URL_BASE . 'public/img/main/logo/logo_login.png');
define('CONF_NAV_LOGO', CONF_URL_BASE . 'public/img/main/logo/logo_header.png');
define('CONF_LOGO_MAIL_HEADER', CONF_URL_BASE . 'public/img/mail/mail_header.png');
define('CONF_LOGO_MAIL_FOOTER', CONF_URL_BASE . 'public/img/mail/mail_footer.png');
define('CONF_PROFILE_IMG', CONF_URL_BASE. 'public/img/perfil/I_love_game.png');

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
define('CONF_MAIL_HOST', '');
define('CONF_MAIL_PORT', '');
define('CONF_MAIL_USER', '');
define('CONF_MAIL_PASSWD', '');
define('CONF_MAIL_OPTION_CHARSET', 'UTF8');
define('CONF_MAIL_OPTION_AUTH', 'true');
define('CONF_MAIL_OPTION_SECURE', 'tls');
define('CONF_MAIL_OPTION_TITLE', 'Rain');
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
define('CONF_DB_HOST', '159.203.176.221');
define('CONF_DB_PORT', '5432');
define('CONF_DB_BASE', 'rain');
define('CONF_DB_USER', 'lendarios');
define('CONF_DB_PASSWD', 'Hunt3r@195');
define('CONF_DB_OPTIONS', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
    PDO::ATTR_CASE => PDO::CASE_NATURAL
]);

/*
 * STORE
 */
define('CONF_STORE_STATUS_DEFAULT', 'PENDENTE');

define('CONF_ORDER_STATUS_DEFAULT', 3);
define('CONF_STATUS_CANCELED', 2);
define('CONF_STATUS_PENDING', 3);
define('CONF_STATUS_TEST', 4);
define('CONF_STATUS_OVERDUE', 5);
define('CONF_STATUS_FINISH', 6);
define('CONF_STATUS_PAYED', 7);

/*
 * MERCADO PAGO INTEGRATION
 */
define('CONF_MP_KEY', "XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX");
define('CONF_MP_CODE', 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX');
define('CONF_MP_URL', "https://api.mercadopago.com/v1/payments");

define('CONF_MP_URL_NOTIFICATION', "https://www.lendariosteam.com.br/teste");
define('CONF_MP_URL_NOTIFICATION11', CONF_URL_BASE . "/event.php?code=" . CONF_MP_CODE);
define('CONF_MP_SESSION_RESPONSE', "MP_SESSION_RESPONSE_PIX");

/*
 * PAYPAL INTEGRATION
 */
define('CONF_PAYPAL_MODE', "sandbox");

define('CONF_PAYPAL_URL', "https://api.paypal.com");
define('CONF_PAYPAL_CLIENTID', 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX');
define('CONF_PAYPAL_SECRETKEY', "https://api.mercadopago.com/v1/payments");

define('CONF_PAYPAL_SANDBOX_URL', "https://api-m.sandbox.paypal.com");
define('CONF_PAYPAL_SANDBOX_CLIENTID', "XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX");
define('CONF_PAYPAL_SANDBOX_SECRETKEY', "XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX");

/*
 * ADDRESS COMPANY
 */
define('CONF_ADDRESS_ZIPCODE', "78070720");
define('CONF_ADDRESS_STREETNAME', 'AVENIDA MANOEL JOSE DE ARRUDA');
define('CONF_ADDRESS_STREETNUMBER', '3177');
define('CONF_ADDRESS_NEIGHBORHOOD', 'BELA MARINA');
define('CONF_ADDRESS_CITY', 'CUIABA');
define('CONF_ADDRESS_UF', 'MT');

/*
 * DOCUMENT COMPANY
 */
define('CONF_DOC_TYPE', "CPF");
define('CONF_DOC_NUMBER', '19119119100');

/*
 * API 
*/
define('CONF_API_TOKEN', "SESSION_TOKEN_API_REST");
