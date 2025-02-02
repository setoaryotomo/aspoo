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
        <div class="col-md-6 mt-2">
          <h2 class="title-login">Buat Akun</h2>

          <form class="pt-2">
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="material-icons fa-2x">person</i>
                  </span>
                </div>
                <input type="text" class="form-control input-login" name="nama" placeholder="Nama">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="material-icons fa-2x">email</i>
                  </span>
                </div>
                <input type="text" class="form-control input-login" name="username" placeholder="username">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="material-icons fa-2x">lock</i>
                  </span>
                </div>
                <input onkeyup="check()" type="password" id="password" class="form-control input-login" name="username" placeholder="Password">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="material-icons fa-2x">lock</i>
                  </span>
                </div>
                <input onkeyup="check()" type="password" id="confirm_password" class="form-control input-login" name="confirmpass" placeholder="Confirm Password">
              </div>
              <span class="confirm-pass" id="message"></span>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-1">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="material-icons fa-2x">person_add</i>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="col-10 ml-3">
                  <select class="form-control selectpicker select-role" data-style="btn btn-link" id="exampleFormControlSelect1">
                    <option>Admin</option>
                    <option>Super Admin</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="form-group pt-2 text-center">
              <button href="#" class="btn btn-akun1 btn-lg btn-round">Buat Akun</button>
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
  var check = function() {
    if (document.getElementById('password').value == document.getElementById('confirm_password').value) {
      document.getElementById('message').innerHTML = 'password sama';
      document.getElementById('message').style.color = 'green';
    } else {
      document.getElementById('message').innerHTML = 'password tidak sama';
      document.getElementById('message').style.color = 'red';
    }
  }
</script>

</html>