<?php
    // Create database connection using config file
	require_once("controllers/auth.php"); 
    include_once("controllers/config.php");

	$movie_id = $_GET['id'];
	$user_id = $_SESSION['user']['id'];

	$selectMovie = $db->prepare("SELECT * FROM movies WHERE id=$movie_id");
	$selectMovie->execute();
	$movie = $selectMovie->fetch();

	$incrViews = $db->prepare("UPDATE movies SET views = views + 1 WHERE id=$movie_id");
	$incrViews->execute();

	$selectComments = $db->prepare("SELECT * FROM rates inner join users on rates.user_id=users.id WHERE movie_id=$movie_id ORDER BY rates.id DESC");
	$selectComments->execute();
	$comments = $selectComments->fetchAll();

	if (!empty($_POST['comment'])) {
        $movie_id = $_GET['id'];
        $user_id = $_SESSION['user']['id'];
		$star = $_POST['rate'];
		$com = $_POST['comment'];

		$sql = 'INSERT INTO rates (star,comment,movie_id,user_id) VALUES (:star,:comment,:movie_id,:user_id)';
        $row = $db->prepare($sql);

		$data = array(
			":star" => $star,
			":comment" => $com,
			":movie_id" => $movie_id,
			":user_id" => $user_id
		);

		$saved = $row->execute($data);

		header("Location: detailMovie.php?id=$movie_id");
	}
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
			<div style="display: flex; margin: 0px 0px 24px 50px;">
				<a href="index.php" style="margin-top: 24px; text-decoration: none; background-color:dimgray; color: white; padding-top: 8px; padding-bottom: 8px; padding-left: 12px; padding-right: 12px; border-radius: 4px;">
					<span class="fa fa-arrow-left" style="margin-right: 4px;"></span>Back to Home Page
				</a>
			</div>
			<div class="trailer">
				<iframe
					width="92%"
					height="92%"
					src="<?= $movie['url'] ?>"
					title="YouTube video player"
					frameborder="0"
					allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
					allowfullscreen
				></iframe>
				<!-- src="https://www.youtube.com/embed/BRb4U99OU80" -->
			</div>

			<div class="review">
				<div class="rate">
					<div class="post">
						<div class="text">Thanks for rating us!</div>
						<!-- <div class="edit">EDIT</div> -->
					</div>
					<div class="star-widget">
						<form method="POST" enctype="multipart/form-data">
						
							<input type="radio" name="rate" id="rate-5" value="5" />
							<label for="rate-5" class="fas fa-star"></label>
							
							<input type="radio" name="rate" id="rate-4" value="4" />
							<label for="rate-4" class="fas fa-star"></label>
								
							<input type="radio" name="rate" id="rate-3" value="3" />
							<label for="rate-3" class="fas fa-star"></label>
							
							<input type="radio" name="rate" id="rate-2" value="2" />
							<label for="rate-2" class="fas fa-star"></label>
							
							<input type="radio" name="rate" id="rate-1" value="1" />
							<label for="rate-1" class="fas fa-star"></label>
							
							<div class="input-comment">
								<header></header>
								<div class="textarea">
									<textarea cols="30" name="comment" placeholder="Describe your experience.."></textarea>
								</div>
								<div class="btn">
									<button type="submit">Post</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>

			<h1 style="margin: 20px 0px 30px 50px;">Comments :</h1>

			<?php foreach ($comments as $comment) { ?>
				<div class="comment__container opened" id="first-comment">
					<div class="comment__card">
						<h3 class="comment__title"><?= $comment["username"] ?> 
							<span style="margin-right: 8px; margin-left: 8px;">&ndash;</span>
							<span style="font-size: 0.9rem;"><?= $comment['star'].' / 5' ?></span>
						</h3>
						<p>
							<?= $comment['comment'] ?>
						</p>
						<div class="comment__card-footer">
							<?= date('d F Y', strtotime($comment['created_at'])) ?>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
			
		<script>
			const btn = document.querySelector("button");
			const post = document.querySelector(".post");
			const widget = document.querySelector(".star-widget");
			btn.onclick = () => {
				widget.style.display = "none";
				post.style.display = "block";
			};
		</script>
	</body>
</html>
