<?php require_once("assets/header.php"); ?>

    <script>
    //Chequea si el usuario Iniciso sesion
    firebase.auth().onAuthStateChanged(function(user) {
        if (user) {
        } else {
          window.location.replace("login.php");
        }
      });
    </script>


	<!-- Javascript -->
	<script src='codebase/dhtmlxscheduler.js' type="text/javascript" charset="utf-8"></script>
	<script src='codebase/ext/dhtmlxscheduler_timeline.js' type="text/javascript" charset="utf-8"></script><!-- TimelineView -->
	<script src="codebase/ext/dhtmlxscheduler_units.js"></script><!-- UnitsView -->
	<script src='codebase/ext/dhtmlxscheduler_minical.js' type="text/javascript"></script><!-- Minicalendar -->
	<script src='codebase/ext/dhtmlxscheduler_readonly.js' type="text/javascript"></script><!-- ReadOnly -->
	<!-- <script src="codebase/ext/dhtmlxscheduler_quick_info.js" type="text/javascript" charset="utf-8"></script>QuickInfo -->
	<script src="codebase/ext/dhtmlxscheduler_tooltip.js"></script> <!-- Tooltip -->
	<script src="codebase/ext/dhtmlxscheduler_key_nav.js" type="text/javascript" charset="utf-8"></script><!-- Keyboard functions 

	<script src="codebase/dhtmlxDataProcessor/live_updates.js" type="text/javascript"></script><! Live Updates 1 -->
	<script type="text/javascript" src="http://40.85.176.172:8080/sync.js"></script><!-- Node JS Server 2 -->

	<script src="http://export.dhtmlx.com/scheduler/api.js"></script> <!-- Export to Excel-->
	
	<script src="codebase/locale/locale_es.js" charset="utf-8"></script> <!--Language -->

	<!--- JQuery Mobile -->
	<script src="//code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
	<!--- Javascript End -->

	<!--- CSS  -->
	<link rel='stylesheet' type='text/css' href='codebase/dhtmlxscheduler.css'><!--dhtmlx -->
	<link rel='stylesheet' type='text/css' href='assets/css/clean_master_colors.css'><!--Colores especificos de CleanMaster -->
	<!--- CSS end -->

	<style type="text/css" media="screen">
		/** SI ESTA BLOQUEADO **/

		.verticalView {
			width: 100%;
			height: 100%;
			text-align: center;
			padding-top: 45%;
		}

		/** GENERA DE LA PAGINA **/

		.contentBlock {
			font-size: 18px;
			margin-top: 10px;
			color: #4a98ce;
		}
		html, body {
		margin: 0px;
		height: 100%;
		min-height: 100%;
		overflow: auto;
		}
		
		/**	 LIGHT BOX CONTAINER   **/
		
		.dhx_cal_light, .dhx_cal_light_wide { /** Margen del Pop-up Total **/
				        top: 10% !important;
		}

		.dhx_cal_light_wide .dhx_cal_lsection {  /** Para la primer columna del Lightbox **/
			width: 140px;
			padding-right: 0px;
			margin-bottom: 5px;
		}
		.dhx_cal_light_wide .dhx_cal_larea {
			margin-left: 3px;
			height: 600px;
			max-height: 85%;
			overflow-y: auto;
		}
		.dhx_cal_light_wide .dhx_cal_larea {
			width: 98%;
		}
		.dhx_cal_light_wide {
			height: 62% !important;
		}
			/** FOMR CONTROLS **/

		.dhx_cal_light_wide .dhx_wrap_section { /** Es el borde inferior para pode **/
			padding-bottom: 7px;
		}
		input[type="text"] { /** Para el Date select que esta muy abajo **/
			margin-top: 0px;
		}
		.dhx_cal_ltext textarea { /** Textarea para que no se vaya para abajo **/
			margin-top: -2px;
		}
		.dhx_cal_light select, .dhx_cal_ltext textarea {
    		margin-top: 2px;
		}
		/** LIGHTBOX CELULAR **/
		@media (max-width: 980px) {
			.dhx_cal_light, .dhx_cal_light_wide {
				        top: 0% !important;
						left: 0% !important;
						width: 100% !important;
						height: 100% !important;
			}
			.dhx_cal_light_wide .dhx_cal_larea {
				max-height: 77%;
			}
			html, body {
			overflow: scroll;
			}
		}

		@media (max-height: 390px) {
			.dhx_cal_light, .dhx_cal_light_wide {
				        top: 0% !important;
						left: 0% !important;
						width: 100% !important;
						height: 100% !important;
			}
			.dhx_cal_light_wide .dhx_cal_larea {
				max-height: 70%;
			}
			html, body {
			overflow: scroll;
			}
			.dhx_cal_quick_info {
				    top: 65px !important;
			}

		}
	</style>
	
	<!-- CSS End -->

		<!-- Javascript Code -->
	<script type="text/javascript" charset="utf-8">
	
		$( document ).ready(function() {
			if($( window ).height() > $( window ).width()){
				$(".verticalView").show();
		} else {
				$(".verticalView").hide();
		}
		})

		$( window ).on( "orientationchange", function( event ) {
		$(".verticalView").toggle();
		});

		function app_initialize() {


		var name, email, photoUrl, uid;
		var current_user = {};

		config_start();

		function config_start(){
			
			//Inicializa el usuario
			firebase.auth().onAuthStateChanged(function(user) {

			if (user) {
				photoUrl = user.photoURL;
				uid = user.uid; 

					return firebase.database().ref('/users/' + uid).once('value').then(function(snapshot) {
					current_user.name = snapshot.val().username;
					current_user.privilege = snapshot.val().privilege;

					//Oculta cosas dependiendo el privilegio
					if (current_user.privilege != "admin" ) {
						//oculta todas las opciones de edicion
						$("#menu_units").hide();
						$("#menu_emails").hide();
						$("#sub_menu_units").hide();
						$("#data_base_log").hide();
						$("#menu_services").hide();
						
					}

					//console.log("Desde la funcion de parse: " + current_user.name);
					//Load Calendar
					init(current_user);

					});

			} else {
				console.log("Problema al cargar usuario");
			}
			});
		}

			function init(user) {

				scheduler.config.xml_date = "%Y-%m-%d %H:%i";
				scheduler.locale.labels.timeline_tab = "Unidad";
				scheduler.locale.labels.unit_tab = "Completo";

				//Permisos
				if (user.privilege == "ventas") {
						scheduler.config.drag_move = false; //Permiso para Drag and Drop
				} else if (user.privilege == "vista") {
						scheduler.config.readonly_form = true; //Unicamente si no tiene permiso de ver
						scheduler.config.drag_move = false; //Permiso para Drag and Drop
				} 
				
				//Secciones Adicionales del formulario:
				scheduler.locale.labels.section_custom = "Section";
				scheduler.locale.labels.section_subject = "Subject";

				//Formulario:
				scheduler.config.details_on_create = true;
				scheduler.config.details_on_dblclick = true;

				//==============================
				// Ignora los dias Domingos
				//==============================

				scheduler.ignore_month = function(date){
					if (date.getDay() == 0) //hides Saturdays and Sundays
						return true;
				};

				scheduler.ignore_timeline = function(date){
				//non-work hours
				if (date.getHours() == 19 || date.getHours() == 20 || date.getHours() == 21 || date.getHours() == 22 || date.getHours() == 23 || date.getHours() == 0  || date.getHours() == 1 || date.getHours() == 2 || date.getHours() == 3 || date.getHours() == 4 || date.getHours() == 5 || date.getHours() == 6 || date.getHours() == 7 ) {
					return true;
					}
			};



				//==============================
				// FORMULARIO - Validacion y registro de creacion y cambio
				//==============================

				var current_event;
				var current_id = "a";

				scheduler.attachEvent("onEventSave",function(id,ev){
					console.log("0) onEventSave ID: " + id);
					
				if (!ev.text || !ev.address || !ev.phone || !ev.email ) {
					dhtmlx.alert("Debes llenar los campos obligatorios *");
					return false;
				}

				if (!validateEmail(ev.email)) {
					dhtmlx.alert("Debe ser un correo electronico valido");
					return false;
				}
				if (ev.text.length<5) {
					dhtmlx.alert("El texto es muy pequeño");
					return false;
				}
				if(!ev.created_by){
					ev.created_by = user.name; //Current User
				}
					ev.edited_by = user.name; //PHP current user

				return true;

				});

				function validateEmail(email) {
					var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
					return re.test(email);
				}

				//==============================
				// FORMULARIO - HISTORIAL DE CAMBIOS
				//==============================

				// Cuando Cambia el ID da pie a guardar el LOG (Esto solo pasa al inicio asi que...) :
				
				scheduler.attachEvent("onEventAdded", function(id,ev){
					//Almacena el evento hasta que tengamos el ID final
					console.log("1) onEventAdded ID: " + id);

					if(id.toString().length > 5) { // Solo si el ID es generado Ofline de 45654645565
					console.log("    OnEventAdded is offline: (casa)");
					this.current_event = ev;
					} else { console.log("    OnEventAdded is offline: (live_update)"); }
				});

				// --------------  CUANDO SE Cambia el IP
				scheduler.attachEvent("onEventIdChange", function(old_id,new_id){
					console.log("2) onEventIdChange ID: ");

					console.log("onEventIdChange ID old: " + old_id);
					console.log("onEventIdChange ID new: " + new_id);
					console.log("onEventIdChange current_id: " + current_id);

						if(current_id !== new_id ) { // Si el ID es difente entonces lo guarda
						console.log("Los ID son diferentes");
						current_id = new_id;

						//--------  firebase log
						saveHistory(new_id, this.current_event, function() { 
							location.reload(); //Recarga para evitar errores
						});
						//--------  firebase log

						//--------  Email save
						saveEmail(this.current_event, function(validador) { 
							console.log(validador);
							if (validador == false) {
								console.log("Email guardado exitosamente");
							} else {
								console.log("Email ya existe");
							}
						});
						//--------  Email save

						} else {
							console.log("Los ID son iguales Return")
							return false;
						}
				});

				// --------------  CUANDO CAMBIA
					scheduler.attachEvent("onEventChanged", function(id,ev){
							console.log("onEventChanged ID: " + id);
						if(id.toString().length < 5) { // Solo si el ID es generado Ofline de 45654645565
						console.log("onEventChanged Actualizado con LOG");
						//--------  firebase log
						updateHistory(id, ev, function() { 
							// ...
						});
						//--------  firebase log
						}
					});
					
			 // --------------  Antes de que se elimine		
					scheduler.attachEvent("onBeforeEventDelete", function(id,e){
    				//any custom logic here
					//Oculta cosas dependiendo el privilegio
					if (user.privilege != "admin" ) {
						//oculta todas las opciones de edicion
						alert("SOLO EL ADMINISTRADOR PUEDE ELIMINAR");
    					return false;
						
					} else {
						return true;
					}

					
					});

			   // --------------  CUANDO SE ELIMINA
					scheduler.attachEvent("onConfirmedBeforeEventDelete", function(id,e){

						if(id.toString().length < 5) { // El 45654645565
							console.log("Eliminado con Log (real)");
						
								console.log("onConfirmedBeforeEventDelete");
								//--------  firebase log
								deleteHistory(id, function() { 
									// ...
								});
								//--------  firebase log

						} else {
							console.log("Eliminado sin Log (falso)");
						}
					});

				//==============================
				//Configuration
				//==============================
				

				//Calendarios:
				var sections = [
					{key:1, label:"Panel 1 - Billy"},
					{key:2, label:"Panel 2 - Elvin"},
					{key:3, label:"Panel 3 - Marlon"},
					{key:4, label:"Panel 4 - Israel"},
					{key:5, label:"Panel 5 - Mario"},
					{key:8, label:"Panel nueva"},
					{key:6, label:"Eventos 1"},
					{key:7, label:"Eventos 2"}
				];

				//Calendarios:
				var howto = [
					{key:"Paginas Amarillas", label:"Paginas Amarillas"},
					{key:"Facebook", label:"Facebook"},
					{key:"Twitter", label:"Twitter"},
					{key:"Youtube", label:"Youtube"},
					{key:"Google Ads", label:"Google Ads"},
					{key:"Revista", label:"Revista"},
					{key:"Periodico", label:"Periodico"},
					{key:"Correo electronico publicitario", label:"Correo electronico publicitario"},
					{key:"TV", label:"TV"},
					{key:"Publicidad Paneles", label:"Publicidad Paneles"},
					{key:"Volantes", label:"Volantes"},
					{key:"Referencias personales", label:"Referencias personales"},
					{key:"Cliente actual", label:"Cliente actual"},
					{key:"Telemarketing", label:"Telemarketing"},
					{key:"Pagina web", label:"Pagina web"}
				];

				var paymentm = [
					{key:"--", label:"seleccione..."},
					{key:"Efectivo", label:"Efectivo"},
					{key:"Cheque", label:"Cheque"},
					{key:"Tarjeta", label:"Tarjeta"},
					{key:"Deposito", label:"Deposito"},
					{key:"Orden_blanca", label:"Orden blanca"}
				];

				var yesno = [
					{key:"--", label:"seleccione..."},
					{key:"si", label:"si"},
					{key:"no", label:"no"}
				];

				//Servicios:
				var subject = [
					{ key: 'servicio_m', label: 'Servicios de muebles y sillas' },//amarillo
					{ key: 'limpieza_a', label: 'Limpieza de alfombras' },
					{ key: 'limpieza_c', label: 'Limpieza de colchones' },
					{ key: 'limpieza_p', label: 'Limpieza de Paneles de Tela' },
					{ key: 'limpieza_pi', label: 'Limpieza de pisos' },
					{ key: 'limpieza_ve', label: 'Limpieza de vehículos ' },
					{ key: 'plagas_gel', label: 'Control de plagas Gel' },
					{ key: 'plagas_as', label: 'Control de plagas aspersión' },
					{ key: 'plagas_roe', label: 'Control de plagas roedores' },

					{ key: 'limpieza_ge', label: 'limpieza general' }, //azul
					
					{ key: 'limpieza_ba', label: 'Limpieza baños' }, //verde
					{ key: 'limpieza_vi', label: 'Limpieza de vidrios' },

					{ key: 'oursourcing', label: 'Outsourcing' } //Lila
				];

				var durations = {
					day: 24 * 60 * 60 * 1000,
					hour: 60 * 60 * 1000,
					minute: 60 * 1000
				};

				var get_formatted_duration = function(start, end) {
					var diff = end - start;

					var days = Math.floor(diff / durations.day);
					diff -= days * durations.day;
					var hours = Math.floor(diff / durations.hour);
					diff -= hours * durations.hour;
					var minutes = Math.floor(diff / durations.minute);

					var results = [];
					if (days) results.push(days + " days");
					if (hours) results.push(hours + " hours");
					if (minutes) results.push(minutes + " minutes");
					return results.join(", ");
				};


				var resize_date_format = scheduler.date.date_to_str(scheduler.config.hour_date);

				scheduler.templates.event_bar_text = function(start, end, event) {
					var state = scheduler.getState();
					if (state.drag_id == event.id) {
						return resize_date_format(start) + " - " + resize_date_format(end) + " (" + get_formatted_duration(start, end) + ")";
					}
					return event.text; // default
				};

				//==============================
				//Views
				//==============================

				scheduler.config.first_hour = 8;
				
				//----- Time Line
				scheduler.createTimelineView({
					name:	"timeline",
					y_unit:scheduler.serverList("sections"), //Server Load
					x_unit:	"minute",
					x_date:	"%H:%i",
					x_step:	60,
					x_size: 11,
					x_start: 8,
					x_length:	24, //Esto es el ingrediente secreto
					y_unit:	sections,
					y_property:	"type_id",
					render:"bar",
					event_dy: "full"
				});
				
				//----- Unit Views
				scheduler.createUnitsView({
					name:"unit",
					property:"type_id", //the mapped data property
					first_hour:10,
					list: sections,
					size: 42
					
				});

				//==============================
				//colores
				//==============================

				//#Colores de Servicio
				scheduler.templates.event_class=function(start, end, event){
					var css = "";

					if(event.subject) // if event has subject property then special class should be assigned
						css += "event_"+event.subject + " " + event.apar_bool;

					if(event.id == scheduler.getState().select_id){
						css += " selected";
					}
					
					return css; // default return
				};

				
				//colores de Unidades
				scheduler.templates.timeline_scaley_class = function(key, label,  section){ 
					return "timeline_cell_" + key;
				};

				//==============================
				//Quick Info Settings
				//==============================

				// --------------- CONFIGURACION DE QUICK INFO
				/**
				scheduler.config.quick_info_detached = false;

				scheduler.templates.quick_info_content = function(start, end, ev){
					var x;
					var texto = "Evento no especificado";

						for (x in subject) {
							if(subject[x].key == ev.subject) {
								texto = subject[x].label;
							} 
						}
					var quickinfoD = "<strong>Dirección:</strong> " + ev.address + ", <br> <strong>Servicio: </strong>" + texto;
					return quickinfoD;
				};
				**/
				


				//==============================
				//Tooltip
				//==============================
				var format=scheduler.date.date_to_str("%Y-%m-%d %H:%i"); 
				scheduler.templates.tooltip_text = function(start,end,event) {

					var x;
					var texto = "Evento no especificado";
					for (x in subject) {
							if(subject[x].key == event.subject) {
								texto = subject[x].label;
							} 
						}

					return "<b>Evento:</b> "+event.text+"<br/><b>Dirección:</b> "+
					event.address+"<br/><b>Servicio:</b> "+texto;
				};



				//==============================
				//Form Settings
				//==============================

				scheduler.config.lightbox.sections=[
					{name:"¿Está reservado?", height:30, type:"select", options: yesno, map_to:"apar_bool"}, //Como se entero     #PENDIENTE SQL
					{name:"* Cliente", height:30, map_to:"text", type:"textarea"}, //Nombre de Cliente
					{name:"* Dirección", height:30, map_to:"address", type:"textarea"}, //Zona
					{name:"Indicaciones para llegar", height:50, map_to:"comment", type:"textarea"},//comentario
					{name:"* Período", height:30, type:"calendar_time", map_to:"auto" },//calendario
					{name:"* Teléfono", height:30, map_to:"phone", type:"textarea"}, //Telefono
					{name:"* Correo eletrónico", height:30, map_to:"email", type:"textarea"}, //email
					{name:"Ficha enviada", height:30, type:"select", options: yesno, map_to:"ficha_bool"}, //Ficha tecnica enviada     #PENDIENTE SQL
					{name:"Cotización enviada", height:30, type:"select", options: yesno, map_to:"cot_bool"}, //Cotizacion enviada    #PENDIENTE SQL
					{name:"Como se entero", height:30, type:"select", options: howto, map_to:"howto"}, //Como se entero     #PENDIENTE SQL
					{name:"Servicio a realizar", height:30, type:"select", options: subject, map_to:"subject" },//servicio
					{name:"Descripción del servicio", height:40, map_to:"description", type:"textarea"}, //descripcion
					{name:"Forma de pago", height:30, type:"select", options: paymentm, map_to:"payment_method"}, //Forma de pago     #PENDIENTE SQL
					{name:"NIT", height:30, map_to:"nit", type:"textarea"}, //Como se entero     #PENDIENTE SQL
					{name:"Nombre a facturar", height:30, map_to:"facturanombre", type:"textarea"}, //Nombre de factura     #PENDIENTE SQL
					{name:"Valor del servicio Q.", height:30, map_to:"cost", type:"textarea"}, //Valor Servicio     #PENDIENTE SQL
					{name:"Vendido por:", height:30, map_to:"sold_by", type:"textarea"}, //Miebros del equipo
					{name:"Personal asignado", height:30, map_to:"personal", type:"textarea"}, //Miebros del equipo
					
					{name:"Creado por", height:30, map_to:"created_by", type:"textarea"}, //Creado por
					{name:"Editado por", height:30, map_to:"edited_by", type:"textarea"}, //Editado por ultima vez
				];
				scheduler.attachEvent("onLightbox", function(){
				var section = scheduler.formSection("Creado por");
				var section2 = scheduler.formSection("Editado por");
				section.control.disabled = true;
				section2.control.disabled = true;
				});

				//==============================
				//Data loading
				//==============================
				scheduler.init('scheduler_here', new Date(), "timeline"); //Para comenzar una customizada solo 2014, 5, 30
				//method takes the url to the file that will process CRUD operations on the server
				scheduler.load("config.php");

				//==============================
				//Save Data
				//==============================
				var dp = new dataProcessor("config.php");
				//dp.live_updates("http://40.85.176.172:8080/sync");
				dp.init(scheduler);

				//Hide Spinner
				$(".spinner").hide();

		}

			} //Function Inicial

					//==============================
					//Export Data 
					//==============================
					function exportScheduler(type){
						if (type == "pdf")
							scheduler.exportToPDF({
								header:"<link rel='stylesheet' href='http://calaps.com/apps/cleanmaster/assets/css/clean_master_colors.css' type='text/css' title='no title' charset='utf-8'>",
							});
						else
							scheduler.exportToPNG({
								header:"<link rel='stylesheet' href='http://calaps.com/apps/cleanmaster/assets/css/clean_master_colors.css' type='text/css' title='no title' charset='utf-8'>",
							});
					}

					//==============================
					//Mini Calendar
					//==============================
					function show_minical(){
						if (scheduler.isCalendarVisible()){
							scheduler.destroyCalendar();
						} else {
							scheduler.renderCalendar({
								position:"dhx_minical_icon",
								date:scheduler._date,
								navigation:true,
								handler:function(date,calendar){
									scheduler.setCurrentView(date);
									scheduler.destroyCalendar()
								}
							});
						}
					}
					//==============================
					//Mini Calendar Ends
					//==============================

					//==============================
					//Funciones para historial
					//==============================

					function saveHistory(id, event, callback){

						console.log("2.1) SUB saveHistory: " + id);
						
						//Esto guarda la información para un evento creado por primera vez
						if(event._move_delta == undefined || event._move_delta == "undefined" || event._move_delta === null) { 
							console.log("event._move_delta == undefined");
							event._move_delta = 1; //Soliciona el error que tira al inicio
						}

						console.log(event._move_delta);	

							//Soliciona el error que tira al inicio
							var start_dates = event.start_date;
							event.start_dates = start_dates.toString();

							var end_dates = event.end_date;
							event.end_dates = end_dates.toString();


						
						event.created_date = formattedDate(start_dates); //Guarda la fecha en la que es creado
						event.creation_date = formattedDate(); //Guarda la fecha en la que es creado
						
						firebase.database().ref('history/' + id).set({
							event
						});

						//Esto crea la funcion de que existe
						var changes = {
							status: "active"
						}

						var updates = {};
						updates['history/' + id + '/status'] = changes;
						
						return firebase.database().ref().update(updates);
						
					}


					function saveEmail(event, callback){

						var validador = false;

						firebase.database().ref('/emails/').once('value').then(function(snapshot) {
						var emails = snapshot.val();

						for (x in emails) {
							if(emails[x].email === event.email){
								validador = true;
							}
						}

						if (validador == false) {
							var emailname = event.email;
							emailname = emailname.replace(/[^a-zA-Z ]/g, "");

							firebase.database().ref('emails/' + emailname).set({
								//Primera creación del perfil del usuario
								email: event.email,
								text: event.text
							});
						}

						callback(validador);
						
					});

						
					}



					function updateHistory(id, event, callback){
						console.log("---- SUB updateHistory: " + id);

						//Esto pasa cuando se modifica, guarda el historial de cambios en Firebase
							if(event._move_delta == undefined) { event._move_delta = 1; //Soliciona el error que tira al inicio
							}
						
						    var start_dates = event.start_date;
							event.start_dates = start_dates.toString();

							var end_dates = event.end_date;
							event.end_dates = end_dates.toString();
							

						var newPostKey = firebase.database().ref().child('users').push().key;
						// Write the new post's data simultaneously in the posts list and the user's post list.
						var updates = {};
						updates['history/' + id + '/version/' + newPostKey] = event;

						return firebase.database().ref().update(updates);
						
						callback();
					}

					function deleteHistory(id, callback){
						console.log("#### SUB deleteHistory: " + id);

						user_name = $("#userName").text();

						//Esto guarda la información para un evento creado por primera vez
						var changes = {
							status: "deleted",
							deleted_by: user_name 
						}

						var updates = {};
						updates['history/' + id + '/status'] = changes;

						return firebase.database().ref().update(updates);

						callback();
					}

					//==============================
					//Funciones Generales
					//==============================

					function formattedDate(date) {
						var d = new Date(date || Date.now()),
							month = '' + (d.getMonth() + 1),
							day = '' + d.getDate(),
							year = d.getFullYear();

						if (month.length < 2) month = '0' + month;
						if (day.length < 2) day = '0' + day;

						return [month, day, year].join('/');
					}


	</script>
		<!-- Javascript Code -->
