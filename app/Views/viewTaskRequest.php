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
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header row justify-content-center mr-0">
      <div class="col-sm-6 container-fluid mt-4 pl-4">        
        <h3><?php if(isset($taskrequestinfo)){ echo $taskrequestinfo->task_title; }?></h3>

        <?php if($session->getTempdata('success')){?>
          <span class="text-success input-group mt-1"><?= $session->getTempdata('success');?></span>
        <?php }?>

        <?php if($session->getTempdata('error')){?>
          <span class="text-danger input-group mt-1"><?= $session->getTempdata('error');?></span>
        <?php }?>

      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <?php if(isset($taskrequestinfo)){?>
    <section class="content">
      <div class="row justify-content-center">
        <div class="col-sm-6">
          <?php
          /*echo "<pre>";
          print_r($taskrequestinfo);
          echo "</pre>"; */
          $task_description = getTaskRequestMeta("task_description",$taskrequestinfo->task_id);
          $reference_img = getTaskRequestMeta("reference_img",$taskrequestinfo->task_id);
          $task_status = $taskrequestinfo->task_status;
          $task_budget = getTaskRequestMeta("budget",$taskrequestinfo->task_id);
          $task_priority = getTaskRequestMeta("priority",$taskrequestinfo->task_id);
          $task_submitted_date = date("d/m/Y", strtotime($taskrequestinfo->task_date));
          $deadline = getTaskRequestMeta("deadline",$taskrequestinfo->task_id);
          if(!empty($deadline->meta_value)){
            $task_deadline =  date("d/m/Y", strtotime($deadline->meta_value));
          }?> 
          
          <?php if($task_description->meta_value || $reference_img->meta_value){?>
          <div class="panel panel-default">
            <?php if($task_description->meta_value){?>
            <div class="panel-body">
              <?php echo $task_description->meta_value;?> 
            </div>
            <?php } if($reference_img->meta_value){?>
            <div  class="panel-body" id="dvPassport" style="display: none">
              <p class="p-like">Attached image:</p>
              <img src="<?php echo $reference_img->meta_value;?>" height="200px" width="300px">
            </div>            
            <div class="panel-footer">
              <input id="btnPassport" type="button" value="View more..." class="panel-button" onclick="ShowHideDiv(this)">
            </div>
          <?php }?>
          </div>
          <?php }?>

          <h6 class="h6-like">Task status: <span><?php echo ucwords(str_replace("_"," ",$task_status));?></span></h6>

          <?php if($task_budget->meta_value){?>
          <h6 class="h6-like">Esstimated budget:<span>$<?php echo $task_budget->meta_value;?></span></h6>
          <?php }

          if($task_priority->meta_value){?>
          <h6 class="h6-like">Priority:<span class="red-icon<?php echo $task_priority->meta_value?>"><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;<?php echo ucwords($task_priority->meta_value);?></span></h6>
          <?php }?>

          <h6 class="h6-like">Date submitted:<span><?php echo $task_submitted_date;?></span></h6>
          <?php if($task_deadline){?>
          <h6 class="h6-like">Deadline:<span><?php echo $task_deadline;?></span></h6>
          <?php }?>

          <div class="text-center"><div class="newtaskbtn"><a class="btn btn-block btn-primary" href="<?= base_url();?>/taskRequest">Submit a new request</a></div></div>

        </div>
      </div>
    </section>
    <?php }?>
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
<script type="text/javascript">
function ShowHideDiv(btnPassport) {
  var dvPassport = document.getElementById("dvPassport");
  if (btnPassport.value == "View more...") {
    dvPassport.style.display = "block";
    btnPassport.value = "View less...";
  } else {
    dvPassport.style.display = "none";
    btnPassport.value = "View more...";
  }
}  
</script>