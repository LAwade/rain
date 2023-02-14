<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h3 class="mt-4">Pedidos</h3>
    </div>
    <hr>
    <div class="row">
        <div class="col-lg-12 mb-4">
            <?php foreach ($orders as $o) { ?>
                <div class="card mb-2">
                    <a href="#collapseCard<?= $o->id ?>" style="text-decoration: none" class="d-block card-header py-3 collapsed" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapseCard<?= $o->id ?>">
                        <h6 class="m-0 font-weight-bold text-primary"> #<?= $o->id ?> PEDIDO | <span class="text-<?php echo ($o->name == CONF_STORE_STATUS_DEFAULT) ? "danger" : 'success' ?>"><?= $o->name ?></span> </h6>
                    </a>
                    <div class="py-3 collapse col-lg-6" id="collapseCard<?= $o->id ?>">
                        <ol class="list-group list-group-numbered">
                            <?php foreach ($pedidos as $p) { 
                                if($p->order_id == $o->id){
                            ?>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold"><b><?= $p->product_name ?></b></div>
                                        <small class="text-muted"><?= $p->description ?></small>
                                    </div>
                                    <span class="badge bg-default">R$ <?= str_format_reais($p->price * $p->unity) ?></span>
                                </li>
                            <?php }} ?>
                        </ol>
                    </div>

                    <div class="collapse col-lg-6" id="collapseCard<?= $o->id ?>">
                        <a href="#">Editar</a> 
                        &nbsp;
                        <?php if($o->name == CONF_STORE_STATUS_DEFAULT){ ?>
                            <a href="<?= CONF_URL_BASE . "order/create/" . $o->id ?>">Efetuar Pagamento</a>
                        <?php } ?>
                    </div>

                    <div class="collapse col-lg-12" id="collapseCard<?= $o->id ?>">
                        <hr>
                        <small class="text-muted"> Criado em: <?= date_hours_br($o->created_at) ?> </small>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>