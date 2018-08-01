<?php
    require_once 'header.php';
    //////inicio de contenido
?>  
<h3>Agregar Incidencia</h3>  
<form action="" method="post">
<div class="row">
  <div class="col-xs-4">
    <label for="emp">Usuario</label>
    <select name="emp" id="emp" class="form-control" required="true">
        <option value="">Selecione usuario...</option>
    </select>
  </div>
  <div class="col-xs-4">
    <label for="suc">Sucursal</label>
    <select name="suc" id="suc" class="form-control" required="true">
        <option value="">Selecione Sucursal...</option>
    </select>
  </div>
  <div class="col-xs-4">
    <label for="cat">Categoria</label>
    <select name="cat" id="cat" class="form-control" required="true">
        <option value="">Selecione Categoria...</option>
    </select>
  </div>
</div> 
<div class="row">
  <div class="col-xs-2">
    <label for="nivel">Nivel de Prioridad</label>
    <select name="nivel" id="nivel" class="form-control" required="true">
        <option value="">Nivel...</option>
    </select>
  </div>
  <div class="col-xs-10">
    <label for="asunto">Asunto</label>
    <input type="text" name="asunto" id="asunto" class="form-control" required="true" placeholder="Titulo de el reporte">
  </div>
</div> 
<div class="row">
    <div class="col-xs-12">
    <label for="rep">Descripcion de Falla</label>  
    <textarea name="rep" id="rep" cols="30" rows="10" class="form-control" required="true" placeholder="Describa detalladamente la falla" ></textarea> 
    </div>
</div>
<div class="row">
    <div class="col-xs-5">
    <label for="att">Adjunte alguna imagen(menor a 1MB)</label>
    <input type="file" name="att" id="att" class="form-control">
    </div>
    <div class="col-xs-2">
        <br></b><input type="reset" value="Restablecer" class="button">
    </div>
    <div class="col-xs-2">
        <br><input type="submit" value="Guardar" class="button">
    </div>
    <div class="col-xs-2">
        <br><a href="tickets.php" class="button">Regresar</a>
    </div>
<div>
</form>
<?php
    /////fin de contenido
    require_once 'footer.php';
?>
