<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h3 class="mt-4">Product</h3>
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
                                <input type="text" name="name" value="<?= $product->name ?>" class="form-control" id="exampleInputEmail" placeholder="Name">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-12 mb-3 mb-sm-0">
                                <h4 class="small font-weight-bold">Description:</h4>
                                <input type="text" name="description" value="<?= $product->description ?>" class="form-control" id="exampleInputEmail" placeholder="Description">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-12 mb-3 mb-sm-0">
                                <h4 class="small font-weight-bold">Price:</h4>
                                <input type="text" name="price" value="<?= $product->price ?>" class="form-control" id="exampleInputEmail" placeholder="Price">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-12 mb-3 mb-sm-0">
                                <h4 class="small font-weight-bold">Unity:</h4>
                                <input type="number" name="unity" value="<?= $product->unity ?>" class="form-control" id="exampleInputEmail" placeholder="Unity">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-12 mb-3 mb-sm-0">
                                <h4 class="small font-weight-bold">Split Payment:</h4>
                                <input type="number" name="split_payment" value="<?= $product->split_payment ?>" class="form-control" id="exampleInputEmail" placeholder="Split Payment">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-12 mb-3 mb-sm-0">
                                <h4 class="small font-weight-bold">Tax:</h4>
                                <input type="number" name="tax" value="<?= $product->tax ?>" class="form-control" id="exampleInputEmail" placeholder="Tax">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-12 mb-3 mb-sm-0">
                                <h4 class="small font-weight-bold">Test Period:</h4>
                                <input type="number" name="test_period" value="<?= $product->test_period ?>" class="form-control" id="exampleInputEmail" placeholder="Test Period">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-12 mb-3 mb-sm-0">
                                <h4 class="small font-weight-bold">Category:</h4>
                                <select class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref" name="category">
                                    <?php foreach ($category as $value) { ?>
                                        <option value="<?= $value->id ?>" <?= $value->id == $product->id_category ? 'selected' : '' ?> ><?= $value->name ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12 mb-3 mb-sm-0">
                                <h4 class="small font-weight-bold">Status:</h4>
                                <div class="form-group form-check">
                                    <input type="checkbox" name="active" value="1" class="form-check-input" id="exampleCheck1" <?= $product->active ? 'checked' : ''; ?>>
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
                        <i class="fas fa-scroll"></i> Created
                    </div>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Description</th>
                                <th scope="col">Price</th>
                                <th scope="col">Unity</th>
                                <th scope="col">Split Pay</th>
                                <th scope="col">Tax</th>
                                <th scope="col">Test Per.</th>
                                <th scope="col">Category</th>
                                <th scope="col">Status</th>
                                <th scope="col" colspan="2"></th>
                            </tr>
                        </thead>
                        
                        <?php foreach ($all as $value) { ?>
                            <tbody>
                                <tr align="center">
                                    <th scope="row"><?= $value->id ?></th>
                                    <td><?= $value->name ?></td>
                                    <td><?= substr($value->description,  0, 50) . ( strlen($value->description) > 50 ? '...' : '') ?></td>
                                    <td><?= $value->price ?></td>
                                    <td><?= $value->unity ?></td>
                                    <td><?= $value->split_payment ?></td>
                                    <td><?= $value->tax ?></td>
                                    <td><?= $value->test_period ?></td>
                                    <td><?= $value->name_category ?></td>
                                    <td><?= $value->active ? "<i class='fas fa-check text-success'></i>" : "<i class='fas fa-times text-danger'></i>" ?></td>
                                    <td> 
                                        <a href="<?= CONF_URL_BASE .  "product/create/edit/{$value->id}" ?>" class="btn btn-success btn-icon-split">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-pen"></i>
                                            </span>
                                        </a>
                                        <a href="<?= CONF_URL_BASE . "product/create/delete/{$value->id}" ?>" class="btn btn-danger btn-icon-split">
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
