<?php

namespace app\controllers;
use app\core\Controller;
use app\shared\Paypal;
use app\models\Order;
use app\cases\SaleCase;
use app\models\Payment;
use app\models\Bank;
use app\providers\ProductProvider;
use app\providers\SaleProvider;
use Exception;

class APIController extends Controller {

    function __construct($param = null) {
        if (!session()->data(CONF_API_TOKEN)) {
            if($param[0] == 'token' && $param[1]){
                $this->auth($param[1]);
            }

            api([
                'error' => true,
                'message' => "could not authenticate"
            ]);
        }
        session()->unset(CONF_API_TOKEN);
    }

    public function index() {
        api([
            'error' => true,
            'message' => "could not authenticate."
        ]);
    }

    private function auth($token) {
        session()->set(CONF_API_TOKEN, $token);
        api([
            'error' => false,
            'message' => "authenticated."
        ]);
    }

    public function ping() {
        api([
            'error' => false,
            'message' => "Sua mensagem foi lida as " . date('d/m/Y H:i:s'),
            "data" => [
                'IP' => $_SERVER['REMOTE_ADDR']
            ]
        ]);
    }

    public function mercadopago(){
        $input = is_postback();

        api([
            'error' => false,
            'message' => ''
        ]);
    }

    public function paypal(){
        $input = is_postback();

        try{
            $pay = new Payment;
            $bank = new Bank;
            $paypal = new Paypal(CONF_PAYPAL_MODE);
            $getOrder = $paypal->getOrder($input['id']);
            $response = json_decode($getOrder , true);
    
            if($response['status'] == "COMPLETED"){
                $sales = new SaleCase(new SaleProvider, new ProductProvider);
    
                $result = $bank->findLikeByName('paypal');
                if (strtolower($result->name) != strtolower('paypal')) {
                    throw new Exception("Não foi possível encontrar o banco!");
                }
    
                $pay->id_status = CONF_STATUS_PENDING;
                $pay->id_bank = $result->id;
                $pay->id_invoice = $response['purchase_units'][0]['custom_id'];
                $pay->amount = $response['purchase_units'][0]['amount']['value'];
                $pay->received = $response['purchase_units'][0]['amount']['value'];
                $pay->code_reference = $response['purchase_units'][0]['payments']['captures'][0]['id'];
                $pay->logs = base64_encode($getOrder);
                $savePay = $pay->save();
    
                if(!$savePay){
                    api([
                        'error' => true,
                        'message' => "Pagamento não aprovado!"
                    ]);
                    return;
                }
    
                if(strtoupper($response['purchase_units'][0]['description']) == 'ORDER'){
                    $sales->handle('ORDER', $response['purchase_units'][0]['custom_id'], 
                        [
                            'pay_id' => $savePay,
                            'amount' => $response['purchase_units'][0]['amount']['value'],
                            'code_reference' => $response['purchase_units'][0]['payments']['captures'][0]['id']
                        ]
                    );
                } 
    
                if(strtoupper($response['purchase_units'][0]['description']) == 'PAYMENT'){
                    $sales->handle('ORDER', $response['purchase_units'][0]['custom_id'], 
                        [
                            'pay_id' => $savePay,
                            'amount' => $response['purchase_units'][0]['amount']['value'],
                            'code_reference' => $response['purchase_units'][0]['payments']['captures'][0]['id']
                        ]
                    );
                }
    
                api([
                    'error' => false,
                    'message' => "Pagamento aprovado!"
                ]);
            }
        } catch (Exception $ex) {
            logger()->error($ex->getMessage());
        }

        api([
            'error' => true,
            'message' => "Pagamento não aprovado!"
        ]);
    }
}