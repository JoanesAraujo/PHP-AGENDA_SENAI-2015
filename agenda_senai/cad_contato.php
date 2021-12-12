<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="./css/bootstrap.min.css">

<meta http-equiv="content-type" content="text/html; charset=utf-8"/>

<!-- Optional theme -->
<link rel="stylesheet" href="./css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="./js/bootstrap.min.js"></script>

<link rel="stylesheet" href="./css/site.css">


<form class="form-horizontal">
<fieldset>

<!-- Form Name -->
<legend>Cadastro de contato</legend>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="nome_cargo">Nome</label>  
  <div class="col-md-4">
  <input id="nome_cargo" name="nome_cargo" type="text" placeholder="" class="form-control input-md" required="">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="email">Email</label>  
  <div class="col-md-4">
  <span id="reauth-email" class="reauth-email"></span>
  <input type="email" id="inputEmail" class="form-control" placeholder="Endereço de Email" required autofocus>
    
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="cargo">Cargo</label>
  <div class="col-md-4">
    <select id="cargo" name="cargo" class="form-control">
    </select>
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="ramal">Ramal</label>  
  <div class="col-md-4">
  <input id="ramal" name="ramal" type="text" placeholder="" class="form-control input-md" required="">
    
  </div>
</div>



<!-- Button (Double) -->
<div class="form-group">
  <label class="col-md-4 control-label" for=""></label>
  <div class="col-md-8">
    <button id="" name="" class="btn btn-success">Salvar</button>
    <button id="" name="" class="btn btn-danger">Cancelar</button>
  </div>
</div>

</fieldset>
</form>
