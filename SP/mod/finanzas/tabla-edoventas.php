<?php include("../../funciones.php");

try{ 
    
    if ($_POST){
        
        $Ejercicio =  $_POST["TxtEjercicio"]; 
        $Mes =  $_POST["TxtMes"]; 
        
        //parametros de la llamada
        $parametros = array();
        $parametros['Empresa'] = 'TAYCOSA';
        $parametros['Mes'] = $Mes;
        $parametros['Ejercicio'] = $Ejercicio;
        //ini_set("soap.wsdl_cache_enabled", "0");
        //Invocación al web service
        $WS = new SoapClient($WebService, $parametros);
        //recibimos la respuesta dentro de un objeto
        //$result = $WS->Edoresultados($parametros);
        //$xml = $result->EdoresultadosResult->any;
        $result = $WS->edoventas($parametros);
        $xml = $result->edoventasResult->any;
        $obj = simplexml_load_string($xml);
        $Datos = $obj->NewDataSet->Table;
//echo $xml;
    }
    else{}
} catch(SoapFault $e){
  var_dump($e);
}

    echo "<div class='table-responsive'>
        <table id='grid' class='table table-striped table-bordered table-condensed table-hover display compact nowrap' cellspacing='0' style='width:100%;'><tfoot><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th></tfoot></table></div>"; 

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
        $(document).ready(function() {

            var table = $('#grid').DataTable({
                data:datos,
				//array("Id_ConceptoCtb","ConceptoCtb","Ventas","Devoluciones","DevoxRefact","Descto","NCGAR","VENTASNETAS","CostoVentas","CostoGAR","CostoGNR","TOTAL_COSTO_VENTAS","TF");
                columns: [
                    { data: "ConceptoCtb" },
                    { data: "Ventas" },
                    { data: "Devoluciones" },
                    { data: "DevoxRefact" },
                    { data: "Descto" },
                    { data: "NCGAR" },
                    { data: "VENTASNETAS" },
                    { data: "CostoVentas" },
                    { data: "CostoGAR" },
                    { data: "CostoGNR" },
                    { data: "TOTAL_COSTO_VENTAS" }
                ],
                columnDefs: [
                    { 'title': 'CONCEPTO', 'width':'150px', className: "text-left", 'targets': 0},
                    { 'title': 'VENTAS', 'width':'50px', className: "text-right", 'targets': 1},
                    { 'title': 'DEVOLUCIONES', 'width':'50px', className: "text-right", 'targets': 2},
                    { 'title': 'DEVO POR REFAC', 'width':'50px', className: "text-right", 'targets': 3},
                    { 'title': 'DESCUENTO', 'width':'50px', className: "text-right", 'targets': 4},
                    { 'title': 'NCGAR', 'width':'50px', className: "text-right", 'targets': 5},
                    { 'title': 'VTAS NETAS', 'width':'50px', className: "text-right", 'targets': 6},
                    { 'title': 'COSTO VENTAS', 'width':'50px', className: "text-right", 'targets': 7},
                    { 'title': 'COSTO GAR', 'width':'50px', className: "text-right", 'targets': 8},
                    { 'title': 'COSTO NGAR', 'width':'50px', className: "text-right", 'targets': 9},
                    { 'title': 'TOTAL COSTO', 'width':'50px', className: "text-right", 'targets': 10}
            ],
            'createdRow': function ( row, data, index ) {
            },
            paging: false,
            searching: true,
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
                }
            },
            'scrollY': '60vh',
            'scrollCollapse': true,
            'scrollX': true,
            'paging': false,
             fixedHeader: {
                header: true,
                footer: false
            },
            'responsive':true,
       "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
           
            var api_diez = this.api(), data;
            var api_anoant = this.api(), data;
            var api_anoact = this.api(), data;
            var api_utilper = this.api(), data;
            var api_inggen = this.api(), data;
            var api_promen = this.api(), data;
            var api_acuene = this.api(), data;
            var api_variac = this.api(), data;
            var api_mesant = this.api(), data;
            var api_mesact = this.api(), data;

            
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
            //===========================================================================
            total_diez = api_diez
                .column( 10 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            var numFormat = $.fn.dataTable.render.number( '\,', '.', 2, '$' ).display;
            $( api_diez.column( 10 ).footer() ).html(numFormat(total_diez) );
            //===========================================================================
            total_anoant = api_anoant
                .column( 9 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api_anoant.column( 9 ).footer() ).html(numFormat(total_anoant) );
           
            //===========================================================================
            total_anoact = api_anoact
                .column( 8 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api_anoact.column( 8 ).footer() ).html(numFormat(total_anoact) );
           
            //===========================================================================
            total_utilper = api_utilper
                .column( 7 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api_utilper.column( 7 ).footer() ).html(numFormat(total_utilper) );
           
            //===========================================================================
            total_inggen = api_inggen
                .column( 6 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api_inggen.column( 6 ).footer() ).html(numFormat(total_inggen) );

            //===========================================================================
            total_promen = api_promen
                .column( 5 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api_promen.column( 5 ).footer() ).html(numFormat(total_promen) );

            //===========================================================================
            total_acuene = api_acuene
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api_acuene.column( 4 ).footer() ).html(numFormat(total_acuene) );
           
            //===========================================================================
            total_variac = api_variac
                .column( 3 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api_variac.column( 3 ).footer() ).html(numFormat(total_variac) );
           
            //===========================================================================
            total_mesant = api_mesant
                .column( 2 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api_mesant.column( 2 ).footer() ).html(numFormat(total_mesant) );
           
            //===========================================================================
            total_mesact = api_mesact
                .column( 1 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api_mesact.column( 1 ).footer() ).html(numFormat(total_mesact) );
           
        }
        } );
        $('#txtbusqueda').on('keyup change', function() {
          //clear global search values
          table.search('');
          table.column($(this).data('columnIndex')).search(this.value).draw();
        });

        $(".dataTables_filter input").on('keyup change', function() {
          //clear column search values
          table.columns().search('');
          //clear input values
          $('#txtbusqueda').val('');
        });
        } );
        //FUNCION DE PLATILLOS MENUS
        $(function(){

            $('.T1').click(function() {                
                if ($('.N').css("display") != "none" ) {
                    $('.N').hide(); 
                }else{
                    $('.N').show(); 
                }
            });
        });
    </script>