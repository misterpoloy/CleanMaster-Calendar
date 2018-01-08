<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="Calaps.com">
    <link rel="icon" href="../../favicon.ico">

	<title>Cleanmaster.com Calendar</title>

    <script src="https://www.gstatic.com/firebasejs/3.3.0/firebase.js"></script>
    <script>
      // Initialize Firebase
      var config = {
        apiKey: "AIzaSyDN9HGLIAnGUvTFO-5a3YUfEDUR2X4tWyw",
        authDomain: "clean-master-calendar.firebaseapp.com",
        databaseURL: "https://clean-master-calendar.firebaseio.com",
        storageBucket: "",
      };
      firebase.initializeApp(config);
    </script>

	<!-- ********* CSS ******** -->
	<!-- Boostrap -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<!-- Boostrap Table -->
  <link rel="stylesheet" href="assets/css/bootstrap-table.css">
  <!-- calaps -->
	<link rel='stylesheet' type='text/css' href='assets/css/calaps.css'>
  <!-- offline -->
	<link rel='stylesheet' type='text/css' href='assets/css/offline-theme-default.css'>
   <!-- offline Spanish -->
	<link rel='stylesheet' type='text/css' href='assets/css/offline-language-spanish.css'>


    <!-- ********* JS ********** -->
	<!-- Calaps Firebase -->
	<script src="assets/js/calaps_firebase.js" type="text/javascript" charset="utf-8"></script>
	<!-- jQuery -->
	<script src="http://code.jquery.com/jquery-2.2.4.min.js" type="text/javascript" charset="utf-8"></script>
	<!-- Boostrap -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <!-- OffLine -->
	<script src="assets/js/offline.js" type="text/javascript" charset="utf-8"></script>
    <!-- Simpulate 00 -->
	<script src="assets/js/jquery.simulate.js" type="text/javascript" charset="utf-8"></script>

	<link rel='stylesheet' type='text/css' href='assets/css/clean_master_colors.css'><!--Colores especificos de CleanMaster -->

    <!-- Date Picker -->
	<link rel='stylesheet' type='text/css' href='assets/css/bootstrap-datepicker.min.css'>
    <script src="assets/js/bootstrap-datepicker.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="assets/locales/bootstrap-datepicker.es.min.js" type="text/javascript" charset="utf-8"></script>
    <!-- Date Picker -->
    <!-- Export table -->
    <script src="assets/js/extensions/export/bootstrap-table-export.js"></script> 
    <script src="//rawgit.com/hhurz/tableExport.jquery.plugin/master/tableExport.js"></script>
    <!-- Export table -->

    <script type="text/javascript">

        $(document).ready(function(){

            firebase.database().ref('/emails_page/').once('value').then(function(snapshot) {

                var emails = snapshot.val();
                var tr;
                var ammount = 0;

                for (x in emails) {
                        tr = $('<tr>');//Inicio de tabla
                            tr.append("<td>" + emails[x].name + "</td>");
                            tr.append("<td>" + emails[x].email + "</td>");
                            tr.append("<td>" + emails[x].cel + "</td>");
                        tr.append("</tr>"); //Fin de tabla
                       
                       $('#tableData').append(tr); //Agrega el contenido
                       ammount++;
                }

                console.log("Total de correos: " +  ammount);

                     //Despues de cargar el contenido instancia la tabla
                    $.getScript( "assets/js/bootstrap-table.js", function( data, textStatus, jqxhr ) {
                    $(".spinner").hide();
                    $("#pshow").show();
                    $(".no-records-found").hide(); //Oculta el error de carga
                    });


            });

        });
    </script>

</head>

<body onload="settings();">

        <!-- Spinner Load -->
		<div class="spinner">
		<div class="double-bounce1"></div>
		<div class="double-bounce2"></div>
		</div>
		<!-- End Spinner -->

    <?php require_once("assets/layout/header_menu.php"); ?>


        <div id="add_personal" class="content-div">
                <h3 class="titlePage">Datos de contacto de cliente <img class="icon2" src="images/icons/mail.png"></h3>

                     <div id="toolbar">
                        <select class="form-control">
                            <option value="">Exporte básico</option>
                        </select>
                    </div>

                    <table data-show-export="true"
                     data-toggle="table"  
                     data-height="499" 
                     data-pagination="true" 
                     data-toolbar="#toolbar">
                        
                        <thead>
                        <tr>
                            <th data-field="name" data-sortable="true">Nombre</th>
                            <th data-field="email" data-sortable="false">Correo</th>
                            <th data-field="cel" data-sortable="false">Celular</th>
                        </tr>
                        </thead>

                        <!-- Contenido de tabla -->
                        <tbody id="tableData">
                        
                        </tbody>
                </table>
        </div>

        <!-- MODALS --> 
	    <?php require_once("assets/layout/modals.php"); ?>
	    <!-- MODALS -->
        
        <?php require_once("assets/layout/footer.php"); ?>
        
        <script>
            var $table = $('#table');
            $(function () {
                $('#toolbar').find('select').change(function () {
                    $table.bootstrapTable('destroy').bootstrapTable({
                        exportDataType: $(this).val()
                    });
                });
            })
        </script>

</body>
</html>