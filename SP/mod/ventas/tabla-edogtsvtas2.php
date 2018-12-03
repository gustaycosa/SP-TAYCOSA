<?php include("../../funciones.php");

try{ 
    
    if ($_POST){
        ini_set("soap.wsdl_cache_enabled", "0");
        $Ejercicio =  $_POST["TxtEjercicio"]; 
        $Mes =  $_POST["TxtMes"]; 
		$Moneda = $_POST["CmbMoneda"]; 
        
        
        //parametros de la llamada
        $parametros = array();
        $parametros['Id_Empresa'] = 'TAYCOSA';
        $parametros['Mes'] = $Mes;
        $parametros['Ejercicio'] = $Ejercicio;
		$parametros['Moneda'] = $Moneda;
		
        //Invocación al web service
        $WS = new SoapClient($WebService, $parametros);
        //recibimos la respuesta dentro de un objeto
        $result = $WS->VentasNetasDetalle($parametros);
        $xml = $result->VentasNetasDetalleResult->any;
        $obj = simplexml_load_string($xml);
        $Datos = $obj->NewDataSet->Table;
    }
    else{}
} catch(SoapFault $e){
  var_dump($e);
}

    echo "<div class='table-responsive'>
        <table id='grid' class='table table-striped table-bordered table-condensed table-hover display compact' cellspacing='0' style='width:100%;' ><tfoot><tr><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th></tr></tfoot></table></div>";

	$arreglo = [];
	for($i=0; $i<count($Datos); $i++){
		$arreglo[$i]=$Datos[$i];
	}

?>

     <script type="text/javascript"> 
        var datos = 
        <?php 
            echo json_encode($arreglo);
        ?>
		;
		<?php
        /*
			$sGridNomb = '#griddet';
			$sWsNomb = 'vtas_netasdet';
			$aColumnas = array("nombre","Facturado","Descuentos","DevolucionProducto","DevolucionRefacturacion","GarantiaNoRe","GarantiaReem","ReFacturacion","Abonos");
			$aTitulos = array("nombre","Facturado","Descuentos","DevolucionProducto","DevolucionRefacturacion","GarantiaNoRe","GarantiaReem","ReFacturacion","Abonos");
			echo GrdRptShort($sGridNomb,$sWsNomb,$aColumnas,$aTitulos);
            */
		?>

   $(document).ready(function() {
         var table = $('#grid').DataTable({
            data:datos,
            columns: [
                { data: 'nombre', 'className':'text-left' },
                { "className": 'text-right btn_facturado', "orderable": false, "data": 'Facturado', "defaultContent": ''},
                { "className": 'text-right btn_descuentos', "orderable": false, "data": 'Descuentos', "defaultContent": ''},
                { "className": 'text-right btn_devoproducto', "orderable": false, "data": 'DevolucionProducto', "defaultContent": ''},
                {"className": 'text-right btn_devorefactutacion', "orderable": false, "data": 'DevolucionRefacturacion',"defaultContent": ''},
                { "className": 'text-right btn_garantianore', "orderable": false, "data": 'GarantiaNoRe', "defaultContent": '' },
                { "className": 'text-right btn_garantreem', "orderable": false, "data": 'GarantiaReem', "defaultContent": '' },
                { "className": 'text-right btn_refacturacion', "orderable": false, "data": 'ReFacturacion', "defaultContent": ''},
                { "className": 'text-right btn_cobrado', "orderable": false, "data": 'TotalCobradoMes', "defaultContent": ''},
                { data: 'VtasNetas', 'className':'text-right' },
            ],
            columnDefs: [
                { 'title': 'Nombre',  'width':'200px', className: "text-left", 'targets': 0},
                { 'title': 'Facturado',  'width':'50px', className: "text-right",'targets': 1},
                { 'title': 'Descuentos',  'width':'50px', className: "text-right", 'targets': 2},
                { 'title': 'Dev.Producto',  'width':'50px', className: "text-right", 'targets': 3},
                { 'title': 'Dev.Refacturacion',  'width':'50px', className: "text-right", 'targets': 4},
                { 'title': 'GarantiaNoRe',  'width':'50px', className: "text-right", 'targets': 5},
                { 'title': 'GarantiaReem',  'width':'50px', className: "text-right", 'targets': 6},
                { 'title': 'ReFacturacion',  'width':'50px', className: "text-right", 'targets': 7},
                { 'title': 'Cobrado',  'width':'50px', className: "text-right", 'targets': 8},
                { 'title': 'Vtas netas',  'width':'50px', className: "text-right", 'targets': 9}
            ],
            'createdRow': function ( row, data, index ) {
            },
            paging: false,
            searching: false,
            ordering: false,
            buttons: [
                {
                    extend: 'copy',
                    message: 'PDF created by PDFMake with Buttons for DataTables.',
                    text: 'Copiar',
                    exportOptions: {
                        modifier: {
                            page: 'all'
                        }
                    }
                },
                {
                    extend: 'pdf',
                    text: 'PDF',
                    filename: 'ventasnetas',
                    extension: '.pdf',       
                    exportOptions: {
                        columns: ':visible',
                        modifier: {
                            page: 'all'
                        }
                    }
                },
                {
                    extend: 'csv',
                    text: 'CSV',
                    header:'true',
                    filename: 'ventasnetas',
                    extension: '.csv',       
                    exportOptions: {
                        columns: ':visible',
                        modifier: {
                            page: 'all'
                        }
                    }
                },
                {
                    extend: 'excel',
                    message: 'PDF creado desde el sistema en linea del tayco.',
                    text: 'XLS',
                    filename: 'ventasnetas',
                    extension: '.xlsx', 
                    exportOptions: {
                        columns: ':visible',
                        modifier: {
                            page: 'all'
                        }
                    },
                    customize: function( xlsx ) {
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];
                        $('row:first c', sheet).attr( 's', '42' );
                    }
                },
                {
                    extend: 'print',
                    message: 'PDF creado desde el sistema en linea del tayco.',
                    text: 'Imprimir',
                    exportOptions: {
                        stripHtml: false,
                        modifier: {
                            page: 'all'
                        }
                    }
                },
            ],
            'pagingType': 'full_numbers',
            'lengthMenu': [[-1], ['Todo']],
            'language': {
                'sProcessing':    'Procesando...',
                'sLengthMenu':    'Mostrar _MENU_ registros',
                'sZeroRecords':   'No se encontraron resultados',
                'sEmptyTable':    'Ningún dato disponible en esta tabla',
                'sInfo':          'Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros',
                'sInfoEmpty':     'Mostrando registros del 0 al 0 de un total de 0 registros',
                'sInfoFiltered':  '(filtrado de un total de _MAX_ registros)',
                'sInfoPostFix':   '',
                'sSearch':        'Buscar:',
                'sUrl':           '',
                'sInfoThousands':  ',',
                'sLoadingRecords': 'Cargando...',
                'oPaginate': {
                    'sFirst':    'Primero',
                    'sLast':    'Último',
                    'sNext':    'Siguiente',
                    'sPrevious': 'Anterior'
                },
                'oAria': {
                    'sSortAscending':  ': Activar para ordenar la columna de manera ascendente',
                    'sSortDescending': ': Activar para ordenar la columna de manera descendente'
            },
            'paging': false,
            'responsive': true
                    },
        "footerCallback": function ( row, data, start, end, display ) {
            
        }
        } );
    } );
    </script>