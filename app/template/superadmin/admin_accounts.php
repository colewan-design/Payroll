<?php 

ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
require_once('../controllerUserData.php');
$con = new mysqli('bsu-info.tech', 'u455679702_cps', 'OpK3RKh]!h9', 'u455679702_cps') or die(mysqli_error($mysqli));
$email = $_SESSION['email'];

$password = $_SESSION['password'];
if($email != false && $password != false){
    $sql = "SELECT * FROM usertable WHERE email = '$email'";
    $run_Sql = mysqli_query($con, $sql);
    if($run_Sql){
        $fetch_info = mysqli_fetch_assoc($run_Sql);
        $status = $fetch_info['status'];
		$name = $fetch_info['name'];
		$image = $fetch_info['image'];
        $code = $fetch_info['code'];
        if($status == "verified"){
            if($code != 0){
                header('Location: reset-code.php');
            }
        }else{
            header('Location: user-otp.php');
        }
    }
}else{
    header('Location: login.php');
}
?>


<?php 
  $mysqli = new mysqli('bsu-info.tech', 'u455679702_cps', 'OpK3RKh]!h9', 'u455679702_cps') or die(mysqli_error($mysqli));  

?>

  <?php 
function generateRandomPassword($length = 8) {
  $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
  $chars_length = strlen($chars);
  $password = '';
  for ($i = 0; $i < $length; $i++) {
    $password .= $chars[rand(0, $chars_length - 1)];
  }
  return $password;
}

