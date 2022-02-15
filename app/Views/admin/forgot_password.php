<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <img src="<?php echo $base_url;?>/dist/img/logo.png" alt="Logo" class="brand-image img-circle elevation-3" style="width: 15%;"><br>
    <!--<span class="brand-text font-weight-light">TheIToons</span><br>-->
    <b>Forgot Password</b>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>

      <form action="#" method="post">
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Request new password</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mt-4 mb-1">
        <a href="<?php echo $site_url;?>/admin">Login</a>
      </p>
      <p class="mb-0">
        <a href="<?php echo $site_url;?>/admin/register" class="text-center">Register a new membership</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->