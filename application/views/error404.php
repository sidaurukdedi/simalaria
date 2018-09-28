<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Error 404</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css');?>">
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/AdminLTE.min.css');?>">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition lockscreen">
  <!-- Automatic element centering -->
  <div class="lockscreen-wrapper">
    <div class="lockscreen-logo">
    <a href="<?php echo base_url('dashboard'); ?>"><b>Surveilans</b> Malaria</a>
    </div>
    <div class="error-page">
      <h2 class="headline text-yellow"> 404</h2>

      <div class="error-content">
        <h3><i class="fa fa-warning text-yellow"></i> Oops! Page not found.</h3>

        <p>
          We could not find the page you were looking for.
          Meanwhile, you may <a href="<?php echo base_url('dashboard'); ?>">return to dashboard</a>
        </p>
      </div>
      <!-- /.error-content -->
    </div>
    <div class="text-center">
      <a href="<?php echo base_url('login'); ?>">Or sign in as a different user</a>
    </div>

    <br>
    <br>
    <div class="lockscreen-footer text-center">
      Copyright &copy; <?php echo date("Y");?><b><a href="http://malaria.id/" class="text-black"> malaria.id</a></b> All rights reserved<!-- <br>
      Admin Theme By <b><a href="http://almsaeedstudio.com" class="text-black">Almsaeed Studio</a></b> Version 2.3.6<br> -->
    </div>
    <div class="lockscreen-footer text-center">
      
    </div>
  </div>
</body>
</html>


