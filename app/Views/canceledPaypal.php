<?php $session = \Config\Services::session();?>
<?php $site_name = getGeneralData("site_name");
  if(!empty($site_name->option_value))
  {$sitename=$site_name->option_value;}else{$sitename="TheIToons";}?>
<?php $site_logo=getGeneralData("site_logo");
  if(!empty($site_logo->option_value))
  {$site_logo=$site_logo->option_value;}else{$site_logo = base_url()."/public/assets/dist/img/logo.png";}?>
<body class="hold-transition layout-fixed taskdashboard viewrequest">
<div class="wrapper">
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <img src="<?= $site_logo;?>" alt="Logo" style="width: 5%;">
    <p class="site-description"><?= $sitename;?></p>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a href="<?= base_url();?>/dashboard" class="nav-link">Dashboard</a>
      </li>
      <li class="nav-item">
        <a href="#" class="nav-link">Contact</a>
      </li>
      <li class="nav-item">
        <a href="<?= base_url();?>/login/logout" class="nav-link">Logout</a>
      </li>
    </ul>
  </nav>  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper text-center">
    <!-- Content Header (Page header) -->
    <!-- <section class="content-header row justify-content-center mr-0"> -->
    <section class="row justify-content-center mr-0 pt-5">
      <div class="col-sm-6 container-fluid mt-4 pl-4">        
        <h1>Oops!</h1>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row justify-content-center">
        <div class="col-sm-8">
          <h3 class="pb-3">Sorry! Your payment has been not received successfully.</h3>
          <h5>Please try again later. <b><a href="<?= base_url();?>/dashboard">View Requests</a></b></h5>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
  <footer class="main-footer">
    <strong>© <?= $sitename;?> - 2022</strong>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

</div>
<!-- ./wrapper -->