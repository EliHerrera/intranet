<?php
    require_once 'headerbi.php';
    require 'menubi.php';
    //////inicio de contenido
    switch ($_GET['b']) {
        case 'a':
           $band='A';
            break;
        case 'p':
            $band='P';
             break;
        case 'c':
             $band='C';
              break;
        case 'r':
              $band='R';
               break;
             
        default:
            $band='N';
            break;
    }
    if (empty($_GET['fil'])) {
        $fini='2018-01-01';
        $ffin='2018-12-31';
    }else{
        $queryResult=$pdo->query("SELECT * from Intranet.filtros_bi where valor=$_GET[fil]");
                while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                    $ffin=$row['ffin'];
                    $fini=$row['fini'];
                    $texto=$row['texto'];
                }
    }
    if ($band=='R') {
        $queryResult=$pdo->query("SELECT
                                    A.ID_Ticket,
                                    A.fecha_alta,
                                    A.folio,
                                    C.macroproceso,
                                    A.Mensaje
                                FROM
                                    Intranet.ticket A
                                INNER JOIN Intranet.msj_ticket B ON A.ID_Ticket = B.IDTicket
                                INNER JOIN Intranet.r_macroproceso C on A.ID_Categoria=C.ID
                                WHERE
                                    (
                                        A.fecha_alta BETWEEN '$fini'
                                        AND '$ffin'
                                    )
                                AND B.IDUsuario = $idcontraloria
                                AND A.ID_Usuario<>$idcontraloria");
        
        
    }
?> 
<h3>Relacion de Casos de Riesgo del mes de <?php echo $texto; ?></h3>
<div class="col-xs-2">   
    <a href="viewincidencia.php?b=<?php echo $_GET['b']; ?>&fil=<?php echo $_GET['fil']; ?>" class="button">Regresar</a>
</div>
<table class="table">
    <tr><th>Fecha</th><th>Folio</th><th>Proceso</th><th>Acontecimiento</th><th>Area Involucradas</th><th>Cambios o Definicion Final</th><th>Impacto o Modificacion de Politica</th><th>Seguimiento Contralor Normativo</th><th>Acciones</th></tr>
    <?php
        while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
                    $idticket=$row['ID_Ticket'];
                    $fecha_alta=$row['fecha_alta'];
                    $folio=$row['folio'];
                    $macroproceso=$row['macroproceso'];
                    $acontecimineto=$row['Mensaje'];
                    echo "<tr><td>".$fecha_alta."</td><td><a href='viewincidencia2.php?idtic=".$idticket."'>".$folio."</a></td><td>".$macroproceso."</td><td>".$acontecimineto."</td>";
                    $queryResult2=$pdo->query("SELECT
                                                C.Nombre
                                            FROM
                                                Intranet.msj_ticket A
                                            INNER JOIN sibware.personal B ON A.IDUsuario = B.ID
                                            INNER JOIN sibware.personal_departamentos C ON B.IDDepartamento = C.ID
                                            WHERE
                                                IDTicket = $idticket
                                            GROUP BY
                                                A.IDUsuario");
                    echo "<td>";
                    echo "<li>";                            
                    while ($row=$queryResult2->fetch(PDO::FETCH_ASSOC)) {
                        $area=$row['Nombre'];
                        echo "<ul>".$area."</ul>";
                        $areasin=array($area);
                    }
                    echo "</li>";
                    echo "</td>";  
                    $queryResult3=$pdo->query("SELECT
                                                A.mensaje
                                            FROM
                                                Intranet.msj_ticket A
                                            
                                            WHERE
                                                A.IDTicket = $idticket
                                                and A.IDUsuario=$idcontraloria
                                            LIMIT 1"); 
                    while ($row=$queryResult3->fetch(PDO::FETCH_ASSOC)) {
                        $cambios=$row['mensaje'];
                        echo "<td>".$cambios."</td>";
                    }
                    $impacto="";
                    $seguimiento=""; 
                    $queryResult4=$pdo->query("SELECT
                                                *
                                            FROM
                                                Intranet.gestion_riesgos A
                                            
                                            WHERE
                                                A.ID_Ticket = $idticket
                                               
                                            "); 
                                            
                                
                                while ($row=$queryResult4->fetch(PDO::FETCH_ASSOC)) {
                                    $impacto=$row['impacto'];
                                    $seguimiento=$row['seguimiento'];
                                    
                            }                                                 
                echo "<td>".$impacto."</td><td>".$seguimiento."</td><td>";
                if ($idcontraloria==$idpersonal) {
                     echo "<a href='gestionarin.php?idticket=".$idticket."&b=".$_GET['b']."&fil=".$_GET['fil']."'>Gestionar</a>";
                }
               
                echo "</td></tr>";    
                }
    ?>    
</table>  
<li>
    <ul>

    </ul>
</li>

<?php
    /////fin de contenido
    require_once 'footer.php';
?>
