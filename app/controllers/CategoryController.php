<?php

namespace app\controllers;

use app\core\Controller;
use app\models\Category;

class CategoryController extends Controller {

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
        $category = new Category();

        if ($input) {
            $category->name = $input['name'];
            $category->description = $input['description'];
            $category->active = $input['active'] ?? 0;

            $res = $category->save($id);
            $callback = $category->callback();

            if($res && !$callback){
                $this->message()->success(config('messages')['ACTION_SUCCESS'])->flash();
            } else {
                $this->message()->danger($callback)->flash();
            } 
        }

        if ($action == 'delete' && $category->delete($id)) {
            $this->message()->danger(config('messages')['ACTION_DELETED'])->flash();
        }

        if ($action == 'edit' && $id && !$input) {
            unset($action);
            $info['category'] = $category->find($id);
        }

        $info['all'] = $category->findAll();

        $this->load('category/create', $action);
        $this->view('template', $info);
    }
}
?>