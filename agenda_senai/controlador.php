<?php

try
{	
	//Open database connection
	require 'conexao.php';
	
	//se quiser deixar apenas alguns campos em maiúsculo basta comentar a linha abaixo e fazer assim
	// POR EXEMPLO: $nome = strtoupper($_POST['nome']); 
	$_POST = array_map ('strtoupper', $_POST);#deixa campo todo maiúsculo

	//Getting records (listAction)
	if($_GET["action"] == "list")
	{
		//Get record count
		
		$sth = $con->prepare("SELECT COUNT(*) AS RecordCount FROM contato");
		$sth->execute();

		$result = $sth->fetch(PDO::FETCH_ASSOC);
		$recordCount = $result['RecordCount'];
																//pesquisar maiúsculo, menusculo e com acentuação
		$nomePesquisado 		= ($_GET['nome']) ? " and c.nome like '%".$_GET['nome']."%' collate Latin1_General_CI_AI " : "";
		$departamentoPesquisado = ($_GET['departamento']) ? " and dep.id = ".$_GET['departamento'] : "";
		
		$sth = $con->prepare("select '' as telefones
									, c.id
									, c.nome
									, c.email
									, c.ramal
									, car.id as cargo_id
									, dep.id as departamento_id
									, uni.nome as unidade
							 from contato as c inner join cargo as car on c.cargo_id=car.id
							inner join departamento as dep on c.departamento_id=dep.id
							inner join unidade as uni on dep.unidade_id=uni.id
						WHERE 1=1 $nomePesquisado $departamentoPesquisado
							ORDER BY " . $_GET['jtSorting']);
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
		$jTableResult['TotalRecordCount'] = $recordCount;
		$jTableResult['Records'] = $rows;
		print json_encode($jTableResult);
	}
	//Creating a new record (createAction)
	else if($_GET["action"] == "create")
	{
		
		#$nome 				= strtoupper($_POST["nome"]); //deixa só esse campo maiúsculo
		$nome 				= $_POST["nome"];
		$cargo_id 			= $_POST["cargo_id"];
		$ramal 				= $_POST["ramal"];
		#$email 	 		= strtolower($_POST["email"]); #e-mail minúsculo
		$email 			    = $_POST["email"];
		$departamento_id 	= $_POST["departamento_id"];
		
		$jTableResult = array();
		
		//validações
		if (!$nome) {
			$jTableResult['Result']  = "ERROR";
			$jTableResult['Message'] = "Preencha o nome!";
			print json_encode($jTableResult);
			die;
		}
		if (!$ramal) {
			$jTableResult['Result']  = "ERROR";
			$jTableResult['Message'] = "Digite um Ramal!";
			print json_encode($jTableResult);
			die;
		}
		if (strlen($ramal)!=4) {
			$jTableResult['Result']  = "ERROR";
			$jTableResult['Message'] = "Digite um Ramal de 4 números!!";
			print json_encode($jTableResult);
			die;
		}
		if (!$email) {
			$jTableResult['Result']  = "ERROR";
			$jTableResult['Message'] = "Digite um Email Válido!";
			print json_encode($jTableResult);
			die;
		}
		if (filter_var($email, FILTER_VALIDATE_EMAIL)=== false) {
			$jTableResult['Result']  = "ERROR";
			$jTableResult['Message'] = "Digite um Email Válido!";
			print json_encode($jTableResult);
			die;
		}
		
		//Não cadastrar email existente
				
		$result = $con->prepare("select * from contato where email='$email'");
		$result->execute();	
		if ($result->fetch(PDO::FETCH_ASSOC)) {
			$jTableResult['Result']  = "ERROR";
			$jTableResult['Message'] = "Email já cadastrado!";
			print json_encode($jTableResult);
			die;
		}
		
		
		//Insert record into database
		$result = $con->prepare(
		
								"INSERT INTO contato(nome, cargo_id, ramal, email, departamento_id) VALUES
								('$nome','$cargo_id', '$ramal', '$email', '$departamento_id')"
								
								);
				  $result->execute();
				  
		//Get last inserted record (to return to jTable)
		$result = $con->prepare("SELECT top 1 * FROM contato order by id desc");
		$result->execute();

		$row = $result->fetch(PDO::FETCH_ASSOC);
		
		//Return result to jTable
		
		$jTableResult['Result'] = "OK";
		$jTableResult['Record'] = $row;
		print json_encode($jTableResult);
	}
	//Updating a record (updateAction)
	else if($_GET["action"] == "update")
	{
		$nome             =$_POST['nome'];
		$cargo_id         =$_POST['cargo_id'];
		$ramal			  =$_POST['ramal'];
		$email            =$_POST['email'];
		$departamento_id  =$_POST['departamento_id'];
		
		//validações
		if (!$nome) {
			$jTableResult['Result']  = "ERROR";
			$jTableResult['Message'] = "Prencha o nome!";
			print json_encode($jTableResult);
			die;
		}
		if (!$ramal) {
			$jTableResult['Result']  = "ERROR";
			$jTableResult['Message'] = "Digite um Ramal!";
			print json_encode($jTableResult);
			die;
		}
		if (strlen($ramal)!=4) {
			$jTableResult['Result']  = "ERROR";
			$jTableResult['Message'] = "Digite um Ramal de 4 números!!";
			print json_encode($jTableResult);
			die;
		}
		if (!$email) {
			$jTableResult['Result']  = "ERROR";
			$jTableResult['Message'] = "Digite um Email Válido!";
			print json_encode($jTableResult);
			die;
		}
		if (filter_var($email, FILTER_VALIDATE_EMAIL)=== false) {
			$jTableResult['Result']  = "ERROR";
			$jTableResult['Message'] = "Digite um Email Válido!";
			print json_encode($jTableResult);
			die;
		}
			//Editar email que não seja de quem está sendo editado
				
		$result = $con->prepare("select * from contato where email='$email' and id!=".$_POST["id"]);
		$result->execute();	
		if ($result->fetch(PDO::FETCH_ASSOC)) {
			$jTableResult['Result']  = "ERROR";
			$jTableResult['Message'] = "Email já cadastrado!";
			print json_encode($jTableResult);
			die;
		}
			
			   
		//Update record in database
		$result = $con->prepare("UPDATE contato SET 
										nome 			= '" .$_POST["nome"] . "'
									, 	cargo_id 		= '" .$_POST["cargo_id"] . "'
									, 	ramal 			= '" .$_POST["ramal"] . "'
									, 	email 			= '" .$_POST["email"] . "'
									, 	departamento_id = '" .$_POST["departamento_id"] . "' 
									
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

		$sth = $con->prepare("SELECT COUNT(*) AS RecordCount FROM contato");
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
		$result = $con->prepare("DELETE FROM contato WHERE id = " . $_POST["id"] . "");
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