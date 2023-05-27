<!DOCTYPE html>
<?php require_once("config.php"); ?>
<html>
	<head>
		<!-- Basic Page Info -->
		<meta charset="utf-8" />
		<title>Register</title>
		<!-- Site favicon -->
		<link rel="icon" type="image/png" sizes="16x16" href=""/>
		<!-- Mobile Specific Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
		<!-- Google Font -->
		<link
			href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>
		<!-- CSS -->
		<link rel="stylesheet" type="text/css" href="dist/css/login/core.css" />
		<link rel="stylesheet" type="text/css" href="dist/css/login/icon-font.min.css"/>
		<link rel="stylesheet" type="text/css" href="dist/css/login/style.css" />
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.6.5/sweetalert2.css"/>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.6.5/sweetalert2.all.js"></script>
		<script>
		 //Success Message
		 function success() {
            new swal(
                {
                    title: 'Registration Successful!',
                    type: 'success',
					confirmButtonText: 'Login',
                    confirmButtonClass: 'btn btn-success',
                }
            ).then(function(){
					window.location = "login.php";
			})
        };
		</script>
        <style>
            .register-box2 {
                width: 60%;
                padding: 40px 20px;
                margin: 5px auto;
                border-radius: 1.5%;
                background: rgba(76, 175, 80, .6)
            }
        </style>
	</head>
	<body class="register-page " style="background-image: url(src/images/payroll.jpg); background-size:cover; background-position:center; background-repeat:no-repeat;">
		<div class="register-wrap">
            <div class="container d-flex justify-content-center">
                    <div class="register-box2 box-shadow">
                        	<div class="profile-photo d-flex justify-content-center">
                                <img src="src/images/bsu.jpg" alt="" class="avatar-photo mr-10">
                                <img src="src/images/cboo.jpg" alt="" class="avatar-photo"/>
							</div>
                            <?php 
								if(isset($_POST['signup'])){
									extract($_POST);
									if(strlen($fname) < 3){
										$error[] = 'First Name At Least 3 Characters Long';
									}
									if(strlen($fname) > 20){
										$error[] = 'FIrstname Maximum of 20 Characters Only';
									}
									if(!preg_match("/^[A-Za-z _]*[A-Za-z ]+[A-Za-z _]*$/", $fname)){
										$error[] = 'Enter Firstname  without any Digits or Special Symbols';
									}  
									if(strlen($lname) < 3){
										$error[] = 'Last Name At Least 3 Characters Long';
									}
									if(strlen($lname) > 20){
										$error[] = 'Lastname Maximum of 20 Characters Only';
									}
									if(!preg_match("/^[A-Za-z _]*[A-Za-z ]+[A-Za-z _]*$/", $lname)){
										$error[] = 'Enter Lastname letters without any Digits or Special Symbols';
									} 
									if(strlen($username) < 3){
										$error[] = 'Last Name At Least 3 Characters Long';
									}
									if(strlen($username) > 20){
										$error[] = 'Username Maximum of 20 Characters Only';
									}
									if(!preg_match("/^[A-Za-z _]*[A-Za-z ]+[A-Za-z _]*$/", $username)){
										$error[] = 'Enter Username without any Digit or Special Symbols';
									} 
									if(strlen($email) > 50){
										$error[] = 'Maximum Email Length Exceeded';
									}
									if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
										$error[] = 'Invalid Email Address';
									}
									if($passwordConfirm ==''){
										$error[] = 'Please confirm the password.';
									}
									if($password != $passwordConfirm){
										$error[] = 'Passwords Do Not Match.';
									}
									// Validate password strength
									$uppercase = preg_match('@[A-Z]@', $password);
									$lowercase = preg_match('@[a-z]@', $password);
									$number    = preg_match('@[0-9]@', $password);
									$specialChars = preg_match('@[^\w]@', $password);
									if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
										$error[] = 'Password should be at least 8 characters in length, at least one upper case letter, one number, and one special character.';
									}

									$sql = "SELECT * FROM users WHERE (username='$username' OR email='$email')";
									$res=mysqli_query($dbc,$sql);
									if(mysqli_num_rows($res) > 0){
										$row = mysqli_fetch_assoc($res);
										if($username==$row['username'])
										{
											$error[] ='Username Already Exists.';
										}
										if($email==$row['email'])
										{
											$error[] ='Email Already Exists.';
										} 	 
									}
									if(!isset($error)){
										$role = $_POST['role'];
										$date = date('Y-m-d');
										$options = array("cost"=>4);
										$password = password_hash($password,PASSWORD_BCRYPT,$options);
										//Insert to DB
										$result = mysqli_query($dbc,"INSERT INTO users(fname,lname,username,email,password,date,role) VALUES('$fname','$lname','$username','$email','$password','$date','$role')");
										if($result){
											$done = 2;
										}
										else{
											$error[] ='Failed : Something went wrong';
										}
									}
								}
							?>
                            <div class="col-sm">
							<?php 
								if(isset($error)){
									foreach($error as $error){
										echo '<p class="errmsg" style = "color:#fff;">&#x26A0;'.$error.' </p>'; 
									}
								}
							?>
							</div>
							<?php 
								if(isset($done)){//success dialog call
									echo "<script type = 'text/javascript'>
										success();
									</script>"
							?>
							 <?php } else {
								header('register.php');
							 }?>
                            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                            <label>Firstname</label>
                                            <div class="input-group custom">
                                                <input name="fname" type="text"
                                                    class="form-control form-control-lg"
                                                    placeholder="First Name"
                                                    value="<?php if(isset($error)){ echo $_POST['fname'];}?>"
                                                    required=""
                                                />
                                                <div class="input-group-append custom">
                                                    <span class="input-group-text"
                                                        ><i class="icon-copy dw dw-user1"></i
                                                    ></span>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                            <label>Lastname</label>
                                            <div class="input-group custom">
                                                <input
                                                    name="lname"
                                                    type="text"
                                                    class="form-control form-control-lg"
                                                    placeholder="Last Name"
                                                    value="<?php if(isset($error)){ echo $_POST['lname'];}?>"
                                                    required=""
                                                />
                                                <div class="input-group-append custom">
                                                    <span class="input-group-text"
                                                        ><i class="icon-copy dw dw-user1"></i
                                                    ></span>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                            <label>Username</label>
                                            <div class="input-group custom">
                                                <input
                                                    name="username"
                                                    type="text"
                                                    class="form-control form-control-lg"
                                                    placeholder="Username"
                                                    value="<?php if(isset($error)){ echo $_POST['username'];}?>" 
                                                    required=""
                                                />
                                                <div class="input-group-append custom">
                                                    <span class="input-group-text"
                                                        ><i class="icon-copy dw dw-user1"></i
                                                    ></span>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                            <label>Email Address</label>
                                            <div class="input-group custom">
                                                <input
                                                    name="email"
                                                    type="text"
                                                    class="form-control form-control-lg"
                                                    placeholder="Email"
                                                    value="<?php if(isset($error)){ echo $_POST['email'];}?>"
                                                    required
                                                />
                                                <div class="input-group-append custom">
                                                    <span class="input-group-text"
                                                        ><i class="icon-copy dw dw-email1"></i></span>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                            <label>Password</label>
                                            <div class="input-group custom">
                                                <input
                                                    name="password"
                                                    type="password"
                                                    id="password"
                                                    class="form-control form-control-lg"
                                                    placeholder="Password"
                                                    required
                                                />
                                                <div class="input-group-append custom">
                                                    <span class="input-group-text">
                                                    <i class="icon-copy bi bi-eye-fill" id="togglePassword"></i>
                                                    </span>
                                                    <script>
                                                        const togglePassword = document.querySelector('#togglePassword');
                                                        const password = document.querySelector('#password');
                                                        togglePassword.addEventListener('click', () => {
                                                            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                                                            password.setAttribute('type', type);
                                                            // Toggle the eye and bi-eye icon
                                                            $("#togglePassword").toggleClass('icon-copy bi bi-eye-slash-fill');
                                                    });
                                                </script>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                            <label>Confirm Password</label>
                                            <div class="input-group custom">
                                                <input
                                                    name="passwordConfirm"
                                                    type="password"
                                                    id="confirmPassword"
                                                    class="form-control form-control-lg"
                                                    placeholder="Confirm Password"
                                                    required
                                                />
                                                <div class="input-group-append custom">
                                                    <span class="input-group-text">
                                                    <i class="icon-copy bi bi-eye-fill" id="toggleConfirm"></i>
                                                    </span>
                                                    <script>
                                                        const toggleConfirm = document.querySelector('#toggleConfirm');
                                                        const passwordConfirm = document.querySelector('#confirmPassword');
                                                        toggleConfirm.addEventListener('click', () => {
                                                            const typeConfirm = passwordConfirm.getAttribute('type') === 'password' ? 'text' : 'password';
                                                            passwordConfirm.setAttribute('type', typeConfirm);
                                                            // Toggle the eye and bi-eye icon
                                                            $("#toggleConfirm").toggleClass('icon-copy bi bi-eye-slash-fill');
                                                    });
                                                </script>
                                                </div>
                                            </div>
                                    </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>User Type</label>
									<select class="selectpicker" name="role" aria-label="Default select example">
											<option selected value="user">User</option>
											<option value="admin">Admin</option>
									</select>
                                    </div>
                                </div>
								<div class="col-md-6 col-sm-12">
									<div class="input-group mb-0 d-flex justify-content-center">
										<button type="submit" name="signup" class="btn btn-primary btn-lg btn-block" type="submit" style="margin-top:34px; width: 60%;">Sign Up</button>
									</div>
								</div>
							</div>
                            <div class="d-flex justify-content-center">
                                <div>
									<p class="text-white">Already have an account? <a href="login.php" class="text-blue">Login</a></p>
								</div>
                            </div>
                            </form>
                    </div>
                </div>
            </div>
		</div>
		<!-- js -->
		<script src="plugins/sweetalert2/sweetalert2.all.js"></script>
		<script src="dist/css/login/core.js"></script>
		<script src="dist/css/login/script.min.js"></script>
		<script src="dist/css/login/layout-settings.js"></script>
	</body>
</html>
