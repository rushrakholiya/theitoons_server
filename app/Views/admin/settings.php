<?php $session = \Config\Services::session();?>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  <?= $this->include("admin/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Settings</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      
      <?php if($session->getTempdata('success')){?>
        <div class="alert alert-success">
          <?= $session->getTempdata('success');?>
        </div>
      <?php }?>

      <?php if($session->getTempdata('error')){?>
        <div class="alert alert-danger">
          <?= $session->getTempdata('error');?>
        </div>
      <?php }?>

      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-12 col-sm-8">      
            <div class="card card-primary card-tabs">
              <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">General</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Payment</a>
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-one-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                     <?= form_open_multipart('admin/settings/generalSetting','class="form-horizontal" id="generalForm"'); ?>
                     <div class="form-group row">
                      <label for="sitename" class="col-sm-3 col-form-label">Site Name</label>
                      <?php $site_name = getGeneralData("site_name");
                      if(!empty($site_name->option_value))
                        {$sitename=$site_name->option_value;}else{$sitename="";}?>
                      <div class="col-sm-9">
                        <input type="text" id="sitename" name="sitename" class="form-control" value="<?= $sitename;?>">
                      </div>
                     </div>
                     <div class="form-group row">
                      <label for="sitename" class="col-sm-3 col-form-label">Admin Email</label>
                      <?php $admin_email = getGeneralData("admin_email");
                      if(!empty($admin_email->option_value))
                        {$admin_email=$admin_email->option_value;}else{$admin_email="";}?>
                      <div class="col-sm-9">
                        <input type="email" id="admin_email" name="admin_email" class="form-control" value="<?= $admin_email;?>">
                      </div>
                     </div>
                     <div class="form-group row">
                      <label for="sitefavicon" class="control-label col-sm-3 col-form-label">Site Favicon</label>
                      <div class="col-sm-9">
                        <input type="file" class="form-control sitefavicon userProfilePicture" name="sitefavicon" />
                      </div>
                     </div> 
                     <div class="form-group row">
                      <label for="sitelogo" class="control-label col-sm-3 col-form-label">Site Logo</label>
                      <div class="col-sm-9">
                        <input type="file" class="form-control sitelogo userProfilePicture" name="sitelogo"/>
                      </div>
                     </div>
                     <div class="form-group">
                      <input type="submit" value="Save Settings" class="btn btn-success float-right">
                     </div>                    
                     <?= form_close();?>
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                     <?= form_open_multipart('admin/settings/paypalSetting','class="form-horizontal"'); ?>
                     <div class="card card-default">
                        <div class="card-header">
                          <h3 class="card-title pt-2">Paypal</h3>
                          <div class="card-tools">
                            <div class="custom-control custom-switch">
                              <?php $paypal_enable_disable = getGeneralData("paypal_enable_disable");
                            if(!empty($paypal_enable_disable->option_value))
                              {$paypal_enable_disable=$paypal_enable_disable->option_value;}else{$paypal_enable_disable="";}?>
                              <input type="checkbox" value="1" class="custom-control-input" id="paypalenable" name="paypalenable" <?php if($paypal_enable_disable==1){echo "checked"; }?>>
                              <label class="custom-control-label" for="paypalenable">Enable/Disable</label>
                            </div>
                          </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                          <div class="form-group row">
                            <label for="paypal_sandbox" class="control-label col-sm-3 col-form-label">PayPal sandbox</label>
                            <?php $paypal_sandbox = getGeneralData("paypal_sandbox");
                            if(!empty($paypal_sandbox->option_value))
                              {$paypal_sandbox=$paypal_sandbox->option_value;}else{$paypal_sandbox="";}?>
                            <div class="col-sm-9 pt-2">
                              <div class="form-check">
                                <input class="form-check-input" value="1" type="checkbox" id="paypalsandbox" name="paypalsandbox" <?php if($paypal_sandbox==1){echo "checked"; }?>>
                                <label class="form-check-label" for="paypalsandbox">Enable PayPal sandbox</label>
                              </div>
                            </div>
                          </div>                         
                          <div class="form-group row">
                            <label for="paypalemail" class="col-sm-3 col-form-label">PayPal Email</label>
                            <?php $paypal_email = getGeneralData("paypal_email");
                            if(!empty($paypal_email->option_value))
                              {$paypalemail=$paypal_email->option_value;}else{$paypalemail="";}?>
                            <div class="col-sm-9">
                              <input type="email" id="paypalemail" name="paypalemail" class="form-control" value="<?= $paypalemail;?>">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="paypalreceiveremail" class="col-sm-3 col-form-label">Receiver Email</label>
                            <?php $receiver_email = getGeneralData("receiver_email");
                            if(!empty($receiver_email->option_value))
                              {$paypalreceiveremail=$receiver_email->option_value;}else{$paypalreceiveremail="";}?>
                            <div class="col-sm-9">
                              <input type="email" id="paypalreceiveremail" name="paypalreceiveremail" class="form-control" value="<?= $paypalreceiveremail;?>">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="live_API_username" class="col-sm-3 col-form-label">Live API username</label>
                            <?php $live_API_username = getGeneralData("live_API_username");
                            if(!empty($live_API_username->option_value))
                              {$live_API_username=$live_API_username->option_value;}else{$live_API_username="";}?>
                            <div class="col-sm-9">
                              <input type="text" id="live_API_username" name="live_API_username" class="form-control" value="<?= $live_API_username;?>">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="live_API_password" class="col-sm-3 col-form-label">Live API Password</label>
                            <?php $live_API_password = getGeneralData("live_API_password");
                            if(!empty($live_API_password->option_value))
                              {$live_API_password=$live_API_password->option_value;}else{$live_API_password="";}?>
                            <div class="col-sm-9">
                              <input type="password" id="live_API_password" name="live_API_password" class="form-control" value="<?= $live_API_password;?>">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="live_API_signature" class="col-sm-3 col-form-label">Live API Signature</label>
                            <?php $live_API_signature = getGeneralData("live_API_signature");
                            if(!empty($live_API_signature->option_value))
                              {$live_API_signature=$live_API_signature->option_value;}else{$live_API_signature="";}?>
                            <div class="col-sm-9">
                              <input type="password" id="live_API_signature" name="live_API_signature" class="form-control" value="<?= $live_API_signature;?>">
                            </div>
                          </div>
                          <div class="form-group">
                            <input type="submit" value="Save Settings" class="btn btn-success float-right">
                          </div>           
                        </div>
                        <!-- /.card-body -->
                        
                      </div>
                      <?= form_close();?>
                  </div>
                </div>
              </div>
              <!-- /.card -->
            </div>
          </div>
          <?php $site_favicon=getGeneralData("site_favicon");
          if(!empty($site_favicon->option_value)){?>
          <div class="col-md-2 sitefavicon">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Fav icon</h3>
              </div>          
              <div class="card-body">
                <div class="form-group">
                    <img class="img-circle mx-auto d-block" src="<?= $site_favicon->option_value;?>" height="60px" width="60px">
                </div>
              </div>
            </div>
          </div>
          <?php }?>
          <?php $site_logo=getGeneralData("site_logo");
          if(!empty($site_logo->option_value)){?>
          <div class="col-md-2 sitelogo">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Logo</h3>
              </div>          
              <div class="card-body">
                <div class="form-group">
                    <img class="img-circle mx-auto d-block" src="<?= $site_logo->option_value;?>" height="60px" width="60px">
                </div>
              </div>
            </div>
          </div>
          <?php }?>
        </div>
        <!-- /.row -->
        
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <script src="//geodata.solutions/includes/countrystatecity.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.5.3/js/bootstrapValidator.js"></script>
  <script>
    $(document).ready(function() {
        $('#generalForm').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                sitefavicon: {
                    validators: {
                        file: {
                            extension: 'jpg,jpeg,png',
                            type: 'image/jpg,image/jpeg,image/png',
                            message: 'The selected file is not valid'
                        }
                    }
                },
                sitelogo: {
                    validators: {
                        file: {
                            extension: 'jpg,jpeg,png',
                            type: 'image/jpg,image/jpeg,image/png',
                            message: 'The selected file is not valid'
                        }
                    }
                }
            }
        });
    });

    $('a[data-toggle="pill"]').on('shown.bs.tab', function (e) {
      var target = $(e.target).attr("href") // activated tab
      //alert(target);
      if (target != "#custom-tabs-one-profile")
      {
        $(".sitefavicon").show();
        $(".sitelogo").show();
      }else{
        $(".sitefavicon").hide();
        $(".sitelogo").hide();
      }
    });
    
  </script>
 <link rel="stylesheet" href="<?= base_url();?>/public/assets/dist/css/userforms.css"> 