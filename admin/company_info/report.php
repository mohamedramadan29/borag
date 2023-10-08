<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> معلومات الشركة </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
                    <li class="breadcrumb-item active"> معلومات الشركة </li>
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
                                        <th> الأسم </th>
                                        <th> رقم الهاتف </th>
                                        <th> العنوان </th>
                                        <th> عمولة الشركه  </th>
                                        <th> </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $stmt = $connect->prepare("SELECT * FROM company_info");
                                    $stmt->execute();
                                    $allrecord = $stmt->fetchAll();
                                    $i = 0;
                                    foreach ($allrecord as $record) {
                                        $i++;
                                    ?>
                                        <tr>
                                            <td> <?php echo $i; ?> </td>
                                            <td> <?php echo  $record['name']; ?> </td>
                                            <td> <?php echo  $record['phone']; ?> </td>
                                            <td> <?php echo  $record['address']; ?> </td>
                                            <td> <?php echo  $record['percent']; ?> </td>

                                            <td>
                                                <button type="button" class="btn btn-success btn-sm waves-effect" data-toggle="modal" data-target="#edit-Modal_<?php echo $record['id']; ?>"> تعديل <i class='fa fa-pen'></i> </button>
                                            </td>
                                        </tr>
                                        <!-- EDIT NEW CATEGORY MODAL   -->
                                        <div class="modal fade" id="edit-Modal_<?php echo $record['id']; ?>" tabindex="-1" role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title"> تعديل </h4>
                                                    </div>
                                                    <form method="post" action="main.php?dir=company_info&page=edit" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <input type='hidden' name="request_id" value="<?php echo $record['id']; ?>">
                                                                <label for="Company-2" class="block"> الأسم  </label>
                                                                <input type="text" name="name" class="form-control" value="<?php echo $record['name'] ?>">
                                                            </div> 
                                                            <div class="form-group">
                                                                <label for="Company-2" class="block"> رقم الهاتف </label>
                                                                <input type="text" name="phone" class="form-control" value="<?php echo $record['phone'] ?>">
                                                            </div> 
                                                            <div class="form-group">
                                                                <label for="Company-2" class="block"> العنوان </label>
                                                                <input type="text" name="address" class="form-control" value="<?php echo $record['address'] ?>">
                                                            </div> 
                                                            <div class="form-group">
                                                                <label for="Company-2" class="block"> نسبة العمولة </label>
                                                                <input type="text" name="percent" class="form-control" value="<?php echo $record['percent'] ?>">
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
                                <h4 class="modal-title">أضافة سند صرف </h4>
                            </div>
                            <form action="main.php?dir=requests&page=add" method="post" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="name"> الأسم بالكامل </label>
                                        <input required type="text" class="form-control" name="name">
                                    </div>
                                    <div class="form-group">
                                        <label for="name"> المبلغ المطلوب </label>
                                        <input required type="number" class="form-control" name="price_request">
                                    </div>
                                    <div class="form-group">
                                        <label for="name"> المحافطة </label>
                                        <input required type="text" class="form-control" name="city">
                                    </div>
                                    <div class="form-group">
                                        <label for="name"> رقم الهاتف </label>
                                        <input required type="text" class="form-control" name="phone">
                                    </div>
                                    <div class="form-group">
                                        <label for="name"> تاريخ استلام الطلب </label>
                                        <input required type="date" class="form-control" name="request_order">
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