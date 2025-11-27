<?php
session_start();
if (!isset($_SESSION['userid']) || empty($_SESSION['userid'])) {
  header("Location: login.php");
  exit;
}
$userid = $_SESSION['userid'];
$firstname = $_SESSION['firstname'];
$fullname = $_SESSION['fullname'];
?>

<head>
  <link rel="icon" type="image/x-icon" href="assets/image/neocash.ico">
  <title>Equipment Tracking System</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Century+Gothic:wght@100;200;300;400;500;600;700;800;900&display=swap');

    .light {
      background-image: url("assets/image/10.png");
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
      background-repeat: no-repeat;
    }

    .dark {
      background-image: url("assets/image/12.png");
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
      background-repeat: no-repeat;
    }
  </style>
</head>

<body id="body">
  <nav class="navbar navbar-expand-sm sticky-top bg-body py-0 shadow-sm me-auto">
    <a class="navbar-brand d-flex align-items-center ms-1" href="#">
      <img src="assets/image/Neologo.png" width="30" height="30" class="d-inline-block align-top me-2" alt="">
      <strong style="font-family: Century Gothic, sans-serif;">NEOCASH|Equipment Tracking System</strong>
    </a>
    <button class="btn btn-outline-secondary ms-auto me-3" type="button" data-bs-toggle="offcanvas"
      data-bs-target="#sidebar">
      <i class="fa fa-bars" aria-hidden="true"></i> </button>
  </nav>

  <nav class="navbar fixed-bottom navbar-light py-0 footer" style="z-index: 0;">
    <a class="navbar-brand strong mr-auto" href="#" style="font-size: 0.7rem; font-family: Fahkwang, sans-serif;">&copy;
      NLI, All Rights Reserved <?php echo date('Y'); ?></a>
  </nav>

  <div class="offcanvas offcanvas-end" style="width: 300px;" id="sidebar">
    <div class="offcanvas-header">
      <h4 class="offcanvas-title">Hi, <?= $firstname ?>!</h4>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body">
      <hr class="my-3">

      <div class="d-flex flex-column">
        <div class="mb-3">
          <div class="fw-bold">Equipment Summary</div>
          <ul class="list-group">
            <li class="list-group-item d-flex justify-content-between">
              <div class="small">Total equipment</div>
              <span id="total" class="badge bg-secondary rounded-pill"></span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
              <div class="small">In Stock</div>
              <span id="instock" class="badge bg-success rounded-pill"></span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
              <div class="small">Deployed</div>
              <span id="deployed" class="badge bg-primary rounded-pill"></span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
              <div class="small">Damaged</div>
              <span id="damaged" class="badge bg-danger rounded-pill"></span>
            </li>
          </ul>
        </div>

        <div class="mb-3">
          <div class="fw-bold">Actions</div>
          <div class="list-group">
            <a href="#" class="d-flex justify-content-between list-group-item list-group-item-action small"
              data-type="add" data-bs-toggle="modal" data-bs-target="#unitmodal">
              Add Unit
              <i class="fa fa-plus me-2" aria-hidden="true"></i>
            </a>
            <a href="#" class="d-flex justify-content-between list-group-item list-group-item-action small"
              data-type="stock" data-bs-toggle="modal" data-bs-target="#equipmentmodal">
              Add Equipment
              <i class="fa fa-laptop me-2" aria-hidden="true"></i>
            </a>
          </div>
        </div>

        <div class="mb-3">
          <div class="fw-bold">Settings</div>
          <div class="list-group">
            <a href="#" class="list-group-item d-flex justify-content-between" aria-current="true">
              <div class="small">Toggle Dark mode</div>
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="darkModeSwitch" checked>
              </div>
            </a>
            <button type="button"
              class="list-group-item d-flex justify-content-between list-group-item-action fw-bold logoutbtn">
              <div class="small text-danger">Logout</div>
              <i class="fa fa-sign-out me-2 text-danger" aria-hidden="true"></i>
            </button>
          </div>
        </div>
      </div>

      <hr class="my-3">
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.7/sweetalert2.all.min.js"></script>
  <script>
    $(document).ready(function () {

      const htmlElement = $('html');
      const switchElement = $('#darkModeSwitch');
      const body = $('#body');

      const currentTheme = localStorage.getItem('bsTheme') || 'light';
      htmlElement.attr('data-bs-theme', currentTheme);
      switchElement.prop('checked', currentTheme === 'dark');

      switchElement.on('change', function () {
        if ($(this).is(':checked')) {
          htmlElement.attr('data-bs-theme', 'dark');
          localStorage.setItem('bsTheme', 'dark');
          body.removeClass('light');
          body.addClass('dark');
        } else {
          htmlElement.attr('data-bs-theme', 'light');
          localStorage.setItem('bsTheme', 'light');
          body.removeClass('dark');
          body.addClass('light');
        }
      });

      if (currentTheme === 'light') {
        body.removeClass('dark');
        body.addClass('light');
      } else {
        body.removeClass('light');
        body.addClass('dark');
      }

      $.ajax({
        url: 'load/getnumbers.php',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
          $('#total').text(data.total);
          $('#instock').text(data.instock);
          $('#deployed').text(data.deployed);
          $('#inrepair').text(data.inrepair);
          $('#damaged').text(data.damaged);
        }
      });

      $('.logoutbtn').click(function () {
        Swal.fire({
          icon: 'success',
          title: 'Logging Out',
          showConfirmButton: false,
          timer: 1500,
          timerProgressBar: true
        }).then(function () {
          window.location.href = "logout.php";
        })
      });
    });
  </script>