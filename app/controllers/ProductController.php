<?php

namespace app\controllers;

use app\core\Controller;
use app\models\Category;
use app\models\Product;

class ProductController extends Controller {

    function __construct() {
        if (!session()->data(CONF_SESSION_LOGIN)) {
            redirect('login');
        }
    }

    public function index(){
        $this->load('home/index');
        $this->view('template');
    }

    public function create($action = null, $id = null){
        $input = is_postback();
        $category = new Category;
        $product = new Product();
        
        if ($input) {
            
            $product->name = $input['name'];
            $product->description =  $input['description'];
            $product->price = $input['price'];
            $product->unity = $input['unity'];
            $product->split_payment = $input['split_payment'];
            $product->tax = $input['tax'];
            $product->test_period = $input['test_period'] ?? 0;
            $product->id_category = $input['category'];
            $product->active = $input['active'] ?? 0;
            
            $callback = $product->callback();
            $res = $product->save($id);

            if($res && empty($callback)){
                $this->message()->success(config('messages')['ACTION_SUCCESS'])->flash();
            } else {
                $this->message()->danger($callback)->flash();
            } 
        }

        if ($action == 'delete' && $product->delete($id)) {
            $this->message()->danger(config('messages')['ACTION_DELETED'])->flash();
        }

        if ($action == 'edit' && $id && !$input) {
            unset($action);
            $info['product'] = $product->find($id);
        }

        $info['all'] = $product->findWithCategory();
        $info['category'] = $category->findAll();

        $this->load('product/create', $action);
        $this->view('template', $info);

    }
}
