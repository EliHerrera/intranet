<?PHP 
echo "<div class='navbi'>";
echo "<ul class='nav nav-tabs'>";   
   $queryResult = $pdo->query("SELECT * FROM Intranet.menu_bi WHERE idusuario=$idpersonal");
    while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        echo "<li class='nav-item'>";
        echo "     <a class='nav-link' href='".$row['file']."'>".$row['menu']."</a>";
        echo "</li>";
    } 
   
echo "</ul>";
echo "</div>";    
?> 