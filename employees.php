<?php

session_start();
// Initialize the session
isset($_SESSION) || session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
// Define variables and initialize with empty values

require_once 'config.php';
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
<?php require_once 'process.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CBO Payroll Management System</title>
    <link rel="stylesheet" href="style.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
   <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
   <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/datatables.bootsrap4.min.css"/>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
   <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
  
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
<section id="mainBody">
  <div id="bodyContent">
     
  </div>
</section>
<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
 
<script src="http://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script> 
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.js"></script>


<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script> 
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script> 
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
            <form action="">
            <div class="sidebar-menu" >
                <ul>
                    <li class="side-nav">
                        <a href="index.php" >
                            <span class="las la-adjust"></span>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="side-nav">
                        <a class="current" href="employees.php" >
                            <span class="las la-users"></span>
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
                        <a href="" >
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
              
            </div>
            </form>
           <!--side-card was here-->
        </div>
    </div>
    <div class="main-content">
    <header>
            <div class="header-title-wrapper">
                
                <div class="header-title">
                    <h1>Employees</h1>
                    <p>Display Employee Records <span class="las la-chart-line">

                    </span> </p>
                </div>
            </div>
            <div class="header-action"  >
                
                    
               
                  
               <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Add Record
</button>

<!-- Modal -->
<div style="margin-right:8rem; "class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background:var(--bg);">
        <h5 class="modal-title" id="exampleModalLabel">Add Records</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" style="padding-left:8rem; background:var(--bg);">
      <div class="row justify-content-enter" >
            <form action="process.php" method="post" class="forms" >
                <input type="hidden" name="id" value="<?php echo$id ?>">
                <div class="form-group">
                <label for="">Name</label>
                <input type="text" name="name" class="form-control" value="<?php echo $name; ?>" placeholder="Enter your name">
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
                    <button type="submit" class="btn btn-info" name="update">Update</button>
                    <a href="employees.php" id="cancel" name="cancel" class="btn btn-danger">Cancel</a>
               <?php else: ?>
                <button type="submit" class="btn btn-success" name="save" style="margin-top:10px;">Save</button>
                <a href="employees.php" id="cancel" name="cancel" class="btn btn-danger" style="margin-top:10px;">Cancel</a>
                <?php endif; ?>
            </form>
            </div>
      </div>
      <div class="modal-footer" style="background:var(--bg);">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
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
            <div class="container">
            <?php
            $mysqli = new mysqli('localhost', 'root', '', 'crud') or die(mysqli_error($mysqli));       
            $result = $mysqli->query("SELECT * FROM dataa") or die(mysqli->error);
             
            ?>
            <div class="row justify-content-center">
                <table id="tableid" class="table table-striped table-bordered table-sm " style=" width: calc(95vw - 320px);">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Position</th>
                            <th>SG</th>
                            <th>Step</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                <?php
                    while($row = $result->fetch_assoc()):
                ?>
                <tr>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['position']; ?></td>
                    <td><?php echo $row['sg']; ?></td>
                    <td><?php echo $row['step']; ?></td>
                    <td>
                       
                
                       
                        <select class="ass"id="xyz" onChange="window.location.href=this.value">
                        <option value="" disabled selected hidden>Actions</option>
                        <option  class="btn btn-link btn-sm" value="edit-record.php?edit=<?php echo $row['id']; ?>">Edit</option>
                            

                        <option  class="btn btn-link btn-sm" value="process.php?delete=<?php echo $row['id']; ?>">Delete</option>

                           
                        </select>
                       
                    </td>
                </tr>
                <?php endwhile;  ?>
               

                </table>
            </div>
            <?php 
            function pre_r($array){
            

                echo '<pre>';
                print_r($array);
                echo '</pre>';
            }
            ?>
            
           
            </div>
        </main>
    </div>
 
   <style>
/* scrollbar styling
 */

::-webkit-scrollbar {
    -webkit-appearance: none;
}
::-webkit-scrollbar:vertical {
    width: 11px;
}
::-webkit-scrollbar:horizontal {
    height: 11px;
}
::-webkit-scrollbar-thumb {
    border-radius: 8px;
    border: 2px solid white; /* should match background, can't be transparent */
    background-color: rgba(0, 0, 0, .5);
}
::-webkit-scrollbar-track { 
    background-color: #fff; 
    border-radius: 8px; 
} 

    .link-color {
       
       color: var(--link-color);
     }
     .dropdown-item:hover{
       text-decoration: underline;
      
     }
     
       
    select#xyz {
   border:0px;
   outline:0px;
   color:var(--link-color);
}
.ass:hover{
    text-decoration: underline;
}
.table{
    color:var(--table-color);
}
.th{
    font-size:.9rem;
   
}

/* remove the horizontal scroll bar*/
html, body {
  max-width: 100%;
  overflow-x: hidden;
}
   </style>

   
   <!-- refresh the page once the back button has been clicked -->
  <script>
 window.onunload = function(){};

 $(document).ready(function () {
    $('#tableid').DataTable();
});

if (window.history.state != null && window.history.state.hasOwnProperty('historic')) {
    if (window.history.state.historic == true) {
        document.body.style.display = 'none';
        window.history.replaceState({historic: false}, '');
        window.location.reload();
    } else {
        window.history.replaceState({historic  : true}, '');
    }
} else {
    window.history.replaceState({historic  : true}, '');
}

</script>
</body>
</html>