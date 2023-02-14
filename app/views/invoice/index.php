<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h3 class="mt-4">Faturas</h3>
    </div>
    <hr>
    <div class="row">
        <div class="col-lg-12">
            <?php foreach ($invoice as $o) { ?>
                <div class="d-flex text-muted pt-3">
                    <div class="pb-3 mb-0 small lh-sm border-bottom w-100">
                        <div class="d-flex justify-content-between">
                            <h5 class="text-gray-dark">#<?= $o->id ?> FATURA | <span class="text-<?php echo ($o->name == CONF_STORE_STATUS_DEFAULT) ? "danger" : 'success' ?>"><?= $o->name ?></h5>
                            <?php if ($o->name == CONF_STORE_STATUS_DEFAULT) { ?>
                                <h5><a href="<?= CONF_URL_BASE . "order/create/" . $o->id_order ?>">PAGAR AGORA</a></h5>
                            <?php } ?>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="text-gray-dark">Valor: R$<?= str_format_reais($o->amount) ?> | Data Vencimento: <?= date_br($o->due_date) ?> | Data Pagamento: <?= $o->payment_date ? date_br($o->payment_date) : '-' ?></h6>
                            <small class="text-muted"> Gerada em: <?= date_hours_br($o->created_at) ?> </small>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

    </div>
</div>