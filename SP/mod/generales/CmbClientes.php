<?php //include("../../funciones.php");
$WebService = 'http://dwh.taycosa.mx/WEB_SERVICES/DataLogs.asmx?wsdl';
ini_set("soap.wsdl_cache_enabled", "0");

try{ 
    $CveBusqueda =  $_POST["TxtCliente"]; 
    $parametros = array();
    $parametros['CveBusqueda'] = $CveBusqueda;
    $WS = new SoapClient($WebService, $parametros);
    $result = $WS->MuestraClientes($parametros);
    $xml = $result->MuestraClientesResult->any;
    $obj = simplexml_load_string($xml);
    $Datos = $obj->NewDataSet->Table;
    
} catch(SoapFault $e){
  var_dump($e);
}


//	for($i=0; $i<count($Datos); $i++){
//         echo "<li><a id='".$Datos[$i]->$Columnas[0]."' href='#'>".$Datos[$i]->$Columnas[1]."</a></li>";
//	}


    $i = 0;
    while ($i < count($Datos)):
        echo "<li><a id='".$Datos[$i]->ID_CLIENTE."'>".$Datos[$i]->NOMBRE."</a></li>";
        $i++;
    endwhile;

//$publicidad = Array(’90×600′ => ‘adsense’, ‘500×500’ => ‘adjal’);

//foreach($Datos as $ID_CLIENTE => ID_CLIENTE) {
//
////echo $llave.’ ‘.$valor;
//echo "<li><a id='".$ID_CLIENTE."'>".$ID_CLIENTE."</a></li>";
//
//}
    echo '<li role="separator" class="divider"></li>';
    echo '<li id="0"><a>TODOS</a></li>';
?>

 