<?php
try{ 
    
    if ($_POST){
    
        $Asunto =  $_POST["TxtAsunto"];
        $Descripcion =  $_POST["TxtDescripcion"];
        $FechaSol =  $_POST["txtFecha"];
        $Id_Solicita =  $_POST["TxtIdSolicita"];
        $Id_Responsable =  $_POST["CmbNOMBRESUSUARIOWEB"];

        $WebService="http://dwh.taycosa.mx/WEB_SERVICES/DataLogs.asmx?wsdl";
        //parametros de la llamada
        $parametros = array();
        $parametros['Asunto'] = $Asunto;
        $parametros['Descripcion'] = $Descripcion;
        $parametros['FechaSol'] = $FechaSol;
        $parametros['Id_Solicita'] = $Id_Solicita;
        $parametros['Id_Responsable'] = $Id_Responsable;

        $WS = new SoapClient($WebService, $parametros);
        $result = $WS->RegistrarTarea($parametros);
        $xml = $result->RegistrarTareaResult->any;
        $obj = simplexml_load_string($xml);
        $Datos = $obj->NewDataSet->Table;
    }
    else{

    }
} catch(SoapFault $e){
  $functions = $WS->__getFunctions ();
var_dump ($functions);
}


?>