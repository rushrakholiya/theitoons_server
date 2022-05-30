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
//print_r($uriarray);
if (in_array("login", $uriarray)) { $menu_name = 'login';}
if (in_array("forgotPassword", $uriarray)) { $menu_name = 'forgotPassword';}
if (in_array("register", $uriarray)) { $menu_name = 'register';}
if (in_array("resetPassword", $uriarray)) { $menu_name = 'resetPassword';}

if (in_array("taskRequest", $uriarray)) { $menu_name = 'taskRequest';}
if (in_array("dashboard", $uriarray)) { $menu_name = 'dashboard';}
if (in_array("viewTaskRequest", $uriarray)) { $menu_name = 'viewTaskRequest';}
if (in_array("editTaskRequest", $uriarray)) { $menu_name = 'editTaskRequest';}
if (in_array("canceledPaypal", $uriarray)) { $menu_name = 'canceledPaypal';}
if (in_array("thankYouPaypal", $uriarray)) { $menu_name = 'thankYouPaypal';}

//if($menu_name=="taskRequest" || $menu_name=="dashboard" || $menu_name=="viewTaskRequest" || $menu_name=="editTaskRequest" || $menu_name = 'canceledPaypal' || $menu_name = 'thankYouPaypal'){
if($menu_name !="login" && $menu_name !="forgotPassword" && $menu_name !="register" && $menu_name !="resetPassword"){?>
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

<script>
  // @see https://docs.headwayapp.co/widget for more configuration options.
  var HW_config = {
    selector: ".whatsnew", // CSS selector where to inject the badge
    account:  "xGEpOJ",
    callbacks: {
      onWidgetReady: function(widget) {
        console.log("Widget is here!");
        console.log("unseen entries count: " + widget.getUnseenCount());
        setTimeout(function () {
           if( widget.getUnseenCount() > 0){
            $('#HW_badge').html("What's New <span class='appcount'> "+ widget.getUnseenCount() +"</span>");
           }
           else{
            $('#HW_badge').html("What's New");
           }           
        }, 3000);
      },
      onShowWidget: function(){
        console.log("Someone opened the widget!");
        setTimeout(function () {
           $('#HW_badge').text("What's New");
        }, 10);
      },
      onShowDetails: function(changelog){
        console.log(changelog.position); // position in the widget
        console.log(changelog.id); // unique id
        console.log(changelog.title); // title
        console.log(changelog.category); // category, lowercased
      },
      onReadMore: function(changelog){
        console.log(changelog); // same changelog object as in onShowDetails callback
      },
      onHideWidget: function(){
        console.log("Who turned off the light?");
      }
    }
};
</script>
<script async src="https://cdn.headwayapp.co/widget.js"></script>
</head>
<?php 
if($menu_name !="login" && $menu_name !="forgotPassword" && $menu_name !="register" && $menu_name !="resetPassword"){?>
  <?php $site_name = getGeneralData("site_name");
  if(!empty($site_name->option_value))
  {$sitename=$site_name->option_value;}else{$sitename="TheIToons";}
  $site_logo=getGeneralData("site_logo");
  if(!empty($site_logo->option_value))
  {$site_logo=$site_logo->option_value;}else{$site_logo = base_url()."/public/assets/dist/img/logo.png";}
  $bodyclass ="";$bodyinnerclass="";
  if($menu_name=="canceledPaypal" || $menu_name == 'thankYouPaypal' || $menu_name=="viewTaskRequest"){$bodyclass="viewrequest";}
  if($menu_name=="editTaskRequest" || $menu_name=="taskRequest"){$bodyinnerclass="taskrequest";}?>
<body class="hold-transition layout-fixed taskdashboard <?= $bodyclass;?>">
<div class="wrapper <?= $bodyinnerclass;?>">
  <!-- <nav class="main-header navbar navbar-expand navbar-white navbar-light">-->
  <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <!-- Left navbar links -->
    <img src="<?= $site_logo;?>" alt="Logo" style="width: 5%;">
    <p class="site-description"><?= $sitename;?></p>

    <!-- Right navbar links -->
    <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse order-3" id="navbarCollapse">

      <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
          <a href="<?= base_url();?>/dashboard" class="nav-link">Dashboard </a>
          <span id="dropdownSubMenu1"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"></span>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              <li><a href="<?= base_url();?>/dashboard" class="dropdown-item">Active requests</a></li>
              <li><a href="<?= base_url();?>/dashboard/completeRequestsList" class="dropdown-item">Complete requests</a></li>
            </ul>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">Contact</a>
        </li>
        <li class="nav-item">
          <a href="<?= base_url();?>/login/logout" class="nav-link">Logout</a>
        </li>
        <li class="nav-item">
          <span class="nav-link whatsnew"></span>
        </li>      
      </ul>

    </div>
  </nav>  
<?php }?>