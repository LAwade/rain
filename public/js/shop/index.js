$(() => {
    viewitem()
    $(".shop_start").on('click', function() {
        additem($(this).attr('id'));
    })

    paymentInvoice()
})

const additem = (id) => {
    request({
        url: '/store/itens/' + localStorage.getItem('token_shop'), 
        data: {action: 'add', id: id}
    }, (response) => {
        $("#mycart").text(` Carrinho (${response.count})`)
        $("#badge_count_shop").text(response.count)
    })
}

const viewitem = () => {
    request({
        url: '/store/itens/' + localStorage.getItem('token_shop'),
        data: {action: 'view'}
    }, (response) => {
        $("#mycart").text(` Carrinho (${response.count})`)
        $("#badge_count_shop").text(response.count)
    })
}

const request = ({url, data = {}}, handle) => {
    $.ajax({
        url: window.location.origin + url,
        data: data,
        method: "POST"
    }).done(handle)
}

const paymentInvoice = () => {
    $('#paypal-pay').css({
        display: 'none'
    })
    $('input:radio[name="paymenttype"]').change(function() {
        if ($(this).is(':checked') && $(this).val() == 'pix') {
            $('#pix').css({
                display: 'block'
            })
            $('#paypal-pay').css({
                display: 'none'
            })
        } else {
            $('#paypal-pay').css({
                display: 'block'
            })
            $('#pix').css({
                display: 'none'
            })
        }
    })
}