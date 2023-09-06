<?php
ob_start();
$pagetitle = 'Home';
session_start();
include 'init.php';

if (isset($_SESSION['admin_username'])) {
    include 'include/navbar.php';
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <?php
    $page = '';
    if (isset($_GET['page']) && isset($_GET['dir'])) {
        $page = $_GET['page'];
        $dir = $_GET['dir'];
    } else {
        $page = 'manage';
    }
    // start Website Routes 
    // STRAT DASHBAORD
    if ($dir == 'dashboard' && $page == 'dashboard') {
        include 'dashboard.php';
    } elseif ($dir == 'dashboard' && $page == 'emp_dashboard') {
        include 'emp_dashboard.php';
    }
    // END DASHBAORD
    // START Request
    if ($dir == 'requests' && $page == 'add') {
        include "requests/add.php";
    } elseif ($dir == 'requests' && $page == 'edit') {
        include "requests/edit.php";
    } elseif ($dir == 'requests' && $page == 'delete') {
        include 'requests/delete.php';
    } elseif ($dir == 'requests' && $page == 'report') {
        include "requests/report.php";
    } elseif ($dir == 'requests' && $page == 'under_report') {
        include "requests/under_report.php";
    } elseif ($dir == 'requests' && $page == 'finish_report') {
        include "requests/finish_report.php";
    } elseif ($dir == 'requests' && $page == 'print') {
        include "requests/print.php";
    }
    // START Profile
    if ($dir == 'profile' && $page == 'add') {
        include "profile/add.php";
    } elseif ($dir == 'profile' && $page == 'edit') {
        include "profile/edit.php";
    } elseif ($dir == 'profile' && $page == 'delete') {
        include 'profile/delete.php';
    } elseif ($dir == 'profile' && $page == 'report') {
        include "profile/report.php";
    }
    // START Profile
    if ($dir == 'inquiries' && $page == 'add') {
        include "inquiries/add.php";
    } elseif ($dir == 'inquiries' && $page == 'edit') {
        include "inquiries/edit.php";
    } elseif ($dir == 'inquiries' && $page == 'delete') {
        include 'inquiries/delete.php';
    } elseif ($dir == 'inquiries' && $page == 'report') {
        include "inquiries/report.php";
    }
    // START Acounts
    if ($dir == 'acounts' && $page == 'add') {
        include "acounts/add.php";
    } elseif ($dir == 'acounts' && $page == 'edit') {
        include "acounts/edit.php";
    } elseif ($dir == 'acounts' && $page == 'delete') {
        include 'acounts/delete.php';
    } elseif ($dir == 'acounts' && $page == 'report') {
        include "acounts/report.php";
    }
    // START Acounts Details
    if ($dir == 'acounts_details' && $page == 'add') {
        include "acounts_details/add.php";
    } elseif ($dir == 'acounts_details' && $page == 'edit') {
        include "acounts_details/edit.php";
    } elseif ($dir == 'acounts_details' && $page == 'delete') {
        include 'acounts_details/delete.php';
    } elseif ($dir == 'acounts_details' && $page == 'report') {
        include "acounts_details/report.php";
    }
    ?>

</div>

</div>
</div>
</div>
</div>
</div>
</div>
</div>



<?php
include $tem . "footer.php";
?>