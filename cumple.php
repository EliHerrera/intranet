<?php
    require_once 'header.php';
    //////inicio de contenido
    $anio=idate('Y');
    $anio=$anio-1;
    $mes=idate('m');
    if (!empty($_GET)) {
        $to=$_GET['mail'];
        // $to="sistemas@credicor.com.mx";
        $from="atencioaclientes@credicor.com.mx";
        $name='Atencion a Clientes Credicor Mexicano';
        $idcte=$_GET['idcte'];
        $emp=$_GET['emp'];
        $mes=idate('m');
        $anio=idate('Y');
        $fecha=date('Y-m-d');
        $subject='FELICIDADES';
        $message = file_get_contents('http://www.credicormexicano.com.mx/flayers/cuumple.html');
        $queryResult = $pdo->query("INSERT INTO Intranet.mailingcumpleanios (
            Intranet.mailingcumpleanios.IDCliente,
            Intranet.mailingcumpleanios.mes,
            Intranet.mailingcumpleanios.anio,
            Intranet.mailingcumpleanios.lEnviado,
            Intranet.mailingcumpleanios.IDCteHist,
            Intranet.mailingcumpleanios.emp,
            Intranet.mailingcumpleanios.fechareg
        )
        VALUES
            (
                $idcte,
                $mes,
                $anio,
                'S',
                $idcte,
                $emp,
                '$fecha'
            )
        ");
        require('correo.php');
        echo "<div class='alert alert-success'>";
        echo "    <strong>Exito!</strong>El correo ha sido Enviado con Exito!";
        echo "</div>";
    }
?> 
<h3>Relacion de Cumpleañeros del mes</h3> 
<table class="table">
<tr><th>Ejecutivo</th><th>Cliente</th><th>Correo Cte</th><th>Mes</th><th>Dia</th><th>Empresa</th><th>Producto</th><th>Importe</th><th>Revisar</th></tr>
<?PHP
    $queryResult = $pdo->query("SELECT
	CONCAT(
		C.Nombre,
		' ',
		C.Apellido1,
		' ',
		C.Apellido2
	) AS ejecutivo,
	B.ID,
	CONCAT(
		B.Nombre,
		' ',
		B.Apellido1,
		' ',
		B.Apellido2
	) AS Cliente,
	B.Email,
	gMes (B.FNacimiento) AS Mes,
	DATE_FORMAT(B.FNacimiento, '%d') AS dia,
	ROUND(
		sum(
			(
				(
					(
						A.Importe * (A.TasaTotal / 100) / 365
					) * A.Plazo
				) + A.Importe
			) - (
				(
					A.Importe * ((A.TasaRetencion / 100) / 360)
				) * A.Plazo
			)
		),
		2
	) as Importe
FROM
	2_prestamos A
INNER JOIN sibware.2_cliente B ON A.IDCliente = B.ID
INNER JOIN sibware.personal C ON B.IDejecutivo = C.ID
LEFT JOIN Intranet.mailingcumpleanios D ON D.IDCliente = B.ID
WHERE
	A.`status` = 'V'
AND MONTH (B.FNacimiento) = $mes
AND ISNULL(D.lEnviado)
GROUP BY
	B.ID
ORDER BY
    dia ASC");
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        $ejecutivo= $row['ejecutivo'];
	echo"<tr><td>$ejecutivo</td>";
	$nom_cte=$row['Cliente'];
	$idcte=$row['ID'];
	echo"<td>$nom_cte</td>";
	$correo_cte=$row['Email'];
	echo"<td>$correo_cte</td>";
	$mes=$row['Mes'];
	echo"<td>$mes</td>";
	$dia=$row['dia'];
	echo"<td>$dia</td>";
	echo"<td>CMU</td>";
	$pro='IN';
	//$pro2=mysql_result($sql_cumple,$i,'pro2');
	//$pro3=mysql_result($sql_cumple,$i,'pro3');	
	if(!empty($pro)){echo"<td>$pro</td>";}
	elseif(!empty($pro2)){echo"<td>$pro2</td>";}
	else{echo"<td>$pro3</td>";}
	$importe=$row['Importe'];
	$importe=number_format($importe,2);
	echo"<td>$".$importe."</td>";
	echo"<td><a href='cumple.php?mail=$correo_cte&&idcte=$idcte&&emp=2'><img alt='alt' src='img/icons/icon_mail.png'></a></td>";
	echo"</tr>";
    }
?>
</table>  

<?php
    /////fin de contenido
    require_once 'footer.php';
?>
