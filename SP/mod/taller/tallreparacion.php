<?php include("validasesion.php"); ?>
<!DOCTYPE html>
<html class="no-js">

<?php include("../../funciones.php"); ?>
<?php echo Cabecera('Maquinaria en reparacion'); ?>
<?php
    $TituloPantalla = 'Maquinaria en reparacion';  
	//$Arreglo = array("Nombre","Saldo");
	//echo PasaArreglo($Arreglo);
?>

    <body>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h6 id="cabecera">
                    <?php echo $TituloPantalla; /*Incluir modal nvo*/?>
                </h6>
            </div>
            <div class="panel-body">
                <form id="formulario" method="POST" class="form-inline">
                    <input type="hidden" id="TxtClave" name="TxtClave">
                    <button type="submit" id="btnEnviar" class="btn btn-primary btn-sm" onMouseOver=""><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Consultar</button>
                </form>
                <div class="respuesta"></div>                 
                <div class="vtasdetalles"></div>

                <span id="TotalFac"></span>
                <div class="vtasfacturas"></div>
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
                    url: 'tabla-tallreparacion.php',
                    data: $("form").serialize(), // Adjuntar los campos del formulario enviado.
                    success: function(data) {
						$('#CargaGif').hide();
                        $('#btnEnviar').removeAttr('disabled');
                        $(".respuesta").html(data); // Mostrar la respuestas del script PHP.
                        $(".respuesta").show();
                        $('#grid').DataTable().draw();
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
        
        $(document).on('click','a.VincProd',function(){
            var id = $(this).attr("id");
            $("#TxtClave").val(id);
            $('#CargaGif').show();
            $.ajax({
                type: "POST",
                url: 'tabla-tallreparacion.php',
                data: $("form").serialize(), // Adjuntar los campos del formulario enviado.
                success: function(data) {
                    //$('#btnEnviar').removeAttr('disabled');
                    $('#CargaGif').hide();
                    $("#DivMdlMaqDet").html(data); // Mostrar la respuestas del script PHP.
                    $("#DivMdlMaqDet").show();
                    $('#MdlMaqDet').modal('show')
                },
                error: function(error) {
                    $('#CargaGif').hide();
                    console.log(error);
                    alert('Algo salio mal :S');
                }
            });
            return false; // Evitar ejecutar el submit del formulario.	
        }); 
        
        $(document).on('dblclick','tr.maquinaria',function(){
            var id = $(this).attr("id");
            $("#TxtClave").val(id);
            $('#CargaGif').show();
            $.ajax({
                type: "POST",
                url: 'tabla-tallreparaciondet.php',
                data: $("form").serialize(), // Adjuntar los campos del formulario enviado.
                success: function(data) {
                    //$('#btnEnviar').removeAttr('disabled');
                    $('#CargaGif').hide();
                    $("#DivMdlMaqDet").html(data); // Mostrar la respuestas del script PHP.
                    $("#DivMdlMaqDet").show();
                    $('#MdlMaqDet').modal('show')
                },
                error: function(error) {
                    $('#CargaGif').hide();
                    console.log(error);
                    alert('Algo salio mal :S');
                }
            });
            return false; // Evitar ejecutar el submit del formulario.	
        });
    </script>

</html>
