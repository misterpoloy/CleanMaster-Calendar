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

      var database = firebase.database();
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

    <script type="text/javascript">

        $(document).ready(function(){
            console.log("Inicio del inicio");

            firebase.database().ref('/history/').once('value').then(function(snapshot) {
                console.log("Comeinza Firebase");
                var history = snapshot.val();
                var x;
                var y;
                var tr;
                var versions;
                var vesions_count;
                var versiones_append = "";
                var current_id_history;

                var current_event = new Object;

                for (x in history) {
                    console.log("Comeinza FOR");
                        versiones_append = "";
                        
                        try {
                            console.log("TRY THE LOOP" + x);
                            current_id_history = history[x]["event"]["id"];//Almacena el ID (Despues sirve para saber las versiones de que ID cargar)
                            current_event["id"] = current_id_history;
                            current_event["subject"] = history[x]["event"]["subject"]
                            current_event["text"] = history[x]["event"]["text"];
                            current_event["created_date"] = history[x]["event"]["created_date"];
                            current_event["created_by"] = history[x]["event"]["created_by"];
                            current_event["status"] = history[x]["status"]["status"]
                        }
                        catch(err) {
                            console.warn("Objetos obsoletos en Firebase");
                            
                            current_id_history = 000;
                            current_event["id"] = current_id_history;
                            current_event["subject"] = "no_data";
                            current_event["text"] = "Sin original";
                            current_event["created_date"] = "No hay datos";
                            current_event["created_by"] = "No hay datos";
                            current_event["status"] = "No hay datos";
                        }
                        if(current_id_history > 0 && current_id_history.toString().length < 6 ) {

                        tr = $('<tr>');
                        tr.append("<td>" + current_event.id + "</td>"); // ID
                        tr.append("<td class='dhx_cal_event_line event_" + current_event.subject + "'><a href='#' onClick='history_modal("+ current_event.id +");'>" + current_event.text + "</a></td>"); // Titulo
                        tr.append("<td>" + current_event.created_date + "</td>"); // Date
                        tr.append("<td>" + current_event.created_by + "</td>"); // Created By

                        versions = history[x]["version"];
                        
                    // ------ Comienza la columna que abarca los resultados 
                        vesions_count = 0; //Resete el historial de cambios para cada evento

                        if(versions !== undefined) {
                            //Queremos saber cuantas versiones tiene:
                            //vesions_count = Object.keys(versions).length;

                            for (y in versions) {
                                //Loop de Historial de versiones
                                vesions_count++; //Comienza en 1

                                versiones_append = versiones_append + "<a href='#' onClick='version_modal(" + current_id_history + ", \""+ y +"\")'> V" + vesions_count + ". </a>";
                                //console.log(versions[y]);
                            }

                        } else {
                            //No ha sido editado
                            //Versiones
                            versiones_append = "No ha sido editado";
                        }
                        tr.append("<td>" + versiones_append + "</td>"); // Versiones

                        // ------ Comienza la columna que abarca los resultados 
                        
                        
                        //Estado actual
                        if(current_event.status == "deleted") {
                            tr.append("<td class='log_deleted'> Eliminado por: " + history[x]["status"]["deleted_by"] +"</td>");
                        } else {
                            tr.append("<td class='log_active'> Activo </td>");
                        }

                        tr.append("</tr>");
                        }
                        $('#tableData').append(tr); 

                }   //Despues de cargar el contenido instancia la tabla
                    $.getScript( "assets/js/bootstrap-table.js", function( data, textStatus, jqxhr ) {

                    $(".spinner").hide();
                    $("#pshow").show();
                                  
                    });

            });

        });
    </script>

	<style type="text/css" media="screen">
       html, body {
		margin: 0px;
		height: 100%;
		min-height: 100%;
        overflow: scroll;
		}
         a {
            color: #00b1e9;
            text-decoration: none;
        }
        .log_active {
            background: #e4ffe4;
        }
        .log_deleted {
            background: #ffe4e4;
        }
        .dhx_cal_event_line a {
			color:white;
		}
        .event_modal {
            width: 170px;
            padding: 7px;
            margin-right: 10px;
            color: #747473;
        }
        .modal-body {
            /* padding: 25px; */
            max-height: calc(100vh - 270px);
            overflow-y: auto;
        }
        .date_controls {
            text-align: center;
            margin-top: 26px;       
        }
        .spanNo {
            padding-right: 0px;
            padding-left: 0px;
            margin-top: 20px !important;
            width: 50%;
            margin:auto;
            text-align: center;
        }
        .dateb {
            background-color: #ffffff;
            border-color: #b9b9b9;
            color: #909090;
            margin-top: 6px;
            height: 42px;
            width: 100%;
        }
        .nopadding {
                padding-right: 5px;
                padding-left: 5px;
        }
        .veditado {
                background: #ffeda8;
                padding: 4px;
                -webkit-border-radius: 5px;
                -moz-border-radius: 5px;
                border-radius: 5px;
        }
        .vagregado {
                background: #a9ffa8;
                padding: 4px;
                -webkit-border-radius: 5px;
                -moz-border-radius: 5px;
                border-radius: 5px;
        }
        .vdeleted {
                background: #ff9898;
                padding: 4px;
                -webkit-border-radius: 5px;
                -moz-border-radius: 5px;
                border-radius: 5px;
        }
        		/** LIGHTBOX CELULAR **/
		@media (max-width: 980px) {
            .pull-right, .search {
                width: 100%;
            }
            .titlePage {
                margin-top: 35px;
            }
            .icon2 {
                margin-top: 0px;
            }
            .navbar-collapse {
                width: 100%;
                margin-bottom: 30px;
            }
            .spanNo {
            margin-top: 20px;
            width: 100%;
            }
		}
		@media (max-width: 330px) {
            .icon2 {
                margin-top: 25px;
            }
		}
	</style>

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
                <h3 class="titlePage">Historial de cambios de eventos<img class="icon2" src="images/icons/change.png"></h3>

            
                <div class="row spanNo" id="sandbox-container">
                     <div class="col-md-8 nopadding"><input type="text" placeholder="Ingresa la fecha a consultar" class="form-control"></div>
                     <div class="col-md-2 nopadding"><button type="button" id="fecha_hoy" class="btn btn-default dateb">Hoy</button></div>
                     <div class="col-md-2 nopadding"><button type="button" id="fecha_todos" class="btn btn-default dateb">Todos</button></div>
                </div>
           

                    <table data-show-export="true" data-toggle="table"  data-height="499" data-search="true" data-pagination="true" data-sort-name="id" data-sort-order="desc">
                        <thead>
                        <tr>
                            <th data-field="id" data-sortable="true">ID</th>
                            <th data-field="name" data-sortable="false">Evento original</th>
                            <th data-field="date" data-sortable="true">Fecha de evento</th>
                            <th data-field="autor" data-sortable="true">Autor original</th>
                            <th data-field="history" data-sortable="false">Historial de cambios</th>
                            <th data-field="status" data-sortable="false">Estado</th>
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

		$('#sandbox-container input').datepicker({
            format: "mm/dd/yyyy",
			language: "es"
		});

   //---------- Funcion para la fecha     
                function formattedDate(date) {
						var d = new Date(date || Date.now()),
							month = '' + (d.getMonth() + 1),
							day = '' + d.getDate(),
							year = d.getFullYear();

						if (month.length < 2) month = '0' + month;
						if (day.length < 2) day = '0' + day;

						return [month, day, year].join('/');
					}

                    
    e = jQuery.Event("keypress")
    e.which = 13 //choose the one you want

    $( "#fecha_hoy" ).click(function() {
    //Funciones para el #filtro
           var DateToday = formattedDate();
           $( '.pull-right.search input' ).val(DateToday);
            $( '.pull-right.search input' ).focus();
            $( '.pull-right.search input' ).simulate("keyup", "49");
           
    });

    $( "#fecha_todos" ).click(function() {
    //Funciones para el #filtro
           $( '.pull-right.search input' ).val(" ");
           $( '.pull-right.search input' ).focus();
           $( '.pull-right.search input' ).simulate("keyup", "49");
           
    });

    $('#sandbox-container input').change(function() {
           $( '.pull-right.search input' ).val($('#sandbox-container input').val());
           $( '.pull-right.search input' ).focus();
           $( '.pull-right.search input' ).simulate("keyup", "49");
    });


    //---------- END Funcion para la fecha     

    // Carga original
    function history_modal(id) {
        //Set Default Values
         $('#history_modal').modal('toggle');
         reset_fields();
           
        //Carga datos con ID
        return firebase.database().ref('/history/' + id + '/event').once('value').then(function(snapshot) {

            var event_unidad = unitToString(snapshot.val().type_id);

        
            $("#event_text").text(snapshot.val().text);
            $("#event_address").text(snapshot.val().address);
            $("#event_phone").text(snapshot.val().phone);
            $("#event_email").text(snapshot.val().email);
            $("#event_service").text(snapshot.val().subject); //OJO
            $("#event_description").text(snapshot.val().description);
            $("#event_time_start").text(snapshot.val().start_dates);
            $("#event_time_end").text(snapshot.val().end_dates);
            $("#event_comment").text(snapshot.val().comment);
            $("#event_sales").text(snapshot.val().sold_by);
            $("#event_personal").text(snapshot.val().personal);
            $("#event_unit").text(event_unidad);
            $("#event_created_by").text(snapshot.val().created_by);
            $("#event_edited_by").text(snapshot.val().edited_by);

            //Si era un evento antigup
            if(snapshot.val().creation_date == null) {
                $("#event_creation_date").text(snapshot.val().created_date);
            } else {
                $("#event_creation_date").text(snapshot.val().creation_date);
            }

            $("#event_howto").text(snapshot.val().howto); //Nuevo 1
            $("#event_cot_bool").text(snapshot.val().cot_bool); //Nuevo 2
            $("#event_ficha_bool").text(snapshot.val().ficha_bool); //Nuevo 3
            $("#event_payment_method").text(snapshot.val().payment_method); //Nuevo 4
            $("#event_facturanombre").text(snapshot.val().facturanombre); //Nuevo 5
            $("#event_cost").text(snapshot.val().cost); //Nuevo 6
            $("#event_nit").text(snapshot.val().nit); //Nuevo 7
            $("#event_apar_bool").text(snapshot.val().apar_bool); //Nuevo 8
        
        });


    }

    // Carga Versiones
    function version_modal(eventId, id) {
        //Set Default Values
         $('#history_modal').modal('toggle');
         reset_fields();

        //Carga primero el Original
        return firebase.database().ref('/history/' + eventId + '/event/').once('value').then(function(result) {

            var text_original = result.val().text;
            var address_original = result.val().address;
            var phone_original = result.val().phone;
            var email_original = result.val().email;
            var service_original = result.val().subject;
            var description_original = result.val().description;
            var time_start_original = result.val().start_dates;
            var time_end_original = result.val().end_dates;
            var comment_original = result.val().comment;
            var sales_original = result.val().sold_by;
            var personal_original = result.val().personal;
            var unit_original = unitToString(result.val().type_id);
            var created_by_original = result.val().created_by;
            var edited_by_original = result.val().edited_by;
            var creation_date_original = result.val().creation_date;
            var howto_original = result.val().howto;
            var cot_bool_original = result.val().cot_bool;
            var ficha_bool_original = result.val().ficha_bool;
            var payment_method_original = result.val().payment_method;
            var facturanombre_original = result.val().facturanombre;
            var cost_original = result.val().cost;
            var nit_original = result.val().nit;
            var apar_bool_original = result.val().apar_bool;

            //Carga datos con ID
            return firebase.database().ref('/history/' + eventId + '/version/' + id).once('value').then(function(snapshot) {

            var text_version = snapshot.val().text;
            var address_version = snapshot.val().address;
            var phone_version = snapshot.val().phone;
            var email_version = snapshot.val().email;
            var service_version = snapshot.val().subject;
            var description_version = snapshot.val().description;
            var time_start_version = snapshot.val().start_dates;
            var time_end_version = snapshot.val().end_dates;
            var comment_version = snapshot.val().comment;
            var sales_version = snapshot.val().sold_by;
            var personal_version = snapshot.val().personal;
            var unit_version = unitToString(snapshot.val().type_id);
            var created_by_version = snapshot.val().created_by;
            var edited_by_version = snapshot.val().edited_by;
            var creation_date_version = snapshot.val().creation_date;
            var howto_version = snapshot.val().howto;
            var cot_bool_version = snapshot.val().cot_bool;
            var ficha_bool_version = snapshot.val().ficha_bool;
            var payment_method_version = snapshot.val().payment_method;
            var facturanombre_version = snapshot.val().facturanombre;
            var cost_version = snapshot.val().cost;
            var nit_version = snapshot.val().nit;
            var apar_bool_version = snapshot.val().apar_bool;

            var event_unidad = unitToString(snapshot.val().type_id);
            
            // ------------------------ text ----------------------------------
            if(text_original !== text_version){
                if(text_original == "" && text_version.length > 0 ){
                        $("#event_text").addClass( "vagregado" ); // #Agregado
                        $("#event_text").text(snapshot.val().text);
                    } else if (text_original.length > 0 && text_version == "" ){
                        $("#event_text").addClass( "vdeleted" ); // #Eliminado
                        $("#event_text").text("Eliminado");
                    } else { 
                        $("#event_text").addClass( "veditado" ); // #Editado
                        $("#event_text").text(snapshot.val().text);
                    }
            } else { $("#event_text").text(snapshot.val().text); } // #Es igual

            // ------------------------ address ----------------------------------
            if(address_original !== address_version){
                if(address_original == "" && address_version.length > 0 ){
                        $("#event_address").addClass( "vagregado" ); // #Agregado
                        $("#event_address").text(snapshot.val().address);
                    } else if (address_original.length > 0 && address_version == "" ){
                        $("#event_address").addClass( "vdeleted" ); // #Eliminado
                        $("#event_address").text("Eliminado");
                    } else { 
                        $("#event_address").addClass( "veditado" ); // #Editado
                        $("#event_address").text(snapshot.val().address);
                    }
            } else { $("#event_address").text(snapshot.val().address); } // #Es igual
            // --------------------------- phone ------------------------------
            if(phone_original !== phone_version){
                if(phone_original == "" && phone_version.length > 0 ){
                        $("#event_phone").addClass( "vagregado" ); // #Agregado
                        $("#event_phone").text(snapshot.val().phone);
                    } else if (phone_original.length > 0 && phone_version == "" ){
                        $("#event_phone").addClass( "vdeleted" ); // #Eliminado
                        $("#event_phone").text("Eliminado");
                    } else { 
                        $("#event_phone").addClass( "veditado" ); // #Editado
                        $("#event_phone").text(snapshot.val().phone);
                    }
            } else { $("#event_phone").text(snapshot.val().phone); } // #Es igual

            // ------------------------ email ----------------------------------
            if(email_original !== email_version){
                if(email_original == "" && email_version.length > 0 ){
                        $("#event_email").addClass( "vagregado" ); // #Agregado
                        $("#event_email").text(snapshot.val().email);
                    } else if (email_original.length > 0 && email_version == "" ){
                        $("#event_email").addClass( "vdeleted" ); // #Eliminado
                        $("#event_email").text("Eliminado");
                    } else { 
                        $("#event_email").addClass( "veditado" ); // #Editado
                        $("#event_email").text(snapshot.val().email);
                    }
            } else { $("#event_email").text(snapshot.val().email); } // #Es igual

            // ------------------------ service ----------------------------------
            if(service_original !== service_version){
                if(service_original == "" && service_version.length > 0 ){
                        $("#event_service").addClass( "vagregado" ); // #Agregado
                        $("#event_service").text(snapshot.val().subject);
                    } else if (service_original.length > 0 && service_version == "" ){
                        $("#event_service").addClass( "vdeleted" ); // #Eliminado
                        $("#event_service").text("Eliminado");
                    } else { 
                        $("#event_service").addClass( "veditado" ); // #Editado
                        $("#event_service").text(snapshot.val().subject);
                    }
            } else { $("#event_service").text(snapshot.val().subject); } // #Es igual

            // ------------------------ description ----------------------------------
            if(description_original !== description_version){
                if(description_original == "" && description_version.length > 0 ){
                        $("#event_description").addClass( "vagregado" ); // #Agregado
                        $("#event_description").text(snapshot.val().description);
                    } else if (description_original.length > 0 && description_version == "" ){
                        $("#event_description").addClass( "vdeleted" ); // #Eliminado
                        $("#event_description").text("Eliminado");
                    } else { 
                        $("#event_description").addClass( "veditado" ); // #Editado
                        $("#event_description").text(snapshot.val().description);
                    }
            } else  { $("#event_description").text(snapshot.val().description); } // #Es igual

            // ------------------------ time_start ----------------------------------
            if(time_start_original !== time_start_version){
                if(time_start_original == "" && time_start_version.length > 0 ){
                        $("#event_time_start").addClass( "vagregado" ); // #Agregado
                        $("#event_time_start").text(snapshot.val().start_dates);
                    } else if (time_start_original.length > 0 && time_start_version == "" ){
                        $("#event_time_start").addClass( "vdeleted" ); // #Eliminado
                        $("#event_time_start").text("Eliminado");
                    } else { 
                        $("#event_time_start").addClass( "veditado" ); // #Editado
                        $("#event_time_start").text(snapshot.val().start_dates);
                    }
            } else { $("#event_time_start").text(snapshot.val().start_dates); } // #Es igual

            // ------------------------ time_end ----------------------------------
            if(time_end_original !== time_end_version){
                if(time_end_original == "" && time_end_version.length > 0 ){
                        $("#event_time_end").addClass( "vagregado" ); // #Agregado
                        $("#event_time_end").text(snapshot.val().end_dates);
                    } else if (time_end_original.length > 0 && time_end_version == "" ){
                        $("#event_time_end").addClass( "vdeleted" ); // #Eliminado
                        $("#event_time_end").text("Eliminado");
                    } else { 
                        $("#event_time_end").addClass( "veditado" ); // #Editado
                        $("#event_time_end").text(snapshot.val().end_dates);
                    }
            } else { $("#event_time_end").text(snapshot.val().end_dates); } // #Es igual

            // ------------------------ comment ----------------------------------
            if(comment_original !== comment_version){
                if(comment_original == "" && comment_version.length > 0 ){
                        $("#event_comment").addClass( "vagregado" ); // #Agregado
                        $("#event_comment").text(snapshot.val().comment);
                    } else if (comment_original.length > 0 && comment_version == "" ){
                        $("#event_comment").addClass( "vdeleted" ); // #Eliminado
                        $("#event_comment").text("Eliminado");
                    } else { 
                        $("#event_comment").addClass( "veditado" ); // #Editado
                        $("#event_comment").text(snapshot.val().comment);
                    }
            } else { $("#event_comment").text(snapshot.val().comment); } // #Es igual

            // ------------------------ sales ----------------------------------
            if(sales_original !== sales_version){
                if(sales_original == "" && sales_version.length > 0 ){
                        $("#event_sales").addClass( "vagregado" ); // #Agregado
                        $("#event_sales").text(snapshot.val().sold_by);
                    } else if (sales_original.length > 0 && sales_version == "" ){
                        $("#event_sales").addClass( "vdeleted" ); // #Eliminado
                        $("#event_sales").text("Eliminado");
                    } else { 
                        $("#event_sales").addClass( "veditado" ); // #Editado
                        $("#event_sales").text(snapshot.val().sold_by);
                    }
            } else { $("#event_sales").text(snapshot.val().sold_by); } // #Es igual

                // ------------------------ personal ----------------------------------
            if(personal_original !== personal_version){

                if(personal_original == "" && personal_version.length > 0 ){
                        $("#event_personal").addClass( "vagregado" ); // #Agregado
                        $("#event_personal").text(snapshot.val().personal);
                    } else if (personal_original.length > 0 && personal_version == "" ){
                        $("#event_personal").addClass( "vdeleted" ); // #Eliminado
                        $("#event_personal").text("Eliminado");
                    } else { 
                        $("#event_personal").addClass( "veditado" ); // #Editado
                        $("#event_personal").text(snapshot.val().personal);
                    }
            } else { $("#event_personal").text(snapshot.val().personal); } // #Es igual

                // ------------------------ unit ----------------------------------
            if(unit_original !== unit_version){
                if(unit_original == "" && unit_version.length > 0 ){
                        $("#event_unit").addClass( "vagregado" ); // #Agregado
                        $("#event_unit").text(event_unidad);
                    } else if (unit_original.length > 0 && unit_version == "" ){
                        $("#event_unit").addClass( "vdeleted" ); // #Eliminado
                        $("#event_unit").text("Eliminado");
                    } else { 
                        $("#event_unit").addClass( "veditado" ); // #Editado
                        $("#event_unit").text(event_unidad);
                    }
            } else { $("#event_unit").text(event_unidad); } // #Es igual

            // ------------------------ created_by ----------------------------------
            if(created_by_original !== created_by_version){
                if(created_by_original == "" && created_by_version.length > 0 ){
                        $("#event_created_by").addClass( "vagregado" ); // #Agregado
                        $("#event_created_by").text(snapshot.val().created_by);
                    } else if (created_by_original.length > 0 && created_by_version == "" ){
                        $("#event_created_by").addClass( "vdeleted" ); // #Eliminado
                        $("#event_created_by").text("Eliminado");
                    } else { 
                        $("#event_created_by").addClass( "veditado" ); // #Editado
                        $("#event_created_by").text(snapshot.val().created_by);
                    }
            } else { $("#event_created_by").text(snapshot.val().created_by); } // #Es igual

            // ------------------------ edited_by ----------------------------------
            if(edited_by_original !== edited_by_version){
                if(edited_by_original == "" && edited_by_version.length > 0 ){
                        $("#event_edited_by").addClass( "vagregado" ); // #Agregado
                        $("#event_edited_by").text(snapshot.val().edited_by);
                    } else if (edited_by_original.length > 0 && edited_by_version == "" ){
                        $("#event_edited_by").addClass( "vdeleted" ); // #Eliminado
                        $("#event_edited_by").text("Eliminado");
                    } else { 
                        $("#event_edited_by").addClass( "veditado" ); // #Editado
                        $("#event_edited_by").text(snapshot.val().edited_by);
                    }
            } else { $("#event_edited_by").text(snapshot.val().edited_by); } // #Es igual

            // ------------------------ creation_date ----------------------------------
            $("#event_creation_date").text("Sin cambios");
   
            // ------------------------ howto ----------------------------------
            if(howto_original !== howto_version){
                if(howto_original == "" && howto_version.length > 0 ){
                        $("#event_howto").addClass( "vagregado" ); // #Agregado
                        $("#event_howto").text(snapshot.val().howto);
                    } else if (howto_original.length > 0 && howto_version == "" ){
                        $("#event_howto").addClass( "vdeleted" ); // #Eliminado
                        $("#event_howto").text("Eliminado");
                    } else { 
                        $("#event_howto").addClass( "veditado" ); // #Editado
                        $("#event_howto").text(snapshot.val().howto);
                    }
            } else { $("#event_howto").text(snapshot.val().howto); } // #Es igual   

            // ------------------------ cot_bool ----------------------------------
            if(cot_bool_original !== cot_bool_version){
                if(cot_bool_original == "" && cot_bool_version.length > 0 ){
                        $("#event_cot_bool").addClass( "vagregado" ); // #Agregado
                        $("#event_cot_bool").text(snapshot.val().cot_bool);
                    } else if (cot_bool_original.length > 0 && cot_bool_version == "" ){
                        $("#event_cot_bool").addClass( "vdeleted" ); // #Eliminado
                        $("#event_cot_bool").text("Eliminado");
                    } else { 
                        $("#event_cot_bool").addClass( "veditado" ); // #Editado
                        $("#event_cot_bool").text(snapshot.val().cot_bool);
                    }
            } else { $("#event_cot_bool").text(snapshot.val().cot_bool); } // #Es igual      

            // ------------------------ ficha_bool ----------------------------------
            if(ficha_bool_original !== ficha_bool_version){
                if(ficha_bool_original == "" && ficha_bool_version.length > 0 ){
                        $("#event_ficha_bool").addClass( "vagregado" ); // #Agregado
                        $("#event_ficha_bool").text(snapshot.val().ficha_bool);
                    } else if (ficha_bool_original.length > 0 && ficha_bool_version == "" ){
                        $("#event_ficha_bool").addClass( "vdeleted" ); // #Eliminado
                        $("#event_ficha_bool").text("Eliminado");
                    } else { 
                        $("#event_ficha_bool").addClass( "veditado" ); // #Editado
                        $("#event_ficha_bool").text(snapshot.val().ficha_bool);
                    }
            } else { $("#event_ficha_bool").text(snapshot.val().ficha_bool); } // #Es igual     

            // ------------------------ payment_method ----------------------------------
            if(payment_method_original !== payment_method_version){
                if(payment_method_original == "" && payment_method_version.length > 0 ){
                        $("#event_payment_method").addClass( "vagregado" ); // #Agregado
                        $("#event_payment_method").text(snapshot.val().payment_method);
                    } else if (payment_method_original.length > 0 && payment_method_version == "" ){
                        $("#event_payment_method").addClass( "vdeleted" ); // #Eliminado
                        $("#event_payment_method").text("Eliminado");
                    } else { 
                        $("#event_payment_method").addClass( "veditado" ); // #Editado
                        $("#event_payment_method").text(snapshot.val().payment_method);
                    }
            } else { $("#event_payment_method").text(snapshot.val().payment_method); } // #Es igual            

            // ------------------------ facturanombre ----------------------------------
            if(facturanombre_original !== facturanombre_version){
                if(facturanombre_original == "" && facturanombre_version.length > 0 ){
                        $("#event_facturanombre").addClass( "vagregado" ); // #Agregado
                        $("#event_facturanombre").text(snapshot.val().facturanombre);
                    } else if (facturanombre_original.length > 0 && facturanombre_version == "" ){
                        $("#event_facturanombre").addClass( "vdeleted" ); // #Eliminado
                        $("#event_facturanombre").text("Eliminado");
                    } else { 
                        $("#event_facturanombre").addClass( "veditado" ); // #Editado
                        $("#event_facturanombre").text(snapshot.val().facturanombre);
                    }
            } else { $("#event_facturanombre").text(snapshot.val().facturanombre); } // #Es igual    

            // ------------------------ cost ----------------------------------
            if(cost_original !== cost_version){
                if(cost_original == "" && cost_version.length > 0 ){
                        $("#event_cost").addClass( "vagregado" ); // #Agregado
                        $("#event_cost").text(snapshot.val().cost);
                    } else if (cost_original.length > 0 && cost_version == "" ){
                        $("#event_cost").addClass( "vdeleted" ); // #Eliminado
                        $("#event_cost").text("Eliminado");
                    } else { 
                        $("#event_cost").addClass( "veditado" ); // #Editado
                        $("#event_cost").text(snapshot.val().cost);
                    }
            } else { $("#event_cost").text(snapshot.val().cost); } // #Es igual            

            // ------------------------ NIT ----------------------------------
            if(nit_original !== nit_version){
                if(nit_original == "" && nit_version.length > 0 ){
                        $("#event_nit").addClass( "vagregado" ); // #Agregado
                        $("#event_nit").text(snapshot.val().nit);
                    } else if (nit_original.length > 0 && nit_version == "" ){
                        $("#event_nit").addClass( "vdeleted" ); // #Eliminado
                        $("#event_nit").text("Eliminado");
                    } else { 
                        $("#event_nit").addClass( "veditado" ); // #Editado
                        $("#event_nit").text(snapshot.val().nit);
                    }
            } else  { $("#event_nit").text(snapshot.val().nit); } // #Es igual

            // ------------------------ apar_bool ----------------------------------
            if(apar_bool_original !== apar_bool_version){
                if(apar_bool_original == "" && apar_bool_version.length > 0 ){
                        $("#event_apar_bool").addClass( "vagregado" ); // #Agregado
                        $("#event_apar_bool").text(snapshot.val().apar_bool);
                    } else if (apar_bool_original.length > 0 && apar_bool_version == "" ){
                        $("#event_apar_bool").addClass( "vdeleted" ); // #Eliminado
                        $("#event_apar_bool").text("Eliminado");
                    } else { 
                        $("#event_apar_bool").addClass( "veditado" ); // #Editado
                        $("#event_apar_bool").text(snapshot.val().apar_bool);
                    }
            } else  { $("#event_apar_bool").text(snapshot.val().apar_bool); } // #Es igual

            
            }); //Termina la version_compare
        
        }); //Termina el Original


    }

    function reset_fields() {
            $("#event_text").text("cargando...");
            $("#event_text").removeClass( "veditado" );
            $("#event_text").removeClass( "vdeleted" );
            $("#event_text").removeClass( "vagregado" );

            $("#event_phone").text("cargando...");
            $("#event_phone").removeClass( "veditado" );
            $("#event_phone").removeClass( "vdeleted" );
            $("#event_phone").removeClass( "vagregado" );

            $("#event_email").text("cargando...");
            $("#event_email").removeClass( "veditado" );
            $("#event_email").removeClass( "vdeleted" );
            $("#event_email").removeClass( "vagregado" );

            $("#event_service").text("cargando..."); //OJO
            $("#event_service").removeClass( "veditado" );
            $("#event_service").removeClass( "vdeleted" );
            $("#event_service").removeClass( "vagregado" );

            $("#event_description").text("cargando...");
            $("#event_description").removeClass( "veditado" );
            $("#event_description").removeClass( "vdeleted" );
            $("#event_description").removeClass( "vagregado" );
            
            $("#event_time_start").text("cargando...");
            $("#event_time_start").removeClass( "veditado" );
            $("#event_time_start").removeClass( "vdeleted" );
            $("#event_time_start").removeClass( "vagregado" );

            $("#event_time_end").text("cargando...");
            $("#event_time_end").removeClass( "veditado" );
            $("#event_time_end").removeClass( "vdeleted" );
            $("#event_time_end").removeClass( "vagregado" );

            $("#event_comment").text("cargando...");
            $("#event_comment").removeClass( "veditado" );
            $("#event_comment").removeClass( "vdeleted" );
            $("#event_comment").removeClass( "vagregado" );

            $("#event_sales").text("cargando...");
            $("#event_sales").removeClass( "veditado" );
            $("#event_sales").removeClass( "vdeleted" );
            $("#event_sales").removeClass( "vagregado" );

            $("#event_personal").text("cargando..."); //OJO
            $("#event_personal").removeClass( "veditado" );
            $("#event_personal").removeClass( "vdeleted" );
            $("#event_personal").removeClass( "vagregado" );

            $("#event_created_by").text("cargando...");
            $("#event_created_by").removeClass( "veditado" );
            $("#event_created_by").removeClass( "vdeleted" );
            $("#event_created_by").removeClass( "vagregado" );

            $("#event_edited_by").text("cargando...");
            $("#event_edited_by").removeClass( "veditado" );
            $("#event_edited_by").removeClass( "vdeleted" );
            $("#event_edited_by").removeClass( "vagregado" );

            $("#event_creation_date").text("cargando...");
            $("#event_creation_date").removeClass( "veditado" );
            $("#event_creation_date").removeClass( "vdeleted" );
            $("#event_creation_date").removeClass( "vagregado" );

            $("#event_howto").text("cargando..."); //Nuevo 1
            $("#event_howto").removeClass( "veditado" );
            $("#event_howto").removeClass( "vdeleted" );
            $("#event_howto").removeClass( "vagregado" );

            $("#event_cot_bool").text("cargando..."); //Nuevo 2
            $("#event_cot_bool").removeClass( "veditado" );
            $("#event_cot_bool").removeClass( "vdeleted" );
            $("#event_cot_bool").removeClass( "vagregado" );

            $("#event_ficha_bool").text("cargando..."); //Nuevo 3
            $("#event_ficha_bool").removeClass( "veditado" );
            $("#event_ficha_bool").removeClass( "vdeleted" );
            $("#event_ficha_bool").removeClass( "vagregado" );

            $("#event_payment_method").text("cargando..."); //Nuevo 4
            $("#event_payment_method").removeClass( "veditado" );
            $("#event_payment_method").removeClass( "vdeleted" );
            $("#event_payment_method").removeClass( "vagregado" );

            $("#event_facturanombre").text("cargando..."); //Nuevo 5
            $("#event_facturanombre").removeClass( "veditado" );
            $("#event_facturanombre").removeClass( "vdeleted" );
            $("#event_facturanombre").removeClass( "vagregado" );

            $("#event_cost").text("cargando..."); //Nuevo 6
            $("#event_cost").removeClass( "veditado" );
            $("#event_cost").removeClass( "vdeleted" );
            $("#event_cost").removeClass( "vagregado" );

            $("#event_nit").text("cargando..."); //Nuevo 7
            $("#event_nit").removeClass( "veditado" );
            $("#event_nit").removeClass( "vdeleted" );
            $("#event_nit").removeClass( "vagregado" );

            $("#event_apar_bool").text("cargando..."); //Nuevo 8
            $("#event_apar_bool").removeClass( "veditado" );
            $("#event_apar_bool").removeClass( "vdeleted" );
            $("#event_apar_bool").removeClass( "vagregado" );
    }

    function unitToString(key) {
        var event_unidad;
            switch(key) {
                case 1:
                    event_unidad = "Billy";
                    break;
                case 2:
                    event_unidad = "Elvin";
                    break;
                case 3:
                    event_unidad = "Alvaro";
                    break;
                case 4:
                    event_unidad = "Israel";
                    break;
                case 5:
                    event_unidad = "Mario";
                    break;
                default:
                    event_unidad = "NO HAY INFORMACIÓN";
            }
        return event_unidad;

    }
</script>

</body>
</html>