<?php 
	require_once("../../controllers/auth.php");
    require_once("../../controllers/isAdmin.php");
	include_once("../../controllers/config.php");

    $sql = "SELECT * FROM movies ORDER BY ID DESC";
    $row = $db->prepare($sql);
    $row->execute();
    $movies = $row->fetchAll();
?>

<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<link rel="stylesheet" href="../dashboard.css" type="text/css" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="../dashboard.js"></script>
        <title>Movie - Index</title>
	</head>

	<body>
		
        <?php include '../../components/sidebar.php' ?>

		<div id="main">
			<div class="head">
				<div class="col-div-6">
					<span style="font-size: 30px; cursor: pointer; color: white" class="nav">Movies</span>
					<span style="font-size: 30px; cursor: pointer; color: white" class="nav2">Movies</span>
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
                <a href="create.php" style="text-decoration: none; background-color: limegreen; color: white; padding-top: 8px; padding-bottom: 8px; padding-left: 12px; padding-right: 12px; border-radius: 4px;">Create
                <span class="fa fa-plus-circle"></span></a>
            </div>

			<div class="col-div-12">
				<div class="box-table">
					<div class="content-box">
						<table>
                            <tr>
                                <th>Judul</th> <th>Thumbnail</th> <th>Tanggal Rilis</th> <th>views</th> <th>Rate</th> <th>Status</th> <th style="text-align: center;">Action</th>
                            </tr>
                            <?php
                                foreach($movies as $movie){
                            ?>
                                <tr>
                                    <td><?= $movie['judul']?></td>
                                    <td><img src="../../assets/<?= $movie['thumbnail'] ?>" style="width: 150px;"/></td>
                                    <td><?= date('d F Y', strtotime($movie['release_date'])) ?></td>
                                    <td><?= number_format($movie['views']) ?></td>
                                    <td><?php 
                                            $query = $db->prepare("SELECT AVG(star) FROM rates WHERE movie_id=:id");
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
                                        ?></td>
                                    <td><?php if ($movie['is_tayang'] == 1) {
                                            echo "Tayang";
                                        } else {
                                            echo "Segera";
                                        }
                                    ?></td>
                                    <td>
                                        <div style="margin-left: 16px; margin-right: -36px; display: flex; gap: 12px">
                                            <a href="show.php?id=<?= $movie['id'];?>" style="text-decoration: none; background-color: goldenrod; color: white; padding: 8px; border-radius: 4px;">Detail
                                            <span class="fa fa-info-circle"></span></a>
                                            <a href="review.php?id=<?= $movie['id'];?>" style="text-decoration: none; background-color: darkviolet; color: white; padding: 8px; border-radius: 4px;">Review
                                            <span class="fa fa-star"></span></a>
                                            <a href="edit.php?id=<?= $movie['id'];?>" style="text-decoration: none; background-color: dodgerblue; color: white; padding: 8px; border-radius: 4px;">Edit
                                            <span class="fa fa-edit"></span></a>
                                            <a onclick="return confirm('Apakah yakin data akan di hapus?')" href="delete.php?id=<?= $movie['id'];?>" style="text-decoration: none; background-color: deeppink; color: white; padding: 8px; border-radius: 4px;">Delete
                                            <span class="fa fa-trash"></span></a>
                                        </div>
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
