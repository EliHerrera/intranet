<?php
set_time_limit(0);
if (!empty($_POST)) {
    $inicio='2018-01-01';
    $tc=0;
    require_once 'cn/cn.php';
    $queryResult=$pdo->query("SELECT A.Paridad from sibware.indicador_tipocambio A where Fecha='$_POST[ffin]'");
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        $tc=$row['Paridad'];
    }
    

    $queryResult=$pdo->query("SELECT * from Intranet.PLD_Tipo_persona");
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        $arraytpto[]=$row['Pto'];
        $arraytp[]=$row['TipoPersona'];

    }
    $queryResult=$pdo->query("SELECT * from Intranet.PLD_Actividades");
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        $arrayActPto[]=$row['Pto'];
        $arrayAct[]=$row['Indicador'];

    }
    $queryResult=$pdo->query("SELECT * from Intranet.PLD_Nacionalidad");
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        $arrayNacPto[]=$row['Pto'];
        $arrayNac[]=$row['Indicador'];

    }
    $queryResult=$pdo->query("SELECT * from Intranet.PLD_PEPS");
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        $arrayPepsPto[]=$row['Pto'];
        $arrayPeps[]=$row['Indicador'];

    }
    $queryResult=$pdo->query("SELECT * from Intranet.PLD_Const");
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        $arrayConstPto[]=$row['Pto'];
        $arrayConst[]=$row['Indicador'];
        $arrayConstli[]=$row['liminf'];
        $arrayConstls[]=$row['limsup'];

    }
    $queryResult=$pdo->query("SELECT * from Intranet.PLD_FuenteFondeo");
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        $arrayffPto[]=$row['Pto'];
        $arrayff[]=$row['indicador'];
        

    }
    
    $queryResult=$pdo->query("SELECT A.Pto, A.Indicador, B.tipo from Intranet.PLD_TipoCredito A INNER JOIN sibware.2_entorno_tipocredito B on A.IDTipoCredito=B.ID");
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        $arraytcpto[]=$row['Pto'];
        $arraytc[]=$row['Indicador'];

    }
    $queryResult=$pdo->query("SELECT A.Pto, A.Indicador from Intranet.PLD_Cobertura A ");
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        $arraycobpto[]=$row['Pto'];
        $arraycob[]=$row['Indicador'];

    }
    $queryResult=$pdo->query("SELECT A.Pto, A.Indicador from Intranet.PLD_Zonas_R A ");
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        $arrayzrpto[]=$row['Pto'];
        $arrayzr[]=$row['Indicador'];

    }
    $queryResult=$pdo->query("SELECT A.Pto, A.Indicador from Intranet.PLD_InsMont A ");
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        $arrayimpto[]=$row['Pto'];
        $arrayim[]=$row['Indicador'];

    }
    $queryResult=$pdo->query("SELECT A.Pto, A.Indicador from Intranet.PLD_Moneda A ");
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        $arraymdpto[]=$row['Pto'];
        $arraymd[]=$row['Indicador'];

    }
    $queryResult=$pdo->query("SELECT A.Pto, A.Indicador from Intranet.PLD_VolumenTr A ");
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        $arrayvopto[]=$row['Pto'];
        $arrayvo[]=$row['Indicador'];

    }

    $queryResult = $pdo->query("SELECT
	B.ID,
	CONCAT(
		B.Nombre,
		' ',
		B.Apellido1,
		' ',
		B.Apellido2
	) AS Cliente,
	B.Tipo,
	B.IDPais,
	D.pais,
	D.altoriesgo,
	B.IDActividadCNBV,
	B.IDLocalidadCNBV,
	F.lPeps,
	B.FSHCP,
    E.Indicador,
    DATEDIFF('$_POST[ffin]', B.FSHCP) AS diasC
FROM
	sibware.2_cliente B
LEFT JOIN sibware.2_entorno_paises D ON B.IDPais = D.ID
INNER JOIN sibware.2_entorno_actividadcnbv E ON B.IDActividadCNBV = E.ID
LEFT JOIN sibware.2_pld_matriz F ON B.ID = F.IDCliente
INNER JOIN sibware.2_entorno_localidadcnbv G ON B.IDLocalidadCNBV = G.ID
LEFT JOIN sibware.2_prestamos H ON B.ID = H.IDCliente
LEFT JOIN sibware.2_contratos I ON B.ID = I.IDCliente
WHERE
	B.FCliente <= '$_POST[ffin]'
AND B. STATUS = 'S'
AND B.lProspecto = 'N'
AND (
	(
		(
			(
				H.FInicio <= '$inicio'
				AND H.FTermino >= '$inicio'
				AND H.FTermino <= '$_POST[ffin]'
			)
			OR (
				H.FInicio >= '$inicio'
				AND H.FInicio <= '$_POST[ffin]'
				AND H.FTermino >= '$_POST[ffin]'
			)
			OR (
				H.FInicio <= '$inicio'
				AND H.FTermino >= '$_POST[ffin]'
			)
		)
		AND (H. STATUS <> 'C')
	)
	OR (
		(
			(
				I.FInicio <= '$inicio'
				AND I.FTermino >= '$inicio'
				AND I.FTermino <= '$_POST[ffin]'
			)
			OR (
				I.FInicio >= '$inicio'
				AND I.FInicio <= '$_POST[ffin]'
				AND I.FTermino >= '$_POST[ffin]'
			)
			OR (
				I.FInicio <= '$inicio'
				AND I.FTermino >= '$_POST[ffin]'
			)
		)
		AND (
			I. STATUS <> 'C'
			OR I. STATUS <> '-'
		)
	)
)
GROUP BY
	B.ID
");

}


