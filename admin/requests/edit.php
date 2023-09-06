<?php
if (isset($_POST['edit_cat'])) {
    $request_id = $_POST['request_id'];
    $status = $_POST['status'];
    $formerror = [];
    if (empty($formerror)) {
        $stmt = $connect->prepare("UPDATE requests SET status=? WHERE id = ? ");
        $stmt->execute(array($status,$request_id));
        if ($stmt) {
            $_SESSION['success_message'] = "تم التعديل بنجاح ";
            header('Location:main?dir=requests&page=report');
            exit();
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main?dir=requests&page=report');
        exit();
    }
}
