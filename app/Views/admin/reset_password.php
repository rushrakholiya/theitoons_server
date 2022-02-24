<?php $session = \Config\Services::session();?>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <img src="<?= base_url();?>/public/assets/dist/img/logo.png" alt="Logo" class="brand-image img-circle elevation-3" style="width: 20%;"><br>
    <!--<span class="brand-text font-weight-light">TheIToons</span><br>-->
    <b>Reset Password</b>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">You are only one step a way from your new password, reset your password now.</p>

      <?php if($session->getTempdata('error')){?>
        <span class="text-danger input-group mt-1 ml-1 mb-2"><?= $session->getTempdata('error'); ?></span>
      <?php }?>

      <?php if($session->getTempdata('success')){?>
        <span class="text-success input-group mt-1 ml-1 mb-2"><?= $session->getTempdata('success'); ?></span>
      <?php }?>

      <?php if(isset ($error)){?>
        <span class="text-danger input-group mt-1 ml-1 mb-2"><?= $error; ?></span>
      <?php }?>

      <?= form_open(); ?>
      <div class="input-group mb-3">
        <input type="password" class="form-control" placeholder="Password *" name="password">
        <div class="input-group-append">
          <div class="input-group-text">
            <span class="fas fa-lock"></span>
          </div>
        </div>
        <?php if(isset($validation)){?>
        <span class="text-danger input-group mt-1 ml-1"><?php echo displayError($validation,'password'); ?></span><?php }?>
      </div>
      <div class="input-group mb-3">
        <input type="password" class="form-control" placeholder="Confirm Password *" name="confirm_password">
        <div class="input-group-append">
          <div class="input-group-text">
            <span class="fas fa-lock"></span>
          </div>
        </div>
        <?php if(isset($validation)){?>
        <span class="text-danger input-group mt-1 ml-1"><?php echo displayError($validation,'confirm_password'); ?></span><?php }?>
      </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Reset new password</button>
          </div>
          <!-- /.col -->
        </div>
      <?= form_close(); ?>

      <p class="mt-4 mb-1">
        <a href="<?= base_url();?>/login">Login</a>
      </p>
      <p class="mb-0">
        <a href="<?= base_url();?>/register" class="text-center">Register a new membership</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->