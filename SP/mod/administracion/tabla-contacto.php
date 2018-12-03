<?php

try{ 
    /*
    if (isset($_POST['g-recaptcha-response'])){

	    $recaptcha = new \ReCaptcha\ReCaptcha($secret);

	    $resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);

	    if ($resp->isSuccess()){
	        /*echo "Success! That's it. Everything is working. Go integrate this into your real project.";*/

            if ($_POST){

                $nombre =  $_POST["Nombre"]; 
                $edo =  $_POST["edo"]; 
                $municipio = $_POST["municipio"]; 
                $plantas =  $_POST["plantas"]; 
                $plantada =  $_POST["plantada"]; 
                $sinplanta = $_POST["sinplanta"]; 

                $WebService="http://dwh.taycosa.mx/WEB_SERVICES/DataLogs.asmx?wsdl";
                //parametros de la llamada
                $parametros = array();
                $parametros['Nombre'] = $nombre;
                $parametros['Estado'] = $edo;
                $parametros['Municipio'] = $municipio;
                $parametros['NumPlantas'] = $plantas;
                $parametros['SupPlantar'] = $plantada;
                $parametros['SupxPlantar'] = $sinplanta;
                $WS = new SoapClient($WebService, $parametros);
                //recibimos la respuesta dentro de un objeto
                $result = $WS->Temp_SP_InsertaRegistroAEvento($parametros);
                $xml = $result->Temp_SP_InsertaRegistroAEventoResult->any;
                $obj = simplexml_load_string($xml);
                $Datos = $obj->NewDataSet->Table;
			}
            else{}
    /*
		}
		else{
			echo "<script language='JavaScript'> alert('Por favor use el captcha.'); </script>";
    	}
    }*/
}
    
catch(SoapFault $e){
  var_dump($e);
}

    echo "<script>alert('datos registrados');</script>";

?>
