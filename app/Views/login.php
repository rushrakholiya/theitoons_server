<?php $session = \Config\Services::session();?>
<body class="hold-transition login-page">
<div class="login-box">   
  <div class="login-logo">
    <?php $site_logo=getGeneralData("site_logo");
          if(!empty($site_logo->option_value))
            {$site_logo=$site_logo->option_value;}else{$site_logo = base_url()."/public/assets/dist/img/logo.png";}?>
    <img src="<?= $site_logo;?>" alt="Logo" class="brand-image img-circle elevation-3" style="width: 20%;"><br>
    <!--<span class="brand-text font-weight-light">TheIToons</span><br>-->
    <b>Login</b>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Login to start your session</p>

      <?php if($session->getTempdata('success')){?>
        <span class="text-success input-group mt-1 ml-1 mb-2"><?= $session->getTempdata('success'); ?></span>
      <?php }?>

      <?php if($session->getTempdata('error')){?>
        <span class="text-danger input-group mt-1 ml-1 mb-2"><?= $session->getTempdata('error'); ?></span>
      <?php }?>

      <?= form_open(); ?>
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email *" name="email" value="<?= set_value('email');?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
          <?php if(isset($validation)){?>
          <span class="text-danger input-group mt-1 ml-1"><?php echo displayError($validation,'email'); ?></span><?php }?> 
        </div>
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
        <div class="row justify-content-center">          
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Login</button>
          </div>
          <!-- /.col -->
        </div>
      <?= form_close(); ?>

      <p class="mb-1 mt-4">
        <a href="<?= base_url();?>/login/forgotPassword">I forgot my password</a>
      </p>
      <p class="mb-0">
        <a href="<?= base_url();?>/register" class="text-center">Register a new membership</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->