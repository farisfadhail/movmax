<?php 
	require_once("../../controllers/auth.php"); 
	require_once("../../controllers/isAdmin.php"); 
	include_once("../../controllers/config.php");
?>

<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<link rel="stylesheet" href="../dashboard.css" type="text/css" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="../dashboard.js"></script>
        <title>User - Index</title>
	</head>

	<body>
		
        <?php include '../../components/sidebar.php' ?>

		<div id="main">
			<div class="head">
				<div class="col-div-6">
					<span style="font-size: 30px; cursor: pointer; color: white" class="nav">Users</span>
					<span style="font-size: 30px; cursor: pointer; color: white" class="nav2">Users</span>
				</div>

				<div class="col-div-6">
					<div class="profile">
						<p><?php echo $_SESSION["user"]["username"] ?> <span>Admin Novmax</span></p>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>

			<div class="clearfix"></div>
			<br />

			<div class="col-div-12">
				<div class="box-table">
					<div class="content-box">
						<table>
                            <tr>
                                <th>Username</th> <th>Email</th> <th>Status</th> <th style="text-align: center;">Action</th>
                            </tr>
                            <?php
                                $sql = "SELECT * FROM users";
                                $row = $db->prepare($sql);
                                $row->execute();
                                $users = $row->fetchAll();
                                foreach($users as $user){
                                ?>
                            <tr>
                                <td><?= $user['username']?></td>
                                <td><?= $user['email'];?></td>
                                <td><?php if ($user['is_admin'] == 1) {
                                        echo "Admin";
                                    } else {
                                        echo "User";
                                    }
                                ?></td>
                                <td style="text-align: center;">
									<a href="edit.php?id=<?= $user['id'];?>" style="text-decoration: none; background-color: dodgerblue; color: white; padding: 8px; border-radius: 4px;">Edit
									<span class="fa fa-edit"></span></a>
                                    <a onclick="return confirm('Apakah yakin data akan di hapus?')" href="delete.php?id=<?= $user['id'];?>" style="text-decoration: none; background-color: deeppink; color: white; padding: 8px; border-radius: 4px;">Delete
                                    <span class="fa fa-trash"></span></a>
                                </td>
                            </tr>
                            <?php } ?>
						</table>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</body>
</html>