?>
<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Intr@net Credicor</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
<header>
        <div class="user">BIENVENIDO <strong>EFREN ALMANZA LAMAS</strong>   <a href="#"><img src="img/icons/user.png" alt="" height='12px' width='12px'></a> <a href="#"><img src="img/icons/notification.png" alt="" height='10px' width='10px'></a> <a href="#">CERRAR SESION </a> </div>
        
    </header>
    <div class="logo"><img src="img/logos/Imagotipo.png" alt="" height='45px' width="235px"  width="100" ></div>
    <nav>
    <div class="menu">
		<ul>
            <li><a href="#"><img src="img/icons/icon_tramites.png" alt="" height='20px' width='20px'></br>TRAMITES INTERNOS</a>
                <ul>
							<li><a href="#">VACACIONES</a></li>
                            <li><a href="#">PRESTAMOS</a></li>
                            <li><a href="#">...</a></li>    
                            
                </ul>    
            </li>            
			<li><a href="#"><img src="img/icons/icon_digital.png" alt="" height='20px' width='20px'></br>REVISTA DIGITAL</a></li>
            <li><a href="#"><img src="img/icons/icon_seguimientos.png" alt="" height='20px' width='20px'></br>SEGUIMIENTOS</a>
                <ul>
							<li><a href="#">VACACIONES</a></li>
                            <li><a href="#">PRESTAMOS</a></li>
                            <li><a href="#">...</a></li>    
                            
                </ul>
            </li>
            <li><a href="#"><img src="img/icons/icon_documentacion.png" alt="" height='20px' width='20px'></br>DOCUMENTACION</a>
                <ul>
							<li><a href="#">VACACIONES</a></li>
                            <li><a href="#">PRESTAMOS</a></li>
                            <li><a href="#">...</a></li>    
                            
                </ul>
            </li>    
            <li><a href="#"><img src="img/icons/icon_bussines.png" alt="" height='20px' width='20px'></br>BUSSINES INTELIGENCE</a>
                <ul>
							<li><a href="#">VACACIONES</a></li>
                            <li><a href="#">PRESTAMOS</a></li>
                            <li><a href="#">...</a></li>    
                            
                </ul>
            </li>  
            <li><a href="#"><img src="img/icons/icon_soporte.png" alt="" height='20px' width='20px'></br>SOPORTE</a>
                <ul>
							<li><a href="#">VACACIONES</a></li>
                            <li><a href="#">PRESTAMOS</a></li>
                            <li><a href="#">...</a></li>    
                            
                </ul>
            </li>
        </ul>
    </div>
	</nav>
<div class="contenido">
<h1>EBR/PLD Credicor 2018</h1>
<form action="ebrpld.php" method="post" class="form-inline" role="form">
<label for="fini">Desde</label><input type='date' id='fini' name='fini' required='true' ><label for="ffin">Hasta</label><input type='date' id='ffin' name='ffin' required='true' >
<input type=submit value='Buscar' class="button"> 
<h3>Rango de Clasificacion:
<?php 
    if (!empty($_POST)) {
        echo " De ".$_POST['fini']." a ".$_POST['ffin'];
    }
     
