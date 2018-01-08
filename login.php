<?php require_once("assets/header.php"); ?>

    <script>
    //Chequea si el usuario Iniciso sesion
    firebase.auth().onAuthStateChanged(function(user) {
        if (user) {
          //Informacion del usuario
          var name, email, photoUrl, uid;
          name = user.displayName;
          email = user.email;
          uid = user.uid; 
          //Chequea si el usuario esta activo
              return firebase.database().ref('/users/' + uid).once('value').then(function(snapshot) {
                if(snapshot.val()){
                    var isEnable = snapshot.val().enable;
                    if(isEnable == true){
                      $('#error').html('<div class="alert alert-success">Correcto, por favor espere....</div>');
                      window.location.replace("index.php");
                    } else {
                      //significa que el usuario esta desactivo
                      $('#error').html('<div class="alert alert-danger">Usuario desactivado</div>');
                        firebase.auth().signOut().then(function() {
                           $('#error').html('<div class="alert alert-danger">Usuario desactivado</div>');
                           $(".btn-lg").prop('disabled', false);
                        }, function(error) {
                            // An error happened.
                             $('#error').html('<div class="alert alert-danger">Se ha producido un error.</div>');
                        });
                    }
                } else {
                  //Normalmente es cuando se agregan usuarios de Google FireBase
                  firebase.database().ref('users/' + uid).set({
                      uid: uid,
                      username: name,
                      enable: true,
                      email: email,
                      ready: true,
                      privilege: "admin" //Por defecto son Admin ya que los otros desde el inicio se instancian
                    });
                    window.location.replace("index.php");
                }
              

              });

        } else {
          // No user is signed in.
          console.log("No hay sesion");
        }
      });
    </script>

      <style type="text/css" media="screen">
          body {
          /** background-color: #00b1e9; **/
          /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#03fcfe+0,1d81bc+51,2d3695+100 */
background: #03fcfe; /* Old browsers */
background: -moz-linear-gradient(top,  #03fcfe 0%, #1d81bc 51%, #2d3695 100%); /* FF3.6-15 */
background: -webkit-linear-gradient(top,  #03fcfe 0%,#1d81bc 51%,#2d3695 100%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(to bottom,  #03fcfe 0%,#1d81bc 51%,#2d3695 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#03fcfe', endColorstr='#2d3695',GradientType=0 ); /* IE6-9 */

          }
          .wrapper {    
          margin-top: 80px;
          margin-bottom: 20px;
          }
          .logoIMG {
                width: 60%;
                margin-left: 20% !important;
            }
          /** custom Footer **/
          .text-muted {
              color: #d0d0d0;
              text-align: center;
          }
          .footer {
              border: 1px solid #2655a5;
              background: rgb(31, 52, 130);
          }
          @media (max-width: 980px) {
            .footer {
            display: block;

            }
            }
      </style>

  </head>

  <body>

    <!-- Begin page content -->
    <div class="container">

          <div class = "container">
            <div class="wrapper">
              <form action="" method="post" name="Login_Form" class="form-signin">       
                  <image class="logoIMG" src="images/logo.png"></a><!-- Imagen logo -->
                  <hr class="colorgraph"><br>
                      
                      <!--Error division start -->		
                      <div id="error"> </div>
                      <!--Error division end  -->

                  <input type="text" class="form-control" id="username" placeholder="correo" required="" autofocus="" />
                  <input type="password" class="form-control" id="password" placeholder="contraseña" required=""/>     		  
                
                  <button class="btn btn-lg btn-primary btn-block" onClick="login();return false;" value="Login">Iniciar sesión</button>  			
              </form>			
            </div>
    </div>
      
    </div>

    <?php require_once("assets/layout/footer.php"); ?>

    <script>
    function login(){

        var username = $('#username').val();
        var password = $('#password').val();

        $('#error').html('<div class="alert alert-info">Por favor espere...</div>');	

        //Check if username and password are entered or not
        if(username.length==0 || password.length==0)
        {
          $('#error').html('<div class="alert alert-danger">Todos los campos son necesarios</div>');
          return;	
        }

        $(".btn-lg").prop('disabled', true);
        //Friebase login
        firebase.auth().signInWithEmailAndPassword(username, password).catch(function(error) {
          // Handle Errors here.
              $('#error').html('<div class="alert alert-danger">Uusario o contraseña incorrecto</div>');
              $(".btn-lg").prop('disabled', false);
                  var errorCode = error.code;
                  var errorMessage = error.message;
                  console.log(errorMessage);
          return;
        });
        //Succes 
        $('#error').html('<div class="alert alert-info">Usuario encontrado. Espere...</div>');	

    }
    </script>
   </body>
</html>
