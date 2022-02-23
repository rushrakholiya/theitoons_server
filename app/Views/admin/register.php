<?php $session = \Config\Services::session();?>
<body class="hold-transition register-page">
<div class="register-box">
  
  <div class="register-logo">
    <img src="<?= base_url();?>/public/assets/dist/img/logo.png" alt="Logo" class="brand-image img-circle elevation-3" style="width: 20%;"><br>
    <b>Registration</b>
  </div>

  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">Get ready to scale</p>

      <?php 
      /*$db = db_connect();
      $query = $db->query("SELECT * FROM `users` WHERE `user_id` = 1");
      $result = $query->getRow();
      echo $result->user_name;
      print_r($result);*/
      if($session->getTempdata('error')){?>
          <span class="text-danger input-group mt-1 ml-1 mb-1"><?= $session->getTempdata('error'); ?></span>
      <?php }?>

      <?= form_open(); ?>
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Username *" name="username" value="<?= set_value('username');?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
          <span class="text-danger input-group mt-1 ml-1"><?= display_error($validation,'username'); ?></span>        
        </div>

        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email *" name="email" value="<?= set_value('email');?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
          <span class="text-danger input-group mt-1 ml-1"><?= display_error($validation,'email'); ?></span>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password *" name="password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
          <span class="text-danger input-group mt-1 ml-1"><?= display_error($validation,'password'); ?></span>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Retype password *" name="pass_confirm">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
          <span class="text-danger input-group mt-1 ml-1"><?= display_error($validation,'pass_confirm'); ?></span>
        </div>
        <div class="row mb-3">
          <div class="col-12">
            <div class="icheck-primary">
              <input type="checkbox" id="agreeTerms" name="terms" value="1" <?= set_checkbox('terms', '1'); ?>>
              <label for="agreeTerms">
               Please confirm that you agree to our <a href="#">privacy policy</a>
              </label>
            </div>
            <span class="text-danger input-group mt-1 ml-1"><?= display_error($validation,'terms'); ?></span>
          </div>
        </div>
        <div class="row justify-content-center">
          <!-- /.col -->
          <div class="col-6">
            <button type="submit" class="btn btn-primary btn-block">Create Account</button>
          </div>
          <!-- /.col -->
        </div>
      <?= form_close(); ?>
      
      <!--<div class="social-auth-links text-center">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i>
          Sign up using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i>
          Sign up using Google+
        </a>
      </div>-->

      <p class="mb-1 mt-4 text-center">
          Already have an account? <a href="<?= base_url();?>/login">Login here</a>
      </p>

    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->