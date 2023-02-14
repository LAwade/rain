<?php

namespace app\shared;

use app\shared\RequestCURL;
use Exception;

class MercadoPagoPIX {

    private array $sale;
    private array $address;
    private array $document;

    private string $notification_url;
    private string $key;
    private string $url;

    function __construct(string $url, string $key, string $notification_url)
    {
        $this->url = $url;
        $this->key = $key;
        $this->notification_url = $notification_url;
    }

    function sale($first_name, $last_name, $email, $amount, $external_id, $description){
        $this->sale = [
            "transaction_amount" => $amount,
            "description" => $description,
            "external_reference" => $external_id,
            "notification_url" => $this->notification_url,
            "payment_method_id" => "pix",
            "payer" => [
                "email" => $email,
                "first_name" => $first_name,
                "last_name" => $last_name
            ]
        ];
    }

    function document($document_type, $document_number){
        $this->document = [
            "type" => $document_type,
            "number" => $document_number
        ];
    }

    function address($zip_code, $street_name, $street_number, $neighborhood, $city, $federal_unit){
        $this->address = [
            "zip_code" => $zip_code,
            "street_name" => $street_name,
            "street_number" => $street_number,
            "neighborhood" => $neighborhood,
            "city" => $city,
            "federal_unit" => $federal_unit
        ];
    }
    
    function send(){
        $data = $this->sale;
        $data['payer']['identification'] = $this->document;
        $data['payer']['address'] = $this->address;
        $json = json_encode($data);

        try {
            $request = new RequestCURL($this->url, false);
            $request->content_type([
                "Accept: application/json", 
                "Content-Type: application/json", 
                "Authorization: Bearer " . $this->key
            ]);
            $request->post_field($json, true);
    
            return $request->exec_request();
        } catch (Exception $ex){
            return false;
        }
    }
}

?>


