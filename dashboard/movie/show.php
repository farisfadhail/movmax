<?php 
	require_once("../../controllers/auth.php");
    require_once("../../controllers/isAdmin.php");
	include_once("../../controllers/config.php");

    // untuk menampilkan data barang berdasarkan id barang
	$id = $_GET['id'];
	$sql = "SELECT * FROM movies WHERE id=?";
	$row = $db->prepare($sql);
	$row->execute(array($id));
	$movie = $row->fetch();

    $query = $db->prepare("SELECT AVG(star) FROM rates WHERE movie_id=:id");
?>

<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<link rel="stylesheet" href="../dashboard.css" type="text/css" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="../dashboard.js"></script>
        <title>Detail - <?= $movie['name'] ?></title>
	</head>

	<body>
		
        <?php include '../../components/sidebar.php' ?>

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
            <div style="display: flex; margin-left: 12px; margin-bottom: 12px;">
                <a href="index.php" style="text-decoration: none; background-color:dimgray; color: white; padding-top: 8px; padding-bottom: 8px; padding-left: 12px; padding-right: 12px; border-radius: 4px;">
                    <span class="fa fa-arrow-left" style="margin-right: 4px;"></span>Back to Dashboard
                </a>
            </div>

			<div class="col-div-12">
				<div class="box-table">
					<div class="content-box">
                        <div style="color: white;">
                            <h2>Judul :</h2>
                            <h3>- <?= $movie['judul']?></h3>
                        </div>
                        <div style="color: white;">
                            <h2>Rate :</h2>
                            <h3>- <?php 
                                $data = array(
                                    ":id" => $movie['id']
                                );
                                $query->execute($data);
                                $avgRates = $query->fetch();
                                if ($avgRates['AVG(star)'] != NULL) {
                                    echo round($avgRates['AVG(star)'], 2).'/5';
                                } else {
                                    echo '0/5';
                                }
                            ?></h3>
                        </div>
                        <div style="color: white;">
                            <h2>Sinopsis :</h2>
                            <p style="color: white;"><?= $movie['sinopsis']?></p>
                        </div>
                        <div style="color: white;">
                            <h2>Tanggal Rilis :</h2>
                            <h3>- <?= date('d F Y', strtotime($movie['release_date'])) ?></h3>
                        </div>
                        <div style="color: white;">
                            <h2>Link Video :</h2>
                            <h3>- <?= $movie['url']?></h3>
                        </div>
                        <div style="color: white;">
                            <h2>Views :</h2>
                            <h3>- <?= $movie['views']?></h3>
                        </div>
                        <div style="color: white;">
                            <h2>Status :</h2>
                            <h3>- <?php if ($movie['is_tayang'] == 1) {
                                        echo "Tayang";
                                    } else {
                                        echo "Segera";
                                    }
                                ?>
                            </h3>
                        </div>
                        <div style="color: white;">
                            <h2>Thumbnail :</h2>
                            <img src="../../assets/<?= $movie['thumbnail']?>" style="width: 250px;">
                        </div>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</body>
</html>
