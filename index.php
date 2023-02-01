<?php 
	require_once("controllers/auth.php");
    include_once("controllers/config.php");
?>

<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="style.css" />
		<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&family=Sen:wght@400;700;800&display=swap" rel="stylesheet" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
		<title>MovMax</title>
	</head>

	<body>
		
		<?php include 'components/navbar.php' ?>

		<div class="container">
			<div class="content-container">
				<div class="featured-content" style="background: linear-gradient(to bottom, rgba(0, 0, 0, 0), #151515), url('img/f-1.jpg')">
					<?php
						$sql = "SELECT * FROM movies ORDER BY ID DESC LIMIT 1";
						$row = $db->prepare($sql);
						$row->execute();
						$lastMovie = $row->fetchAll();
						foreach($lastMovie as $lm){
					?>
						<img class="featured-title" src="assets/<?= $lm['thumbnail'] ?>" alt="" style="width: 300px;" />
						<p class="featured-desc">
							<?= $lm['sinopsis'] ?>
						</p>
						<a href="detailMovie.php?id=<?= $lm['id'];?>">
							<button name="addView" class="featured-button" onclick="">TONTON</button>
						</a>
					<?php } ?>
				</div>
				<div class="movie-list-container">
					<h1 class="movie-list-title">SEDANG TAYANG</h1>
					<div class="movie-list-wrapper">
						<div class="movie-list">
							<?php
								$sql = "SELECT * FROM movies WHERE is_tayang=1";
								$row = $db->prepare($sql);
								$row->execute();
								$movies = $row->fetchAll();
								foreach($movies as $movie){
							?>
							<div class="movie-list-item">
								<img class="movie-list-item-img" src="assets/<?= $movie['thumbnail'] ?>" alt="" />
								<span class="movie-list-item-title"><?= $movie['judul']?></span>
								<p class="movie-list-item-desc">
									<?= $movie['sinopsis'] ?>
								</p>
								<a href="detailMovie.php?id=<?= $movie['id'];?>">
									<button class="movie-list-item-button">TONTON</button>
								</a>
							</div>
							<?php
								}
							?>
						</div>
						<i class="fas fa-chevron-right arrow"></i>
					</div>
				</div>
				<div class="movie-list-container">
					<h1 class="movie-list-title">SEGERA TAYANG</h1>
					<div class="movie-list-wrapper">
						<div class="movie-list">
							<?php
								$sql = "SELECT * FROM movies WHERE is_tayang=0";
								$row = $db->prepare($sql);
								$row->execute();
								$movies = $row->fetchAll();
								foreach($movies as $movie){
							?>
							<div class="movie-list-item">
								<img class="movie-list-item-img" src="assets/<?= $movie['thumbnail'] ?>" alt="" />
								<span class="movie-list-item-title"><?= $movie['judul']?></span>
								<p class="movie-list-item-desc"><?= $movie['sinopsis']?></p>
								<a href="detailMovie.php?id=<?= $movie['id'];?>">
									<button class="movie-list-item-button">TONTON</button>
								</a>
							</div>
							<?php
								}
							?>
						</div>
						<i class="fas fa-chevron-right arrow"></i>
					</div>
				</div>
			</div>
		</div>
		<script src="app.js"></script>
	</body>
</html>
