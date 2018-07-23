<?php
    require_once 'header.php';
    //////inicio de contenido
?>
<table class="table">
<tr><th colspan="2">Documentos de Politicas</th></tr>
<tr><th>Documento</th><th>Descarga</th></tr>
<?php
$queryResult=$pdo->query("SELECT
	*
FROM
	Intranet.documentos A
WHERE
	A.`status` = 'S'
AND A.tipo = 'DOC'");


      
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
     	 echo "<tr><td>$row[Documento]</td><td><a href='$row[url]'><img alt='alt' src='img/icons/icon_pdf.png' target='_blank'></a></td></tr>"	;
     	 }
    	 	
?>	
</table>
<?php    
    /////fin de contenido
    require_once 'footer.php';
?>
