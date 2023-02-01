<?php
    // Create database connection using config file
	require_once("controllers/auth.php"); 
    include_once("controllers/config.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&family=Sen:wght@400;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
    <title>Movies</title>
</head>
<body>
    
    <?php include 'components/navbar.php' ?>

    <div class="container">
        <div class="content-container">
            <div class="movie-list-container">
                <h1 class="movie-list-title">POPULAR</h1>
                <div class="movie-list-wrapper">
                    <div class="movie-list">
                        <?php
                            $sql = "SELECT * FROM movies ORDER BY views DESC LIMIT 4";
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
                            <a href="detailMovie.php?id=<?= $movie['id'];?>"><button class="movie-list-item-button">TONTON</button></a>
                        </div>
                        <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
            <div class="movie-list-container">
                <h1 class="movie-list-title">SEDANG TAYANG</h1>
                <div class="movie-list-wrapper">
                    <div class="movie-list">
                        <?php
                            $sql = "SELECT * FROM movies WHERE is_tayang=1 ORDER BY ID DESC";
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
                            <a href="detailMovie.php?id=<?= $movie['id'];?>"><button class="movie-list-item-button">TONTON</button></a>
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
                            $sql = "SELECT * FROM movies WHERE is_tayang=0 ORDER BY ID DESC";
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
</body>
</html>