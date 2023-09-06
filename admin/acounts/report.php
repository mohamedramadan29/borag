<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> الحسابات </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
                    <li class="breadcrumb-item active"> الحسابات </li>
                </ol>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content-header -->


<!-- DOM/Jquery table start -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <button type="button" class="btn btn-primary waves-effect btn-sm" data-toggle="modal" data-target="#add-Modal"> أضافة حساب جديد <i class="fa fa-plus"></i> </button>
                    </div>
                    <?php
                    if (isset($_SESSION['success_message'])) {
                        $message = $_SESSION['success_message'];
                        unset($_SESSION['success_message']);
                    ?>
                        <?php
                        ?>
                        <script src="plugins/jquery/jquery.min.js"></script>
                        <script src="plugins/sweetalert2/sweetalert2.min.js"></script>
                        <script>
                            $(function() {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: '<?php echo $message; ?>',
                                    showConfirmButton: false,
                                    timer: 2000
                                })
                            })
                        </script>
                        <?php
                    } elseif (isset($_SESSION['error_messages'])) {
                        $formerror = $_SESSION['error_messages'];
                        foreach ($formerror as $error) {
                        ?>
                            <div class="alert alert-danger alert-dismissible" style="max-width: 800px; margin:20px">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <?php echo $error; ?>
                            </div>
                    <?php
                        }
                        unset($_SESSION['error_messages']);
                    }
                    ?>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="my_table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th> # </th>
                                        <th> رقم الحساب </th>
                                        <th> المبلغ الكلي </th>
                                        <th> مبلغ الايداع </th>
                                        <th> الباقي </th>
                                        <th> </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $stmt = $connect->prepare("SELECT * FROM accounts ORDER BY id DESC");
                                    $stmt->execute();
                                    $allrecord = $stmt->fetchAll();
                                    $i = 0;
                                    foreach ($allrecord as $record) {
                                        $i++;
                                    ?>
                                        <tr>
                                            <td> <?php echo $i; ?> </td>
                                            <td> <?php echo  $record['account_number']; ?> </td>
                                            <td>  <?php echo  number_format($record['all_price'],2)?> </td>

                                            <td> <?php
                                                    $stmt = $connect->prepare("SELECT * FROM account_details WHERE account_id=?");
                                                    $stmt->execute(array($record['id']));
                                                    $account_rows = $stmt->fetchAll();
                                                    $total_price = 0;
                                                    foreach ($account_rows as $row) {
                                                        $total_price += $row['price_amount'];
                                                    }
                                                    echo number_format($total_price, 2)
                                                    ?>
                                            </td>
                                            <td> <?php
                                                    $remind = $record['all_price'] - $total_price;
                                                    echo number_format($remind, 2); ?> </td>
                                            <td>
                                                <button type="button" class="btn btn-success btn-sm waves-effect" data-toggle="modal" data-target="#edit-Modal_<?php echo $record['id']; ?>"> تعديل <i class='fa fa-pen'></i> </button>
                                                <a href="main.php?dir=acounts&page=delete&request_id=<?php echo $record['id']; ?>" class="confirm btn btn-danger btn-sm"> حذف <i class='fa fa-trash'></i> </a>
                                                <a href="main.php?dir=acounts_details&page=report&account_id=<?php echo $record['id']; ?>" class="btn btn-warning btn-sm"> تفاصيل الحساب <i class='fa fa-eye'></i> </a>
                                            </td>
                                        </tr>
                                        <!-- EDIT NEW CATEGORY MODAL   -->
                                        <div class="modal fade" id="edit-Modal_<?php echo $record['id']; ?>" tabindex="-1" role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title"> تعديل الحساب </h4>
                                                    </div>
                                                    <form method="post" action="main.php?dir=acounts&page=edit" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            <input type='hidden' name="request_id" value="<?php echo $record['id']; ?>">
                                                            <div class="form-group">
                                                                <label for="name"> رقم الحساب </label>
                                                                <input required type="text" class="form-control" name="account_number" value="<?php echo $record['account_number'] ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="name"> مبلغ الايداع الكلي المطلوب </label>
                                                                <input required type="number" class="form-control" name="all_price" value="<?php echo $record['all_price'] ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="Company-2" class="block"> الحالة </label>
                                                                <select name="status" class="form-control select2" id="">
                                                                    <option value=""> تغير الحالة </option>
                                                                    <option <?php if ($record['status'] == 0) echo 'selected'; ?> value="0"> نشط </option>
                                                                    <option <?php if ($record['status'] == 1) echo 'selected'; ?> value="1"> تم السداد </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" name="edit_cat" class="btn btn-primary waves-effect waves-light "> تعديل </button>
                                                            <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">رجوع</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- ADD NEW CATEGORY MODAL   -->
                <div class="modal fade" id="add-Modal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"> اضافة حساب جديد </h4>
                            </div>
                            <form action="main.php?dir=acounts&page=add" method="post" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="name"> رقم الحساب </label>
                                        <input required type="text" class="form-control" name="account_number">
                                    </div>
                                    <div class="form-group">
                                        <label for="name"> مبلغ الايداع الكلي المطلوب </label>
                                        <input required type="number" class="form-control" name="all_price">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" name="add_cat" class="btn btn-primary waves-effect waves-light "> حفظ </button>
                                    <button type="button" class="btn btn-default waves-effect " data-dismiss="modal"> رجوع </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>