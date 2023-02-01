<?php 
	require_once("../controllers/auth.php"); 
	require_once("../controllers/isAdmin.php"); 
	include_once("../controllers/config.php");
?>

<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<link rel="stylesheet" href="dashboard.css" type="text/css" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="dashboard.js"></script>
		<title>Dashboard Admin</title>
	</head>

	<body>
		<div id="mySidenav" class="sidenav">
			<p class="logo">MovMax</p>
			<a href="index.php" class="icon-a"><i class="fa fa-dashboard icons"></i> &nbsp;&nbsp;Dashboard</a>
			<a href="user/index.php" class="icon-a"><i class="fa fa-users icons"></i> &nbsp;&nbsp;Users</a>
			<a href="movie/index.php" class="icon-a"><i class="fa fa-film icons"></i> &nbsp;&nbsp;Film</a>
            <br/>
			<a href="user/my-profile.php" class="icon-a"><i class="fa fa-user icons"></i> &nbsp;&nbsp;My Profile</a>
			<a href="../index.php" class="icon-a"><i class="fa fa-home icons"></i> &nbsp;&nbsp;Home Page</a>
			<a href="../logout.php" class="icon-a"><i class="fa fa-sign-out icons"></i> &nbsp;&nbsp;Logout</a>
		</div>
		<div id="main">
			<div class="head">
				<div class="col-div-6">
					<span style="font-size: 30px; cursor: pointer; color: white" class="nav">Dashboard</span>
					<span style="font-size: 30px; cursor: pointer; color: white" class="nav2">Dashboard</span>
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

			<div class="col-div-4">
				<div class="box">
					<p><?php
						$sql = "SELECT count(*) FROM users"; 
                        $result = $db->prepare($sql); 
                        $result->execute(); 
                        $number_of_rows = $result->fetchColumn(); 
                        echo $number_of_rows
					?><br /><span>Customers</span></p>
                    <i class="fa fa-users box-icon"></i>
				</div>
			</div>
			<div class="col-div-4">
				<div class="box">
					<p><?php 
                        $sql = "SELECT count(*) FROM movies"; 
                        $result = $db->prepare($sql); 
                        $result->execute(); 
                        $number_of_rows = $result->fetchColumn(); 
                        echo $number_of_rows
                    ?><br /><span>Movies</span></p>
					<i class="fa fa-film box-icon"></i>
				</div>
			</div>
			<div class="col-div-4">
				<div class="box">
					<p><?php 
                        $sql = "SELECT sum(views) FROM movies"; 
                        $result = $db->prepare($sql); 
                        $result->execute(); 
                        $number_of_rows = $result->fetchColumn(); 
                        echo number_format($number_of_rows)
                    ?><br /><span>Total Views</span></p>
					<i class="fa fa-film box-icon"></i>
				</div>
			</div>
			<div class="clearfix"></div>
			<br /><br />
			<div class="col-div-12">
				<div class="box-table">
					<div class="content-box">
						<p>Top Popular Movies <span><a href="movie/index.php" style="text-decoration: none; color: #4DBF00;">See All</a></span></p>
						<br />
						<table>
                            <tr>
								<th>Judul</th>
								<th>Tanggal Rilis</th>
								<th>Views</th>
							</tr>
                            <?php
                                $sql = "SELECT * FROM movies ORDER BY views DESC LIMIT 5";
                                $row = $db->prepare($sql);
                                $row->execute();
                                $popularMovie = $row->fetchAll();
                                foreach($popularMovie as $pm){
                            ?>
							<tr>
								<td><?= $pm['judul']?></td>
								<td><?= $pm['release_date']?></td>
								<td><?= number_format($pm['views']) ?></td>
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
