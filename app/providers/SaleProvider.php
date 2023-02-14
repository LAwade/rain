<?php

namespace app\providers;

use app\interface\ISale;
use app\models\Bank;
use app\models\Invoice;
use app\models\Order;
use app\models\Item;
use app\models\Payment;
use Exception;

class SaleProvider implements ISale
{

    public function invoice($id, $data)
    {
    }

    public function order($id, $payment)
    {
        $order = new Order;
        $pay = new Payment;
        $bank = new Bank;
        $invoice = new Invoice;

        try {
            if (!$id || !$payment) {
                throw new Exception("Não foi possível receber as informações dos parametros");
            }

            $order->begin();

            $result = $order->find($id);
            $result->active = 1;
            $result->id_status = CONF_STATUS_FINISH;
            $rsp = $result->save($id);

            if (!$rsp) {
                throw new Exception("Não foi possível alterar as informações dos status do pedido!");
            }

            $data = $order->findAllItens($id);
            $amount = 0;
            foreach ($data as $v) {
                $item = new Item();
                $result = $item->find($v->id_item);
                $result->active = 1;
                $amount += ($v->price * $v->unity);
                if (!$result->save($v->id_item)) {
                    throw new Exception("Não foi possível alterar as informações dos status do item!");
                }
            }

            $invoice->id_order = $id;
            $invoice->id_status = CONF_STATUS_PAYED;
            $invoice->amount = $amount;
            $invoice->payment_date = date('Y-m-d');
            $invoice->due_date = date_incrase_days(date('Y-m-d'), 30);
            $saveInvoice = $invoice->save();

            if(!$saveInvoice){
                throw new Exception("Não foi possível inserir os dados da fatura!");
            }

            $pay = $pay->find($payment['pay_id']);
            $pay->id_status = CONF_STATUS_FINISH;
            $savePay = $pay->save($payment['pay_id']);

            if(!$savePay){
                throw new Exception("Não foi possível alterar as informações do pagamento!");
            }

            $allitens = $order->findAllItens($id);
            $order->commit();

            return $allitens;
        } catch (Exception $e) {
            logger(str_name_file(__FILE__))->error($e->getMessage());
            $order->rollback();
        }

        return false;
    }
}
