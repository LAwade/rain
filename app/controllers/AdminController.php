<?php

namespace app\controllers;

use app\core\Controller;
use app\models\Bank;
use app\models\Menu;
use app\models\Page;
use app\models\Permission;

class AdminController extends Controller {

    function __construct() {
        if (!session()->data(CONF_SESSION_LOGIN)) {
            redirect('login');
        }
    }

    public function index() {

    }
    
    public function menu($action = null, $id = null) {
        $input = is_postback();
        $menu = new Menu();

        if (isset($input['exec'])) {
            $menu->name = $input['name_menu'];
            $menu->icon = $input['icon_menu'];
            $menu->position = $input['position_menu'];
            $menu->active = $input['active_menu'] ?? 0;

            $res = $menu->save($id);
            $callback = $menu->callback();
            if ($res && !$callback) {
                $this->message()->success(config('messages')['ACTION_SUCCESS'])->flash();
            } else {
                $this->message()->danger($callback)->flash();
            }
        }

        if ($action == 'edit' && $id && !$input) {
            unset($action);
            $info['menu'] = $menu->find($id);
        }

        if ($action == 'delete' && $menu->delete($id)) {
            $this->message()->danger(config('messages')['ACTION_DELETED'])->flash();
        }

        $info['all'] = $menu->findAll();

        $this->load('admin/menu', $action);
        $this->view('template', $info);
    }

    public function page($action = null, $id = null) {
        $input = is_postback();

        $menu = new Menu();
        $permission = new Permission;
        $page = new Page();

        if ($input) {
            $page->name = $input['name_page'];
            $page->path = $input['path_page'];
            $page->id_menu = $input['id_menu'];
            $page->access_id_permission = $input['access_id_permission'];
            $page->active = $input['active_page'] ?? 0;
            $res = $page->save($id);

            $callback = $page->callback();
            if ($res && !$page->callback()) {
                $this->message()->success(config('messages')['ACTION_SUCCESS'])->flash();
            } else {
                $this->message()->danger($callback)->flash();
            }
        }

        if ($action == 'delete' && $page->delete($id)) {
            $this->message()->danger(config('messages')['ACTION_DELETED'])->flash();
        }

        if ($action == 'edit' && $id && !$input) {
            unset($action);
            $info['pages'] = $page->find($id);
        }

        $info['permission'] = $permission->findAll();
        $info['menu'] = $menu->findAll();
        $info['all'] = $page->findAllConfig();

        $this->load('admin/page', $action);
        $this->view('template', $info);
    }
    
    public function bank($action = null, $id = null) {
        $input = is_postback();

        $bank = new Bank();

        if ($input) {
            $bank->name = $input['name'];
            $bank->description = $input['description'];
            $bank->url = $input['url'];
            $bank->url_notification = $input['url_notification'];
            $bank->key = $input['key'] ?? 0;
            $bank->extra_code = $input['extra_code'] ?? 0;
            $bank->active = $input['active'] ?? 0;
            $res = $bank->save($id);

            $callback = $bank->callback();
            if ($res && !$bank->callback()) {
                $this->message()->success(config('messages')['ACTION_SUCCESS'])->flash();
            } else {
                $this->message()->danger($callback)->flash();
            }
        }

        if ($action == 'delete' && $bank->delete($id)) {
            $this->message()->danger(config('messages')['ACTION_DELETED'])->flash();
        }

        if ($action == 'edit' && $id && !$input) {
            unset($action);
            $info['banks'] = $bank->find($id);
        }

        $info['all'] = $bank->findAll();

        $this->load('admin/bank', $action);
        $this->view('template', $info);
    }

}