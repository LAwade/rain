<?php

namespace app\shared;
use app\shared\RequestCURL;

class Paypal {
    private $url;
    private $client_id;
    private $secret_key;
    private $token;
    private $api;

    function __construct($mode)
    {
        if($mode == 'sandbox'){
            $this->url = CONF_PAYPAL_SANDBOX_URL;
            $this->client_id = CONF_PAYPAL_SANDBOX_CLIENTID;
            $this->secret_key = CONF_PAYPAL_SANDBOX_SECRETKEY;
        } else {
            $this->url = CONF_PAYPAL_URL;
            $this->client_id = CONF_PAYPAL_CLIENTID;
            $this->secret_key = CONF_PAYPAL_SECRETKEY;
        }
        $this->auth();
    }

    public function auth(){
        $this->api = 'v1/oauth2/token';
        $response = json_decode($this->request('grant_type=client_credentials', true), true);
        $this->token = $response['access_token'];
    }

    public function getOrder($id){
        $this->api = "v2/checkout/orders/$id";
        return $this->request();
    }

    private function request($data = null){
            $request = new RequestCURL($this->url . "/" . $this->api);

            if(!$this->token){
                $request->content_type([
                    "Content-Type: application/x-www-form-urlencoded"
                ]);
                $request->user_pwd("{$this->client_id}:{$this->secret_key}");
            } else {
                $request->content_type([
                    "Content-Type: application/json", 
                    "Authorization: Bearer " . $this->token
                ]);
            }

            if($data){
                $request->post_field($data, true);
            }
           
            return $request->exec_request();
    }
}

?>