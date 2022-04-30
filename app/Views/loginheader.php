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
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?= base_url();?>/public/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url();?>/public/assets/dist/css/adminlte.min.css">
<?php $menu_name ="";
$uri = current_url();
$uriarray = explode('/', $uri);
if (in_array("taskRequest", $uriarray)) { $menu_name = 'taskRequest';}
if (in_array("dashboard", $uriarray)) { $menu_name = 'dashboard';}
if (in_array("viewTaskRequest", $uriarray)) { $menu_name = 'viewTaskRequest';}
if (in_array("editTaskRequest", $uriarray)) { $menu_name = 'editTaskRequest';}

if($menu_name=="taskRequest" || $menu_name=="dashboard" || $menu_name=="viewTaskRequest" || $menu_name=="editTaskRequest"){?>
  <link rel="stylesheet" href="<?= base_url();?>/public/assets/dist/css/taskdashboard.css">
<?php }

if($menu_name =="editTaskRequest"){?>
  <link rel="stylesheet" href="?= base_url();?>/public/assets/plugins/ekko-lightbox/ekko-lightbox.css">
<?php }

if($menu_name=="taskRequest" || $menu_name=="editTaskRequest"){?>
  <link rel="stylesheet" href="<?= base_url();?>/public/assets/dist/css/userforms.css">
  <!-- bootstrap slider -->
  <link rel="stylesheet" href="<?= base_url();?>/public/assets/plugins/bootstrap-slider/css/bootstrap-slider.min.css">

  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css" /> -->
  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
<?php }?>
</head>