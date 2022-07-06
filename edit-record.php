<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CBO Payroll Management System</title>
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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

    <input type="checkbox" name="" id="menu-toggle">
    <div class="sidebar">
        <div class="sidebar-container">
            <div class="brand">
                <h2>
                    <span class="lab la-staylinked"></span>
                    CBO Payroll Management System
                </h2>
            </div>
            <div class="sidebar-avartar">
                <div>
                    <img src="img/1.png" alt="">
                </div>
                <div class="avartar-info">

                    <div class="avartar-text">

                        <h4>
                            Raja Sulayman
                        </h4>
                        <small>
                            639-27402-9600
                        </small>
                    </div>
                    <span class="las la-angle-double-down">

                    </span>

                </div>
            </div>
            <form action="">
            <div class="sidebar-menu" >
                <ul>
                    <li>
                        <a href="index.php" >
                            <span class="las la-adjust"></span>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a class="current" href="employees.php" >
                            <span class="las la-users"></span>
                            <span>Employees</span>
                        </a>
                    </li>
                    <li>
                        <a href="" >
                            <span class="las la-chart-bar"></span>
                            <span>Calculations</span>
                        </a>
                    </li>
                    <li>
                        <a href="" >
                            <span class="las la-calendar"></span>
                            <span>Reports</span>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <span class="las la-user"></span>
                            <span>Account</span>
                        </a>
                    </li>
                    
                </ul>
              
            </div>
            </form>
           <!--side-card was here-->
        </div>
    </div>
    <div class="main-content">
    <header>
            <div class="header-title-wrapper">
                <label for="">
                    <span class="las la-bars">

                    </span>
                </label>
                <div class="header-title">
                    <h1>Employees</h1>
                    <p>Display Employee Records <span class="las la-chart-line">

                    </span> </p>
                </div>
            </div>
            <div class="header-action">
                <h1>Edit Records</h1>
            </div>
        </header>
        <main>
            <?php require_once 'process.php' ?>

            <?php

            if (isset($_SESSION['message'])):
            ?>
            <div class="alert alert-<?=$_SESSION['msg_type']?>">

                <?php
                echo $_SESSION['message'];
                unset($_SESSION['message']);
                ?>
        
            </div>
            <?php endif ?>

            <?php
            $mysqli = new mysqli('localhost', 'root', '', 'crud') or die(mysqli_error($mysqli));       
            $result = $mysqli->query("SELECT * FROM dataa") or die(mysqli->error);
             
            ?>
           
      
            <?php 
            function pre_r($array){
            

                echo '<pre>';
                print_r($array);
                echo '</pre>';
            }
            ?>
            
            <div class="row justify-content-enter">
            <form action="process.php" method="POST" class="forms" >
                <input type="hidden" name="id" value="<?php echo $id ?>">
                <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" 
                        value="<?php echo $name; ?>" placeholder="Enter your name">
                </div>
                
                <div class="form-group">
                <label for="">Position</label>
                <input type="number" name="position" class="form-control" value="<?php echo $position; ?>" placeholder="Enter your position">
                </div>
                <div class="form-group">
                <label for="">Sg</label>
                <input type="number" name="sg" class="form-control" value="<?php echo $sg; ?>" placeholder="Enter your SG">
                </div>
                <div class="form-group">
                <label for="">Step </label>
                </div>
                <input type="number" name="step" class="form-control" value="<?php echo $step; ?>"  placeholder="Enter your Step">
                
                <?php
                if ($update == true ): 
                 ?>
                    <button type="submit" class="btn btn-info" name="update" style="margin-top:10px;">Update</button>
                    <a href="employees.php" id="cancel" name="cancel" class="btn btn-danger" style="margin-top:10px;">Cancel</a>
               <?php else: ?>
                <button type="submit" class="btn btn-success" name="save">Save</button>
                <a href="/link-to/whatever-address/" id="cancel" name="cancel" class="btn btn-danger" style="margin-top:10px;">Cancel</a>
</div>y
                <?php endif; ?>
            </form>
            </div>
            </div>
        </main>
    </div>
</body>
</html>