<?php

namespace app\controllers;

use app\core\Controller;
use app\models\Category;
use app\models\Product;

class StoreController extends Controller {

    function __construct() {
        if (!session()->data(CONF_SESSION_LOGIN)) {
            redirect('login');
        }
    }

    public function index(){
        $this->load('home/index');
        $this->view('template');
    }

    public function shop(){

        $token = md5(time() . rand(999,999999));
        session()->set(CONF_SESSION_SHOP_TOKEN, $token);

        $product = new Product;
        $category = new Category;

        $info['all'] = $product->findWithCategory();
        $info['category'] = $category->findAll();
        $info['token'] = $token;

        $this->load('store/shop');
        $this->view('template', $info);
    }

    public function cart($action = null, $id = null){

        $info = [];
        $product = new Product;

        if ($action == 'delete' && $id) {
            $cart = (array) session()->data(CONF_SESSION_CART);
            if (($key = array_search($id, $cart)) !== false) {
                unset($cart[$key]);
                session()->set(CONF_SESSION_CART, $cart);
                $this->message()->danger("The item was successfully removed!")->flash();
            }
        }

        $cart = (array) session()->data(CONF_SESSION_CART);
        if($cart){
            foreach($cart as $c){
                $info['products'][] = $product->find($c);
            }
        }
        
        $this->load('store/cart');
        $this->view('template', $info);
    }

    public function itens($token = null){
        $input = is_postback();
        $data = [];
        if($token == session()->data(CONF_SESSION_SHOP_TOKEN) && $input){

            if(session()->data(CONF_SESSION_CART)){
                $data = (array) session()->data(CONF_SESSION_CART);
            }

            if($input['action'] == 'add'){
                array_push($data, $input['id']);
                session()->set(CONF_SESSION_CART, $data);
            }
            
            api(["error" => false, "message" => "OK", "count" => count($data), "cart" => $data]);
        } else {
            api(["error" => true, "message" => "Não foi possível encontrar o carrinho informado!"]);
        }
    }
}

?>