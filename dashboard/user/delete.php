<?php

    require_once("../../controllers/auth.php"); 
	require_once("../../controllers/isAdmin.php"); 
    require_once('../../controllers/config.php');

    $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: ID not found.');

    $sql = "DELETE FROM users WHERE id=:id";
    $query = $db->prepare($sql);
    $query->execute(array(':id' => $id));
    
    header("Location:index.php");

?>