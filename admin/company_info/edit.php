<?php
if (isset($_POST['edit_cat'])) {
    
    $name = $_POST['name']; 
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $formerror = [];
    if (empty($formerror)) {
        $stmt = $connect->prepare("UPDATE company_info SET name=?,phone=?,address=?");
        $stmt->execute(array($name,$phone,$address));
        if ($stmt) {
            $_SESSION['success_message'] = "تم التعديل بنجاح ";
            header('Location:main?dir=company_info&page=report');
            exit();
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main?dir=company_info&page=report');
        exit();
    }
}
