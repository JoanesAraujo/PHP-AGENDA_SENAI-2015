<?php require 'conexao.php'; ?>

<html>
  <head>
  <meta http-equiv="content-type" content="text/html; charset=uft-8"/>
  <!-- Latest compiled and minified CSS -->
  <title>SENAI</title>
<link rel="stylesheet" href="./css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="./css/bootstrap-theme.min.css">


<link rel="stylesheet" href="./css/menu.css">
	
	<!-- jgrid -->
	<link href="./js/jtable.2.4.0/themes/redmond/jquery-ui-1.8.16.custom.css" rel="stylesheet" type="text/css" />
	<link href="./js/jtable.2.4.0/scripts/jtable/themes/lightcolor/blue/jtable.css" rel="stylesheet" type="text/css" />	
	<script src="./js/jtable.2.4.0/scripts/jquery-1.6.4.min.js" type="text/javascript"></script>
    <script src="./js/jtable.2.4.0/scripts/jquery-ui-1.8.16.custom.min.js" type="text/javascript"></script>
    <script src="./js/jtable.2.4.0/Scripts/jtable/jquery.jtable.js" type="text/javascript"></script>	
	<!-- fim jgrid-->
	
	<!-- Mascara telefone-->
		<script type="text/javascript">
			function mascaraTelefone( campo ) {
      
         function trata( valor,  isOnBlur ) {
            
            valor = valor.replace(/\D/g,"");                      
            valor = valor.replace(/^(\d{2})(\d)/g,"($1)$2");       
            
            if( isOnBlur ) {
               
               valor = valor.replace(/(\d)(\d{4})$/,"$1-$2");   
            } else {

               valor = valor.replace(/(\d)(\d{3})$/,"$1-$2"); 
            }
            return valor;
         }
         
         campo.onkeypress = function (evt) {
             
            var code = (window.event)? window.event.keyCode : evt.which;   
            var valor = this.value
            
            if(code > 57 || (code < 48 && code != 8 ))  {
               return false;
            } else {
               this.value = trata(valor, false);
            }
         }
         
         campo.onblur = function() {
            
            var valor = this.value;
            if( valor.length < 13 ) {
               this.value = ""
            }else {      
               this.value = trata( this.value, true );
            }
         }
         
         campo.maxLength = 14;
      }
		</script>
	<!--Fim Mascara telefone-->

</head>
 
