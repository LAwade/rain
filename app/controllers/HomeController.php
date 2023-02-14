<?php

namespace app\controllers;

use app\core\Controller;
use app\models\Client;
class HomeController extends Controller {

    function __construct() {
        if (!session()->data(CONF_SESSION_LOGIN)) {
            redirect('login');
        }
    }

    public function index() {
        
        $this->load('home/index');
        $this->view('template');
    }

    public function changepassword() {
        $input = is_postback();
        
        if ($input) {
            $client = new Client;
            if ($input['password'] == $input['repassword']) {
                $data = $client->find(session()->data(CONF_SESSION_LOGIN)->id);
                $client->name = $data->name;
                $client->email = $data->email;
                $client->password = $input['password'];
                $client->active = $data->active;
                
                if ($client->save(session()->data(CONF_SESSION_LOGIN)->id)) {
                    $this->message()->success("Your password updated!")->flash();
                } else {
                    $this->message()->danger("Couldn't change password!")->flash();
                }
            } else {
                $this->message()->danger("The passwords are different!")->flash();
            }
        }
        $this->load('home/changepassword');
        $this->view('template');
    }
}