</head>

	<body onload="app_initialize(); settings();">

		<!-- Spinner Load -->
		<div class="spinner">
		<div class="double-bounce1"></div>
		<div class="double-bounce2"></div>
		</div>
		<!-- End Spinner -->

		<!-- Spinner Load -->
		<div class="verticalView">
			<img src="images/icons/rotate.png">
			<div class="contentBlock">Usar el dispositivo horizontal</div>
		</div>
		<!-- End Spinner -->

		<?php require_once("assets/layout/header_menu.php"); ?>

		<!-- CALENDAR -->
		<div id="scheduler_here" class="dhx_cal_container" style='width:100%; height:127%; margin-bottom: 39px;'>
			<div class="dhx_cal_navline">
				<div class="dhx_cal_prev_button">&nbsp;</div>
				<div class="dhx_cal_next_button">&nbsp;</div>
				<div class="dhx_cal_today_button"></div>
				<div class="dhx_cal_date"></div>
				
				<div class="dhx_minical_icon" id="dhx_minical_icon" onclick="show_minical()">&nbsp;</div>
				<div class="dhx_cal_tab" name="day_tab" style="right:204px;"></div>
				<div class="dhx_cal_tab" name="week_tab" style="right:140px;"></div>
				<div class="dhx_cal_tab" name="timeline_tab" style="right:280px;"></div>
				<div class="dhx_cal_tab" name="month_tab" style="right:76px;"></div>
				<div class="dhx_cal_tab" name="unit_tab" style="right:280px;"></div>
			</div>
			<div class="dhx_cal_header">
			</div>
			<div class="dhx_cal_data">
			</div>
		</div>
		<!-- END CALENDAR -->

		<!-- MODALS --> 
		<?php require_once("assets/layout/modals.php"); ?>
		<!-- MODALS -->

		<?php require_once("assets/layout/footer.php"); ?>

	</body>

</html>