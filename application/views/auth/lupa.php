<title>Sistem pendaftaran uji coba</title>
<!-- css files -->
<link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome.css'); ?>"> <!-- Font-Awesome-Icons-CSS -->
<link rel="stylesheet" href="<?php echo base_url('assets/css/login.css'); ?>" type="text/css" media="all" /> <!-- Style-CSS --> 
<!-- //css files -->
<!-- web-fonts -->
<link href="//fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700" rel="stylesheet">
<link href="//fonts.googleapis.com/css?family=Josefin+Slab:100,300,400,600,700" rel="stylesheet">
<!-- //web-fonts -->
</head>
<body>
    <!--header-->
    <div class="header-w3l">
      <h1><a href="<?php echo base_url(''); ?>"><img align="center" style="max-width: 250px" src="<?php echo base_url('assets/images/logo.png'); ?>" alt="Kcdev Logo"></a></h1>
    </div>
    <!--//header-->
    <!--main-->
    <div class="main-w3layouts-agileinfo">
             <!--form-stars-here-->
            <div class="wthree-form">
              <h2>Masukkan Email Anda. Passsword baru akan dikirim lewat Email.</h2>
              <form action="<?php echo base_url('reset/doforget'); ?>" method="post">

        <?php if( $message = $this->session->flashdata('message')): ?>
          <div style="color: white; text-shadow: 3px 3px 4px #000; border-style: solid;border-width: 1px; padding: 5px; margin-bottom: 10px; text-align: center;">
            <?php echo $message['message']; ?>
          </div>
        <?php elseif( $message = $this->session->flashdata('message')): ?>
          <div style="color: white; text-shadow: 3px 3px 4px #000; border-style: solid;border-width: 1px; padding: 5px; margin-bottom: 10px; text-align: center;">
            <?php echo $message['message']; ?>
          </div>
        <?php endif; ?>

                <div class="form-sub-w3">
                  <input type="text" name="username" placeholder="Email... " required="wajib diisi" />
                <div class="icon-w3">
                  <i class="fa fa-user" aria-hidden="true"></i>
                </div>
                </div>
                <div class="clear"></div>
                <div class="submit-agileits">
                  <input type="submit" name="submit" value="Reset">
                </div>
              </form>

            </div>
        <!--//form-ends-here-->

    </div>
    <!--//main-->
</body>