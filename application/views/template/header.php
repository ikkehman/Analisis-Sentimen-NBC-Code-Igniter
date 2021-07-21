 <head>
  <title>Sistem Pengaduan Tenag Kerja</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
 <!-- CSS  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" type="text/css" rel="stylesheet"/>
    <link href="<?php echo base_url('assets/css/ikkeh.css'); ?>" type="text/css" rel="stylesheet"/>
    <link href="<?php echo base_url('assets/css/ready.css?version'.filemtime('assets/css/ready.css')); ?>" type="text/css" rel="stylesheet"/>
    <link href="<?php echo base_url('assets/css/demo.css'); ?>" type="text/css" rel="stylesheet"/>
    <link href="<?php echo base_url('assets/datepicker/dist/css/bootstrap-datepicker3.standalone.min.css'); ?>" type="text/css" rel="stylesheet"/>

<script src="<?php echo base_url('assets/js/core/jquery.3.2.1.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/plugin/webfont/webfont.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/core/popper.min.js'); ?>"></script>

</head>
<body data-background-color="bg3">

  <div class="main-header">
      <!-- Logo Header -->
      <div class="logo-header">
        <!--
          Tip 1: You can change the background color of the logo header using: data-background-color="black | dark | blue | purple | light-blue | green | orange | red"
        -->
        <a href="<?php echo base_url('dashboard'); ?>" class="big-logo">
          <img style="max-height: 45px;" src="<?php echo base_url('assets/images/logo-s.png'); ?>" alt="logo img" class="logo-img">
        </a>
        <a href="<?php echo base_url('dashboard'); ?>" class="logo">
          <img style="max-height: 45px;" src="<?php echo base_url('assets/images/logo-b.png'); ?>" alt="navbar brand" class="navbar-brand">
        </a>
        <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon">
            <i class="la la-bars"></i>
          </span>
        </button>
        <button class="topbar-toggler more"><i class="la la-ellipsis-v"></i></button>
      </div>
      <!-- End Logo Header -->
      <!-- Navbar Header -->
      <nav class="navbar navbar-header navbar-expand-lg">
        <div class="container-fluid">
          <div class="navbar-minimize">
            <button class="btn btn-minimize btn-rounded">
              <i class="la la-navicon"></i>
            </button>
          </div>
          <div class="collapse" id="search-nav">
          </div>
          <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
            <li class="nav-item toggle-nav-search hidden-caret">
              <a class="nav-link" data-toggle="collapse" href="#search-nav" role="button" aria-expanded="false" aria-controls="search-nav">
                <i class="flaticon-search-1"></i>
              </a>
            </li>
            <li class="nav-item dropdown hidden-caret">
              <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="flaticon-alarm"></i>
              </a>
              <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
                <li>
                </li>
                <li>
                  <div class="notif-center">
                  </div>
                </li>
                <li>
                  <a class="see-all" href="<?php echo base_url('surat'); ?>">Lihat semua pesan.<i class="la la-angle-right"></i> </a>
                </li>
              </ul>
            </li>
            <li class="nav-item dropdown hidden-caret">
              <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false"> <img src="<?php echo base_url('assets/images/') . $this->session->userdata('avatar'); ; ?>" alt="image profile" width="40" height="40" class="img-circle"></a>
              <ul class="dropdown-menu dropdown-user animated fadeIn">
                <li>
                  <div class="user-box">
                    <div class="u-img"><img src="<?php echo base_url('assets/images/') . $this->session->userdata('avatar'); ; ?>" alt="image profile"></div>
                    <div class="u-text">
                      <h4><?php echo ucwords($this->session->userdata('level')); ?></h4>
                      <p class="text-muted"><?php echo ucwords(strtolower($this->session->userdata('nama'))); ?></p>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="<?php echo base_url('auth/logout'); ?>">Logout</a>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </nav>
      <!-- End Navbar -->
    </div>

<script>
    WebFont.load({
    google: {"families":["Montserrat:100,200,300,400,500,600,700,800,900"]},
    custom: {"families":["Flaticon", "LineAwesome"], urls: ['<?php echo base_url('assets/css/fonts.css'); ?>']},
    active: function() {
    sessionStorage.fonts = true;
  }
});
</script>

<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>