<?php

ini_set("soap.wsdl_cache_enabled", "0");

	$Columnas = array("Pedido","Renglon","Factura","Articulo","Nombre","Id_Sucursal","costounitario","Importe","Impuesto","cantidad");//COLUMNAS GRID

try{ 
    $WebService="http://dwh.taycosa.mx/WEB_SERVICES/DataLogs.asmx?wsdl";

    $Id =  $_POST["TxtRowID"]; 
    $parametros = array();
    $parametros['iId_Maquinaria'] = $Id;
    
    $WS = new SoapClient($WebService,$parametros);
    $result = $WS->AcondicionamientoSelect($parametros);
    $xml = $result->AcondicionamientoSelectResult->any;
    $obj = simplexml_load_string($xml);
    $Datos = $obj->NewDataSet->Table;
    
} catch(SoapFault $e){
  var_dump($e);
}

echo "<table id='gridpop' class='table table-striped table-bordered table-condensed table-hover display compact'>
	 	<thead><tr>"; 
		
			for($i=0; $i<count($Columnas); $i++){
		  		echo "<th>".$Columnas[$i]."</th>";
			}

	  	echo "</tr></thead>
	 	<tfoot><tr>";

			for($i=0; $i<count($Columnas); $i++){
		  		echo "<th>".$Columnas[$i]."</th>";
			}
	  	
 echo "</tr></tfoot><tbody>";

 for($i=0; $i<count($Datos); $i++){
    echo "<tr class='Seleccionado' data-id='".$Datos[$i]->$Columnas[0]."' data-name='".$Datos[$i]->$Columnas[1]."'>";
    for($j=0; $j<count($Columnas); $j++){
        echo "<td class='text-center'>".$Datos[$i]->$Columnas[$j]."</td>";
    } 
    echo "</tr>";
 } 
    echo "</tbody></table>";


?>

            