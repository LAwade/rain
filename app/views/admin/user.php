<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h3 class="mt-4">Users</h3>
    </div>
    <hr>

    <!-- Content Row -->
    <div class="row">
        <!-- Content Column -->
        <div class="col-lg-12 mb-4">
            <!-- Project Card Example -->
            <div class="card shadow mb-4">
                <div class="card-header">
                    <i class="fas fa-scroll"></i> Create
                </div>
                <div class="card-body">
                    <form class="user" method="POST">
                        <div class="form-group row">
                            <div class="col-sm-12 mb-3 mb-sm-0">
                                <h4 class="small font-weight-bold">Name:</h4>
                                <input type="text" name="name" value="<?= $users->name ?>" class="form-control" placeholder="Name">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-12 mb-3 mb-sm-0">
                                <h4 class="small font-weight-bold">E-mail:</h4>
                                <input type="text" name="email" value="<?= $users->email ?>" class="form-control" placeholder="E-mail">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-12 mb-3 mb-sm-0">
                                <h4 class="small font-weight-bold">Password:</h4>
                                <input type="password" name="password" value="" class="form-control" placeholder="Password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-12 mb-3 mb-sm-0">
                                <h4 class="small font-weight-bold">Permission:</h4>
                                <select class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref" name="permission">
                                    <?php foreach ($permissions as $value) { ?>
                                        <option value="<?= $value->id ?>" <?= $permission_user->id == $value->id ? 'selected' : '' ?> ><?= $value->name ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-12 mb-3 mb-sm-0">
                                <h4 class="small font-weight-bold">Status:</h4>
                                <div class="form-group form-check">
                                    <input type="checkbox" name="active" value="1" class="form-check-input" <?= $users->active ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="exampleCheck1">Active</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-3 mb-3 mb-sm-0">
                                <input type="submit" class="btn btn-success" name="exec" value="Save"/>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-12 mb-4">
            <div class="form-group row">
                <div class="col-sm-12 mb-3 mb-sm-0">
                    <?= session()->flash(); ?>
                </div>
            </div>
        </div>

        <?php if ($all) { ?>
            <div class="col-lg-12 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header">
                        <i class="fas fa-scroll"></i> List
                    </div>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Status</th>
                                <th scope="col">Last Access</th>
                                <th scope="col">Created</th>
                                <th scope="col" colspan="2"></th>
                            </tr>
                        </thead>
                        <?php foreach ($all as $value) { ?>
                            <tbody>
                                <tr>
                                    <th scope="row"><?= $value->id ?></th>
                                    <td><?= $value->name ?></td>
                                    <td><?= $value->email ?></td>
                                    <td><?= $value->active ? "<i class='fas fa-check text-success'></i>" : "<i class='fas fa-times text-danger'></i>" ?></td>
                                    <td><?= date_hours_br($value->last_access) ?></td>
                                    <td><?= date_hours_br($value->created_at) ?></td>
                                    <td> 
                                        <a href="<?= CONF_URL_BASE . "/admin/user/edit/{$value->id}" ?>" class="btn btn-success btn-icon-split">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-pen"></i>
                                            </span>
                                        </a>
                                        <a href="<?= CONF_URL_BASE . "/admin/user/delete/{$value->id}" ?>" class="btn btn-danger btn-icon-split">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-trash"></i>
                                            </span>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        <?php } ?>
                    </table>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
