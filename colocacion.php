<?php
    $location='S';
    $grafica='c';
    require_once 'cargarbi.php';    
    require_once 'header.php';
    //////inicio de contenido
    require 'estiloconst.php'; 
    require 'menubi.php';
   
?>

<?PHP
    if (empty($_POST)) {
        echo "<div id='uno'></div>";
    }elseif (!empty($_POST)) {
        echo "<div id='colfil'></div>";
    }
    
?>
<form action="" method="post">
    <div class="row">
        <div class="col-xs-3">
            <label for="col">Filtrar por :</label><select name="col" id="col" class="form-control" onchange="this.form.submit();return false;">
                <option value="">Seleccione...</option>
                <?PHP
                    $queryResult=$pdo->query("SELECT * FROM Intranet.filtros_bi WHERE lActivo='S'");
                    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='".$row['valor']."'>".$row['texto']."</option>";
                    }
                ?> 
            </select>
        </div>
        <div class="col-xs-2">
            <br><input type="button" name="imprimir" value="Imprimir"  onClick="window.print();" class="button" />
        </div>
    </div>
</form>
<h3>Relacion de colocacion desde <?php echo $fini ?> a <?php echo $ffin ?></h3>
<table class="table">
    <tr><th>Producto</th><th>Folio</th><th>Cliente</th><th>Tipo</th><th>Importe</th><th>Fecha</th><th>Ejecutivo</th><th>Sucursal</th><th>Empresa</th></tr>
    <?php   
    $queryResult=$pdo->query("SELECT
        CONCAT('CR-',LPAD(B.Folio,6,0)) as Folio,
        CONCAT(C.Nombre,' ',C.Apellido1,' ',C.Apellido2) as Cliente,
        E.tipo as tipocte, D.tipo as tipocto, A.Disposicion,A.FInicio,
      IF(A.FInicio BETWEEN '$fini' AND '$ffin','Nuevo','Disposicion') as Tipo,
      CONCAT(F.Nombre,' ',F.Apellido1,' ',F.Apellido2) as Ejecutivo,
    G.Nombre as sucursal
    FROM
        2_contratos_disposicion A
    INNER JOIN 2_contratos B on A.IDContrato=B.ID
    INNER JOIN 2_cliente C on  B.IDCliente=C.ID
    INNER JOIN 2_entorno_tipocredito D on B.IDTipoCredito=D.ID
    INNER JOIN 2_entorno_tipocliente E on C.IDTipoCliente=E.ID
    INNER JOIN personal F on C.IDEjecutivo=F.ID
    INNER JOIN sucursal G on F.IDSucursal=G.ID
    where A.FInicio BETWEEN '$fini' AND '$ffin'
    and B.status<>'C'
    and B.status<>'-'
    ORDER BY D.tipo ASC");
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        echo"<tr><td>".$row['tipocto']."</td><td>".$row['Folio']."</td><td>".$row['Cliente']."</td><td>".$row['tipocte']."</td><td>".number_format($row['Disposicion'],2)."</td><td>".$row['FInicio']."</td><td>".$row['Ejecutivo']."</td><td>".$row['sucursal']."</td><td>CMU</td></tr>";
    }
    $queryResult=$pdo->query("SELECT
    CONCAT('AP-', LPAD(B.Folio, 6, 0)) AS Folio,
    CONCAT(
      C.Nombre,
      ' ',
      C.Apellido1,
      ' ',
      C.Apellido2
    ) AS Cliente,
    E.tipo AS tipocte,
    'ARRENDAMIENTO' as tipocto,
    A.Saldo as Disposicion,
    A.FInicio,
    IF(A.FInicio BETWEEN '$fini' AND '$ffin','Nuevo','Disposicion') as Tipo,
    CONCAT(F.Nombre,' ',F.Apellido1,' ',F.Apellido2) as Ejecutivo,
  G.Nombre as sucursal
  FROM
    2_ap_disposicion A
  INNER JOIN 2_ap_contrato B ON A.IDContrato = B.ID
  INNER JOIN 2_cliente C ON B.IDCliente = C.ID
  INNER JOIN 2_entorno_tipocliente E ON C.IDTipoCliente = E.ID
  INNER JOIN personal F on C.IDEjecutivo=F.ID
  INNER JOIN sucursal G on F.IDSucursal=G.ID
  where A.FInicio BETWEEN '$fini' AND '$ffin'
  and B.status<>'C'
  and B.status<>'-'
  ORDER BY B.Folio ASC");
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        echo"<tr><td>".$row['tipocto']."</td><td>".$row['Folio']."</td><td>".$row['Cliente']."</td><td>".$row['tipocte']."</td><td>".number_format($row['Disposicion'],2)."</td><td>".$row['FInicio']."</td><td>".$row['Ejecutivo']."</td><td>".$row['sucursal']."</td><td>CMU</td></tr>";
    }
    $queryResult=$pdo->query("SELECT
    CONCAT('AP-', LPAD(B.Folio, 6, 0)) AS Folio,
    CONCAT(
      C.Nombre,
      ' ',
      C.Apellido1,
      ' ',
      C.Apellido2
    ) AS Cliente,
    E.tipo AS tipocte,
    'ARRENDAMIENTO' as tipocto,
    A.Saldo as Disposicion,
    A.FInicio,
    IF(A.FInicio BETWEEN '$fini' AND '$ffin','Nuevo','Disposicion') as Tipo,
    CONCAT(F.Nombre,' ',F.Apellido1,' ',F.Apellido2) as Ejecutivo,
  G.Nombre as sucursal
  FROM
    3_ap_disposicion A
  INNER JOIN 3_ap_contrato B ON A.IDContrato = B.ID
  INNER JOIN 3_cliente C ON B.IDCliente = C.ID
  INNER JOIN 3_entorno_tipocliente E ON C.IDTipoCliente = E.ID
  INNER JOIN personal F on C.IDEjecutivo=F.ID
  INNER JOIN sucursal G on F.IDSucursal=G.ID
  where A.FInicio BETWEEN '$fini' AND '$ffin'
  and B.status<>'C'
  and B.status<>'-'
  ORDER BY B.Folio ASC");
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        echo"<tr><td>".$row['tipocto']."</td><td>".$row['Folio']."</td><td>".$row['Cliente']."</td><td>".$row['tipocte']."</td><td>".number_format($row['Disposicion'],2)."</td><td>".$row['FInicio']."</td><td>".$row['Ejecutivo']."</td><td>".$row['sucursal']."</td><td>CMA</td></tr>";
    }
    $queryResult=$pdo->query("SELECT
    CONCAT('VP-', LPAD(B.Folio, 6, 0)) AS Folio,
    CONCAT(
      C.Nombre,
      ' ',
      C.Apellido1,
      ' ',
      C.Apellido2
    ) AS Cliente,
    E.tipo AS tipocte,
    'VENTA A PLAZO' as tipocto,
    A.SaldoFinal as Disposicion,
    A.FInicio,
    IF(A.FInicio BETWEEN '$fini' AND '$ffin','Nuevo','Disposicion') as Tipo,
    CONCAT(F.Nombre,' ',F.Apellido1,' ',F.Apellido2) as Ejecutivo,
  G.Nombre as sucursal
  FROM
    3_vp_disposicion A
  INNER JOIN 3_vp_contrato B ON A.IDContrato = B.ID
  INNER JOIN 3_cliente C ON B.IDCliente = C.ID
  INNER JOIN 3_entorno_tipocliente E ON C.IDTipoCliente = E.ID
  INNER JOIN personal F on C.IDEjecutivo=F.ID
  INNER JOIN sucursal G on F.IDSucursal=G.ID
  where A.FInicio BETWEEN '$fini' AND '$ffin'
  and B.status<>'C'
  and B.status<>'-'
  ORDER BY B.Folio ASC"); 
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        echo"<tr><td>".$row['tipocto']."</td><td>".$row['Folio']."</td><td>".$row['Cliente']."</td><td>".$row['tipocte']."</td><td>".number_format($row['Disposicion'],2)."</td><td>".$row['FInicio']."</td><td>".$row['Ejecutivo']."</td><td>".$row['sucursal']."</td><td>CMA</td></tr>";
    }
    $queryResult=$pdo->query("SELECT
    CONCAT('PR-', LPAD(B.Folio, 6, 0)) AS Folio,
    CONCAT(
      C.Nombre,
      ' ',
      C.Apellido1,
      ' ',
      C.Apellido2
    ) AS Cliente,
    E.tipo AS tipocte,
    'PRESTAMOS' as tipocto,
    A.Disposicion as Disposicion,
    A.FInicio,
    IF(A.FInicio BETWEEN '$fini' AND '$ffin','Nuevo','Disposicion') as Tipo,
    CONCAT(F.Nombre,' ',F.Apellido1,' ',F.Apellido2) as Ejecutivo,
  G.Nombre as sucursal
  FROM
    3_pr_disposicion A
  INNER JOIN 3_pr_contrato B ON A.IDContrato = B.ID
  INNER JOIN 3_cliente C ON B.IDCliente = C.ID
  INNER JOIN 3_entorno_tipocliente E ON C.IDTipoCliente = E.ID
  INNER JOIN personal F on C.IDEjecutivo=F.ID
  INNER JOIN sucursal G on F.IDSucursal=G.ID
  where A.FInicio BETWEEN '$fini' AND '$ffin'
  and B.status<>'C'
  and B.status<>'-'
  ORDER BY B.Folio ASC"); 
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        echo"<tr><td>".$row['tipocto']."</td><td>".$row['Folio']."</td><td>".$row['Cliente']."</td><td>".$row['tipocte']."</td><td>".number_format($row['Disposicion'],2)."</td><td>".$row['FInicio']."</td><td>".$row['Ejecutivo']."</td><td>".$row['sucursal']."</td><td>CMA</td></tr>";
    }        
?>
</table>

<?php
    /////fin de contenido
    require_once 'footer.php';
?>
