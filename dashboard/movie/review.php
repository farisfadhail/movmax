<?php 
	require_once("../../controllers/auth.php");
    require_once("../../controllers/isAdmin.php");
	include_once("../../controllers/config.php");

    // untuk menampilkan data barang berdasarkan id barang
	$id = $_GET['id'];
	$sql = "SELECT * FROM rates inner join users on rates.user_id=users.id inner join movies on rates.movie_id=movies.id WHERE movie_id=$id ORDER BY rates.id DESC";
	$row = $db->prepare($sql);
	$row->execute();
	$reviews = $row->fetchAll();
?>

<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<link rel="stylesheet" href="../dashboard.css" type="text/css" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="../dashboard.js"></script>
        <title>Review Movie</title>
	</head>

	<body>
		
		<?php include '../../components/sidebar.php' ?>

		<div id="main">
			<div class="head">
				<div class="col-div-6">
                    <!-- Reviews - <?= $reviews['judul'] ?> -->
					<span style="font-size: 30px; cursor: pointer; color: white" class="nav">Review Movie</span>
					<span style="font-size: 30px; cursor: pointer; color: white" class="nav2">Review Movie</span>
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
            <div style="display: flex; margin-left: 12px; margin-bottom: 12px;">
                <a href="index.php" style="text-decoration: none; background-color:dimgray; color: white; padding-top: 8px; padding-bottom: 8px; padding-left: 12px; padding-right: 12px; border-radius: 4px;">
                    <span class="fa fa-arrow-left" style="margin-right: 4px;"></span>Back to Dashboard
                </a>
            </div>

			<div class="col-div-12">
				<div class="box-table">
					<div class="content-box">
                        <?php foreach ($reviews as $review) { ?>
                            <div class="comment__container opened" style="margin-bottom: 12px;">
                                <div class="comment__card">
                                    <h2 class="comment__title" style="color: white;"><?= $review["username"] ?> 
                                        <span style="margin-right: 8px; margin-left: 8px;">&raquo;</span>
                                        <span style="font-size: 0.9rem;"><?= $review['star'].' / 5' ?></span>
                                        <span style="margin-right: 8px; margin-left: 8px;">&ndash;</span>
                                        <span style="font-size: 0.9rem;"><?= date('d F Y', strtotime($review['created_at'])) ?></span>
                                    </h2>
                                    <p style="font-size: medium; color:white;">
                                        &ndash; <?= $review['comment'] ?>
                                    </p>
                                </div>
                            </div>
                            <hr/>
                        <?php } ?>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</body>
</html>
