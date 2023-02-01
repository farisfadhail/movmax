<?php 
    // include database connection file
    require_once("../../controllers/auth.php");
    require_once("../../controllers/isAdmin.php");
    include_once("../../controllers/config.php");

    $id = $_SESSION["user"]["id"];

    if (!empty($_POST['confirm-password'])) {
        $newPassword = $_POST['new-password'];
        $confirmPassword = $_POST['confirm-password'];

        if ($newPassword == $confirmPassword) {
            $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

            $sql = "UPDATE users SET password=:password WHERE id=:id";
            $stmt = $db->prepare($sql);

            $params = array(
                ":password" => $password,
                ":id" => $id
            );

            $saved = $stmt->execute($params);

            if ($saved) header("Location: index.php");
        }
    }

	$sql = "SELECT * FROM users WHERE id=?";
	$row = $db->prepare($sql);
	$row->execute(array($id));
	$user = $row->fetch();
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="../dashboard.css" type="text/css" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="../dashboard.js"></script>
        <title>Edit User - <?= $_SESSION["user"]["username"] ?></title>
	</head>

	<body>
		
        <?php include '../../components/sidebar.php' ?>

		<div id="main">
			<div class="head">
				<div class="col-div-6">
					<span style="font-size: 30px; cursor: pointer; color: white" class="nav">Edit user - <?= $_SESSION["user"]["username"] ?></span>
					<span style="font-size: 30px; cursor: pointer; color: white" class="nav2">Edit user - <?= $_SESSION["user"]["username"] ?></span>
                </div>

				<div class="col-div-6">
					<div class="profile">
						<p><?php echo $_SESSION["user"]["username"] ?> <span>Admin Novmax</span></p>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>

            <div style="display: flex; margin-left: 12px; margin-bottom: 12px;">
                <a href="index.php" style="text-decoration: none; background-color:dimgray; color: white; padding-top: 8px; padding-bottom: 8px; padding-left: 12px; padding-right: 12px; border-radius: 4px;">
                    <span class="fa fa-arrow-left" style="margin-right: 4px;"></span>Back to Dashboard
                </a>
            </div>

			<div class="col-div-12">
                <h1 style="color: white; margin-left: 24px;">Profile</h1>
				<div class="box-table">
					<div class="content-box">
                        <form action="" method="POST" enctype="multipart/form-data">
                            <label for="username">Username</label>
                            <input class="form-styling" value="<?= $user['username']?>" type="text" disabled name="username" style="margin-left: 12px; color: white;"/>
                            
                            <label for="email">Email</label>
                            <input class="form-styling" value="<?= $user['email']?>" type="text" disabled name="email" style="margin-left: 12px; color: white;"/>
                        </form>
					</div>
				</div>
			</div>
			<div class="col-div-12">
                <h1 style="color: white; margin-left: 24px;">Change Password</h1>
				<div class="box-table">
                    <div class="content-box">
                        <form action="" method="POST" enctype="multipart/form-data">
                            <label for="new-password">New Password</label>
                            <input class="form-styling" type="password" name="new-password" style="margin-left: 12px; color: white;"/>
                            
                            <label for="confirm-password">Confirm Password</label>
                            <input class="form-styling" type="password" name="confirm-password" style="margin-left: 12px; color: white;"/>
                            
                            <div style="display: flex; margin-left: 12px; margin-bottom: 12px; ">
                                <button name="update" style="font-size: 16px; border: none; text-decoration: none; background-color: dodgerblue; color: white; padding-top: 12px; padding-bottom: 12px; padding-left: 18px; padding-right: 18px; border-radius: 4px;">Edit
                                <span class="fa fa-plus-circle"></span></button>
                            </div>
                        </form>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</body>
</html>