$(function () {
    $("input[type='file']").change(function(){
        nameFileUpload()
    })
})

const nameFileUpload = function () {
    const id = $("input[type='file']").attr('id')
    $("label[for=" + id + "]").text($('#' + id)[0].files[0].name)
}

const toastalert = (message, type, timer = 2500) => {
    $("#layoutSidenav_content").append(`<div class="callout callout-${type}" id="toast-alert">
        <div class="callout-container">
            <p>${message}</p>
        </div>
    </div>`)

    setTimeout(function() {
        $("#toast-alert").fadeOut('slow', function(){
            $(this).remove()
        })
    }, timer);
}