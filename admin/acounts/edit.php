<?php
if (isset($_POST['edit_cat'])) {
    $request_id = $_POST['request_id'];
    $account_number = sanitizeInput($_POST['account_number']);
    $all_price = sanitizeInput($_POST['all_price']);
    
    $formerror = [];
    if (empty($account_number)) {
        $formerror[] = ' من فضلك ادخل رقم الحساب  ';
    }
    $stmt = $connect->prepare("SELECT * FROM accounts WHERE account_number=? AND id != ?");
    $stmt->execute(array($account_number, $request_id));
    $acount_num = $stmt->fetch();
    $count = $stmt->rowCount();
    if ($count > 0) {
        $formerror[] = 'رقم الحساب موجود من قبل من فضلك ادخل رقم اخر ';
    }
    $formerror = [];
    if (empty($formerror)) {
        $stmt = $connect->prepare("UPDATE accounts SET account_number=?,all_price=? WHERE id = ? ");
        $stmt->execute(array($account_number, $all_price, $request_id));
        if ($stmt) {
            $_SESSION['success_message'] = "تم التعديل بنجاح ";
            header('Location:main?dir=acounts&page=report');
            exit();
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main?dir=acounts&page=report');
        exit();
    }
}
