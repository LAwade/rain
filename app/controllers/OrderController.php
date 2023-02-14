<?php

namespace app\controllers;

use app\core\Controller;
use app\models\Invoice;
use app\models\Item;
use app\models\Order;
use app\models\Status;
use app\shared\MercadoPagoPIX;

class OrderController extends Controller
{

    private $mp;

    function __construct()
    {
        if (!session()->data(CONF_SESSION_LOGIN)) {
            redirect('login');
        }

        $this->mp = new MercadoPagoPIX(CONF_MP_URL, CONF_MP_KEY, CONF_MP_URL_NOTIFICATION);
        $this->mp->document(CONF_DOC_TYPE, CONF_DOC_NUMBER);
        $this->mp->address(CONF_ADDRESS_ZIPCODE, CONF_ADDRESS_STREETNAME, CONF_ADDRESS_STREETNUMBER, CONF_ADDRESS_NEIGHBORHOOD, CONF_ADDRESS_CITY, CONF_ADDRESS_UF);
    }

    public function index()
    {
        // $this->load('home/index');
        // $this->view('template');
    }

    public function create($id = null)
    {
        $input = is_postback();
        $status = new Status;
        $order = new Order;
        $invoice = new Invoice;

        $data = (array) session()->data(CONF_SESSION_CART);

        if(!$id && !$data){
            redirect('store/shop');
        }
        
        if (!$id && $data) {
            $status = $status->findByName(CONF_STORE_STATUS_DEFAULT);
            $order->id_client = session()->data(CONF_SESSION_LOGIN)->id;
            $order->id_status = $status->id;
            $order->active = 0;
            $id = $order->save();

            if ($id) {
                foreach ($data as $p) {
                    $item = new Item();
                    $item->id_order = $id;
                    $item->id_product = $p;
                    $item->quantity = 1;
                    $item->active = 0;
                    $item->save();
                }
            }
            session()->unset(CONF_SESSION_CART);
        }

        $order = $order->findItensByUser(session()->data(CONF_SESSION_LOGIN)->id, $id);

        if ($order) {
            $amount = 0;
            $external_id = null;
            $status = [];
            foreach ($order as $o) {
                $external_id = $o->order_id;
                $amount += ($o->price * $o->unity);
            }

            $inv = $invoice->findByOrder($id);
            $status = [CONF_STATUS_PENDING, CONF_STATUS_OVERDUE, CONF_STATUS_CANCELED, CONF_STATUS_TEST];

            if($inv->id_status == CONF_STATUS_PAYED){
                redirect('store/shop');
            }

            $type = in_array($inv->id_status, $status) ? "INVOICE" : "ORDER";
            $response = (array) session()->data(CONF_MP_SESSION_RESPONSE);

            if (strtotime($response['date_of_expiration']) <= time()) {
                session()->unset(CONF_MP_SESSION_RESPONSE);
                $response = null;
            }

            if (!$response) {
                $name = explode(" ", session()->data(CONF_SESSION_LOGIN)->name);
                $this->mp->sale($name[0], $name[1] ?? $name[0], session()->data(CONF_SESSION_LOGIN)->email, $amount, $external_id, $type);
                $response = json_decode($this->mp->send(), true);
                session()->set(CONF_MP_SESSION_RESPONSE, $response);
            }

            $info['qr_code_base64'] = $response['point_of_interaction']['transaction_data']['qr_code_base64'];
            $info['qr_code'] = $response['point_of_interaction']['transaction_data']['qr_code'];
            $info['amount'] = $amount;
            $info['external_id'] = $external_id;
            $info['description'] = $type;
            session()->set(CONF_API_TOKEN, getToken());
        }

        $this->load('order/create');
        $this->view('template', $info);
    }

    public function show($id = null)
    {
        $order = new Order;
        $info['orders'] = $order->findByUser(session()->data(CONF_SESSION_LOGIN)->id, $id);
        $info['pedidos'] = $order->findItensByUser(session()->data(CONF_SESSION_LOGIN)->id, $id);
        $this->load('order/show');
        $this->view('template', $info);
    }
}
