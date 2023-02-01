<?php

require_once("controllers/config.php");

if(isset($_POST['register'])){

    // filter data yang diinputkan
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    // enkripsi password
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);


    // menyiapkan query
    $sql = "INSERT INTO users (username, email, password) 
            VALUES (:username, :email, :password)";
    $stmt = $db->prepare($sql);

    // bind parameter ke query
    $params = array(
        ":username" => $username,
        ":password" => $password,
        ":email" => $email
    );

    // eksekusi query untuk menyimpan ke database
    $saved = $stmt->execute($params);

    // jika query simpan berhasil, maka user sudah terdaftar
    // maka alihkan ke halaman login
    if($saved) header("Location: login.php");
}

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<title>Register Page</title>
		<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" />
		<link rel="stylesheet" href="login.css" />
	</head>
	<body>
		<div class="box-form-regis">
			<div class="left">
				<br /><br /><br /><br /><br /><br /><br /><br /><br />
				<div class="overlay">
					<h1>MovMax</h1>
				</div>
			</div>
			<div class="right">
				<h5 style="color: white;">Register</h5>
				<form action="" method="POST">

					<div style="margin-top: 18px; margin-bottom: -8px">
						<div for="username" style="margin-bottom: -8px; color: white;">Username</div>
						<input type="text" name="username" placeholder="Username" />
					</div>

					<div style="margin-top: 18px; margin-bottom: -8px">
						<div for="email" style="margin-bottom: -8px; color: white;">Email</div>
						<input type="email" name="email" placeholder="Email" />
					</div>

					<div style="margin-top: 18px; margin-bottom: -8px">
						<div for="password" style="margin-bottom: -8px; color: white;">Password</div>
						<input type="password" name="password" placeholder="Password" />
					</div>

					<p>Already have account?, <a href="login.php" style="text-decoration: none; color: rgb(113, 232, 226)">Sign in here!</a></p>
					<br />
					<button type="submit" class="btn btn-success btn-block" name="register">Sign Up</button>

				</form>
			</div>
		</div>
	</body>
</html>
