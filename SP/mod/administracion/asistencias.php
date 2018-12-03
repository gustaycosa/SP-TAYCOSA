<?php include("validasesion.php"); ?>
<!DOCTYPE html>
<html class="no-js">

<?php 
    include("../../funciones.php"); 
    $TituloPantalla = 'Asistencias';   
    echo Cabecera($TituloPantalla);  
?>

    <body>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h6 id="cabecera">
                    <?php echo $TituloPantalla; ?>
                </h6>
            </div>
            <div class="panel-body">
                <form id="formulario" method="POST" class="form-inline">
                    <div class="form-group">
                        <label for="inputFechaIni">Empleado:</label>
                        <?php echo CmbCualquieras('USERID','NAME','ATT_USERINFO'); ?>
                    </div>
                    <div class="form-group">
                        <label for="inputFechaIni">De:</label>
                        <input type="date" name="Fini" id="Fini" value="<?php echo date("Y-m-d");?>" class="form-control" placeholder="Rango Fecha Inicial" />
                    </div>
                    <div class="form-group">
                        <label for="inputFechaFin">A:</label>
                        <input type="date" name="Ffin" id="Ffin" value="<?php echo date("Y-m-d");?>" class="form-control" placeholder="Rango Fecha Final">
                    </div>
                    <button type="submit" id="btnEnviar" class="btn btn-primary btn-sm" onMouseOver=""><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Consultar</button>                     

                </form>
                <div class="respuesta"></div>                 
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
        $(function() {        
            <?php echo JqueryButtons();?>
            
            $("form").on('submit', function(e) {
                e.preventDefault();
                $('#CargaGif').show();
                $('#btnEnviar').attr('disabled', 'disabled')
                $.ajax({
                    type: "POST",
                    url: 'tabla-admasist.php',
                    data: $("form").serialize(), // Adjuntar los campos del formulario enviado.
                    success: function(data) {
                        $('#CargaGif').hide();
                        $('#btnEnviar').removeAttr('disabled');
                        $(".respuesta").html(data); // Mostrar la respuestas del script PHP.
                    },
                    error: function(error) {
                        $('#CargaGif').hide();
                        console.log(error);
                        alert('Algo salio mal :S');
                    }
                });
                return false; // Evitar ejecutar el submit del formulario.
            });
            
            $('select#CmbATT_USERINFO').on('change', function() {
                var id = $('#CmbATT_USERINFO').val();
                var name = $('#CmbATT_USERINFO option:selected').html();
                $("#title").html("Reporte asistencias - " + id + " " + name);
                $("#cabecera").html("Reporte asistencias - " + id + " " + name);
            });
        });

    </script>

</html>
