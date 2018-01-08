  <!--  *************** HEADER MODALS ***************  -->
 <!-- TIPS MODAL -->
        <div id="show_tips_modal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Tips y atajos de Calendario</h4>
            </div>
            <div class="modal-body">
                
                    <!--Error division start -->		
                    <div id="error2"></div>
						<!-- Mostrar info -->
						<p>Funciones basicas de eventos</p>
                        	<div class="alert alert-success">
								Para crear un evento: Seleccione o arraste con el mouse la duracion, despúes vera el formulario. O simplemente haga click en el dia y calendario que quiera crear un evento. 
                        	</div>
							<div class="alert alert-info">
								Para editar un evento: Haga doble click en el evento que desea editar. NOTA: Solo podra editar si cuenta con los permisos de administrador.
                        	</div>
						<!-- Mostrar atajos -->
						<p>Atajos de teclado</p>
                        	<div class="alert alert-info">
								Operador de cortado: Seleccione un evento y presione el comando Ctrl+X para cortar y Ctrl+V para pegar
                        	</div>
							<div class="alert alert-info">
								Operador de copiado: Seleccione un evento y presione el comando Ctrl+C para cortar y Ctrl+V para pegar
                        	</div>

                    <!--Error division end  -->

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
<!-- TIPS MODAL -->

 <!-- CALENDAR MODAL -->
        <div id="show_calendar_modal" class="modal fade" tabindex="-1" role="dialog">
        <div id="modalPage" class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Tiempos de calendario</h4>
            </div>
            <div class="modal-body">
                
                    <img class="times" style="width: 100%" src="images/times.png" />

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
<!-- CALENDAR MODAL -->

 <!-- PP MODAL -->
        <div id="show_pp_modal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Politica de Privacidad</h4>
            </div>
            <div class="modal-body">
                
                    <!--Error division start -->		
                    <?php require_once("assets/layout/privacy_policy.php"); ?>
                    <!--Error division end  -->

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <!-- PP MODAL -->

 <!--  *************** HEADER MODALS END ***************  -->

