<?php
if (isset($_POST['add_cat'])) {
    $account_number = sanitizeInput($_POST['account_number']);
    $all_price = sanitizeInput($_POST['all_price']);

    $formerror = [];
    if (empty($account_number)) {
        $formerror[] = ' من فضلك ادخل رقم الحساب  ';
    }
    $stmt = $connect->prepare("SELECT * FROM accounts WHERE account_number=?");
    $stmt->execute(array($account_number));
    $acount_num = $stmt->fetch();
    $count = $stmt->rowCount();
    if ($count > 0) {
        $formerror[] = 'رقم الحساب موجود من قبل من فضلك ادخل رقم اخر ';
    }
    if (empty($formerror)) {
        $stmt = $connect->prepare("INSERT INTO accounts (account_number,all_price)
        VALUES(:zaccount_number,:zall_price)
        ");
        $stmt->execute(array(
            "zaccount_number" => $account_number,
            "zall_price" => $all_price
        ));
        if ($stmt) {
            $_SESSION['success_message'] = " تمت الأضافة بنجاح  ";
            header('Location:main?dir=acounts&page=report');
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main?dir=acounts&page=report');
        exit();
    }
}
