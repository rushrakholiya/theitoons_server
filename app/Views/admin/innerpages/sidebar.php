<!-- Navbar -->
<?php $session = \Config\Services::session();
      $menu_name ="";
      $uri = current_url();
      $uriarray = explode('/', $uri);
      if (in_array("dashboard", $uriarray)) { $menu_name = 'dashboard';}
      if (in_array("users", $uriarray)) { $menu_name = 'users';}
      //echo $menu_name;?>

  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <?php 
      if(session()->has('logged_user')){
        $uid = session()->get('logged_user');        
        $loggedinuserdata = getLoggedInUserData($uid);
        if(!empty($loggedinuserdata)){
          $id = $loggedinuserdata->user_id;
          $profile_picture = getUserMeta("profile_picture", $id);
            if(!empty($profile_picture->meta_value)){
              $userimage = $profile_picture->meta_value;
            }else{
              $userimage = base_url()."/public/assets/dist/img/default_avatar.jpg";
            }
          $user_role = getUserMeta("user_role", $id);
            if(!empty($user_role->meta_value)){ 
              $userrole = ucfirst($user_role->meta_value); 
            }else{
              $userrole = "";
            }?>
          <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
              <img src="<?= $userimage;?>" class="user-image img-circle elevation-2" alt="User Image">
              <span class="d-none d-md-inline"><?= ucfirst($loggedinuserdata->user_name);?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
              <!-- User image -->
              <li class="user-header bg-primary">
                <img src="<?= $userimage;?>" class="img-circle elevation-2" alt="User Image">
                <p>
                  <?= ucfirst($loggedinuserdata->user_name);?><?php if(!empty($userrole)){ echo " - ".$userrole;}
                  $doj = date("M. Y", strtotime($loggedinuserdata->registered_date));?>
                  <small>Member since <?= $doj;?></small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <a href="<?= base_url();?>/users/viewUser/<?= $id;?>" class="btn btn-default btn-flat">Profile</a>
                <a href="<?= base_url();?>/dashboard/logout" class="btn btn-default btn-flat float-right">Logout</a>
              </li>
            </ul>
          </li>
      <?php }
      }?>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>      
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= base_url();?>/dashboard" class="brand-link">
      <img src="<?= base_url();?>/public/assets/dist/img/logo.png" alt="Logo" class="brand-image img-circle elevation-3">
      <span class="brand-text font-weight-light">TheIToons</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-3 pb-3 mb-3">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="<?= base_url();?>/dashboard" class="nav-link <?php if($menu_name=="dashboard"){?>active<?php }?>">
              <i class="nav-icon fa fa-tachometer-alt"></i>
              <p> Dashboard </p>
            </a>            
          </li> 

          <li class="nav-item">
            <a href="<?= base_url();?>/users" class="nav-link <?php if($menu_name=="users"){?>active<?php }?>">
              <i class="nav-icon fa fa-user"></i>
              <p> Users </p>
            </a>            
          </li> 

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>