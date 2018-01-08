<!-- TOP BAR -->

<nav class="navbar top">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>

        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php"><image class="logoIMG" src="images/logo.png"></a><!-- Imagen logo -->
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        
        <li id="menu_calendar"><a href="index.php">
		<img class="iconMenu" src="images/icons/calendar.png">
		Calendario <span class="sr-only">(current)</span></a></li>
        
		<!-- <li id="menu_units"><a href="users.php">
		<img class="iconMenu" src="images/icons/units.png">
		Unidades</a></li> -->
    
    <!--
		<li id="menu_services"><a href="#">
		<img class="iconMenu" src="images/icons/services.png">
		Servicios</a></li>

    <li id="menu_notes"><a href="#">
		<img class="iconMenu" src="images/icons/notes.png">
		Notas</a></li> -->

    <li id="menu_history"><a href="history.php">
		<img class="iconMenu" src="images/icons/change.png">
		Historial</a></li>

    <li id="menu_times"><a onclick="showTimes();" href="#">
		<img class="iconMenu" src="images/icons/times.png">
		Tiempos</a></li>

     <li id="data_base_log" class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
			<img class="iconMenu" src="images/icons/mail.png">
			Base de datos <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <!-- <li><a href="#" onclick='exportScheduler("png");'>Descargar como Imagen</a></li> -->
            <li><a href="emails.php">Base de datos de aplicación</a></li>
            <li><a href="emails_page.php">Base de datos página webl</a></li>
          </ul>
        </li>
        
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
			<img class="iconMenu" src="images/icons/export.png">
			Descargar <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <!-- <li><a href="#" onclick='exportScheduler("png");'>Descargar como Imagen</a></li> -->
            <li><a href="#" onclick='exportScheduler("pdf");'>Descargar como PDF</a></li>
            <li><a href="#" onClick="scheduler.exportToExcel();">Descargar como lista simple en Excel</a></li>
          </ul>
        </li>

      </ul>


      <ul class="nav navbar-nav navbar-right">

        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
			<img class="iconMenu" src="images/icons/sales.png">  
			    <span id="userName">cargando...</span>
          <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li id="sub_menu_units"><a href="users.php">Personal</a></li>
            <li><a href="#" onclick="showPP();">Privacidad</a></li>
            <li><a href="#" onclick="showTips();">Mostrar ayuda</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#" onClick="firebaseLogOut();">Cerrar Sesion</a></li>
          </ul>
        </li>
      </ul>

      <!--
      <form class="navbar-form navbar-right">
        <div class="form-group">
          <input style="height: 34px;" type="text" class="menuStyle form-control" placeholder="Buscar...">
        </div>
      </form> -->


    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<!-- End TOP BAR -->