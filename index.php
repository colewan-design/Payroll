<?php

session_start();
// Initialize the session
isset($_SESSION) || session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
require_once 'config.php';
// Define variables and initialize with empty values
// SQL query
$strSQL = "SELECT fullname from users WHERE id = '".$_SESSION['id']."'";

// Execute the query (the recordset $rs contains the result)
$rs = mysqli_query($link, $strSQL);

// Loop the recordset $rs
// Each row will be made into an array ($row) using mysqli_fetch_array
while($row = mysqli_fetch_array($rs)) {

  // Write the value of the column FirstName (which is now in the array $row)
 $first= $row["fullname"];


}







?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CBO Payroll Management System</title>
 
    <link rel="stylesheet" href="style.css">
    <script src="js/jquery.min.js"></script>
     <script src="js/bootstrap.min.js"></script>
     <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
     <link href="css/bootstrap-responsive.min.css" rel="stylesheet">
     <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    
    </head>

<script>
     $(function() {
        $('#nav li a').click(function() {
           $('#nav li').removeClass();
           $($(this).attr('href')).addClass('active');
        });
     });
  </script>
<body >
<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <input type="checkbox" name="" id="menu-toggle">
    <div class="sidebar">
        <div class="sidebar-container">
            <div class="brand">
                <h2>
                    <span ></span>
                    CBO Payroll Management System
                </h2>
            </div>
            <div class="sidebar-avartar">
                <div>
                    <img src="img/1.png" alt="">
                </div>
                <div class="avartar-info">

                    <div class="avartar-text">

                        <h4 style="padding-left:3px;">
                        <?php echo $first; ?> 
                        </h4>
                        <small>
                            639-27402-9600
                        </small>
                    </div>
                    <span class="las la-angle-double-down">

                    </span>

                </div>
            </div>
            <form action="" >
            <div class="sidebar-menu">

                <ul  >
                    <li class="side-nav">
                        <a class="current" href="index.php" >
                            <span class="las la-adjust"></span>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="side-nav">
                        <a href="employees.php">
                            <span class="las la-users" ></span>
                            <span>Employees</span>
                        </a>
                    </li>
                    <li class="side-nav">
                        <a href="" >
                            <span class="las la-chart-bar"></span>
                            <span>Calculations</span>
                        </a>
                    </li>
                    <li class="side-nav">
                        <a href="">
                            <span class="las la-calendar"></span>
                            <span>Reports</span>
                        </a>
                    </li>
                    <li class="side-nav">
                        <a href="">
                            <span class="las la-user"></span>
                            <span>Account</span>
                        </a>
                    </li>
                    
                </ul>
             <!--php code here-->
                <?php
            $mysqli = new mysqli('localhost', 'root', '', 'crud') or die(mysqli_error($mysqli));       
            $result = $mysqli->query("SELECT * FROM dataa") or die(mysqli->error);
             
            ?>
            </div>
            </form>
           <!--side-card was here-->
        </div>
    </div>
    <div class="main-content">
        <header >
            <div class="header-title-wrapper">
               
                <div class="header-title">
                    <h1>Hi <?php echo htmlspecialchars($_SESSION["username"]); ?>!</h1>
                    <p>Display Admin Dashboard <span class="las la-chart-line">

                    </span> </p>
                </div>
            </div>
           
            <div class="header-action" style="position:absolute;right:1rem; top:1rem;">
            <div class="dropdown">
           
                <button name="papa" class="btn btn-light dropdown-toggle link-color" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                  <?php echo $first; ?>
                </button>
  
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li><a class="las la-user dropdown-item link-color" href="profile.php">My Profile</a></li>
                    <li><a class="las la-cog dropdown-item link-color" href="profile.php">Account settings </a></li>
                    <li><a class="las la-sign-out-alt dropdown-item link-color" href="logout.php">Log out</a></li>
   
                    </ul>
 
            </div>
                
            </div>
        </header>
        <main>
            <div class="analytics">
                <div class="analytic">
                    <div class="analytic-icon">
                        <span class="las la-users"></span>
                    </div>
                        <div class="analytic-info" >
                            <h4>Total Employees</h4>
                            <h1><?php echo mysqli_num_rows($result); ?></h1>
                        </div> 

                       
                </div>

                <div class="analytic">
                    <div class="analytic-icon">
                        <span class="las la-clock"></span>
                    </div>
                        <div class="analytic-info">
                            <h4>Total Work Hours </h4>
                            <h1>10.0k <small class="text-danger"> 5%</small></h1>
                        </div>  
                </div>

                <div class="analytic">
                    <div class="analytic-icon">
                        <span class="las la-ruble-sign"></span>
                    </div>
                        <div class="analytic-info">
                            <h4> Total Renumeration</h4>
                            <h1>10.0k <small class="text-success"> 5%</small></h1>
                        </div>
                        
                    
                </div>
                <div class="analytic">
                    <div class="analytic-icon">
                        <span class="las la-heart"></span>
                    </div>
                    <div class="analytic-info">
                            <h4>Total Likes</h4>
                            <h1>10.0k</h1>
                    </div> 
                </div>
            </div>
            <div class="block-grid">
                <div class="revenue-card">

                </div>
            </div>
        </main>
    </div>
    <style>

      .link-color {
       
        color: var(--link-color);
      }
      .dropdown-item:hover{
        text-decoration: underline;
       
      }
                 
    </style>
   
  
</body>
</html>