<!--  ***************  USERS MODALS START ***************  -->
        <!-- EDIT MODAL -->
        <div id="edit_user_modal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Editar usuario</h4>
            </div>
            <div class="modal-body">
                
                    <!--Error division start -->		
                    <div id="error"></div>
                    <!--Error division end  -->
                    

                    <label for="comment">Nombre:</label>
                    <input type="text" class="form-control" id="user_name" placeholder="Nombre" required="" autofocus="" />
                    <label for="comment">Correo:</label>
                    <input type="text" class="form-control" id="user_email" placeholder="Correo" disabled />
                    <label for="sel1">Privilegio:</label>
                    <select style="height: 45px;" class="form-control" id="user_privilege">
                        <option>admin</option>
                        <option>ventas</option>
                        <option>vista</option>
                    </select>

            </div>
            <div class="modal-footer">
                
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" onClick="saveUser();return false;" class="btn btn-primary">Guardar cambios</button>
                <button type="button" onClick="changePassword();return false;" class="btn btn-default pull-left">Restaurar contraseña</button>
                
            </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <!-- EDIT MODAL -->

        <!-- DELETE MODAL -->
        <div id="delete_user_modal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Eliminar usuario</h4>
            </div>
            <div class="modal-body">
                
                    <!--Error division start -->		
                    <div id="error2"></div>
                        <div class="alert alert-danger">Estas seguro que quieres eliminar este usuario:<br/><br/>
                            
                            <label for="comment">identificador: </label><br/><span id="del_user_id"></span><br/>
                            <label for="comment">Nombre: </label><br/><span id="del_user_name"></span><br/>
                            <label for="comment">correo: </label><br/><span id="del_user_email"></span><br/>
                            <label for="comment">privilegio: </label><br/><span id="del_user_privilege"></span>
                               
                                <br/><br/><p>Al eliminar la cuenta:</p>
                                    <ul>
                                        <li>Se eliminara de forma definitva</li>
                                        <li>Ya no podra inicar sesión</li>
                                    </ul>
                        </div>
                        <strong>Nota: </strong><p> NO se eliminaran los eventos que este usuario haya hecho en el calendario, si desea eliminarlos. Tendra que hacerlo de forma manual en el Calendario</p>
                    
                    <!--Error division end  -->

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button id="userDeleteButton" type="button" onClick="deleteUser();return false;" class="btn btn-primary">Eliminar</button>
            </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <!-- DELETE MODAL -->


 <!--  *************** USERS MODALS END ***************  -->

  <!--  *************** HISTORY MODALS START ***************  -->

 <!-- EDIT MODAL -->
        <div id="history_modal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Detalles de evento</h4>
            </div>
            <div class="modal-body">
                
                    <!--Error division start -->		
                    <div id="error"></div>


                    <!--Error division end  -->
                    <table id="diferente" class="table-hover" data-show-export="true">
                        <thead>
                        <tr>
                            <th>Campo1</th>
                            <th>Contenido</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><label class="event_modal">Cliente:</label></td>
                            <td><span id="event_text"> cargando...</span></td>
                        </tr>
                        <tr>
                            <td><label class="event_modal">Dirección:</label></td>
                            <td><span id="event_address"> cargando...</span></td>
                        </tr>
                        <tr>
                            <td><label class="event_modal">Telefono:</label></td>
                            <td><span  id="event_phone"> cargando...</span></td>
                        </tr>
                        <tr>
                            <td><label class="event_modal">Correo:</label></td>
                            <td><span id="event_email"> cargando...</span></td>
                        </tr>
                        <tr>
                            <td><label class="event_modal">Como se entero:</label></td>
                            <td><span id="event_howto"> cargando...</span></td>
                        </tr>
                        <tr>
                            <td> <label class="event_modal">Cotizacion enviada:</label></td>
                            <td> <span id="event_cot_bool"> cargando...</span></td>
                        </tr>
                        <tr>
                            <td><label class="event_modal">Ficha tecnica enviada:</label></td>
                            <td><span id="event_ficha_bool"> cargando...</span></td>
                        </tr>
                        <tr>
                            <td><label class="event_modal">Servicio:</label></td>
                            <td><span id="event_service"> cargando...</span></td>
                        </tr>
                        <tr>
                            <td> <label class="event_modal">Descripción:</label></td>
                            <td><span id="event_description"> cargando...</span></td>
                        </tr>
                        <tr>
                            <td> <label class="event_modal">Fecha que inicia:</label></td>
                            <td> <span id="event_time_start"> cargando...</span></td>
                        </tr>
                        <tr>
                            <td><label class="event_modal">Fecha que termina:</label></td>
                            <td> <span id="event_time_end"> cargando...</span></td>
                        </tr>                        
                        <tr>
                            <td><label class="event_modal">Como llegar:</label></td>
                            <td><span id="event_comment"> cargando...</span></td>
                        </tr>
                        <tr>
                            <td><label class="event_modal">Vendido por:</label></td>
                            <td> <span id="event_sales"> cargando...</span></td>
                        </tr>
                        <tr>
                            <td> <label class="event_modal">Valor del servicio:</label></td>
                            <td> <span id="event_cost"> cargando...</span></td>
                        </tr>
                        <tr>
                            <td> <label class="event_modal">Forma de pago:</label></td>
                            <td><span id="event_payment_method"> cargando...</span></td>
                        </tr>
                        <tr>
                            <td><label class="event_modal">Apartado:</label></td>
                            <td><span id="event_apar_bool"> cargando...</span></td>
                        </tr>
                        <tr>
                            <td><label class="event_modal">Nombre de factura:</label></td>
                            <td><span id="event_facturanombre"> cargando...</span></td>
                        </tr>
                        <tr>
                            <td><label class="event_modal">NIT:</label></td>
                            <td> <span id="event_nit"> cargando...</span></td>
                        </tr>
                        <tr>
                            <td><label class="event_modal">Personal asignado:</label></td>
                            <td><span id="event_personal"> cargando...</span></td>
                        </tr>
                        <tr>
                            <td><label class="event_modal">Ruta:</label></td>
                            <td><span id="event_unit"> cargando...</span></td>
                        </tr>
                        <tr>
                            <td><label class="event_modal">Creado por:</label></td>
                            <td><span id="event_created_by"> cargando...</span></td>
                        </tr>
                        <tr>
                            <td><label class="event_modal">Editado por:</label></td>
                            <td><span id="event_edited_by"> cargando...</span></td>
                        </tr>
                        <tr>
                            <td><label class="event_modal">Fecha de creación</label></td>
                            <td><span id="event_creation_date"> cargando...</span><br></td>
                        </tr>

                        </tbody>
                </table>


            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                
            </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <!-- EDIT MODAL -->

         <!--  *************** HISTORY MODALS END ***************  -->