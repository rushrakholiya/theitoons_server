<?php $session = \Config\Services::session();?>
<body class="hold-transition login-page">
<div class="login-box">   
  <div class="login-logo">
    <?php $site_logo=getGeneralData("site_logo");
    if(!empty($site_logo->option_value))
    {$site_logo=$site_logo->option_value;}else{$site_logo = base_url()."/public/assets/dist/img/logo.png";}?>
    <img src="<?= $site_logo;?>" alt="Logo" class="brand-image img-circle elevation-3" style="width: 20%;"><br>
    <b>Paypal Payment</b>

    <a href="<?= base_url();?>/admin/dashboard/logout" style="color: #007bff;text-decoration: none;font-size: 1rem;" class="float-right pt-4 pr-1">Logout</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Paypal Payment</p>

      <?php if($session->getTempdata('success')){?>
        <span class="text-success input-group mt-1 ml-1 mb-2"><?= $session->getTempdata('success'); ?></span>
      <?php }?>

      <?php if($session->getTempdata('error')){?>
        <span class="text-danger input-group mt-1 ml-1 mb-2"><?= $session->getTempdata('error'); ?></span>
      <?php }?>

      <?= form_open(); ?>
        <div class="form-group mb-4">
          <label for="budget" class="mb-0 ml-1">Your Total Amount : <span id="demo">$20.00</span></label>
          <input type='hidden' name='amount' value='20'>
        </div>

        <div class="row justify-content-center">          
          <!-- /.col -->
          <div class="col-8">
            <button type="submit" class="btn btn-primary btn-block">pay with paypal</button>
          </div>
          <!-- /.col -->
        </div>
      <?= form_close(); ?>
     
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->