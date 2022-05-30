<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= esc($title); ?></title>
  <?php $site_favicon=getGeneralData("site_favicon");
          if(!empty($site_favicon->option_value))
            {$site_favicon=$site_favicon->option_value;}else{$site_favicon = base_url()."/public/assets/dist/img/logo.png";}?>
  <link rel="icon" href="<?= $site_favicon;?>">
  
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url();?>/public/assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url();?>/public/assets/dist/css/adminlte.min.css"> 
  
  <?php $menu_name ="";
  $uri = current_url();
  $uriarray = explode('/', $uri);
  if (in_array("dashboard", $uriarray)) { $menu_name = 'dashboard';}
  if (in_array("allTaskRequests", $uriarray)) { $menu_name = 'allTaskRequests';}?>
  
  <?php if($menu_name =="allTaskRequests"){?>
  <link rel="stylesheet" href="?= base_url();?>/public/assets/plugins/ekko-lightbox/ekko-lightbox.css">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
  <?php }

  if($menu_name =="dashboard"){?>
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="<?= base_url();?>/public/assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?= base_url();?>/public/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="<?= base_url();?>/public/assets/plugins/jqvmap/jqvmap.min.css">  
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?= base_url();?>/public/assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?= base_url();?>/public/assets/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="<?= base_url();?>/public/assets/plugins/summernote/summernote-bs4.min.css">
<?php } ?>

<!-- jQuery -->
<script src="<?= base_url();?>/public/assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url();?>/public/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<script>
  // @see https://docs.headwayapp.co/widget for more configuration options.
  var HW_config = {
    selector: ".CHANGE_THIS", // CSS selector where to inject the badge
    account:  "xGEpOJ"
  }
</script>
<script async src="https://cdn.headwayapp.co/widget.js"></script>
</head>