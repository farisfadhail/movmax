<?php 
    require_once("controllers/auth.php"); 
    include_once("controllers/config.php");

    if (isset($_POST['search-input'])) {
      $search = $_POST['search-input'];
      
      $sql = "SELECT * FROM movies WHERE `judul` LIKE '%$search%'";
      $row = $db->prepare($sql);
      $row->execute();;
      $movies = $row->fetchAll();

    } else {
      $sql = "SELECT * FROM movies ORDER BY views DESC LIMIT 8";
      $row = $db->prepare($sql);
      $row->execute();
      $movies = $row->fetchAll();
    }

?>

<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
		<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&family=Sen:wght@400;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="style.css">
  </head>
  <body>

    <?php include 'components/navbar.php' ?>

    <div class="container">
      <form action="" method="POST">
        <input type="search" id="myInput" onkeyup="myFunction()" name="search-input" placeholder="Search for names.." title="Type in a name" style="margin: 24px 36px 24px 36px; border-radius: 8px; width: 95%;">
      </form>
      <div id="myUL">
        <div class="content-container">
          <div class="movie-list-container">
            <div class="movie-list-search" style="gap: 50px;">
              <?php
                foreach($movies as $movie){
              ?>
                <div class="movie-list-item" id="li">
                    <img class="movie-list-item-img" src="assets/<?= $movie['thumbnail'] ?>" alt="" />
                    <span class="movie-list-item-title" id="a"><?= $movie['judul']?></span>
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
      </div>
    </div>
  </body>
</html>