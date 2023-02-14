<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h3 class="mt-4">Loja</h3>
    </div>
    <hr>

    <div class='row'>
        <div class='col-lg-10 mb-4'></div>
    </div>
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <?php foreach ($category as $v) { ?>
                <?php $actv = strtolower($v->name) == 'teamspeak' ? 'active' : '' ?>
                <?= "<a class='nav-item nav-link $actv' id='nav-{$v->name}-tab' data-toggle='tab' href='#nav-{$v->name}' role='tab' aria-controls='nav-{$v->name}' aria-selected='true'>{$v->name}</a>" ?>
            <?php } ?>
        </div>
    </nav>

    <div class="tab-content" id="nav-tabContent">
        <?php $count = 0; ?>
        <?php $category = ""; ?>

        <?php foreach ($all as $k => $p) { ?>
            <?php if ($category != $p->name_category) { ?>
                <?= !empty($category) ? "</div></div></div>" : '' ?>
                <?php $actv1 = strtolower($p->name_category) == 'teamspeak' ? 'show active' : '' ?>
                <?= "<div class='tab-pane fade $actv1' id='nav-{$p->name_category}' role='tabpanel' aria-labelledby='nav-{$p->name_category}-tab'>" ?>
                <?= "<br/>" ?>
                <?= "<div class='row'><div class='col-lg-12 mb-4 card-deck text-center'>" ?>
                <?php $category = $p->name_category; ?>
                <?php $count = 0; ?>
            <?php } ?>

            <?php
                if ($count == 4) {
                    echo "</div></div>";
                    echo "<div class='row'><div class='col-lg-12 mb-4 card-deck text-center'>";
                    $count = 0;
                }
            ?>
            <div class="card mb-4 shadow-sm">
                <div class="card-header">
                    <h5 class="my-0 font-weight-normal"><?= $p->name ?></h5>
                </div>
                <div class="card-body">
                    <h3 class="card-title pricing-card-title">R$<?= str_format_reais($p->price * $p->unity) ?> <small class="text-muted">/mês</small></h3>
                    <ul class="list-unstyled mt-3 mb-4">
                        <?= $p->description ?>
                    </ul>
                    <?php if($p->test_period){ ?>
                        <ul class="list-unstyled mt-3 mb-4">
                            <b>Periodo de Teste <?= $p->test_period ?> dia(s)</b>
                        </ul>
                    <?php } ?>
                    
                    <button type="button" onclick="toastalert('Foi adicionado ao seu carrinho o [<?= $p->name ?>]', 'info')" class="btn btn-md btn-block btn-success shop_start" id="<?= $p->id ?>" >Adicionar ao carrinho</button>
                </div>
            </div>
            <?php $count++; ?>
        <?php } ?>
        </div></div></div>
    </div>

    <div class='row'>
        <div class='col-lg-10 mb-4'></div>
        <div class='col-lg-2 mb-4'>
            <a type="button" class="btn btn-md btn-block btn-primary" href="/store/cart"><i class="fas fa-shopping-cart"></i><span id="mycart"> Carrinho<span></a>
        </div>
    </div>
    <?= "<script>localStorage.setItem('token_shop', '{$token}');</script>" ?>
</div>