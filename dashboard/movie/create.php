<?php
	require_once("../../controllers/auth.php"); // untuk cek login atau belum
    require_once("../../controllers/isAdmin.php"); //untuk cek apakah dia admin atau bukan
    require_once('../../controllers/config.php'); //untuk menghubungi database

	// berikut script untuk proses tambah barang ke database 
	if(!empty($_POST['judul'])){  //judul kosong atau tidak, kalau kosong gabakal dijalanin script
        $filename = rand().'.jpg';  //nama file

		// menangkap data post 
		$judul = $_POST['judul']; 
		$sinopsis = htmlspecialchars($_POST['sinopsis']);
		$thumbnail = $filename;
		$url = $_POST['url'];
		$release_date = $_POST['release_date'];

        // Location
        $target_file = '../../assets/'.$filename;

        // file extension
        $file_extension = pathinfo(
            $target_file, PATHINFO_EXTENSION);
             
        $file_extension = strtolower($file_extension);
      
        // Valid image extension
        $valid_extension = array("png","jpeg","jpg");
		
        $sql = 'INSERT INTO movies (judul,sinopsis,thumbnail,url,release_date,is_tayang) VALUES (:judul,:sinopsis,:thumbnail,:url,:release_date,:is_tayang)';
        $row = $db->prepare($sql);
        
        $date_now = date("Y-m-d"); // this format is string comparable

        if ($date_now >= $release_date) {
            $data = array(
                ":judul" => $judul,
                ":sinopsis" => $sinopsis,
                ":thumbnail" => $thumbnail,
                ":url" => $url,
                ":release_date" => $release_date,
                ":is_tayang" => 1
            );  //dibuat data is_tayang

            if(in_array($file_extension, $valid_extension)) {
                if(move_uploaded_file($_FILES['thumbnail']['tmp_name'], $target_file)) {
                    // Execute query
                    $saved = $row->execute($data);
                    if($saved) header("Location: index.php");
                }
            }
        } else {
            $data = array( //data coming soon
                ":judul" => $judul,
                ":sinopsis" => $sinopsis,
                ":thumbnail" => $thumbnail,
                ":url" => $url,
                ":release_date" => $release_date,
                ":is_tayang" => 0
            );

            if(in_array($file_extension, $valid_extension)) {
                if(move_uploaded_file($_FILES['thumbnail']['tmp_name'], $target_file)) {
                    // Execute query
                    $saved = $row->execute($data);
                    if($saved) header("Location: index.php");
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="../dashboard.css" type="text/css" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="../dashboard.js"></script>
        <title>Tambah Movie</title>
	</head>

	<body>
		
        <?php include '../../components/sidebar.php' ?>

		<div id="main">
			<div class="head">
				<div class="col-div-6">
					<span style="font-size: 30px; cursor: pointer; color: white" class="nav">Tambah Movie</span>
					<span style="font-size: 30px; cursor: pointer; color: white" class="nav2">Tambah Movie</span>
				</div>

				<div class="col-div-6">
					<div class="profile">
						<p><?= $_SESSION["user"]["username"] ?> <span>Admin Novmax</span></p>
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
                            <input class="form-styling" type="text" name="judul" style="margin-left: 12px; color: white;"/>
                            
                            <label for="sinopsis">Sinopsis</label>
                            <textarea class="form-styling" type="textarea" name="sinopsis" style="margin-left: 12px; color: white; padding: 15px;"></textarea>
                            
                            <label for="thumbnail">Thumbnail</label>
                            <div>
                                <img id="output_image" style="width: 200px; height: auto; margin-bottom: 8px; margin-left: 12px;"/>
                            </div>
                            <input class="form-styling" type="file" name="thumbnail" onchange="preview_image(event)" style="margin-left: 12px; color: white; padding-top: 15px"/>
                            
                            <label for="url">Url</label>
                            <input class="form-styling" type="url" name="url" style="margin-left: 12px; color: white;"/>
                            
                            <label for="release_date">Tanggal Rilis</label>
                            <input class="form-styling" type="date" name="release_date" style="margin-left: 12px; color: white; padding: 10px;"/>

                            
                            <div style="display: flex; margin-left: 12px; margin-bottom: 12px; ">
                                <button style="font-size: 16px; border: none; text-decoration: none; background-color: limegreen; color: white; padding-top: 12px; padding-bottom: 12px; padding-left: 18px; padding-right: 18px; border-radius: 4px;">Create
                                <span class="fa fa-plus-circle"></span></button>
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