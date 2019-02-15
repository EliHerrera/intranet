<?php
  require_once 'header.php';
	$idemp=$_REQUEST['idemp'];
	$periodo=$_REQUEST['periodo'];

    
    $queryResult = $pdo->query("DELETE FROM Intranet.RelQst WHERE ID=$idemp AND periodo=$periodo");

	if($queryResult)
	{
		echo'<script type="text/javascript">
		    alert("Registro eliminado");
			 </script>';
		header('Location: qstpld.php');
	}
	else
	{
		echo'<script type="text/javascript">
		    alert("No se pudo eliminar el registro");
		     </script>';
	}


	require_once 'footer.php';
?>  