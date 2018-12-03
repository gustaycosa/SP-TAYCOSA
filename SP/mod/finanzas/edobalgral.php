<?php include("validasesion.php"); ?>
<!DOCTYPE html>
<html class="no-js">

<?php include("../../funciones.php"); ?>
<?php echo Cabecera('Reporte de edos. balance general'); ?>
<?php
    $TituloPantalla = 'Reporte de edos. balance general';    
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

                    <button type="submit" id="btnEnviar" class="btn btn-primary btn-sm" onMouseOver=""><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Consultar</button>
                    
                    <button id="BtnAnaCli" class="btn btn-primary" type="button" data-toggle="modal" data-target="#MdlAntCli">
                        Clientes
                    </button>
                    <button id="BtnAnaDeu" class="btn btn-primary" type="button" data-toggle="modal" data-target="#MdlAnaDeu">
                        Deudores
                    </button>
                    <button id="BtnAnaAnt" class="btn btn-primary" type="button" data-toggle="modal" data-target="#MdlAnaAnt">
                        Anticipos
                    </button>
                    <button id="BtnAnaAcr" class="btn btn-primary" type="button" data-toggle="modal" data-target="#MdlAnaAcr">
                        Acreedores
                    </button>
                    <button id="BtnAnaPro" class="btn btn-primary" type="button" data-toggle="modal" data-target="#MdlAnaPro">
                        Proveedores
                    </button>
                    
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

            <?php echo MdlSearch('MdlAntCli','Clientes');?>
            <?php echo MdlSearch('MdlAnaAnt','Anticipos clientes');?>
            <?php echo MdlSearch('MdlAnaDeu','Deudores diversos');?>
            <?php echo MdlSearch('MdlAnaAcr','Acreedores diversos');?>
            <?php echo MdlSearch('MdlAnaPro','Proveedores');?>

            </div>
    </body>

    <?php echo Script(); ?>

    <script type="text/javascript">
        var timer = 0;
        $(function() {        
            <?php echo JqueryButtons();?>
            $('#BtnAnaCli').click(function() {
                //$('#btnEnviar').attr('disabled', 'disabled')
                $('#CargaGif').show();
                $.ajax({
                    type: "POST",
                    url: 'TablaAnaCli.php',
                    data: $("form").serialize(), // Adjuntar los campos del formulario enviado.
                    success: function(data) {
                        //$('#btnEnviar').removeAttr('disabled');
                        $('#CargaGif').hide();
                        $("#DivMdlAntCli").html(data); // Mostrar la respuestas del script PHP.
                        $("#DivMdlAntCli").show();
                        $('#MdlAntCli').modal('show');
                        $('#gridcli').DataTable().draw();
                    },
                    error: function(error) {
                        $('#CargaGif').hide();
                        console.log(error);
                        alert('Algo salio mal :S');
                    }
                });
                return false; // Evitar ejecutar el submit del formulario.
            });
            
            $('#BtnAnaDeu').click(function() {
                //$('#btnEnviar').attr('disabled', 'disabled')
                $('#CargaGif').show();
                $.ajax({
                    type: "POST",
                    url: 'TablaAnaDeu.php',
                    data: $("form").serialize(), // Adjuntar los campos del formulario enviado.
                    success: function(data) {
                        //$('#btnEnviar').removeAttr('disabled');
                        $('#CargaGif').hide();
                        $("#DivMdlAnaDeu").html(data); // Mostrar la respuestas del script PHP.
                        $("#DivMdlAnaDeu").show();
                        $('#MdlAnaDeu').modal('show');
                        $('#griddeu').DataTable().draw();
                    },
                    error: function(error) {
                        $('#CargaGif').hide();
                        console.log(error);
                        alert('Algo salio mal :S');
                    }
                });
                return false; // Evitar ejecutar el submit del formulario.
            });
            
            $('#BtnAnaPro').click(function() {
                //$('#btnEnviar').attr('disabled', 'disabled')
                $('#CargaGif').show();
                $.ajax({
                    type: "POST",
                    url: 'TablaAnaPro.php',
                    data: $("form").serialize(), // Adjuntar los campos del formulario enviado.
                    success: function(data) {
                        //$('#btnEnviar').removeAttr('disabled');
                        $('#CargaGif').hide();
                        $("#DivMdlAnaPro").html(data); // Mostrar la respuestas del script PHP.
                        $("#DivMdlAnaPro").show();
                        $('#MdlAnaPro').modal('show');
                        $('#gridpro').DataTable().draw();
                    },
                    error: function(error) {
                        $('#CargaGif').hide();
                        console.log(error);
                        alert('Algo salio mal :S');
                    }
                });
                return false; // Evitar ejecutar el submit del formulario.
            });
            
            $('#BtnAnaAnt').click(function() {
                //$('#btnEnviar').attr('disabled', 'disabled')
                $('#CargaGif').show();
                $.ajax({
                    type: "POST",
                    url: 'TablaAnaAnt.php',
                    data: $("form").serialize(), // Adjuntar los campos del formulario enviado.
                    success: function(data) {
                        //$('#btnEnviar').removeAttr('disabled');
                        $('#CargaGif').hide();
                        $("#DivMdlAnaAnt").html(data); // Mostrar la respuestas del script PHP.
                        $("#DivMdlAnaAnt").show();
                        $('#MdlAnaAnt').modal('show');
                        $('#gridant').DataTable().draw();
                    },
                    error: function(error) {
                        $('#CargaGif').hide();
                        console.log(error);
                        alert('Algo salio mal :S');
                    }
                });
                return false; // Evitar ejecutar el submit del formulario.
            });

            $('#BtnAnaAcr').click(function() {
                //$('#btnEnviar').attr('disabled', 'disabled')
                $('#CargaGif').show();
                $.ajax({
                    type: "POST",
                    url: 'TablaAnaAcr.php',
                    data: $("form").serialize(), // Adjuntar los campos del formulario enviado.
                    success: function(data) {
                        //$('#btnEnviar').removeAttr('disabled');
                        $('#CargaGif').hide();
                        $("#DivMdlAnaAcr").html(data); // Mostrar la respuestas del script PHP.
                        $("#DivMdlAnaAcr").show();
                        $('#MdlAnaAcr').modal('show');
                        $('#gridacr').DataTable().draw();
                    },
                    error: function(error) {
                        $('#CargaGif').hide();
                        console.log(error);
                        alert('Algo salio mal :S');
                    }
                });
                return false; // Evitar ejecutar el submit del formulario.
            });
            
            $("form").on('submit', function(e) {
                e.preventDefault();
                $('#CargaGif').show();
                $('#btnEnviar').attr('disabled', 'disabled')
                $.ajax({
                    type: "POST",
                    url: 'tabla-edobalgral.php',
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
                    url: 'tabla-edobalgral2.php',
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
        
        $('tr').click(function() {
//            var id = $(this).attr("data-id");
//            var name = $(this).attr("data-name");
//            $("#TxtCliente").val(id);
//            $("#title").html("Reporte cliente - " + id + " " + name);
//            $("#cabecera").html("Reporte cliente - " + id + " " + name);
//            $('#myModal').modal('hide');
              $('#grid').DataTable().draw();
        });

    </script>
</html>
