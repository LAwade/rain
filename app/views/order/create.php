<script src="https://www.paypal.com/sdk/js?client-id=AdXMSnqrHWV1XZgpIViu4LuLQbJLsJqZXPmjo2hNUSoLFN6_BuTL7C-zyxo__Khp2Eao2AxnQCzuw2BR&currency=BRL"></script>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h3 class="mt-4"><?= $description == "ORDER" ? "Finalizando Pedido" : "Pagamento da Fatura" ?></h3>
    </div>
    <hr>
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="alert" role="alert" id="alertpayment" style="display:none">
                <h4 class="alert-heading" id="title"></h4>
                <p id="msg"></p>
            </div>
        </div>

        <div class="col-lg-4 mb-4"></div>
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm text-center" id="cardpayment">
                <h5 class="card-header">Pagamento PIX/PayPal</h5>
                <br>
                <div>
                    <h5>Total R$ <?= str_format_reais($amount) ?></h5>
                </div>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="paymenttype" id="paymenttype_pix" value="pix" checked>
                        <label class="form-check-label" for="paymenttype_pix">PIX</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="paymenttype" id="paymenttype_paypal" value="paypal">
                        <label class="form-check-label" for="paymenttype_paypal">PayPal</label>
                    </div>
                </div>
                <hr>

                <div id="pix">
                    <div class="mx-auto">
                        <img src="data:image/jpeg;base64,<?= $qr_code_base64 ?> " width="75%" />
                    </div>

                    <div class="card-body">
                        <p class="card-text">O pagamento deve ser realizado em até 20 minutos, depois desse tempo o Código PIX poderá ser inválido!</p>
                        <hr>
                        <p><b>COPIA E COLA</b></p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="input-group mb-4">
                                <input type="text" class="form-control" id="copiaecolapix" value="<?= $qr_code ?>" aria-describedby="button-addon2">
                                <button class="btn btn-outline-secondary" type="button" onclick="copiarTexto()"><i class="fas fa-clipboard"></i></button>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card-body" id="paypal-pay">
                    <div id="paypal-button-container"></div>
                </div>

            </div>
        </div>
        <div class="col-lg-4 mb-4"></div>
    </div>
</div>

<script>
    var FUNDING_SOURCES = [
        paypal.FUNDING.PAYPAL
    ]

    FUNDING_SOURCES.forEach(function(fundingSource) {
        paypal.Buttons({
            createOrder: (data, actions) => {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '<?= $amount ?>'
                        },
                        custom_id: <?= $external_id ?>,
                        description: '<?= $description ?>'
                    }]
                });
            },
            onApprove: (data, actions) => {
                return actions.order.capture().then(function(orderData) {
                    $.ajax({
                        url: window.location.origin + "/api/paypal",
                        type: 'POST',
                        data: orderData,
                        dataType: 'json',
                        beforeSend: function(){
                            $("#alertpayment").show()
                            $("#cardpayment").hide()
                            $("#title").text("Por favor, aguarde que estamos validando seu pagamento!");
                        }
                    }).done(function(data) {
                        if(data.error == true){
                            $("#alertpayment").addClass("alert-danger")
                            $("#title").text("Ops! Não foi possível confirmar seu pagamento!");
                            $("#msg").text("Por favor, tente mais tarde ou entre em contato com nossa equipe!");
                        } else {
                            $("#alertpayment").addClass("alert-success")
                            $("#title").text("Seu Pagamento foi aprovado!");
                            $("#msg").text("Agradeçemos pela sua confiança ❤️. Iremos lhe redirecionar...");
                            setTimeout(function() {
                                window.location.href = "/order/show";
                            }, 3000);
                        }
                    })
                })
            },
            fundingSource: fundingSource,
        }).render('#paypal-button-container');
    })
</script>
<script>


</script>
<script>
    function copiarTexto() {
        let textoCopiado = document.getElementById("copiaecolapix");
        textoCopiado.select();
        textoCopiado.setSelectionRange(0, 99999)
        document.execCommand("copy");
    }
</script>