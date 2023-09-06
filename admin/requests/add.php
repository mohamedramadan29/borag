<?php
if (isset($_POST['add_cat'])) {
    $name = sanitizeInput($_POST['name']);
    $price_request = sanitizeInput($_POST['price_request']);
    $city = sanitizeInput($_POST['city']);
    $phone = sanitizeInput($_POST['phone']);
    $request_order = sanitizeInput($_POST['request_order']);

    $formerror = [];
    if (empty($name)) {
        $formerror[] = ' من فضلك ادخل الاسم  ';
    }
    if (empty($formerror)) {
        $stmt = $connect->prepare("INSERT INTO requests (name,price_request,city,phone,request_order)
        VALUES(:zname,:zprice_request,:zcity,:zphone,:zrequest_order)
        ");
        $stmt->execute(array(
            "zname" => $name,
            "zprice_request" => $price_request,
            "zcity" => $city,
            "zphone" => $phone,
            "zrequest_order" => $request_order,
        ));
        if ($stmt) {
            $_SESSION['success_message'] = " تمت الأضافة بنجاح  ";
            header('Location:main?dir=requests&page=report');
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main?dir=categories&page=report');
        exit();
    }
}
