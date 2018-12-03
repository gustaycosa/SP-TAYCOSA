
<!DOCTYPE html>
<html class="no-js">

<?php include("../../funciones.php"); ?>
<?php echo Cabecera('Reporte de edos. financieros'); ?>
<?php
$TituloPantalla = 'Reporte de edos. financieros';    

require_once('lib/nusoap.php');
ini_set("soap.wsdl_cache_enabled", "0");
$WebService="http://dwh.taycosa.mx/WEB_SERVICES/DataLogs.asmx?wsdl";

$Columnas = array("Modulo","Grupo","forma","Descripcion","InsertarDatos","ActualizarDatos","EliminarDatos","LeerDatos");//COLUMNAS 
    
$parametros = array();
$parametros['sPerfil'] = $perfil ;//'JEFE_VENTAS';
$parametros['sModulo'] = 'DWH';
$parametros['sTipoPerfil'] = $tipoperfil ;//'INCLUYENTE';
        $WS = new SoapClient($WebService, $parametros);
        $result = $WS->AccesosMenu($parametros);
        $xml = $result->AccesosMenuResult->any;
        $obj = simplexml_load_string($xml);
        $Datos = $obj->NewDataSet->Table;
    
    var_dump($Datos); 

    $ar = '
    	<style>
		.nav li{
			background: black;
		}
		.nav li a{
			color: white !important;
			background: #dedede !important;
			color: black !important;
			border-bottom: solid 1pt gray;
		}
		.nav li a:hover{
			color: black !important;
			background: #ffb510 !important;
			cursor: hand;
		}
		.nav li ul{
			display: none;
			padding-left: 5px;
		}
		.nav li ul li{
			background: gray !important;
			list-style-type: none;
		}
	</style>';
    echo $ar;
    $rpt = '<body style="background: url(../img/LOGOTAYCO.jpg) center no-repeat fixed gray;">
        <div class="navmenu navmenu-default navmenu-fixed-left offcanvas" style="background:black;">
          <ul class="nav navmenu-nav" style="background:black;">';
    $BANDERA = '';
    $GRUPO = '';
    $GRUPO_SIG = '';
    for($i=0; $i<count($Datos); $i++){
       $GRUPO = $Datos[$i]->$Columnas[1];
        
        if( strcmp($GRUPO,$BANDERA) !== 0) {
            $BANDERA = $Datos[$i]->$Columnas[1];
		      $rpt = $rpt.'<li>
                <a id="'.$Datos[$i]->$Columnas[1].'" type="button" style="background:black !important; color: white !important;">
                    <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> '.$GRUPO.'</a>'; 
                $rpt = $rpt.'<ul class="'.$Datos[$i]->$Columnas[1].'">';
            }
           else{
               $rpt = $rpt.'';
           }
                $rpt= $rpt.'<li><a href="'.$Datos[$i]->$Columnas[2].'.php" id="'.$Datos[$i]->$Columnas[2].'" target="'.$Datos[$i]->$Columnas[2].'" type="button" class="list-group-item"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> '.$Datos[$i]->$Columnas[3].'</a></li>'; 
            
        $GRUPO_SIG = ($Datos[$i+1]->$Columnas[1]);
        
          if((strcmp($GRUPO_SIG ,$BANDERA) !== 0) or ($i ==count($Datos)-1) ){
		      $rpt = $rpt.'</ul></li>';
            }
        
    }
				$rpt= $rpt.'<li><a href="salir.php" type="button" style="background:black !important; color: white !important;">
					<span class="glyphicon glyphicon-off" aria-hidden="true"></span> Cerrar sesión
				</a>
			</li> 
          </ul>';

        $rpt= $rpt.'</div>
        <div class="navbar navbar-default navbar-fixed-top">
          <button  id="edo" target="edo"  type="button" class="navbar-toggle" data-toggle="offcanvas" data-target=".navmenu" data-canvas="body" style=" background: #337ab7;">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>';
        echo $rpt;
        $ar2='<div id="principal" class="container-fluid"></div></body>';
    echo $ar2;
        include("barratareas.php");    
        echo Script();
    
 ?>
    <script type="text/javascript"> 
        $(document).on('click','.close',function(){
            //id del item menu
            var ID = $( this ).attr("name");
            $( "#navbar #"+ID ).remove();
            $( "#ifm"+ID ).remove();
        });
        
        $(document).on('click','.vna-act',function(){
            //id de ventana
            var ids = $( this ).attr("id");
            //id de iframe a partir de ventana
            var idcomplete = '#ifm'+ids;
            //cambiar clase de abierto a cerrado a iframe
            $("#principal iframe").hide();
            //cambiar clase de activo a inactivo a ventana
            $("#navbar a").attr('class').replace('vna-act', 'vna-min');
            //cambiar clase de activo a inactivo a ventana
            $(this).removeClass( 'vna-act' ).addClass( 'vna-min' );
            $( idcomplete ).hide();
        });
        
        $(document).on('click','.vna-min',function(){
            //id de ventana
            var ids = $( this ).attr("id");
            //id de iframe a partir de ventana
            var idcomplete = '#ifm'+ids;
            //cambiar clase de abierto a cerrado a iframe
            //cambiar clase de activo a inactivo a ventana
            //$("#navbar a").attr('class').replace('vna-act', 'vna-min');
			$("#navbar > a").removeClass('vna-act').addClass('vna-min');
			$("#principal iframe").hide();
			$(this).removeClass( 'vna-min' ).addClass( 'vna-act' );
            //cambiar clase de activo a inactivo a ventana
            $( idcomplete ).show();
        });
        
        $(document).on('click','.list-group-item',function(){
            //id del item menu
			$("#principal iframe").hide();
			$("#navbar > a").removeClass('vna-act').addClass('vna-min');
            var IDFRM = $( this ).attr("id");
            //id del iframe
            var modal2 = "<iframe id='ifm"+IDFRM+"' name='"+IDFRM+"' frameborder='0' class='col-sm-12'></iframe>";
            //id de la ventana
            var ventana = "<a id='"+IDFRM+"' class='vna-act'>"+IDFRM+"<button class='close' name='"+IDFRM+"'>x</button></a>";
            //dibujamos iframe dentro de div principal
            $( "#principal" ).append( modal2 );
            //dibujamos ventana en barra de tareas
            $( "#navbar" ).append( ventana );
            $("#"+IDFRM).attr('class').replace('vna-min', 'vna-act');
            $( "#ifm"+IDFRM ).addClass('ifmOpen');
			//$('.navmenu').hide();
			//$('.navmenu').attr('style','-');
        });

        $(document).on('click','ul.nav li a',function(){
            //id del item menu
			var MenuItem = $( this ).attr("id");
			if ($("."+MenuItem).is(":hidden")) {
				$("ul.nav li ul").hide();
				$("."+MenuItem).show();
			}else{
				$("."+MenuItem).hide();
			}
				
        });
        
        $(document).ready(function() {

        } );

    </script>
    <script language="JavaScript" type="text/javascript">
        function show5(){
            if (!document.layers&&!document.all&&!document.getElementById)
            return
             var Digital=new Date()
             var hours=Digital.getHours()
             var minutes=Digital.getMinutes()
             var seconds=Digital.getSeconds()
             var dn="PM"
             if (hours<12)
             dn="AM"
             if (hours>12)
             hours=hours-12
             if (hours==0)
             hours=12
             if (minutes<=9)
             minutes="0"+minutes
             if (seconds<=9)
             seconds="0"+seconds
            //change font size here to your desire
            myclock=hours+":"+minutes+":"
             +seconds+" "+dn
            if (document.layers){
            document.layers.liveclock.document.write(myclock)
            document.layers.liveclock.document.close()
            }
            else if (document.all)
            liveclock.innerHTML=myclock
            else if (document.getElementById)
            document.getElementById("liveclock").innerHTML=myclock
            setTimeout("show5()",1000)
        }
        window.onload=show5
     </script>
</html>