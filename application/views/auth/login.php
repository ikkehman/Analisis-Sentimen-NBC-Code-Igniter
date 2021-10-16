<title>Sistem Analisis Sentimen</title>
<!-- css files -->
<link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome.css'); ?>"> <!-- Font-Awesome-Icons-CSS -->
<link rel="stylesheet" href="<?php echo base_url('assets/css/login.css'); ?>" type="text/css" media="all" /> <!-- Style-CSS --> 
<!-- //css files -->
<!-- web-fonts -->
<link href="//fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700" rel="stylesheet">
<link href="//fonts.googleapis.com/css?family=Josefin+Slab:100,300,400,600,700" rel="stylesheet">
<!-- //web-fonts -->
 <?php echo $script_captcha; // javascript recaptcha ?>
</head>
<body>
    <!--header-->
    <div class="row">
    <div class="header-w3l">
      <h1>
      <a href="<?php echo base_url(''); ?>"><img align="center" style="max-width: 350px" src="<?php echo base_url('assets/images/logo.png'); ?>" alt="Kcdev Logo"></a></h1>
    </div>

    </div>
    <!--//header-->
    <!--main-->
    <div class="main-w3layouts-agileinfo">
             <!--form-stars-here-->
            <div class="wthree-form">
              <h2>Harap login terlebih dahulu</h2>
              <form action="<?php echo base_url('auth/login'); ?>" method="post">
                <div><?php if(validation_errors()): ?><?php echo validation_errors('<p style="color: white; text-shadow: 3px 3px 4px #000; border-style: solid;border-width: 1px; padding: 5px; margin-bottom: 10px; text-align: center;">', '</p>'); ?><?php endif; ?></div>
                <div class="form-sub-w3">
                  <input type="text" name="username" placeholder="Username... " required="wajib diisi" />
                <div class="icon-w3">
                  <i class="fa fa-user" aria-hidden="true"></i>
                </div>
                </div>
                <div class="form-sub-w3">
                  <input type="password" name="password" placeholder="Password..." required="" />
                <div class="icon-w3">
                  <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                </div>
                </div>
                <div class="form-sub-w3" align="center">
                  <?php echo $captcha // tampilkan recaptcha ?>
                </div>
                <div class="clear"></div>
                <div class="submit-agileits">
                  <input type="submit" name="submit" value="Login">
                </div>
              </form>
            </div>
        <!--//form-ends-here-->

    </div>
    <!--//main-->
</body>