<?php
    $hoy=date('Y-m-d');
    $location='S';
    $grafica='fi';    
    require_once 'cargarbi.php';
    require_once 'header.php';
    //////inicio de contenido
    $fini = strtotime("01-08-2018");
    $ffin=strtotime("31-08-2018");
    $fen=strtotime("19-09-2018");
    if ($fen>=$fini && $fen<=$ffin) {
        echo "entre";
    }else{
       echo "fuera";
    } 
?>    

<?php
    /////fin de contenido
    require_once 'footer.php';
?>