<nav class="navbar navbar-default" role="navigation">
	<div class="container">
		<div class="navbar-header">
			<a id="menu-toggle" href="#" class="navbar-toggle">
					<span class="sr-only">Toggle navigation</span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			</a>
  			<a class="navbar-brand" href="home.xhtml" align="center">
  				 AGENDA SENAI 
  			</a>
			
		</div>
		<!-- Imagem do topo -->
		<img src="img/SENAI-PE-2014.jpg" height="50" align="down">
						 
		<!-- Pesquisa do contato-->
		<div class="filtering">
			<form>
				Nome: <input type="text" name="nome" id="nome" value="<?php echo isset($_GET['nome']) ?$_GET['nome']:""; ?>"/>
				Departamento: 
				<select id="departamento" name="departamento">
					<option value="">TODOS</option>
					<?php
							
							$sth = $con->prepare("select dep.id,
							dep.nome departamento, uni.nome unidade
							from departamento as dep inner join unidade as uni on dep.unidade_id=uni.id order by uni.nome, dep.nome");
							$sth->execute();
							
							
							$rows = array();
							while($row = $sth->fetch(PDO::FETCH_ASSOC))
							{
								$selecionado = $_GET['departamento']==$row['id']?'selected':'';
								
								echo "<option value='".$row['id']."' $selecionado>".$row['unidade'].' - '.$row['departamento']."</option>";
							}							
							?>
				</select>
				<button type="submit" id="LoadRecordsButton">Pesquisar</button>
			</form>
		</div>
		<!--Fim da Pesquisa do contato-->
		 
		 
		<div id="PeopleTableContainer" align="center" style="width: 100%;"></div>
		<script type="text/javascript">
		
		$(document).ready(function () {
		
			$("#nome").focus();
				
		    //Prepare jTable
			$('#PeopleTableContainer').jtable({
													
				title: 'Agenda Eletronica',
				paging: true,
				pageSize: 200,
				sorting: true,
				defaultSorting: 'c.nome ASC',
				<!--jogando o parametro GET no listar-->
				actions: {										  
					listAction: 'controlador.php?action=list&nome=<?php echo isset($_GET['nome'])?$_GET['nome']:"" ?>&departamento=<?php echo isset($_GET['departamento'])?$_GET['departamento']:"" ?>'
					
					//Só cadastrar quem for super usuário
					<?php if (isset($_GET['super']) && $_GET['super']=='usuario') { ?>
					,createAction: 'controlador.php?action=create',
					updateAction: 'controlador.php?action=update',
					deleteAction: 'controlador.php?action=delete'
					<?php } ?>
				},
				
				fields: {
					id: {
						key: true,
						create: false,
						edit: false,
						list: false
					},
					nome: {
						title: 'Nome',
						width: '40%'
					},
					cargo_id: {
						title: 'Cargo',
						width: '20%',
						options: {
							
							<?php
							
							$sth = $con->prepare("select * from cargo order by nome");
							$sth->execute();
							
							//selecionamos id e nome do departamento e joga na estrutura abaixo aonde contato juntou com cargo
							$rows = array();
							echo "0:'--Selecione--',";
							while($row = $sth->fetch(PDO::FETCH_ASSOC))
							{
								echo "'".$row['id']."':'".$row['nome']."',";
							}
												
							?>
							}
					},
					ramal: {
						title: 'Ramal',
						width: '10%'
					},
					email: {
						title: 'Email',
						width: '20%'
					},					
					departamento_id: {
						title: 'Departamento',
						width: '50%',
							options: {
							
							<?php
							
							$sth = $con->prepare("select dep.id,
							dep.nome departamento, uni.nome unidade
							from departamento as dep inner join unidade as uni on dep.unidade_id=uni.id");
							$sth->execute();
							
							//selecionamos id e nome do departamento e joga na estrutura abaixo aonde unidade juntou com departamento
							$rows = array();
							echo "0:'--Selecione--',";
							while($row = $sth->fetch(PDO::FETCH_ASSOC))
							{
								echo "'".$row['id']."':'".$row['unidade'].' - '.$row['departamento']."',";
							}
							# 'id': 'Home phone',
							
							?>
							}
					} 
					
					,
					//Tabela do Telefone
					telefones: {
						title: '',
						width: '5%',
						sorting: false,
						edit: false,
						create: false,								   					
						display: function (studentData) {
							//Create an image that will be used to open child table
							var $img = $('<a href="javascript:void(0);"><img src="./img/phone_metro.png" title="Exibir N&uacute;meros de Telefone" /></a>');							
							//Open child table when user clicks the image						
							
							var clicado = false;
							
							$img.click(function () {
								
								if (clicado == true) {
									$('.jtable-close-button').click();
									clicado = false;
								} else {
									clicado = true;
								
								$('#PeopleTableContainer').jtable('openChildTable', 
										$img.closest('tr'),
										{
											messages: {
												addNewRecord: '+ Adicionar Telefone',
												deleteConfirmation: 'Voc&ecirc; ir&aacute; deletar o telefone. Tem certeza que deseja fazer isso?',
												deleteText: 'Deletar Telefone',
												deleting: 'Deletando',
												 editRecord: 'Editar Telefone',
												 areYouSure: 'Deletar Telefone?',
												canNotDeletedRecords: 'Can not deleted {0} of {1} records!',
												deleteProggress: 'Deleted {0} of {1} records, processing...'
											},
											title: studentData.record.nome + ' - Meus Telefones',
											actions: {
												listAction: './controlador_fone.php?action=list&id=' + studentData.record.id
												
												<?php if (isset($_GET['super']) && $_GET['super']=='usuario') { ?>
												,
												deleteAction: './controlador_fone.php?action=delete',
												updateAction: './controlador_fone.php?action=update',
												createAction: './controlador_fone.php?action=create'
												<?php } ?>
											},
												
											fields: {
												id: {
													key: true,
													create: false,
													edit: false,
													list: false
												},
												telefone: {
													title: 'Telefone',
													width: '30%'																										
													
												},
												contato_id: {
													type: 'hidden',
													defaultValue: studentData.record.id
												},												
												operadora: {
													title: 'Operadora',
													width: '30%'
												},
												observacao: {
													title: 'Observa&ccedil;&atilde;o',
													width: '30%'
												}
												
											}
										}, function (data) { //opened handler
											data.childTable.jtable('load');
										});
										
								}
							});
							//Return image to show on the person row
							return $img;
							
						}
						 
					}
				}
							
				
			});

			//Load person list from server
			$('#PeopleTableContainer').jtable('load');

		});
		
			

	</script>
		
		
  	</div>
</nav>
