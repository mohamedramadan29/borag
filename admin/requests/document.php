<?php
include "phpqrcode/qrlib.php";
$request_id = $_GET['request_id'];
$stmt = $connect->prepare("SELECT * FROM requests WHERE id = ?");
$stmt->execute(array($request_id));
$request_data = $stmt->fetch();
$name = $request_data['name'];
$price_request = $request_data['price_request'];
$city = $request_data['city'];
$phone = $request_data['phone'];
$request_order = $request_data['request_order'];
$status = $request_data['status'];
/////////// qr code //////////

// دمج البيانات في سلسلة نصية واحدة
$data = "الأسم : $name\n";
$data .= "العنوان: $city\n";
$data .= "رقم الهاتف: $phone";
$newPath = 'uploads/qr_codes/'; // تأكد من وجود مسار مسبقًا أو قم بإنشائه

$fileName = uniqid() . time() . ".png";

// الجمع بين المسار واسم الملف للحصول على المسار الكامل للصورة
$fullFilePath = $newPath . $fileName;

// إنشاء رمز الاستجابة السريعة باستخدام البيانات والمسار
QRcode::png($data, $fullFilePath);
/////////// end qr code ///////
?>
<div class="print print_document">
    <div class="data">
        <div class="first_section">
            <div class="first1">
                <button class="btn btn-default"> اصدار حوالة محلية </button>
            </div>
            <div class="first2">
                <img src="uploads/new.png" alt="">
            </div>
            <div class="first3">
                <p> رقم الحوالة : <span style="margin-right: 8px;"> 010023 </span> </p>
                <p> تاريخ الحوالة : <span> 1 / 10 / 2023 </span> </p>
            </div>
        </div>
        <div class="second_section">
            <div class="row">
                <div class="col-6">
                    <div class="first1">
                        <button class="btn btn-default"> معلومات المرسل </button>
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td> الأسم </td>
                                    <td> شركه البراق </td>
                                </tr>
                                <tr>
                                    <td> رقم الهاتف </td>
                                    <td> 010000 12665 </td>
                                </tr>
                                <tr>
                                    <td> العنوان </td>
                                    <td> بغداد الكرخ </td>
                                </tr>
                            </tbody>
                        </table>
                        <button class="btn btn-default"> معلومات المستلم </button>
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td> الأسم </td>
                                    <td> شركه البراق </td>
                                </tr>
                                <tr>
                                    <td> رقم الهاتف </td>
                                    <td> 010000 12665 </td>
                                </tr>
                                <tr>
                                    <td> العنوان </td>
                                    <td> بغداد الكرخ </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-6">
                    <div class="">
                    <div class="first2">
                        <button class="btn btn-default"> باركود التحقق من الحوالة : </button>
                    </div>
                    <div class="qrcode">
                        <img src="<?php echo $fullFilePath; ?>" alt="">
                    </div>
                    </div>
                  
                </div>
            </div>
        </div>

        <button id="print_Button" onclick="window.print(); return false;" class="btn btn-primary"> طباعة الطلب <i class="fa fa-print"></i> </button>
    </div>

</div>

<style>
    .print {
        background-color: #fff;
    }

    .print .data {
        background-color: #fff;
        max-width: 80%;
        margin: auto;
        box-shadow: 0px 0px 10px #e1e1e1;
        border-radius: 10px;
        padding: 30px;
    }

    .print .data img {
        text-align: center;
        max-width: 200px;
        margin: auto;
        display: block;
    }

    @media print {

        .footer,
        .bottom_footer,
        .main_navbar,
        .instagrame_footer {
            display: none !important;
        }

        .print_order {
            max-width: 100% !important;
            padding: 10px !important;
        }

        body {
            background-color: #fff;
        }

        #print_Button {
            display: none !important;
        }

        .print-link {
            display: none !important;
        }

        @page {
            margin: 0;