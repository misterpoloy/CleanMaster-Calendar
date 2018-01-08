<?php require_once("assets/header.php"); ?>
<script type="text/javascript">
    $(document).ready(function(){

        firebase.database().ref('/users/').once('value').then(function(snapshot) {

            var users = snapshot.val();
            var x;
            var tr;
            for (x in users) {

                if(users[x].enable == true) {
                    tr = $('<tr>');
                    tr.append("<td>" + users[x].uid + "</td>");
                    tr.append("<td>" + users[x].username + "</td>");
                    tr.append("<td>" + users[x].email + "</td>");
                    tr.append("<td>" + users[x].privilege + "</td>");
                    tr.append("<td>" + users[x].privilege + "</td>");
                    tr.append("</tr>");
                    $('tbody').append(tr); 
                }

            }   //Despues de cargar el contenido instancia la tabla
                $.getScript( "assets/js/bootstrap-table.js", function( data, textStatus, jqxhr ) {
                //console.log( data ); // Data returned
                //console.log( textStatus ); // Success
                //console.log( jqxhr.status ); // 200
                //console.log( "Load was performed." );
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
        overflow: hidden;
		}
         a {
            color: #00b1e9;
            text-decoration: none;
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
                <h3 class="titlePage">Usuarios de ventas de Plataforma<img class="icon2" src="images/icons/user.png"></h3>

                    <table data-toggle="table"  data-height="399" data-search="true" data-pagination="true">
                        <thead>
                        <tr>
                            <th data-field="id" data-sortable="true">ID</th>
                            <th data-field="name" data-sortable="true">Nombre</th>
                            <th data-field="email" data-sortable="true">Correo</th>
                            <th data-field="privilege" data-sortable="true">Privilegio</th>
                            <th data-field="operate" data-formatter="operateFormatter" data-events="operateEvents">Funciones</th>
                        </tr>
                        </thead>
                        <!-- Contenido de tabla -->
                        <tbody>
                        
                        </tbody>
                </table>
        </div>

        <!-- **************** ADD USER ******************* -->
        <div class="row content-div" style="padding-left:7%; padding-right:8%;">

            <div class="row">
                <div class="col-md-3">
                    <div id="error3"></div>
                    <p><img class="iconMenu" src="images/icons/addusers.png">Agregar a un nuevo usuario</p>
                </div>
            </div>

            <div class="row" id="pshow" style="display: none">

                <div class="col-md-3">
                    <input type="text" class="form-control" id="add_user_name" placeholder="Nombre" required="" autofocus="" />
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control" id="add_user_email" placeholder="Correo" required="" autofocus="" />
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control" id="add_user_password" placeholder="Contraseña" required="" autofocus="" />
                </div>
                <div class="col-md-3">
                    <select style="height: 43px; margin-top: 5px;" class="form-control" id="add_user_privilege">
                            <option>admin</option>
                            <option>ventas</option>
                            <option>vista</option>
                        </select>
                        <div class="alert alert-info">
                        <strong>Admin: </strong>Agregar/eliminar usuarios.<br>
                        <strong>Ventas: </strong>Agregar/eliminar eventos.<br>
                        <strong>Vista: </strong>Unicamente ver sin editar.
                        </div>
                </div>

            </div>

                <div class="row">
                    <div class="col-md-12">
                        <button type="button" onClick="createUser();return false;" style="margin-right: 1%;" class="btn btn-primary pull-right">
                        Crear usuario</button>
                    </div>
                </div>

                
        </div>
        <!-- **************** END ADD USER ******************* -->
        <!-- MODALS --> 
	    <?php require_once("assets/layout/modals.php"); ?>
	    <!-- MODALS -->
        
        <?php require_once("assets/layout/footer.php"); ?>


<script>

    function operateFormatter(value, row, index) {
     
        return [
            '<a class="edit ml10" href="#" onClick="editClick(\'' + row.id + '\' , \'' + row.name + '\' , \'' + row.email + '\' , \'' + row.privilege + '\');" title="Edit">',
                '<i class="glyphicon glyphicon-edit"></i>',
            '</a>',
            '<a class="remove ml10" href="javascript:void(0)" onClick="deleteClick(\'' + row.id + '\' , \'' + row.name + '\' , \'' + row.email + '\' , \'' + row.privilege + '\');" title="Edit">',
                '<i class="glyphicon glyphicon-remove"></i>',
            '</a>'
        ].join('');
    }
    
    var uid;

    function editClick(id, name, email, privilege) {
        // Reset message
         $('#error').html('<div class="alert alert-warning">Si vas a editar <strong>todo</strong> el usuario considera eliminarlo y crear otro antes</div>');	

        //Set Default Values
         $("#user_name").val(name);
         $("#user_email").val(email);
         $("#user_privilege").val(privilege);

         uid = id;
        //Open Modal
         $('#edit_user_modal').modal('toggle');

    }
    function deleteClick(id, name, email, privilege) {
        // Reset message
         $('#error2').html('');	
        $("#userDeleteButton").prop('disabled', false);

         $("#del_user_id").text(id);
          $("#del_user_name").text(name);
           $("#del_user_email").text(email);
            $("#del_user_privilege").text(privilege);

         $('#delete_user_modal').modal('toggle');

    }

    function deleteUser(){
            var id = $("#del_user_id").text();
            var name = $("#del_user_name").text();
            var email = $("#del_user_email").text();
            var privilege = $("#del_user_privilege").text();
       
                 $('#error2').html('<div class="alert alert-info">Por favor espere...</div>');	
                 $("#userDeleteButton").prop('disabled', true);
        
            firebase.database().ref('users/' + id).set({
                email: email,
                enable: false,
                privilege: privilege,
                uid: id,
                username: name,
                
            });
             location.reload();
             $('#error2').html('<div class="alert alert-success">Usuario eliminado con exito!</div>');

    }

    function saveUser(){
        var id = uid;
        var name = $('#user_name').val();
        var email = $('#user_email').val();
        var privilege = $('#user_privilege').val();

        $('#error').html('<div class="alert alert-info">Por favor espere...</div>');	

        //Check if username and password are entered or not
        if(name.length==0 || email.length==0)
        {
          $('#error').html('<div class="alert alert-danger">No puedes guardar un usuario vacio</div>');
          return;	
        }

        $(".btn-lg").prop('disabled', true);
        
            firebase.database().ref('users/' + id).set({
                email: email,
                enable: true,
                privilege: privilege,
                uid: id,
                username: name,
                
            });
             $(".btn-lg").prop('disabled', false);
             $('#error').html('<div class="alert alert-success">Usuario actualizado con exito!</div>');
            location.reload();

             //Open Modal
            $('#edit_user_modal').modal('toggle');
    }

    function changePassword(){
        var email = $('#user_email').val();

        $('#error').html('<div class="alert alert-info">Enviando, favor espere...</div>');	

                var auth = firebase.auth();

                auth.sendPasswordResetEmail(email).then(function() {
                $('#error').html('<div class="alert alert-success">Se ha enviando un correo electronico a <strong>'+ email +'</strong> con las instrucciones.</div>');
                }, function(error) {
                // An error happened.
                $('#error').html('<div class="alert alert-danger">Se ha producido un error. No encontramos al usuario.</div>');
                });
                    
    }
    function createUser(){
        var name = $('#add_user_name').val();
        var email = $('#add_user_email').val();
        var privilege = $('#add_user_privilege').val();
        var password = $('#add_user_password').val();

        $('#error3').html('<div class="alert alert-info">Por favor espere...</div>');	

        //Check if username and password are entered or not
        if(name.length==0 || email.length==0)
        {
          $('#error3').html('<div class="alert alert-danger">Todos los campos son necesarios</div>');
          return;	
        }
        //Crear seguna instancia de Parse
            var config = {
            apiKey: "AIzaSyDN9HGLIAnGUvTFO-5a3YUfEDUR2X4tWyw",
            authDomain: "clean-master-calendar.firebaseapp.com",
            databaseURL: "https://clean-master-calendar.firebaseio.com",
            storageBucket: "",
            };
                var secondaryApp = firebase.initializeApp(config, "Secondary");

        //Si todos los campos estan procede a crear el usuario
        secondaryApp.auth().createUserWithEmailAndPassword(email, password).then(function(firebaseUser) {
            console.log("User " + firebaseUser.uid + " created successfully!");
                    firebase.database().ref('users/' + firebaseUser.uid).set({
                    email: email,
                    enable: true,
                    privilege: privilege,
                    uid: firebaseUser.uid,
                    username: name,
                    
                 });
            //I don't know if the next statement is necessary 
            secondaryApp.auth().signOut();
            location.reload();
        });

         $('#error3').html('<div class="alert alert-success">Usuario creado exitosamente</div>');	
    }

</script>

</body>
</html>