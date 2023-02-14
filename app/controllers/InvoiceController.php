<?php

namespace app\controllers;

use app\core\Controller;
use app\models\Invoice;

class InvoiceController extends Controller{

    function __construct()
    {
        if (!session()->data(CONF_SESSION_LOGIN)) {
            redirect('login');
        }
    }

    public function index()
    {
        $invoice = new Invoice;
        $info['invoice'] = $invoice->findByUser(session()->data(CONF_SESSION_LOGIN)->id);
        $this->load('invoice/index');
        $this->view('template', $info);
    }

}
?>