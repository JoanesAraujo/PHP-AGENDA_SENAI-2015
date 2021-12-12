<?php
	$db_host = 'localhost';
	$db_name = 'AGENDA_SENAI';
	$db_user = 'joanes';
	$db_pass = 'fjn81';

	try{
		$con = new PDO('odbc:Driver={SQL Server Native Client 10.0}; Server='.$db_host.'; Database='.$db_name.';', $db_user, $db_pass);
	} catch (PDOException $e) {
		echo 'Connection failed: ' . $e->getMessage();
	}