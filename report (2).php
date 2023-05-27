<?php
    require_once('db_connect.php');
    $page = isset($_GET['page']) ? $_GET['page'] : 'report_home';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CBOO | Payroll Report</title>
    
		<!-- Site favicon -->
		<link rel="icon" type="image/x-icon" href="src/images/dash.png">
		<!-- Mobile Specific Metas -->
		<meta>
    <script src="validate_js/jquery-3.6.0.min.js"></script>
    <script src="validate_js/bootstrap.min.js"></script>
    <script src="validate_js/script.js"></script>
    <style>
    </style>
</head>
<body>
    <main>
   
    <div>
        <?php 
            if(isset($_SESSION['flashdata'])):
        ?>
        <div class="dynamic_alert alert alert-<?php echo $_SESSION['flashdata']['type'] ?>">
        <div class="float-end"><a href="javascript:void(0)" class="text-dark text-decoration-none" onclick="$(this).closest('.dynamic_alert').hide('slow').remove()">x</a></div>
            <?php echo $_SESSION['flashdata']['msg'] ?>
        </div>
        <?php unset($_SESSION['flashdata']) ?>
        <?php endif; ?>
        <div>
        <?php
                include $page.'.php';
            ?>
        </div>
    </div>
    </main>

</body>
</html>
<?php if(isset($conn)) $conn->close(); ?>