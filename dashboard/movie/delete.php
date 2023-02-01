<?php

    require_once("../../controllers/auth.php");
    require_once("../../controllers/isAdmin.php");
    require_once('../../controllers/config.php');

    $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: ID not found.');

    $sql = $db->prepare("SELECT thumbnail FROM `movies` WHERE id=:id");
    $dataId = array(
        ":id" => $id
    ); //mencari terlebih dahulu id nya berapa
    $sql->execute($dataId); 
    $movie = $sql->fetch(); 
    unlink("../../assets/".$movie['thumbnail']); //hapus thumbnail

    $delRates = "DELETE FROM rates WHERE movie_id=:id";
    $query = $db->prepare($delRates);
    $query->execute(array(':id' => $id));  //hapus komentar

    $sql = "DELETE FROM movies WHERE id=:id";
    $query = $db->prepare($sql);
    $query->execute(array(':id' => $id));  //hapus film
    
    header("Location:index.php");

?>