?>
</h3>
<div>
    <h3>Tipo Persona</h3>
    <table class='table'>
    <tr><th>Indicadores</th><th>Riesgo</th><th>Num. Ctes</th><th>%</th><th>Ponderacion</th></tr>
        <?php
            if (!empty($_POST)) {
                $tipof=0;
                $tipom=0;
                $tipoo=0;
                $nacM=0;
                $nacAR=0;
                $nacExt=0;
                $nacOtro=0;
                $pepsN=0;
                $pepsEx=0;
                $nPeps=0;
                $oPeps=0;
                $const1=0;
                $const2=0;
                $const3=0;
                $actv1=0;
                $actv2=0;
                $actv3=0;
                $actv4=0;
                $actv5=0;
                
                while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                    if ($row['Tipo']=='F') {
                        $tipof++;

                    }elseif ($row['Tipo']=='M') {
                        $tipom++;
                    }else{
                        $tipoo++;
                    }
                    if ($row['IDPais']==142) {
                        $nacM++;
                    }elseif ($row['altoriesgo']=='S') {
                        $nacAR++;
                    }elseif($row['altoriesgo']=='N'and $row['IDpais']<>142){
                        $nacExt++;
                    }else{
                        $nacOtro++;
                    }
                    if ($row['IDPais']==142 and $row['lPeps']=='S') {
                        $pepsN++;
                    }elseif($row['IDPais']<>142 and $row['lPeps']=='S') {
                        $pepsEx++;
                    }elseif($row['lPeps']=='N') {
                        $nPeps++;
                    }else{
                        $oPeps++;
                    }
                    if ($row['diasC']>$arrayConstli[0] and $row['diasC']<=$arrayConstls[0]) {
                        $const1++;
                    }elseif($row['diasC']>=$arrayConstli[1] and $row['diasC']<=$arrayConstls[1]) {
                        $const2++;
                    }elseif($row['diasC']>=$arrayConstli[2] ) {
                        $const3++;
                    }else{
                        $constO++;
                    }
                    if ($row['Indicador']==1) {
                        $actv1++;
                    }elseif($row['Indicador']==2){
                        $actv2++;    
                    }elseif($row['Indicador']==3){
                        $actv3++;    
                    }elseif($row['Indicador']==4){
                        $actv4++;    
                    }elseif($row['Indicador']==5){
                        $actv5++;    
                    }elseif($row['Indicador']==6){
                        $actv6++;    
                    }elseif($row['Indicador']==7){
                        $actv7++;    
                    }
                    
                    
                    
                    
                    
                }
                $totalcte=$tipof+$tipom+$tipoo;
                $pondf=$tipof/$totalcte;
                $pondm=$tipom/$totalcte;
                $pondo=$tipoo/$totalcte;
                $pondNacM=$nacM/$totalcte;
                $pondNacExAR=$nacAR/$totalcte;
                $pondNacExt=$nacExt/$totalcte;
                $pondNacO=$nacOtro/$totalcte;
                $pondPepsN=$pepsN/$totalcte;
                $pondPepsEx=$pepsEx/$totalcte;
                $pondNoPeps=$nPeps/$totalcte;
                $pondOPeps=$oPeps/$totalcte;
                $pondConst1=$const1/$totalcte;
                $pondConst2=$const2/$totalcte;
                $pondConst3=$const3/$totalcte;
                $pondConst4=$constO/$totalcte;
                $pondactv1=$actv1/$totalcte;
                $pondactv2=$actv2/$totalcte;
                $pondactv3=$actv3/$totalcte;
                $pondactv4=$actv4/$totalcte;
                $pondactv5=$actv5/$totalcte;
                $pondactv6=$actv6/$totalcte;
                $pondactv7=$actv7/$totalcte;
                $arraypontp = array($pondf, $pondm, $pondo);
                $arraycanttp = array($tipof, $tipom, $tipoo);
                $arraypondNac=array($pondNacM,$pondNacExAR,$pondNacExt,$pondNacO);
                $arraycantNac=array($nacM,$nacAR,$nacExt,$nacOtro);
                $arraypondPeps=array($pondPepsN,$pondPepsEx,$pondNoPeps,$pondOPeps);
                $arraycantPeps=array($pepsN,$pepsEx,$nPeps,$oPeps);
                $arraypondConst=array($pondConst1,$pondConst2,$pondConst3,$pondConst4);
                $arraycantConst=array($const1,$const2,$const3,$constO);
                $arraypondactv=array($pondactv1,$pondactv2,$pondactv3,$pondactv4,$pondactv5,$pondactv6,$pondactv7);
                $arraycantactv=array($actv1,$actv2,$actv3,$actv4,$actv5,$actv6,$actv7);
                $cont = 0;
                $totalptotp=0;
                $totalpondtp=0;
                $totalporctp=0;
                foreach($arraytp as $value){
                $porc=$arraypontp[$cont]*100;
                $pond=$arraytpto[$cont]*$arraypontp[$cont];

                echo "<tr><td>".$arraytp[$cont]."</td><td>".$arraytpto[$cont]."</td><td>".$arraycanttp[$cont]."</td><td>".number_format($porc,2)."</td><td>".number_format($pond,2)."</td></tr>";
                $totalptotp=$totalptotp+$arraytpto[$cont];
                $totalporctp=$totalporctp+$porc;
                $totalpondtp=$totalpondtp+$pond;
                $cont++;
                }
                echo "<tr><th>Totales</th><th>".$totalptotp."</th><th>".$totalcte."</th><th>".$totalporctp."</th><th>".number_format($totalpondtp,2)."</th></tr>";
            }
            
        ?>
    </table>
    <h3>Nacionalidad</h3>
    <table class='table'>
    <tr><th>Indicadores</th><th>Riesgo</th><th>Num. Ctes</th><th>%</th><th>Ponderacion</th></tr>
    <?php
        if(!empty($_POST)){
        $cont=0;
         foreach($arrayNac as $value){
            $porc=$arraypondNac[$cont]*100;
            $pond=$arrayNacPto[$cont]*$arraypondNac[$cont];

            echo "<tr><td>".$arrayNac[$cont]."</td><td>".$arrayNacPto[$cont]."</td><td>".$arraycantNac[$cont]."</td><td>".number_format($porc,2)."</td><td>".number_format($pond,2)."</td></tr>";
            $totalptoNac=$totalptoNac+$arrayNacPto[$cont];
            $totalporcNac=$totalporcNac+$porc;
            $totalpondNac=$totalpondNac+$pond;
            $cont++;
            }
            echo "<tr><th>Totales</th><th>".$totalptoNac."</th><th>".$totalcte."</th><th>".$totalporcNac."</th><th>".number_format($totalpondNac,2)."</th></tr>";
        }
    ?>
    </table>
    <h3>Actividad Economica</h3>
    <table class='table'>
    <tr><th>Indicadores</th><th>Riesgo</th><th>Num. Ctes</th><th>%</th><th>Ponderacion</th></tr>
    <?php
        if(!empty($_POST)){
        $cont=0;
         foreach($arrayAct as $value){
            $porc=$arraypondactv[$cont]*100;
            $pond=$arrayActPto[$cont]*$arraypondactv[$cont];

            echo "<tr><td>".$arrayAct[$cont]."</td><td>".$arrayActPto[$cont]."</td><td>".$arraycantactv[$cont]."</td><td>".number_format($porc,2)."</td><td>".number_format($pond,2)."</td></tr>";
            $totalptoAct=$totalptoAct+$arrayActPto[$cont];
            $totalporcAct=$totalporcAct+$porc;
            $totalpondAct=$totalpondAct+$pond;
            $cont++;
            }
            echo "<tr><th>Totales</th><th>".$totalptoAct."</th><th>".$totalcte."</th><th>".number_format($totalporcAct,2)."</th><th>".number_format($totalpondAct,2)."</th></tr>";
        }
    ?>
    </table>
    <h3>Personas Politicamente Expuestas</h3>
    <table class='table'>
    <tr><th>Indicadores</th><th>Riesgo</th><th>Num. Ctes</th><th>%</th><th>Ponderacion</th></tr>
    <?php
        if(!empty($_POST)){
        $cont=0;
         foreach($arrayPeps as $value){
            $porc=$arraypondPeps[$cont]*100;
            $pond=$arrayPepsPto[$cont]*$arraypondPeps[$cont];

            echo "<tr><td>".$arrayPeps[$cont]."</td><td>".$arrayPepsPto[$cont]."</td><td>".$arraycantPeps[$cont]."</td><td>".number_format($porc,2)."</td><td>".number_format($pond,2)."</td></tr>";
            $totalptoPeps=$totalptoPeps+$arrayPepsPto[$cont];
            $totalporcPeps=$totalporcPeps+$porc;
            $totalpondPeps=$totalpondPeps+$pond;
            $cont++;
            }
            echo "<tr><th>Totales</th><th>".$totalptoPeps."</th><th>".$totalcte."</th><th>".$totalporcPeps."</th><th>".number_format($totalpondPeps,2)."</th></tr>";
        }
    ?>
    </table>
    <h3>Fecha de Constitucion</h3>
    <table class='table'>
    <tr><th>Indicadores</th><th>Riesgo</th><th>Num. Ctes</th><th>%</th><th>Ponderacion</th></tr>
    <?php
        if(!empty($_POST)){
        $cont=0;
         foreach($arrayConst as $value){
            $porc=$arraypondConst[$cont]*100;
            $pond=$arrayConstPto[$cont]*$arraypondConst[$cont];

            echo "<tr><td>".$arrayConst[$cont]."</td><td>".$arrayConstPto[$cont]."</td><td>".$arraycantConst[$cont]."</td><td>".number_format($porc,2)."</td><td>".number_format($pond,2)."</td></tr>";
            $totalptoConst=$totalptoConst+$arrayConstPto[$cont];
            $totalporcConst=$totalporcConst+$porc;
            $totalpondConst=$totalpondConst+$pond;
            $cont++;
            }
            echo "<tr><th>Totales</th><th>".$totalptoConst."</th><th>".$totalcte."</th><th>".$totalporcConst."</th><th>".number_format($totalpondConst,2)."</th></tr>";
        }
    ?>
    </table>
    <?php
    if(!empty($_POST)){
        $queryResult=$pdo->query("SELECT * from Intranet.grado_riesgo_pld WHERE ERiesgo='CU' and tipo='P1' and (ROUND($totalpondtp) BETWEEN liminf and limsup)");
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
           if (!empty($row['grado'])) {
              $arraygrado[0]=$row['grado'];
            
           }else {
              $arraygrado[0]='NA';
           }
           $arrayelemento[0]="Tipo de Personas";  
              
        }
        
        
        $queryResult=$pdo->query("SELECT * from Intranet.grado_riesgo_pld WHERE ERiesgo='CU' and tipo='N1' and (ROUND($totalpondNac) BETWEEN liminf and limsup)");
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            if (!empty($row['grado'])) {
                $arraygrado[1]=$row['grado'];
              
             }else {
                $arraygrado[1]='NA';
             }
             $arrayelemento[1]="Nacionalidad";
              
        }
        $queryResult=$pdo->query("SELECT * from Intranet.grado_riesgo_pld WHERE ERiesgo='CU' and tipo='A1' and (ROUND($totalpondAct) BETWEEN liminf and limsup)");
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            if (!empty($row['grado'])) {
                $arraygrado[2]=$row['grado'];
              
             }else {
                $arraygrado[2]='NA';
             }
             $arrayelemento[2]="Actividad Economica";
                          
        }
        
        $queryResult=$pdo->query("SELECT * from Intranet.grado_riesgo_pld WHERE ERiesgo='CU' and tipo='PE1' and (ROUND($totalpondPeps) BETWEEN liminf and limsup)");
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            if (!empty($row['grado'])) {
                $arraygrado[3]=$row['grado'];
              
             }else {
                $arraygrado[3]='NA';
             }
             $arrayelemento[3]="Politicamente Expuestas";
              
        }
        
        $queryResult=$pdo->query("SELECT * from Intranet.grado_riesgo_pld WHERE ERiesgo='CU' and tipo='F1' and (ROUND($totalpondConst) BETWEEN liminf and limsup)");
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            if (!empty($row['grado'])) {
                $arraygrado[4]=$row['grado'];
              
             }else {
                $arraygrado[4]='NA';
             }
             $arrayelemento[4]="Fecha de Constitucion";
              
        }
        
        echo "<table class='table table-bordered'>";
        echo "<tr><th colspan='2'>Clientes o Usuarios</th></tr>";
        echo "<tr><th>Elemento de Riesgo</th><th>Nivel Riesgo</th></tr>";
        
        $rCUbajo=0;
        $rCUmedio=0;
        $rCUalto=0;
        $rCUsclass=0;  
        
        for ($i=0; $i < 5; $i++) { 
            
        
            if ($arraygrado[$i]=='B') {
                $rCUbajo++;
            }elseif($arraygrado[$i]=='M') {
                $rCUmedio++;
            }elseif($arraygrado[$i]=='A') {
                $rCUalto++;
            }else{
                $rCUsclass++;
            }
            if ($arraygrado[$i]=='B') {
                $gradoCU='Bajo';
                $colorriskCU='success';
            }elseif($arraygrado[$i]=='M'){
                $gradoCU='Medio';
                
                $colorriskCU='warning';
            }elseif($arraygrado[$i]=='A'){
                $gradoCU='Alto';
                $colorriskCU='danger';
            }
            echo "<tr><td>".$arrayelemento[$i]."</td><td class='".$colorriskCU."'>".$gradoCU."</td></tr>";
          
            
        }
        if ($rCUbajo==5) {
            $nivelCUr='Bajo';
            $colorriskCU='success';
        }elseif($rCUmedio==5){
            $nivelCUr='Medio';
            $colorriskCU='warning';
        }elseif($rCUalto==5){
            $nivelCUr='Alto';
            $colorriskCU='danger';
        }elseif($rCUbajo==4){
            $nivelCUr='Bajo';
            $colorriskCU='success';
        }elseif($rCUmedio==4){
            $nivelCUr='Medio';
            $colorriskCU='warning';
        }elseif($rCUalto==4){
            $nivelCUr='Bajo';
            $colorriskCU='success';
        }elseif($rCUbajo==3){
            $nivelCUr='Bajo';
            $colorrisk='success';
        }elseif($rCUmedio==3){
            $nivelCUr='Medio';
            $colorriskCU='warning';
        }elseif($rCUalto==3){
            $nivelCUr='Alto';
            $colorriskCU='danger';
        }elseif($rCUalto==2 and $rCUmedio==2){
            $nivelCUr='Alto';
            $colorriskCU='danger';
        }elseif($rCUmedio==2 and $rCUbajo==2){
            $nivelCUr='Medio';
            $colorriskCU='warning';
        }else{
            $nivelCUr='NA';
        }

        
        echo "<tr><th>Nivel de Riesgo</th><th class='".$colorriskCU."'>".$nivelCUr."</th></tr>";
        
       echo "</table>";
    }    
    ?>
