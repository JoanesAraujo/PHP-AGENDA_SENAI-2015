<?php

try
{	
	//Open database connection
	require 'conexao.php';
		
	$_POST = array_map('strtoupper', $_POST);
	
	//Getting records (listAction)
	if($_GET["action"] == "list")
	{

		$sth = $con->prepare("SELECT 
								tel.*
							 from telefone as tel inner join contato as c on tel.contato_id=c.id where c.id= " . $_GET['id']);
		$sth->execute();
		
		//Add all records to an array
		$rows = array();
		while($row = $sth->fetch(PDO::FETCH_ASSOC))
		{
		    $rows[] = $row;
		}

		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['TotalRecordCount'] = count($rows);
		$jTableResult['Records'] = $rows;
		print json_encode($jTableResult);
	}
	//Creating a new record (createAction)
	else if($_GET["action"] == "create")
	{
		$contato_id         = $_POST["contato_id"];
		$telefone			= $_POST["telefone"];
		$operadora          = $_POST["operadora"];
		$observacao         = $_POST["observacao"];
		
		//Insert record into database
		$result = $con->prepare(
		
								"INSERT INTO telefone(contato_id,telefone,operadora,observacao) VALUES
								('$contato_id','$telefone','$operadora','$observacao')"
								
								);
				  $result->execute();
			
				  
		//Get last inserted record (to return to jTable)
		$result = $con->prepare("SELECT top 1 * FROM telefone where contato_id=$contato_id order by id desc");
		$result->execute();

		$row = $result->fetch(PDO::FETCH_ASSOC);
		
		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Record'] = $row;
		print json_encode($jTableResult);
						 
	}
		
	
	
	//Updating a record (updateAction)
	else if($_GET["action"] == "update")
	{
		//Update record in database
		$result = $con->prepare("UPDATE telefone SET 
										contato_id 		= '" .$_POST["contato_id"] . "'
									, 	telefone 		= '" .$_POST["telefone"] . "'
									, 	operadora 		= '" .$_POST["operadora"] . "'
									, 	observacao 		= '" .$_POST["observacao"] . "'
									
									WHERE id = " . $_POST["id"] . "");
        $result->execute();
		//Return result to jTable
		
		
		$sth = $con->prepare("select  c.id
									, c.nome
									, c.email
									, c.ramal
									, car.id as cargo_id
									, dep.id as departamento_id
									, uni.nome as unidade
							from contato as c inner join cargo as car on c.cargo_id=car.id
							inner join departamento as dep on c.departamento_id=dep.id
							inner join unidade as uni on dep.unidade_id=uni.id
							" );
		$sth->execute();
		
		//Add all records to an array
		$rows = array();
		while($row = $sth->fetch(PDO::FETCH_ASSOC))
		{
		    $rows[] = $row;
		}

		$sth = $con->prepare("SELECT COUNT(*) AS RecordCount FROM telefone");
		$sth->execute();

		$result = $sth->fetch(PDO::FETCH_ASSOC);
		$recordCount = $result['RecordCount'];
		
		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['TotalRecordCount'] = $recordCount;
		$jTableResult['Records'] = $rows;
		
		print json_encode($jTableResult);
	}
	//Deleting a record (deleteAction)
	else if($_GET["action"] == "delete")
	{
		//Delete from database
		$result = $con->prepare("DELETE FROM telefone WHERE id = " . $_POST["id"] . "");
        $result->execute();
		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
	}
}
catch(Exception $ex)
{
    //Return error message
	$jTableResult = array();
	$jTableResult['Result'] = "ERROR";
	$jTableResult['Message'] = $ex->getMessage();
	print json_encode($jTableResult);
}
	
?>