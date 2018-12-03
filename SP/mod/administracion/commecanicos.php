<?php include("validasesion.php"); ?>
<!DOCTYPE html>
<html class="no-js">

<?php 
    include("../../funciones.php");
    $TituloPantalla = 'Comisiones mecanicos (TALLER)';    
    echo Cabecera($TituloPantalla); 
?>
<body>

    <div class="panel panel-default"> 
        <div class="panel-heading"><h6 id="cabecera"><?php ECHO $TituloPantalla; /*Incluir modal nvo*/?></h6></div> 
        <div class="panel-body"> 

            <form id="formulario" method="POST" class="form-inline">
              <div class="form-group">
                  <label for="inputFechaIni" >Mecanico:</label>
                  <?php echo CmbCualquieras('Cve_Empleado','Nombre','nomempleados'); ?>
              </div>
              <div class="form-group">
                <?php echo TxtDateRango() ?>
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
         $("form").on('submit', function (e) {
             e.preventDefault();
             $('#CargaGif').show();
             $('#btnEnviar').attr('disabled', 'disabled')
             $.ajax({
                   type: "POST",
                   url: 'tabla-admcommecanicos.php',
                   data: $("form").serialize(), // Adjuntar los campos del formulario enviado.
                   success: function(data){
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
        
        $('select#Cmbnomempleados').on('change', function() {
            var id = $('#Cmbnomempleados').val();
            var name = $('#Cmbnomempleados option:selected').html();
            $("#title").html("Reporte comision - MECANICO " + id + " - " + name);
            $("#cabecera").html("Reporte comision - MECANICO " + id + " - " + name);
        });
    });

</script>

</html>