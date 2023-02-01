<?php

    // include database connection file
    require_once("../../controllers/auth.php");
    require_once("../../controllers/isAdmin.php");
    include_once("../../controllers/config.php");
    
    // berikut script untuk proses edit barang ke database 
    
    if(!empty($_POST['judul'])){
        $id = $_GET['id'];

        // File name
        $filename = rand().'.jpg';
        $date_now = date("Y-m-d"); // this format is string comparable

        // menangkap data post 
        $judul = $_POST['judul'];
        $sinopsis = $_POST['sinopsis'];
        $thumbnail = $filename;
        $url = $_POST['url'];
        $release_date = $_POST['release_date'];
        
        // Location
        $target_file = '../../assets/'.$filename;

        // file extension
        $file_extension = pathinfo($target_file, PATHINFO_EXTENSION);
        
        $file_extension = strtolower($file_extension);
        
        // Valid image extension
        $valid_extension = array("png","jpeg","jpg");

        $thumbnailBaru = $thumbnail;
        $newPath = '../../assets/'.$thumbnailBaru;
        
        // Proses upload
        if(move_uploaded_file($_FILES['thumbnail']['tmp_name'], $newPath)) { 
            $sql = $db->prepare("SELECT thumbnail FROM `movies` WHERE id=:id");
            $dataId = array(
                ":id" => $id
            );
            $sql->execute($dataId); 
            $movie = $sql->fetch(); 

            if(is_file("../../assets/".$movie['thumbnail'])) // Jika foto ada
                unlink("../../assets/".$movie['thumbnail']); // Hapus file foto sebelumnya yang ada di folder images
                // Proses ubah data ke Database
                $row = $db->prepare("UPDATE movies SET judul=:judul, sinopsis=:sinopsis, thumbnail=:thumbnailBaru, url=:url, release_date=:release_date, is_tayang=:is_tayang WHERE id=:id");
                
                if ($date_now >= $release_date) {
                    $data = array(
                        ":judul" => $judul,
                        ":sinopsis" => $sinopsis,
                        ":thumbnailBaru" => $thumbnail,
                        ":url" => $url,
                        ":release_date" => $release_date,
                        ":is_tayang" => 1,
                        ":id" => $id
                    );
                } else {
                    $data = array(
                        ":judul" => $judul,
                        ":sinopsis" => $sinopsis,
                        ":thumbnailBaru" => $thumbnail,
                        ":url" => $url,
                        ":release_date" => $release_date,
                        ":is_tayang" => 0,
                        ":id" => $id
                    );
                }

                $saved = $row->execute($data); 

                if($saved) { 
                    header("Location: index.php"); 
                } else {
                    echo "Maaf, Terjadi kesalahan saat mencoba untuk menyimpan data ke database.";
                    echo "<br><a href='edit.php?id=$id'>Kembali Ke Form</a>";
                }
        } else {
            $row = $db->prepare("UPDATE movies SET judul=:judul, sinopsis=:sinopsis, url=:url, release_date=:release_date, is_tayang=:is_tayang WHERE id=:id");
            
            if ($date_now >= $release_date) {
                $data = array(
                    ":judul" => $judul,
                    ":sinopsis" => $sinopsis,
                    ":url" => $url,
                    ":release_date" => $release_date,
                    ":is_tayang" => 1,
                    ":id" => $id
                );
            } else {
                $data = array(
                    ":judul" => $judul,
                    ":sinopsis" => $sinopsis,
                    ":url" => $url,
                    ":release_date" => $release_date,
                    ":is_tayang" => 0,
                    ":id" => $id
                );
            }

            $saved = $row->execute($data);

            if($saved) { 
                header("Location: index.php"); // Redirect ke halaman index.php
            } else {
                // Jika Gagal, Lakukan :
                echo "Maaf, Terjadi kesalahan saat mencoba untuk menyimpan data ke database.";
                echo "<br><a href='edit.php?id=$id'>Kembali Ke Form</a>";
            }
        }
    }

	// untuk menampilkan data barang berdasarkan id barang
	$id = $_GET['id'];
	$sql = "SELECT * FROM movies WHERE id=?";
	$row = $db->prepare($sql);
	$row->execute(array($id));
	$movie = $row->fetch();
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="../dashboard.css" type="text/css" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="../dashboard.js"></script>
        <title>Edit Movie - <?= $movie['judul']?></title>
	</head>

	<body>
		
        <?php include '../../components/sidebar.php' ?>

		<div id="main">
			<div class="head">
				<div class="col-div-6">
					<span style="font-size: 30px; cursor: pointer; color: white" class="nav">Edit Movie - <?= $movie['judul']?></span>
					<span style="font-size: 30px; cursor: pointer; color: white" class="nav2">Edit Movie - <?= $movie['judul']?></span>
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
                        <form action="" method="POST" enctype="multipart/form-data">
                            <label for="judul">Judul</label>
                            <input class="form-styling" value="<?= $movie['judul']?>" type="text" name="judul" style="margin-left: 12px; color: white;"/>
                            
                            <label for="sinopsis">Sinopsis</label>
                            <textarea class="form-styling" type="textarea" name="sinopsis" style="margin-left: 12px; color: white; padding: 15px;"><?= $movie['sinopsis']?></textarea>
                            
                            <label for="thumbnail">Thumbnail</label>
                            <div>
                                <img id="output_image" style="width: 200px; height: auto; margin-bottom: 8px; margin-left: 12px;"/>
                            </div>
                            <input class="form-styling" value="<?= $movie['thumbnail']?>" type="file" name="thumbnail" onchange="preview_image(event)" style="margin-left: 12px; color: white; padding-top: 15px"/>
                            
                            <label for="url">Url</label>
                            <input class="form-styling" value="<?= $movie['url']?>" type="url" name="url" style="margin-left: 12px; color: white;"/>
                            
                            <label for="release_date">Tanggal Rilis</label>
                            <input class="form-styling" value="<?= $movie['release_date']?>" type="date" name="release_date" style="margin-left: 12px; color: white; padding: 10px;"/>

                            
                            <div style="display: flex; margin-left: 12px; margin-bottom: 12px; ">
                                <button name="update" style="font-size: 16px; border: none; text-decoration: none; background-color: dodgerblue; color: white;  padding: 12px; border-radius: 4px;">Edit
                                <span class="fa fa-edit"></span></button>
                            </div>
                        </form>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>

        
        <script>
            function preview_image(event) {
                var reader = new FileReader();
                reader.onload = function() {
                    var output = document.getElementById('output_image');
                    output.src = reader.result;
                }
                reader.readAsDataURL(event.target.files[0]);
            }
        </script>
	</body>
</html>