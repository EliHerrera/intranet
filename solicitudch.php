<?PHP
    $folio = $_GET['idcomi'];
    
    require_once 'cn/cn.php';
    $queryResult = $pdo->query("SELECT
    CONCAT(B.Nombre,' ',B.Apellido1,' ',B.Apellido2) as Ejecutivo,
      A.total_apagar
    FROM
      Intranet.comisiones A
    INNER JOIN sibware.personal B on A.id_ejecutivo=B.ID
    WHERE
      A.id_comision = $folio");
      while ($row=$queryResult->fetch(PDO::FETCH_ASSOC)) {
        $total_apagar=$row['total_apagar'];
        $nombre_ejecutivo=$row['Ejecutivo'];
      }
     $queryResult=$pdo->prepare("UPDATE Intranet.comisiones 
     SET status=3
     WHERE id_comision=$_GET[idcomi]");
     $queryResult->execute(); 
?>
<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Intr@net Credicor</title>
    <link rel="shortcut icon" href="http://wwww.ejemplo.org/img/favicon.ico" />
    
    <style type="text/css">
    
    .style1 {color: #666666}
    .style3 {color: #333333}
    .style4 {
        font-size: 36px;
        font-weight: bold;
    }
    
    </style>
</head>
<body>
<form name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <p>&nbsp;</p>
  <table width="906" border="0" align="center">
    <tr>
      <td width="900"><table width="729" border="0" align="center">
          <tr>
            <td width="177"><div align="center"><strong><img src="img/logos/Imagotipo.png" width="300" height="71" align="absmiddle"></strong></div></td>
            <td width="542"><div align="center" class="style4">SOLICITUD DE CHEQUE</div></td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td><table width="875" border="0">
          <tr>
            <td width="506"><table width="506" border="1">
                <tr>
                  <td width="496">EMPRESA: <strong>SERVICIOS INDEPENDIENTES DEL BAJIO S.C.</strong>.</td>
                </tr>
            </table></td>
            <td width="353"><table width="356" border="1">
                <tr>
                  <td width="349">FECHA:
                    <input name="textfield222" type="text" id="textfield222" value="<?php $hoy = date("Y-m-d"); echo $hoy; ?>">
                      <?php $hoy = date("Y-m-d"); echo $hoy; ?></td>
                </tr>
            </table></td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td><table width="875" border="0">
          <tr>
            <td width="506"><table width="506" border="1">
                <tr>
                  <td width="496">IMPORTE DEL CHEQUE: $ <?php  $honorarios = ($total_apagar*.94333);  echo number_format($honorarios, 2, ".", ","); ?></td>
                </tr>
            </table></td>
            <td width="353"><table width="356" border="1">
                <tr>
                  <td width="346"><label>
                    <input name="radiobutton1" type="radio" value="pesos" checked="checked">
                    Pesos</label>
                      <label>
                      <input name="radiobutton1" type="radio" value="dlls">
                        Dlls.</label>
                  </td>
                </tr>
            </table></td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td><table width="869" border="1">
          <tr>
            <td width="859"><p>CANTIDAD CON LETRA:
              <?php  
			   //$honorarios = $total_apagar*.94333;  echo number_format($honorarios, 2, ",", ".");
		include("CNumeroaLetra.php");
		$numalet= new CNumeroaletra; 
		$numalet->setNumero($honorarios); 
		echo $numalet->letra(); 
            ?>
            </p></td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td><table width="869" border="1">
          <tr>
            <td width="859"><p>BENEFICIARIO:
              <?php  echo $nombre_ejecutivo; ?>
            </p></td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td><table width="869" border="1">
          <tr>
            <td width="859"><p>CONCEPTO:</p>
                <p>
                  <textarea name="textconcepto" cols="100" rows="15" id="textconcepto">
            </textarea>
              </p></td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td><table width="869" border="1">
          <tr>
            <td width="859"><p>INSTRUCCIONES ESPECIALES: </p>
                <table width="846" border="0">
                  <tr>
                    <td width="284">SELLO PARA ABONO EN CUENTA: </td>
                    <td width="552"><label>
                      <input name="radiobutton2" type="radio" value="si" checked="checked">
                      Si </label>
                        <label>
                        <input name="radiobutton2" type="radio" value="no">
                          No</label>
                    </td>
                  </tr>
                  <tr>
                    <td>DEPOSITAR A:</td>
                    <td><table width="546" border="1">
                        <tr>
                          <td width="170"><div align="right">No. CTA. O CLABE </div></td>
                          <td width="360"><input name="txt_concepto2" type="text" id="txt_concepto2" size="60" maxlength="40" ></td>
                        </tr>
                        <tr>
                          <td><div align="right">BANCO</div></td>
                          <td><input name="txt_concepto3" type="text" id="txt_concepto3" size="60" maxlength="40" ></td>
                        </tr>
                        <tr>
                          <td><div align="right">REFERENCIA</div></td>
                          <td><input name="txt_concepto4" type="text" id="txt_concepto4" size="60" maxlength="40" ></td>
                        </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td>OTRAS INDICACIONES </td>
                    <td><textarea name="textarea2" cols="80" rows="4" id="textarea2">
              </textarea></td>
                  </tr>
                  
            </table>
            <table width="850" border="1">
  <tr>
    <th scope="col"><p>FORMULO</p>
      <p><?php echo $nombre_ejecutivo ?></p></th>
    <th scope="col">REVISO
    <br><img src="img/logos/firma_luis.png" height="80" >
    <p>LUIS AYALA MUÑOZ</p></th>
    <th scope="col">AUTORIZO
    <br><img src="img/logos/firma_cristhian.jpg" height="80">
    <p>CRISTHIAN MONTELONGO CARDENAS</p></th>
  </tr>
</table>

            </td>
          </tr>
      </table></td>
    </tr>
  </table>
  <p><tr></tr>
    <script>
function sumar(a,b,c,d,e,f,g,h)
{
var total;
total = parseFloat(a.value)+parseFloat(b.value)+parseFloat(c.value)+parseFloat(d.value)+parseFloat(e.value)+parseFloat(f.value)+parseFloat(g.value)+parseFloat(h.value);
return(total);
}
    </script>
  </p>
  <p align="center">
    <input type="button" name="imprimir" value="Imprimir"  onClick="window.print();" class="button" />
  </p>
</form>

</p>
</body>
</html>