<?php 
    If ( $_SESSION['user']['is_admin'] != '1'){ 
		Echo 'you do not have access to this section'; 
		exit;
	}
?>