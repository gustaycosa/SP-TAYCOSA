
<!DOCTYPE html>
<html class="no-js">

<?php include("../../funciones.php"); ?>
<?php echo Cabecera('Reporte de edos. financieros'); ?>
<?php
    $TituloPantalla = 'Reporte de edos. financieros';    
?>

    <body>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h6 id="cabecera">
                    <?php ECHO $TituloPantalla; /*Incluir modal nvo*/?>
                </h6>
            </div>
            <div class="panel-body">
                <form id="formulario" method="POST" class="form-inline">
                    <div class="form-group">
                        <?php echo TxtPeriodo();?>
                    </div>
                    <div class="form-group">
                        <?php echo CmbMes();?>
                    </div>
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="TxtClave" name="TxtClave" value="" placeholder="Ingrese ejercicio">
                    </div>
                    <button type="submit" id="btnEnviar" class="btn btn-primary btn-sm" onMouseOver=""><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Consultar</button>
                </form>
                <div class="respuesta"></div>
                <div class="detalle"></div>
                 <div class="form-inline">
                    <div class="modal-footer col-sm-2">
                        <?php echo BusquedaGrid(0,'nombre');?>
                    </div>
                    <div class="modal-footer col-sm-10">
                        <?php echo HtmlButtons();?>
                    </div>
                </div>
                <?php echo CargaGif();?>
            </div>
        </div>
    </body>

    <?php echo Script(); ?>

    <script type="text/javascript">
        var timer = 0;
        $(function() {        
            <?php echo JqueryButtons();?>

            $("form").on('submit', function(e) {

                e.preventDefault();
				$('#CargaGif').show();
                $('#btnEnviar').attr('disabled', 'disabled')
                $.ajax({
                    type: "POST",
                    url: 'tabla-edoresultados.php',
                    data: $("form").serialize(), // Adjuntar los campos del formulario enviado.
                    success: function(data) {
						$('#CargaGif').hide();
                        $('#btnEnviar').removeAttr('disabled');
                        $(".respuesta").html(data); // Mostrar la respuestas del script PHP.
                        $(".respuesta").show();
                    },
                    error: function(error) {
						$('#CargaGif').hide();
                        console.log(error);
                        alert('Algo salio mal :S');
                    }
                });

                return false; // Evitar ejecutar el submit del formulario.
            });
        });

        $('select#TxtMes').on('change', function() {
            var id = $('#TxtEjercicio').val();
            var name = $('#TxtMes option:selected').html();
            $("#title").html("Reporte ventas - CLAVE " + id + " - " + name);
            $("#cabecera").html("REPORTE DE ESTADOS - PERIODO " + name + " - " + id );
        });

        $(document).on('click touchstart','#grid tbody tr',function(){
            
            var id = $(this).attr("id");
            //alert(id);
            $("#TxtClave").val(id);
            
            if(timer == 0){
                timer = 1;
                timer = setTimeout(function(){ timer = 0; }, 600);
            }
            else { 
                //alert("double tap"); 
                var id = $(this).parent().attr("id");
                $("#TxtClave").val(id);
                $('#CargaGif').show();
                //$("#myModalLabel").text('FACTURADO '+id);
                $.ajax({
                    type: "POST",
                    url: 'tabla-edoresultados2.php',
                    data: $("form").serialize(), // Adjuntar los campos del formulario enviado.
                    success: function(data) {
                        //$('#btnEnviar').removeAttr('disabled');
                        $('#CargaGif').hide();
                        $(".detalle").html(data); // Mostrar la respuestas del script PHP.
                        $(".detalle").show();
                        //$('#MdlMaqDet').modal('show')
                        $('#gridfact').DataTable().draw();
                    },
                    error: function(error) {
                        $('#CargaGif').hide();
                        console.log(error);
                        alert('Algo salio mal :S');
                    }
                });
                return false; // Evitar ejecutar el submit del formulario.
                timer = 0; 
            }
        });
    </script>

</html>