<h3>Tipo de Credito</h3>
    <table class='table'>
    <tr><th>Indicadores</th><th>Riesgo</th><th>Total de Cartera</th><th>%</th><th>Ponderacion</th></tr>
    <?php
        if(!empty($_POST)){
            $queryResult = $pdo->query("SELECT
            C.tipo,
            B.IDTipoCredito,
            B.IDMoneda,
            sum(A.SaldoCap) AS Cap,
            sum(A.SaldoInt) AS Inte,
            sum(A.SaldoCap)+SUM(A.SaldoInt)as Total
        FROM
            sibware.2_dw_images_contratos A
        INNER JOIN sibware.2_contratos B ON A.IDContrato = B.ID
        INNER JOIN sibware.2_entorno_tipocredito C ON B.IDTipoCredito = C.ID
        WHERE
            A.FImage = '$_POST[ffin]'
        GROUP BY
        B.IDMoneda,C.ID");
        
        $tipocr1=0;
        $tipocr2=0;
        $tipocr3=0;
        
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
            if ($row['IDTipoCredito']==1 && $row['IDMoneda']==1) {
                $tipocr1=$tipocr1+$row['Total'];
            }elseif($row['IDTipoCredito']==2 && $row['IDMoneda']==1){
                $tipocr1=$tipocr1+$row['Total'];
            }elseif($row['IDTipoCredito']==5 && $row['IDMoneda']==1){
                $tipocr1=$tipocr1+$row['Total'];
            }elseif($row['IDTipoCredito']==6 && $row['IDMoneda']==1){
                $tipocr1=$tipocr1+$row['Total'];
            }elseif($row['IDTipoCredito']==3 && $row['IDMoneda']==1){
                $tipocr2=$tipocr2+$row['Total'];
            }elseif($row['IDTipoCredito']==4 && $row['IDMoneda']==1){
                $tipocr3=$tipocr3+$row['Total'];
            }elseif($row['IDTipoCredito']==1 && $row['IDMoneda']==2){
                $tipocr1=$tipocr1+($tc*$row['Total']);
            }elseif($row['IDTipoCredito']==2 && $row['IDMoneda']==2){
                $tipocr1=$tipocr1+($tc*$row['Total']);
            }elseif($row['IDTipoCredito']==5 && $row['IDMoneda']==2){
                $tipocr1=$tipocr1+($tc*$row['Total']);
            }elseif($row['IDTipoCredito']==6 && $row['IDMoneda']==2){
                $tipocr1=$tipocr1+($tc*$row['Total']);
            }elseif($row['IDTipoCredito']==3 && $row['IDMoneda']==2){
                $tipocr2=$tipocr2+($tc*$row['Total']);
            }elseif($row['IDTipoCredito']==4 && $row['IDMoneda']==2){
                $tipocr3=$tipocr3+($tc*$row['Total']);
            }
            
            $canttc=$tipocr1+$tipocr2+$tipocr3;
            $arraycanttc=array($tipocr1,$tipocr2,$tipocr3);
            
        }
        
        $cont=0;
         foreach($arraytc as $value){
            $porc=($arraycanttc[$cont]/$canttc)*100;
            $pond=($porc/100)*$arraytcpto[$cont];

            echo "<tr><td>".$arraytc[$cont]."</td><td>".$arraytcpto[$cont]."</td><td>".number_format($arraycanttc[$cont],2)."</td><td>".number_format($porc,2)."</td><td>".number_format($pond,2)."</td></tr>";
            $totalptotc=$totalptotc+$arraytcpto[$cont];
            $totalporctc=$totalporctc+$porc;
            $totalpondtc=$totalpondtc+$pond;
            $cont++;
            }
            echo "<tr><th>Totales</th><th>".$totalptotc."</th><th>".number_format($canttc,2)."</th><th>".number_format($totalporctc,2)."</th><th>".number_format($totalpondtc,2)."</th></tr>";
        
    }    
    ?>
    </table> 
    <h3>Fuentes de Fondeo</h3>
    <table class='table'>
    <tr><th>Indicadores</th><th>Riesgo</th><th>Total de Cartera</th><th>%</th><th>Ponderacion</th></tr>
    <?php
    if(!empty($_POST)){
    $queryResult = $pdo->query("SELECT
	C.Nombre,
	B.IDOrigenRecursos,
    D.IDMoneda,
	sum(A.SaldoCap) AS Cap,
	sum(A.SaldoInt) AS Inte,
	sum(A.SaldoCap)+SUM(A.SaldoInt)as Total
FROM
	2_dw_images_contratos A
INNER JOIN 2_contratos_disposicion B ON A.IDDisposicion = B.ID
INNER JOIN 2_entorno_origenrecursos C ON B.IDOrigenRecursos = C.ID
INNER JOIN 2_contratos D ON A.IDContrato=D.ID
WHERE
	A.FImage = '$_POST[ffin]'
GROUP BY
    D.IDMoneda,C.ID");
    $orec1=0;
    $orec2=0;
    $orec3=0;
    $orec4=0;    
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        if ($row['IDOrigenRecursos']==1 && $row['IDMoneda']==1) {
            $orec4=$orec4+$row['Total'];
        }elseif($row['IDOrigenRecursos']==2 && $row['IDMoneda']==1) {
            $orec2=$orec2+$row['Total'];
        }elseif($row['IDOrigenRecursos']==3 && $row['IDMoneda']==1) {
            $orec2=$orec2+$row['Total'];
        }elseif($row['IDOrigenRecursos']==4 && $row['IDMoneda']==1) {
            $orec2=$orec2+$row['Total'];
        }elseif($row['IDOrigenRecursos']==1 && $row['IDMoneda']==2) {
            $orec4=$orec4+($tc*$row['Total']);
        }elseif($row['IDOrigenRecursos']==2 && $row['IDMoneda']==2) {
            $orec2=$orec2+($tc*$row['Total']);
        }elseif($row['IDOrigenRecursos']==3 && $row['IDMoneda']==2) {
            $orec2=$orec2+($tc*$row['Total']);
        }elseif($row['IDOrigenRecursos']==4 && $row['IDMoneda']==2) {
            $orec2=$orec2+($tc*$row['Total']);
        }else {
            $orec1=$orec1+$row['Total'];
        }
        $arraycantff=array($orec1,$orec2,$orec3,$orec4);
        $cantff=$orec1+$orec2+$orec3+$orec4;

    }    
    $cont=0;
        
         foreach($arrayff as $value){
            $porc=($arraycantff[$cont]/$canttc)*100;
            $pond=($porc/100)*$arrayffPto[$cont];

            echo "<tr><td>".$arrayff[$cont]."</td><td>".$arrayffPto[$cont]."</td><td>".number_format($arraycantff[$cont],2)."</td><td>".number_format($porc,2)."</td><td>".number_format($pond,2)."</td></tr>";
            $totalptoff=$totalptoff+$arrayffpto[$cont];
            $totalporcff=$totalporcff+$porc;
            $totalpondff=$totalpondff+$pond;
            $cont++;
            }
        echo "<tr><th>Totales</th><th>".$totalptotc."</th><th>".number_format($cantff,2)."</th><th>".$totalporctc."</th><th>".number_format($totalpondff,2)."</th></tr>";
    }    
    ?>    
    </table> 
    <?php
        if(!empty($_POST)){
            $queryResult=$pdo->query("SELECT * from Intranet.grado_riesgo_pld WHERE ERiesgo='PS' and tipo='C1' and (ROUND($totalpondtc) BETWEEN liminf and limsup)");
            while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                if (!empty($row['grado'])) {
                    $arraygrado[0]=$row['grado'];
            
                }else {
                    $arraygrado[0]='NA';
                }
                $arrayelemento[0]="Tipos de Creditos";  
              
            }
            
            $queryResult=$pdo->query("SELECT * from Intranet.grado_riesgo_pld WHERE ERiesgo='PS' and tipo='FD1' and (ROUND($totalpondff) BETWEEN liminf and limsup)");
            while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                if (!empty($row['grado'])) {
                    $arraygrado[1]=$row['grado'];
            
                }else {
                    $arraygrado[1]='NA';
                }
                $arrayelemento[1]="Fondeo";  
              
            }
            echo "<table class='table table-bordered'>";
            echo "<tr><th colspan='2'>Productos y Servicios</th></tr>";
            echo "<tr><th>Elemento de Riesgo</th><th>Nivel Riesgo</th></tr>";
            $rPSbajo=0;
            $rPSmedio=0;
            $rPSalto=0;
            $rPSsclass=0;
            for ($i=0; $i < 2; $i++) { 
            
        
                if ($arraygrado[$i]=='B') {
                    $rPSbajo++;
                }elseif($arraygrado[$i]=='M') {
                    $rPSmedio++;
                }elseif($arraygrado[$i]=='A') {
                    $rPSalto++;
                }else{
                    $rPSsclass++;
                }
                if ($arraygrado[$i]=='B') {
                    $grado='Bajo';
                    $colorrisk='success';
                }elseif($arraygrado[$i]=='M'){
                    $grado='Medio';
                    
                    $colorrisk='warning';
                }elseif($arraygrado[$i]=='A'){
                    $grado='Alto';
                    $colorrisk='danger';
                }
                echo "<tr><td>".$arrayelemento[$i]."</td><td class='".$colorrisk."'>".$grado."</td></tr>";
              
                
            } 
            if ($rPSbajo==2) {
                $nivelPSr='Bajo';
                $colorriskPS='success';
            }elseif($rPSmedio>=1){
                $nivelPSr='Medio';
                $colorriskPS='warning';
            }elseif($rPSalto>=1){
                $nivelPSr='Alto';
                $colorriskPS='danger';
            }
            echo "<tr><th>Nivel de Riesgo</th><th class='".$colorriskPS."'>".$nivelPSr."</th></tr>";
            echo "</table>";
        }
    ?>  
    <h3>Cobertura</h3>
    <table class='table'>
    <tr><th>Indicadores</th><th>Riesgo</th><th>Total de Cartera</th><th>%</th><th>Ponderacion</th></tr>
        <?php
            if (!empty($_POST)) {
                $queryResult=$pdo->query("SELECT
                A.SaldoCap,
                A.SaldoInt,
                B.IDLocalidadCNBV,
                C.Indicador
            FROM
                sibware.2_dw_images_contratos A
            INNER JOIN sibware.2_cliente B ON A.IDCliente = B.ID
            INNER JOIN sibware.2_entorno_localidadcnbv C ON B.IDLocalidadCNBV = C.ID
            WHERE
                A.Fimage = '$_POST[ffin]'");
                $cob1=0;
                $cob2=0;
                $znr1=0;
                $znr2=0;
                $znr3=0;
                $znr4=0;
                while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                    if ($row['IDLocalidadCNBV']>=433 && $row['IDLocalidadCNBV']<=489) {
                        $cob1=$cob1+$row['SaldoCap']+$row['SaldoInt'];
                    }else{
                        $cob2=$cob2+$row['SaldoCap']+$row['SaldoInt'];
                    }if ($row['Indicador']==1) {
                        $znr1=$znr1+$row['SaldoCap']+$row['SaldoInt'];
                    }elseif ($row['Indicador']==2) {
                        $znr2=$znr2+$row['SaldoCap']+$row['SaldoInt'];
                    }elseif ($row['Indicador']==3) {
                        $znr3=$znr3+$row['SaldoCap']+$row['SaldoInt'];
                    }elseif ($row['Indicador']==4) {
                        $znr4=$znr4+$row['SaldoCap']+$row['SaldoInt'];
                    }
                }
                $arraycantcob=array($cob1,$cob2);
                $cantcob=$cob1+$cob2;
                $arraycantznr=array($znr1,$znr2,$znr3,$znr4);
                $cantznr=$znr1+$znr2+$znr3+$znr4;
                $cont=0;
                foreach($arraycob as $value){
                    $porc=($arraycantcob[$cont]/$cantcob)*100;
                    $pond=($porc/100)*$arraycobpto[$cont];

                    echo "<tr><td>".$arraycob[$cont]."</td><td>".$arraycobpto[$cont]."</td><td>".number_format($arraycantcob[$cont],2)."</td><td>".number_format($porc,2)."</td><td>".number_format($pond,2)."</td></tr>";
                    $totalptocob=$totalptocob+$arraycobpto[$cont];
                    $totalporccob=$totalporccob+$porc;
                    $totalpondcob=$totalpondcob+$pond;
                    $cont++;
                }
                echo "<tr><th>Totales</th><th>".$totalptocob."</th><th>".number_format($cantcob,2)."</th><th>".$totalporccob."</th><th>".number_format($totalpondcob,2)."</th></tr>";
        }    
            
        ?>
    </table>
    <h3>Zonas de Riesgo</h3>
    <table class='table'>
    <tr><th>Indicadores</th><th>Riesgo</th><th>Total de Cartera</th><th>%</th><th>Ponderacion</th></tr>
        <?php
            if (!empty($_POST)) {
                $cont=0;
                foreach($arrayzr as $value){
                    $porc=($arraycantznr[$cont]/$cantznr)*100;
                    $pond=($porc/100)*$arrayzrpto[$cont];

                    echo "<tr><td>".$arrayzr[$cont]."</td><td>".$arrayzrpto[$cont]."</td><td>".number_format($arraycantznr[$cont],2)."</td><td>".number_format($porc,2)."</td><td>".number_format($pond,2)."</td></tr>";
                    $totalptoznr=$totalptoznr+$arrayzrpto[$cont];
                    $totalporcznr=$totalporcznr+$porc;
                    $totalpondznr=$totalpondznr+$pond;
                    $cont++;
                }
                echo "<tr><th>Totales</th><th>".$totalptoznr."</th><th>".number_format($cantznr,2)."</th><th>".$totalporcznr."</th><th>".number_format($totalpondznr,2)."</th></tr>";
                
                
            }
        ?>
    </table>
    <?php
        if(!empty($_POST)){
            $queryResult=$pdo->query("SELECT * from Intranet.grado_riesgo_pld WHERE ERiesgo='PA' and tipo='CO1' and (ROUND($totalpondcob) BETWEEN liminf and limsup)");
            while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                if (!empty($row['grado'])) {
                    $arraygrado[0]=$row['grado'];
            
                }else {
                    $arraygrado[0]='NA';
                }
                $arrayelemento[0]="Cobertura";  
              
            }
            
            $queryResult=$pdo->query("SELECT * from Intranet.grado_riesgo_pld WHERE ERiesgo='PA' and tipo='ZR' and (ROUND($totalpondznr) BETWEEN liminf and limsup)");
            while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                if (!empty($row['grado'])) {
                    $arraygrado[1]=$row['grado'];
            
                }else {
                    $arraygrado[1]='NA';
                }
                $arrayelemento[1]="Zonas de Riesgo";  
              
            }
            echo "<table class='table table-bordered'>";
            echo "<tr><th colspan='2'>Paises y areas Geograficas</th></tr>";
            echo "<tr><th>Elemento de Riesgo</th><th>Nivel Riesgo</th></tr>";
            $rPAbajo=0;
            $rPAmedio=0;
            $rPAalto=0;
            $rPAsclass=0;
            for ($i=0; $i < 2; $i++) { 
            
        
                if ($arraygrado[$i]=='B') {
                    $rPAbajo++;
                }elseif($arraygrado[$i]=='M') {
                    $rPAmedio++;
                }elseif($arraygrado[$i]=='A') {
                    $rPAalto++;
                }else{
                    $rPAsclass++;
                }
                if ($arraygrado[$i]=='B') {
                    $grado='Bajo';
                    $colorrisk='success';
                }elseif($arraygrado[$i]=='M'){
                    $grado='Medio';
                    
                    $colorrisk='warning';
                }elseif($arraygrado[$i]=='A'){
                    $grado='Alto';
                    $colorrisk='danger';
                }
                echo "<tr><td>".$arrayelemento[$i]."</td><td class='".$colorrisk."'>".$grado."</td></tr>";
              
                
            } 
            if ($rPAbajo==2) {
                $nivelPAr='Bajo';
                $colorriskPA='success';
            }elseif($rPAmedio>=1){
                $nivelPAr='Medio';
                $colorriskPA='warning';
            }elseif($rPAalto>=1){
                $nivelPAr='Alto';
                $colorriskPA='danger';
            }
            echo "<tr><th>Nivel de Riesgo</th><th class='".$colorriskPA."'>".$nivelPAr."</th></tr>";
            echo "</table>";
        }
    ?>
    <h3>Instrumentos Monetarios</h3>
    <table class='table'>
    <tr><th>Indicadores</th><th>Riesgo</th><th>Total</th><th>%</th><th>Ponderacion</th></tr>
        <?php
            if (!empty($_POST)) {
                
                $queryResult = $pdo->query("SELECT
                sum(A.Importe) as Importe,A.FormaPago,B.IDMoneda
            FROM
                2_ad_bancomovs A
            INNER JOIN 2_ad_bancocuentas B on A.IDCuenta=B.ID 
            WHERE
                (
                    A.FRegistro BETWEEN '$_POST[fini]'
                    AND '$_POST[ffin]'
                )
            AND A.TipoConcepto = 'A'
            AND A.IDDiario<>56 AND A.IDDiario<>6
            GROUP BY A.FormaPago, B.IDMoneda");
                $totEF=0;
                $totCH=0;
                $totTRn=0;
                $totTRi=0;
                $totTrs=0;
                $totMxn=0;
                $totUsd=0;
                $totMdO=0;
                while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                    if ($row['FormaPago']=='EF' ) {
                        $totEF=$row['Importe'];
                        
                    }elseif ($row['FormaPago']=='CH' ) {
                        $totCH=$row['Importe'];
                        
                    }elseif ($row['FormaPago']=='TR') {
                        $totTRn=$row['Importe'];
                        
                    }
                    if ($row['IDMoneda']==1) {
                        $totMxn=$totMxn+$row['Importe'];
                        
                    }elseif ($row['IDMoneda']==2) {
                        $totUsd=$totUsd+$row['Importe'];
                    }
                    
                }
                
                $arraycantim=array($totTRn,$totEF,$totCH,$totTRi);
                $arraycantmd=array($totMxn,$totUsd,$totMdO);
                $totTrs=$totCH+$totEF+$totTRn+$totTRi;
                $totMD=$totMxn+$totUsd+$totMdO;
                $cont=0;        
                foreach($arrayim as $value){
                        $porc=($arraycantim[$cont]/$totTrs)*100;
                        $pond=($porc/100)*$arrayimpto[$cont];
                        echo "<tr><td>".$arrayim[$cont]."</td><td>".$arrayimpto[$cont]."</td><td>".number_format($arraycantim[$cont],2)."</td><td>".number_format($porc,2)."</td><td>".number_format($pond,2)."</td></tr>";
                        $totalptoim=$totalptoim+$arrayimpto[$cont];
                        $totalporcim=$totalporcim+$porc;
                        $totalpondim=$totalpondim+$pond;
                        $cont++;
                }
                echo "<tr><th>Totales</th><th>".$totalptoim."</th><th>".number_format($totTrs,2)."</th><th>".$totalporcim."</th><th>".number_format($totalpondim,2)."</th></tr>";
               
            }
        ?>       
    
    </table>
    <h3>Moneda</h3>
    <table class='table'>
    <tr><th>Indicadores</th><th>Riesgo</th><th>Total</th><th>%</th><th>Ponderacion</th></tr>
        <?php
        if(!empty($_POST)){
            $cont=0;
            foreach($arraymd as $value){
                $porc=($arraycantmd[$cont]/$totMD)*100;
                $pond=($porc/100)*$arraymdpto[$cont];
                echo "<tr><td>".$arraymd[$cont]."</td><td>".$arraymdpto[$cont]."</td><td>".number_format($arraycantmd[$cont],2)."</td><td>".number_format($porc,2)."</td><td>".number_format($pond,2)."</td></tr>";
                $totalptomd=$totalptomd+$arraymdpto[$cont];
                $totalporcmd=$totalporcmd+$porc;
                $totalpondmd=$totalpondmd+$pond;
                $cont++;
        }
        echo "<tr><th>Totales</th><th>".$totalptomd."</th><th>".number_format($totMD,2)."</th><th>".$totalporcmd."</th><th>".number_format($totalpondmd,2)."</th></tr>";
        }
        ?>
    </table>
    <h3>Volumen de las Operaciones</h3>
    <table class='table'>
    <tr><th>Indicadores</th><th>Riesgo</th><th>Num de Op.</th><th>%</th><th>Ponderacion</th></tr>
    
    <?php   
        if (!empty($_POST)) {
            $queryResult = $pdo->query("SELECT
            A.Importe,A.FormaPago,B.IDMoneda,A.FRegistro
        FROM
            sibware.2_ad_bancomovs A
        INNER JOIN sibware.2_ad_bancocuentas B on A.IDCuenta=B.ID 
        WHERE
            (
                A.FRegistro BETWEEN '$_POST[fini]'
                AND '$_POST[ffin]'
            )
        AND A.TipoConcepto = 'A'
        AND A.IDDiario<>56 AND A.IDDiario<>6");
            $niv1=0;  
            $niv2=0;  
            $niv3=0;
            $numop=0;
            while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                $queryResult2 = $pdo->query("SELECT * from sibware.indicador_udi A where A.Fecha='$row[FRegistro]'" );
                $importeOp=$row['Importe'];
                while ($row=$queryResult2->fetch(PDO::FETCH_ASSOC)) {
                    $factor=$row['Factor'];
                    $udi=$importeOp/$factor;
                    if ($udi<=10000) {
                        $niv1++;
                    }elseif($udi>10000 && $udi<=50000){
                        $niv2++;
                    }elseif($udi>50000){
                        $niv3++;
                    }
                    
                }
                $numop++;
                
            }
            $arraynumop=array($niv1,$niv2,$niv3);
            $cont=0;
            foreach($arrayvo as $value){
                $porc=($arraynumop[$cont]/$numop)*100;
                $pond=($porc/100)*$arrayvopto[$cont];
                echo "<tr><td>".$arrayvo[$cont]."</td><td>".$arrayvopto[$cont]."</td><td>".$arraynumop[$cont]."</td><td>".number_format($porc,2)."</td><td>".number_format($pond,2)."</td></tr>";
                $totalptovo=$totalptovo+$arrayvopto[$cont];
                $totalporcvo=$totalporcvo+$porc;
                $totalpondvo=$totalpondvo+$pond;
                $cont++;
            }
             echo "<tr><th>Totales</th><th>".$totalptovo."</th><th>".number_format($numop,2)."</th><th>".$totalporcvo."</th><th>".number_format($totalpondvo,2)."</th></tr>";
             
            $queryResult=$pdo->query("SELECT * from Intranet.grado_riesgo_pld WHERE ERiesgo='TR' and tipo='IM1' and (ROUND($totalpondim) BETWEEN liminf and limsup)");
            while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                if (!empty($row['grado'])) {
                    $arraygrado[0]=$row['grado'];
            
                }else {
                    $arraygrado[0]='NA';
                }
                $arrayelemento[0]="Instrumentos Monetarios";  
              
            }
            
            $queryResult=$pdo->query("SELECT * from Intranet.grado_riesgo_pld WHERE ERiesgo='TR' and tipo='M1' and (ROUND($totalpondmd) BETWEEN liminf and limsup)");
            while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                if (!empty($row['grado'])) {
                    $arraygrado[1]=$row['grado'];
            
                }else {
                    $arraygrado[1]='NA';
                }
                $arrayelemento[1]="Moneda";  
              
            }
            $queryResult=$pdo->query("SELECT * from Intranet.grado_riesgo_pld WHERE ERiesgo='TR' and tipo='V1' and (ROUND($totalpondvo) BETWEEN liminf and limsup)");
            while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                if (!empty($row['grado'])) {
                    $arraygrado[2]=$row['grado'];
            
                }else {
                    $arraygrado[2]='NA';
                }
                $arrayelemento[2]="Vol. de Oper.";  
              
            }
       
             echo "<table class='table table-bordered'>";
             echo "<tr><th colspan='2'>Transaciones y Canales de Envio</th></tr>";
             echo "<tr><th>Elemento de Riesgo</th><th>Nivel Riesgo</th></tr>";
             $rCEbajo=0;
             $rCEmedio=0;
             $rCEalto=0;
             $rCEsclass=0;
             for ($i=0; $i < 3; $i++) { 
             
         
                 if ($arraygrado[$i]=='B') {
                     $rCEbajo++;
                 }elseif($arraygrado[$i]=='M') {
                     $rCEmedio++;
                 }elseif($arraygrado[$i]=='A') {
                     $rCEalto++;
                 }else{
                     $rCEsclass++;
                 }
                 if ($arraygrado[$i]=='B') {
                     $grado='Bajo';
                     $colorrisk='success';
                 }elseif($arraygrado[$i]=='M'){
                     $grado='Medio';
                     
                     $colorrisk='warning';
                 }elseif($arraygrado[$i]=='A'){
                     $grado='Alto';
                     $colorrisk='danger';
                 }
                 echo "<tr><td>".$arrayelemento[$i]."</td><td class='".$colorrisk."'>".$grado."</td></tr>";
               
                 
             } 
             if ($rCEbajo>=2) {
                 $nivelCEr='Bajo';
                 $colorriskCE='success';
             }elseif($rCEmedio>=2){
                 $nivelCEr='Medio';
                 $colorriskCE='warning';
             }elseif($rCEalto==1 ){
                 $nivelCEr='Alto';
                 $colorriskCE='danger';
             }else {
                 # code...
             }
             echo "<tr><th>Nivel de Riesgo</th><th class='".$colorriskCE."'>".$nivelCEr."</th></tr>";
             echo "</table>"; 
        }
    ?>
    <?php
        if (!empty($_POST)) {
           $connivelFIB=0;
           $connivelFIM=0;
           $connivelFIA=0;
           $arraynivelFI=array($nivelCUr,$nivelPSr,$nivelPAr,$nivelCEr);
           
           $cont=0;
           foreach($arraynivelFI as $value){
              
           
               if ($arraynivelFI[$cont]=='Bajo') {
                   $connivelFIB++;
               }elseif($arraynivelFI[$cont]=='Medio'){
                   $connivelFIM++;
               }elseif($arraynivelFI[$cont]=='Alto'){
                   $connivelFIA++;
               }
            $cont++;   
           }
           if ($connivelFIB>=3) {
               $colorriskFI="success";
               $nivelFI="Bajo";
           }elseif ($connivelFIM>=3) {
            $colorriskFI="warning";
            $nivelFI="Medio";
           }elseif ($connivelFIA>=3) {
            $colorriskFI="danger";
            $nivelFI="Alto";
           }elseif ($connivelFIB>=2 && $connivelFIM>=2) {
            $colorriskFI="success";
            $nivelFI="Bajo";
           }elseif ($connivelFIB>=2 && $connivelFIM>=1 && $connivelFIA>=1 ) {
            $colorriskFI="warning";
            $nivelFI="Medio";
           }elseif ($connivelFIB>=1 && $connivelFIM>=2 && $connivelFIA>=1 ) {
            $colorriskFI="warning";
            $nivelFI="Medio";
           }elseif ($connivelFIB>=1 && $connivelFIM>=1 && $connivelFIA>=2 ) {
            $colorriskFI="warning";
            $nivelFI="Medio";
           }elseif ($connivelFIA>=2 && $connivelFIM>=2) {
            $colorriskFI="danger";
            $nivelFI="Alto";
           }else {
            $colorriskFI="danger";
            $nivelFI="No Existe!";
           }

           
            echo "</table>"; 
            echo "<h2>Resumen de Resultados</h2>";
            echo "<table class='table table-bordered'>";
            echo "<tr><th rowspan='5'>Elementos de Riesgo</th><td>Clientes y Usuarios</td><td class='".$colorriskCU."'>".$nivelCUr."</td></tr>";
            echo "<tr><td>Productos o Servicios</td><td class='".$colorriskPS."'>".$nivelPSr."</td></tr>";
            echo "<tr><td>Zona Geografica</td ><td class='".$colorriskPA."'>".$nivelPAr."</td></tr>";
            echo "<tr><td>Transaciones</td><td class='".$colorriskCE."'>".$nivelCEr."</td ></tr>";
            

            echo "<tr><th>Riesgo Inherente</th><th class='".$colorriskFI."'>".$nivelFI."</th></tr>";
            echo "</table>";
        }       
    ?>    
</div>

</div>
    
</body>
</html>