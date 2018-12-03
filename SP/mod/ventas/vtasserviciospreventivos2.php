<?php include("validasesion.php"); ?>
<!DOCTYPE html>
<html class="no-js">

<?php include("../../funciones.php"); ?>
<?php echo Cabecera('Ventas serivicios preventivos'); ?>
<?php
    $TituloPantalla = 'Ventas serivicios preventivos';    
?>
<body>

    <div class="panel panel-default"> 
        <div class="panel-heading"><h6 id="cabecera"><?php ECHO $TituloPantalla; /*Incluir modal nvo*/?></h6></div> 
        <div class="panel-body"> 

            <form id="formulario" method="POST" class="form-inline">
              <div class="form-group">
                  <label for="inputFechaIni" class="form-control">Empresa:</label>
                  <select id="CmbEmpresa" name="CmbEmpresa" class="form-control">
                      <option>TAYCOSA</option>
                  </select>
              </div>
              <div class="form-group">
                <label for="inputFechaIni">De:</label>
                <input type="date"  name="Fini" id="Fini" value="<?php echo date("Y"."-"."m"."-"."01");?>" class="form-control" placeholder="Rango Fecha Inicial"/>
              </div>
              <div class="form-group">
                <label for="inputFechaFin">A:</label>
                <input type="date" name="Ffin" id="Ffin" value="<?php echo date("Y-m-d");?>" class="form-control" placeholder="Rango Fecha Final" >
              </div>
              <button type="submit" id="btnEnviar" class="btn btn-primary btn-sm" onMouseOver="">Consultar</button>
            </form>
            <div class="respuesta"></div>
        </div>
    </div>
</body>

<?php echo Script(); ?>
    
<script type="text/javascript"> 

    $(function () {
         $("form").on('submit', function (e) {
             e.preventDefault();
             $('#btnEnviar').attr('disabled', 'disabled')
             $.ajax({
                   type: "POST",
                   url: 'vtasserviciospreventivos-tabla.php',
                   data: $("form").serialize(), // Adjuntar los campos del formulario enviado.
                   success: function(data)
                   {
                       $('#btnEnviar').removeAttr('disabled');
                       $(".respuesta").html(data); // Mostrar la respuestas del script PHP.
                   },
                    error: function(error) {
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