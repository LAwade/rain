<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h3 class="mt-4">Carrinho</h3>
    </div>
    <hr>
    <div class="row">
        <?php if ($products) { ?>
            <div class="col-md-8 order-md-1">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Meus itens</span>
                </h4>
                <ul class="list-group mb-3">
                    <?php $total = 0; ?>
                    <?php foreach ($products as $k => $v) { ?>
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <div>
                                <h6 class="my-0"><?= $v->name ?></h6>
                                <small class="text-muted"><?= $v->description ?></small>
                                <br>
                                <a href="<?= CONF_URL_BASE ?>store/cart/delete/<?= $v->id ?>">Excluir</a>
                            </div>
                            <h5><strong>R$ <?= str_format_reais($v->price * $v->unity) ?></strong></h5>
                            <?php $total += ($v->price * $v->unity) ?>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <div class="col-md-4 order-md-2 mb-4">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Finalizar</span>
                </h4>
                <form action="<?= CONF_URL_BASE ?>order/create" method="post">
                    <ul class="list-group mb-3">
                        <li class="list-group-item">
                            <h5>Formas de Pagamento</h5>
                            <p>PIX (Brasil)</p>
                            <p>PayPal (Other Countries)</p>
                        </li>

                        <li class="list-group-item d-flex justify-content-between bg-light">
                            <span>Total (BRL)</span>
                            <strong>R$ <?= str_format_reais($total) ?></strong>
                        </li>
                    </ul>
                    <input type="submit" name="exec" class="btn btn-primary btn-lg btn-block" value="Continue o checkout">
                </form>
            </div>
        <?php } else { ?>
            <div class="col-md-12 order-md-1">
                <h3 class="cover-heading">Não encontramos nada no seu carrinho!</h3>
                <p class="lead">Visite nossa loja e veja os nossos produtos e serviços!</p>
                <p class="lead">
                    <a href="<?= CONF_URL_BASE ?>store/shop" class="btn btn-lg btn-primary">Ir para loja</a>
                </p>
            </div>
        <?php } ?>
    </div>
</div>