<!doctype html>
<html lang="en">

<head>
  <title>Hello, world!</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- Material Kit CSS -->
  <link href="assets/css/materialdashboard.css" rel="stylesheet" />
  <!-- custom css -->
  <link rel="stylesheet" type="text/css" href="style/stylee.css">


</head>

<body>
  <div class="wrapper">
    <nav class="navbar navbar-expand-lg navbar-transparent">
        <span class="navbar-brand"><img src="IMG/logo login.png" width="30"> <span class="login-text">&nbsp Apotek Banyu Aji</span> </span>
    </nav>

    <div class="container login-form mt-md-5">
      <div class="row login">
        <div class="col-md-6 mt-md-5">
          <img src="IMG/login.png" class="img-fluid align-middle">
        </div>
        <div class="col-md-6 mt-3">
          <h1 class="title-login">Selamat Datang :)</h1>
          <p class="small-text"><small>Untuk masuk ke website silahkan isi form terlebih dahulu!</small></p class="small-text">

            <form class="pt-3">
              <div class="form-group">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="material-icons fa-2x">email</i>
                    </span>
                  </div>
                  <input type="text" class="form-control input-login" name="username" placeholder="Username">
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="material-icons fa-2x">lock</i>
                    </span>
                  </div>
                  <input type="password" id="password-field" class="form-control input-login" name="username" placeholder="Password">
                   <span toggle="#password-field" class="fa fa-fw fa-eye fa-lg field-icon toggle-password"></span>
                </div>
              </div>
              <div class="form-check ml-4 mt-2">
                <label class="form-check-label">
                  <input class="form-check-input" type="checkbox" value="">
                  ingat saya
                  <span class="form-check-sign">
                    <span class="check"></span>
                  </span>
                </label>
              </div>
              <div class="form-group pt-2 ">
                <div class="row">
                  <div class="col-md-5">
                    <button type="button" class="btn btn-lg btn-round btn-primary btn-login">Login</button>
                  </div>
                  <div class="col-md-7">
                    <a href="#" class="btn btn-akun btn-lg btn-round">Buat Akun</a>
                  </div>
                </div>
              </div>
            </form>

        </div>
      </div>
    </div>

  </div>
</body>

<!--   Core JS Files   -->
<script src="assets/js/core/jquery.min.js"></script>
<script src="assets/js/core/popper.min.js"></script>
<script src="assets/js/core/bootstrap-material-design.min.js"></script>
<script src="assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
<!-- Plugin for the momentJs  -->
<script src="assets/js/plugins/moment.min.js"></script>
<!--  Plugin for Sweet Alert -->
<script src="assets/js/plugins/sweetalert2.js"></script>
<!-- Forms Validations Plugin -->
<script src="assets/js/plugins/jquery.validate.min.js"></script>
<!-- Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
<script src="assets/js/plugins/jquery.bootstrap-wizard.js"></script>
<!--  Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
<script src="assets/js/plugins/bootstrap-selectpicker.js"></script>
<!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
<script src="assets/js/plugins/bootstrap-datetimepicker.min.js"></script>
<!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
<script src="assets/js/plugins/jquery.dataTables.min.js"></script>
<!--  Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
<script src="assets/js/plugins/bootstrap-tagsinput.js"></script>
<!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
<script src="assets/js/plugins/jasny-bootstrap.min.js"></script>
<!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
<script src="assets/js/plugins/fullcalendar.min.js"></script>
<!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
<script src="assets/js/plugins/nouislider.min.js"></script>
<!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
<!-- Library for adding dinamically elements -->
<script src="assets/js/plugins/arrive.min.js"></script>
<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<!--  Notifications Plugin    -->
<script src="assets/js/plugins/bootstrap-notify.js"></script>
<!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
<script src="assets/js/material-dashboard.min.js?v=2.1.2" type="text/javascript"></script>

<script type="text/javascript">
   $(".toggle-password").click(function() {

    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
      input.attr("type", "text");
    } else {
      input.attr("type", "password");
    }
  });
</script>

</html>