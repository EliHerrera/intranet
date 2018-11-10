<?php
$fechaini = new DateTime();
$fechaini->modify('first day of this month');
echo $fechaini->format('Y-m-d'); // imprime por ejemplo: 01/12/2012

$fechafin = new DateTime();
$fechafin->modify('last day of this month');
echo $fechafin->format('Y-m-d'); // imprime por ejemplo: 31/12/2012


?>