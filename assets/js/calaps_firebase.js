
function settings(){
//Informacion del usuario
    var name, email, photoUrl, uid;
    firebase.auth().onAuthStateChanged(function(user) {

    if (user) {
        name = user.displayName;
        email = user.email;
        photoUrl = user.photoURL;
        uid = user.uid; 

            return firebase.database().ref('/users/' + uid).once('value').then(function(snapshot) {
            var username = snapshot.val().username;
            //Contenido
             $("#userName").html(username);
            });
       


    } else {
        console.log("Problema al cargar usuario");
    }
    });
}

//Agregar informacion a firebase
function writeUserData(userId, name, email, privilege) {
  firebase.database().ref('users/' + userId).set({
    username: name,
    email: email,
    privilege: privilege
  });
}

//Cerrar Sesion de FireBase
function firebaseLogOut(){
    firebase.auth().signOut().then(function() {
        window.location.replace("login.php");
    }, function(error) {
        // An error happened.
    });
}
function showTips() {
    $('#show_tips_modal').modal('toggle');
}
function showPP() {
    $('#show_pp_modal').modal('toggle');
}
function showTimes() {
    $('#show_calendar_modal').modal('toggle');
}
