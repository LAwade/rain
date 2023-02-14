<script>
    const toastTrigger = document.getElementById('liveToastBtn')
    const toastLiveExample = document.getElementById('liveToast')
    if (toastTrigger) {
        toastTrigger.addEventListener('click', () => {
            const toast = new bootstrap.Toast(toastLiveExample)
            toast.show()
        })
    }
</script>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h3 class="mt-4">Dashboard</h3>
    </div>
    <hr>
    <!-- Content Row -->
    <div class="row">

        <a onclick="toastalert('teste dfdddddddddddd fffffffffffffffffff bbbbbbbbbbbbbbbbbbb nnnnnnnnnnnn mmmmmmm', 'success')" class="btn btn-primary">teste</a>

    </div>
</div>
<div class="col-lg-12 mb-4">
    <div class="form-group row">
        <div class="col-sm-12 mb-3 mb-sm-0">
            <?= session()->flash(); ?>
        </div>
    </div>
</div>