<?php include("../../funciones.php");

try{ 
    
    if ($_POST){
        ini_set("soap.wsdl_cache_enabled", "0");
        $Estatus =  $_POST["CmbEstatus"]; 
        $De = $_POST["Fini"];
        $A =  $_POST["Ffin"]; 
        $dDe = strtotime($De);
        $newformat1 = date('Y-m-d',$dDe);
        $dA = strtotime($A);
        $newformat2 = date('Y-m-d',$dA);
        $Id_Responsable =  $_POST["CmbNOMBRESUSUARIOWEB2"]; 
        $Id_Solicita =  $_POST["CmbNOMBRESUSUARIOWEB"]; 
        //parametros de la llamada
        $parametros = array();
        $parametros['sEstatus'] = $Estatus;
        $parametros['dtFechaIni'] = $newformat1;
        $parametros['dtFechaFin'] = $newformat2;
        $parametros['Id_Responsable'] = $Id_Responsable;
        $parametros['Id_Solicita'] = $Id_Solicita;
        $WS = new SoapClient($WebService, $parametros);
        $result = $WS->TareaReporte($parametros);
        $xml = $result->TareaReporteResult->any;
        $obj = simplexml_load_string($xml);
        $Datos = $obj->NewDataSet->Table;
//echo $xml;
    }
    else{}
} catch(SoapFault $e){
  var_dump($e);
}

    echo "<div class='table-responsive'>
        <table id='grid' class='table table-bordered table-hover display compact' cellspacing='0' style='width:100%;' ><tfoot><tr><th></th><th></th><th></th><th></th><th></th><th></th></tr></tfoot></table></div>";

$arreglo = [];
for($i=0; $i<count($Datos); $i++){
    $arreglo[$i]=$Datos[$i];
}
        //print_r($arreglo);
        //echo number_format($Suma, 2, ',', ' ');

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
                columns: [
                    { data: "Fecha" },
                    { data: "Nombre_Sol" },
                    { data: "Nombre_Para" },
                    { data: "asunto" },
                    { data: "ESTATUS" },
                    { data: "Num" }
                ],
                columnDefs: [
                    { "title": "FECHA", "targets": 0},
                    { "title": "DE", "targets": 1},
                    { "title": "A", "targets": 2},
                    { "title": "ASUNTO", "targets": 3},
                    { "title": "ESTATUS", "targets": 4},
                    { "title": "#", "targets": 5}
                ],
            'createdRow': function ( row, data, index ) {
                $(row).attr({id:data.Tarea, 'data-toggle':'modal', 'data-target':'#mdlcom'});
                var a = data.ESTATUS;
                if ( a == 'PENDIENTE' ) {
                    $(row).addClass('bg-warning');
                }
                else if ( a == 'TERMINADA' ) {
                    $(row).addClass('bg-success');
                }
                else if ( a == 'FINALIZADA' ) {
                    $(row).addClass('bg-info');
                }
                else {
                    $(row).addClass('bg-danger');
                }
                $(row).addClass('tar');
            },
            paging: false,
            searching: true,
            ordering: true,
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
                    customize: function ( doc ) {
                        // Splice the image in after the header, but before the table
                        doc.content.splice( 1, 0, {
                            
                            alignment: 'center'
                        } );
                        // Data URL generated by http://dataurl.net/#dataurlmaker
                    },
                    filename: 'vtas_netasfact',
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
                    filename: 'vtas_netasfact',
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
                    filename: 'vtas_netasfact',
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
            initComplete: function () {
                this.api().columns([1, 2, 4]).every( function () {
                    var column = this;

                    var select = $('<select><option value="">Selecciona</option></select>')
                        .appendTo( $(column.footer()).empty() )
                        .on( 'change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );

                            column
                                .search( val ? '^'+val+'$' : '', true, false )
                                .draw();
                        } );

                    column.data().unique().sort().each( function ( d, j ) {
                        if(j>1){
                            select.append( '<option value="'+d+'" width="auto">'+d+'</option>' )
                        }
                        else{

                        }
                    } );
                } );
            }
        } );
            
/*        $('#txtbusqueda').on('keyup change', function() {
          //clear global search values
          table.search('');
          table.column($(this).data('columnIndex')).search(this.value).draw();
        });

        $(".dataTables_filter input").on('keyup change', function() {
          //clear column search values
          table.columns().search('');
          //clear input values
          $('#txtbusqueda').val('');
        });*/
    } );

    </script>