if (isset($_POST['submit'])) {
    $user_name = $_POST['name'];
  $user_email = $_POST['email'];
  $user_role = $_POST['role'];

  // Check if email already exists in the userlogin table
  $email_check = "SELECT * FROM userlogin WHERE employee_email = '$user_email'";
  $res = mysqli_query($con, $email_check);
  if (mysqli_num_rows($res) > 0) {
    $errors['user_email'] = "Email that you have entered is already exist!";
  } else {
    // Generate a random password
    $password = generateRandomPassword();
    $text_password = $password;
    $confirm_password = $password;

    // Hash the password
    $options = array("cost"=>4);
    $password = password_hash($password, PASSWORD_BCRYPT, $options);

    $result = mysqli_query($con, "INSERT INTO usertable(name, email, password, role, status, created_at) VALUES('$user_name', '$user_email', '$password', '$user_role', 'verified', CONVERT_TZ(NOW(), '+00:00', '+08:00'))");



    // Send email with password
    $subject = "Account setup complete - CBOO";
    $message = "Your password in CBOO Payroll Website is $text_password. You can use this link to login: https://cps.bsu-info.tech/home.php";

    $message .= " This email and any files transmitted with it are confidential and intended solely for the use of the individual or entity to whom they are addressed. If you have received this email in error, please (1) notify the sender via an email reply, (2) do not copy or use it for any purpose, (3) do not disclose its contents to any other person and, (4) immediately delete this email. Do note that any views or opinions presented in this email are solely those of the author and do not necessarily represent those of the university. Finally, the recipient should check this email and its attachments for the presence of malware. Benguet State University accepts no liability for any damage caused by any malware transmitted by this email. ";

    $sender = "From: cboo@bsu.edu.ph";

    if (mail($user_email, $subject, $message, $sender)) {
      $_SESSION['employee_email'] = $user_email;
      $_SESSION['password'] = $text_password;
    }

    // Close the modal and show success message
    echo "<script type='text/javascript'>
            $('#addUserModal').modal('hide');
            succ();
          </script>";
  }
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css">

    <!-- Twitter -->
    <meta name="twitter:site" content="@themepixels">
    <meta name="twitter:creator" content="@themepixels">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Slim">
    <meta name="twitter:description" content="Premium Quality and Responsive UI for Dashboard.">
    <meta name="twitter:image" content="http://themepixels.me/slim/img/slim-social.png">

    <!-- Facebook -->
    <meta property="og:url" content="http://themepixels.me/slim">
    <meta property="og:title" content="Slim">
    <meta property="og:description" content="Premium Quality and Responsive UI for Dashboard.">

    <meta property="og:image" content="http://themepixels.me/slim/img/slim-social.png">
    <meta property="og:image:secure_url" content="http://themepixels.me/slim/img/slim-social.png">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="600">

    <!-- Meta -->
    <meta name="description" content="Premium Quality and Responsive UI for Dashboard.">
    <meta name="author" content="ThemePixels">

    <title>CBOO | Dashboard</title>

    <!-- vendor css -->
    <link href="../lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="../lib/Ionicons/css/ionicons.css" rel="stylesheet">
    <link href="../lib/chartist/css/chartist.css" rel="stylesheet">
    <link href="../lib/rickshaw/css/rickshaw.min.css" rel="stylesheet">
    <link href="../lib/fullcalendar/css/fullcalendar.css" rel="stylesheet">
    <!-- Slim CSS -->
    <link rel="stylesheet" href="../../css/slim.css">
<style>
 .ticker {
    overflow: hidden;
  }
  .ticker h3 {
    white-space: nowrap;
    animation: ticker 20s linear infinite;
  }
  @keyframes ticker {
    0% {
      transform: translateX(100%);
    }
    100% {
      transform: translateX(-100%);
    }
  }
</style>
  </head>
  <body class="slim-full-width">
    <div class="slim-header">
      <div class="container">
        <div class="slim-header-left">
          <div class="logged-user">
            <img src="../img/bsu.jpg" alt="bsu logo" style="height:45px;width:45px;" class="mr-1"><span><img src="../img/cboo.jpg" alt="cboo logo" style="height:45px; width:45px;"></span>
          </div>
        </div><!-- slim-header-left -->
        <!--Header Center-->
        <div class="ticker ml-auto mr-auto">
        <h3 class="h3" id="news-ticker">
  Compensation, Benefits and Other Obligations Office
</h3>

        </div>
        <div class="slim-header-right">
          <div class="dropdown dropdown-c">
            <a href="#" class="logged-user" data-toggle="dropdown">
              <img src="http://via.placeholder.com/500x500" alt="">
              <span><?php echo $fetch_info['name']?></span>
              <i class="fa fa-angle-down"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
              <nav class="nav">
                <a href="#" class="nav-link"><i class="icon ion-person"></i> View Profile</a>
                <a href="#" class="nav-link"><i class="icon ion-forward"></i> Sign Out</a>
              </nav>
            </div><!-- dropdown-menu -->
          </div><!-- dropdown -->
        </div><!-- header-right -->
      </div><!-- container -->
    </div><!-- slim-header -->

    <div class="slim-navbar">
      <div class="container">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="../index.php">
              <i class="icon ion-ios-home-outline"></i>
              <span>Dashboard</span>
            </a>
          </li>
          <li class="nav-item with-sub">
            <a class="nav-link" href="#">
              <i class="icon ion-ios-people"></i>
              <span>Employee</span>
            </a>
            <div class="sub-item">
              <ul>
                <li><a href="#">Employee Table</a></li>
                <li><a href="#">Employee Data</a></li>
              </ul>
            </div><!-- dropdown-menu -->
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <i class="icon fas fa-regular fa-project-diagram"></i>
              <span>Projects</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <i class="icon ion-ios-home-outline"></i>
              <span>Positions</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <i class="icon ion-ios-home-outline"></i>
              <span>Matrix</span>
            </a>
          </li>
          <li class="nav-item with-sub">
            <a class="nav-link" href="#">
              <i class="icon ion-ios-book-outline"></i>
              <span>Calculations</span>
            </a>
            <div class="sub-item">
              <ul>
                <li><a href="">Allowance</a></li>
                <li><a href="">Leave Deductions</a></li>
                <li><a href="">Mandatory Deductions</a></li>
                <li><a href="">Other Deductions</a></li>
              </ul>
            </div><!-- dropdown-menu -->
          </li>
          <li class="nav-item with-sub">
            <a class="nav-link" href="#">
              <i class="icon ion-ios-book-outline"></i>
              <span>Slips</span>
            </a>
            <div class="sub-item">
              <ul>
                <li><a href="">Create Slip</a></li>
                <li><a href="">Payslip Records</a></li>
                <li><a href="">Payslip History</a></li>
              </ul>
            </div><!-- dropdown-menu -->
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <i class="icon ion-ios-home-outline"></i>
              <span>Report</span>
            </a>
          </li>
          <li class="nav-item with-sub">
            <a class="nav-link" href="#">
              <i class="icon ion-ios-book-outline"></i>
              <span>Admin</span>
            </a>
            <div class="sub-item">
              <ul>
                <li><a href="">Archives</a></li>
                <li><a href="">Employee Accounts</a></li>
                <li><a href="">Manage News</a></li>
                <li><a href="">New User</a></li>
                <li><a href="">Password</a></li>
                <li><a href="">User Logs</a></li>
                <li><a href="">Admin Accounts</a></li>
              </ul>
            </div><!-- dropdown-menu -->
          </li>
        </ul>
      </div><!-- container -->
    </div><!-- slim-navbar -->

    <?php
            
        $result = $mysqli->query("SELECT * FROM data") or die($mysqli->error);
    ?>
    <div class="slim-mainpanel">
      <div class="container">
        <div class="slim-pageheader">
          <ol class="breadcrumb slim-breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Admin Accounts</li>
          </ol>
    
        </div><!-- slim-pageheader -->

     

       <div class="section-wrapper mg-t-20">
          <label class="section-title">ADMIN ACCOUNTS TABLE</label>
          <p class="mg-b-20 mg-sm-b-40">List of admin accounts.</p>
              <div class="mb-3">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">Add New User</button>
              </div>
          <div class="table-responsive">
           <table class="table table-hover mg-b-0">
  <thead>
    <tr>
      <th>Name</th>
      <th>Email</th>
      <th>Role</th>
      <th>Status</th>
      <th colspan="2">Actions</th>
      
    </tr>
  </thead>
  <tbody>
  <?php
    // Query the database for the specified fields
    $sql = "SELECT * FROM usertable";
    $result = mysqli_query($con, $sql);

    // Loop through the result and display the data in the table
   while ($row = mysqli_fetch_assoc($result)) {
      echo "<tr>";
      echo "<td>" . $row["name"] . "</td>";
      echo "<td>" . $row["email"] . "</td>";
      echo "<td>" . $row["role"] . "</td>";
      echo "<td>" . $row["status"] . "</td>";
      echo '<td>
              <button class="btn btn-outline-primary btn-sm rounded-pill px-3 py-2 mr-2" data-bs-toggle="modal" data-bs-target="#updateUserModal" data-id="'.$row['id'].'">
                  <span class="ion-edit mr-2"></span>
                  Edit
              </button>
          </td>';
      echo '<td>
              <button class="btn btn-outline-danger btn-sm rounded-pill px-3 py-2" data-bs-toggle="modal" data-bs-target="#deleteUserModal" data-id="'.$row['id'].'">
                  <span class="ion-android-delete mr-2"></span>
                  Delete
              </button>
          </td>';
      echo "</tr>";
    }


    // Close the database connection
    mysqli_close($con);
    ?>
  </tbody>
</table>

          </div><!-- table-responsive -->
          <!--Modals -->
                    
            <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  </div>
                   <form method="POST" action="#">
                      <div class="modal-body">
                        <div class="mb-3">
                          <label for="name" class="form-label">Name</label>
                          <input type="text" class="form-control" id="name" name="name">
                        </div>
                    
                        <div class="mb-3">
                          <label for="email" class="form-label">Email address</label>
                          <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
                          <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                        </div>
                        <div class="mb-3">
                          <label for="role" class="form-label">Role</label>
                          <select class="form-control form-control:focus" id="role" name="role">
                            <option selected>Select a role</option>
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                          </select>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" name="submit">Save</button>
                      </div>
                    </form>

                </div>
              </div>
            </div>
            
            <!-- Edit Modal-->
            
            <div class="modal fade" id="updateUserModal" tabindex="-1" aria-labelledby="updateUserModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="updateUserModalLabel">Edit User Details</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  </div>
                   <form method="POST" action="#">
                      <div class="modal-body">
                        <div class="mb-3">
                          <label for="name" class="form-label">Name</label>
                          <input type="text" class="form-control" id="name" name="name">
                        </div>
                    
                        <div class="mb-3">
                          <label for="email" class="form-label">Email address</label>
                          <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
                          <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                        </div>
                        <div class="mb-3">
                          <label for="role" class="form-label">Role</label>
                          <select class="form-control form-control:focus" id="role" name="role">
                            <option selected>Select a role</option>
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                          </select>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" name="submit">Update</button>
                      </div>
                    </form>

                </div>
              </div>
            </div>
            

        </div><!-- section-wrapper -->
      </div><!-- container -->
    </div><!-- slim-mainpanel -->

    <div class="slim-footer">
      <div class="container d-flex justify-content-center">
        <p>CBOO@BSU 2023</p>
      </div><!-- container -->
    </div><!-- slim-footer -->

    <script src="../lib/jquery/js/jquery.js"></script>
    <script src="../lib/popper.js/js/popper.js"></script>
    <script src="../lib/bootstrap/js/bootstrap.js"></script>
    <script src="../lib/jquery.cookie/js/jquery.cookie.js"></script>
    <script src="../lib/chartist/js/chartist.js"></script>
    <script src="../lib/d3/js/d3.js"></script>
    <script src="../lib/rickshaw/js/rickshaw.min.js"></script>
    <script src="../lib/jquery.sparkline.bower/js/jquery.sparkline.min.js"></script>

  
 
    <script src="../lib/moment/js/moment.js"></script>
    <script src="../lib/fullcalendar/js/fullcalendar.js"></script>
    <script src="/app/js/slim.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.3/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/js/bootstrap.min.js"></script>
   <script>
    $('#updateUserModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var id = button.data('id'); // Extract id from data-id attribute

        // Make an AJAX request to fetch the user's data based on the id
        $.ajax({
            url: '/app/template/superadmin/get_user_data.php',
            method: 'GET',
            data: {id: id},
            dataType: 'json',
            success: function (response) {
                // Log the response to the console for debugging
                console.log(response);

                // Set the value of the name input field to the name in the response
                $('#name').val(response.name);

                // Set the value of the email input field to the email in the response
                $('#email').val(response.email);

                // Set the value of the role select field to the role in the response
                $('#role').val(response.role);
            },
            error: function () {
                alert('Failed to fetch user data!');
            }
        });
    });
</script>

  
  </body>
</html>
