<?php if($user->isLoggedin()) $session->redirect("/"); ?>
<!DOCTYPE html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Inicio de sesión | Archivo Digital</title>
  <link href="https://fonts.googleapis.com/css?family=Nunito:300,400|Roboto:400,700" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/normalize/4.2.0/normalize.min.css" integrity="sha256-K3Njjl2oe0gjRteXwX01fQD5fkk9JFFBdUHy/h38ggY=" crossorigin="anonymous" rel="stylesheet">
  <link href="https://cdn.rawgit.com/cobyism/gridism/0.2.2/gridism.css" rel="stylesheet">
  <link href="<?php echo $config->urls->templates; ?>assets/styles/_main.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
  <link rel="apple-touch-icon" href="/site-boilerplate/static/455375-147357/images/favicon-180x180.png">
  <link rel="shortcut icon" href="/site-boilerplate/static/455375-147357/images/favicon-64x64.png">
</head>
<body class="login">

  <!-- Head: Logo and Main Title -->
  <header>
    <img src="https://dummyimage.com/100x100/000/fff" alt="#todo">
    <h1>Inicio de Sesión</h1>
  </header>
  <!-- Section: Login -->
  <section id="fail-user-data" class="k-alert-negative" style="display: none">
    <p>El nombre de usuario o contraseña son incorrectos.</p>
  </section>
  <section id="fail-warning" class="k-alert-warning" style="display: none">
    <p id="p-warning"></p>
  </section>
  <section id="fail-danger" class="k-alert-negative" style="display: none;">
    <p>Algo salio mal :(, refresca la pagina e intenta de nuevo.</p>
  </section>
  <section>
    <form id="login">
      <label for="user">Nombre de Usuario</label>
      <input id="user" name="user" type="text" >
      <label for="pass">Contraseña</label>
      <input id="pass" type="password" name="pass" >
      <button class="k-btn-success">
        Ingresar
      </button>
      
    </form>
  </section>
</body>
</html>
<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<script type='text/javascript'>
  $('#login').on('submit', function (e) { 
    if($("#user").val().length < 3){
        $("#p-warning").text('Ingrese su nombre de usuario completo');
        $("#fail-warning").slideDown();
        $("#user").focus();
    }else if($("#pass").val().length < 6){
        $("#p-warning").text('La contraseña debe ser de minimo 6 caracteres');
        $("#fail-warning").slideDown();
        $("#pass").focus();
    }else{
      $.ajax({
          url: "login",
          type: "post",
          data: $(this).serialize(),
          dataType: "json",
        }).done(function(msg){
          if(msg['result']){
            swal({
              title: 'Iniciando Sesión...',
              text: 'Sera redirigido en segundos',
              animation: 'slide-from-top',
              type: 'success',
              timer: 1000,
              showConfirmButton: false
              },
              setTimeout(function(){
                top.window.location='<?php echo $config->urls->root; ?>';
            }, 1300)
              );
          }else{
            $("#fail-user-data").slideDown();
            $("#user").focus();
          }
        }).fail(function (jqXHR, textStatus) {
            $("#fail-danger").slideDown();
        });
    }
    e.preventDefault(); 
  });
  $("input").change(function() {
    if ($(this).val() == '') return;
      $("#fail-warning").slideUp();
      $("#fail-user-data").slideUp();
      $("#fail-danger").slideUp();
  });
</script>