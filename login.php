<?php 

require_once("controllers/config.php");

if(isset($_POST['login'])){

    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    $sql = "SELECT * FROM users WHERE email=:email";
    $stmt = $db->prepare($sql);
    
    // bind parameter ke query
    $params = array(
        ":email" => $email
    );

    $stmt->execute($params);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // jika user terdaftar
    if($user){
        // verifikasi password
        if(password_verify($password, $user["password"])){
			// buat Session
			session_start();
			$_SESSION["user"] = $user;

			if ($user["is_admin"] == 0) {
				header("Location: index.php");
			} else {
				header("Location: dashboard/index.php");
			}
            
        }
    }
}
?>

<!-- username: salwa, email: salwa@gmail.com, password: 123 -->

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<title>Login Page</title>
		<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" />
		<link rel="stylesheet" href="login.css" />
	</head>
	<body>
		<div class="box-form">
			<div class="left">
				<br /><br /><br /><br /><br /><br /><br /><br /><br />
				<div class="overlay">
					<h1>MovMax</h1>
				</div>
			</div>
			<div class="right">
				<h5 style="color: white;">Login</h5>
				<form action="" method="POST">

					<div style="margin-top: 18px; margin-bottom: -8px">
						<div for="email" style="margin-bottom: -8px; color: white;">Email</div>
						<input type="email" name="email" placeholder="Email" />
					</div>

					<div style="margin-top: 18px; margin-bottom: -8px">
						<div for="password" style="margin-bottom: -8px; color: white;">Password</div>
						<input type="password" name="password" placeholder="Password" />
					</div>

					<p style="margin-top: 24px;">Don't have an account?, <a href="register.php" style="text-decoration: none; color: rgb(113, 232, 226)">Create here!</a> it takes less than a minute</p>
					<br />
					<button type="submit" name="login">Sign In</button>

				</form>
			</div>
		</div>
	</body>
</html>
	
