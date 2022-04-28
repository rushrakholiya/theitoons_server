<?php $session = \Config\Services::session();?>
<?php $site_name = getGeneralData("site_name");
  if(!empty($site_name->option_value))
  {$sitename=$site_name->option_value;}else{$sitename="TheIToons";}?>
<?php $site_logo=getGeneralData("site_logo");
  if(!empty($site_logo->option_value))
  {$site_logo=$site_logo->option_value;}else{$site_logo = base_url()."/public/assets/dist/img/logo.png";}?>
<body class="hold-transition layout-fixed taskdashboard">
<div class="wrapper">
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <img src="<?= $site_logo;?>" alt="Logo" style="width: 5%;">
    <p class="site-description"><?= $sitename;?></p>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item active">
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
    <section class="content-header">
      <div class="container-fluid text-center mt-4">        
        <h3>Your active requests</h3>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-2">       
        </div>
        <div class="col-sm-8">          
          <!-- Default box -->
          <?php if($session->getTempdata('success')){?>
            <div class="text-center mb-3"><span class="text-success"><?= $session->getTempdata('success'); ?></span></div>
          <?php }?>

          <?php if($session->getTempdata('error')){?>
            <div class="text-center mb-3"><span class="text-danger"><?= $session->getTempdata('error'); ?></span></div>
          <?php }?>

          <?php if(isset($error)){
            $frame1 = base_url()."/public/assets/dist/img/frame.png";?>
            <center>
              <img src="<?= $frame1;?>" width="250">
              <br><span><?= $error;?></span><br>
              <div class="newtaskbtn"><a class="btn btn-block btn-primary" href="<?= base_url();?>/taskRequest">Submit a new request</a></div>
            </center>
          <?php }?>

          <?php if(isset($taskrequestdata)){
              /*echo "<pre>";
              print_r($taskrequestdata);
              echo "</pre>";*/ ?> 
          <div class="card">
            <div class="card-body table-responsive p-0">        
              <table class="table table-striped projects text-nowrap">
                  <thead>
                      <tr>
                          <th>Task Title</th>
                          <th>Priority</th>
                          <th>Deadline</th>
                          <th>Status</th>                       
                          <th>Submitted Date</th>
                          <th>Actions</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php 
                     foreach($taskrequestdata as $row)
                      {
                        
                        $priority = getTaskRequestMeta("priority",$row->task_id);
                        if(!empty($priority)){$task_priority = $priority->meta_value;}

                        $deadline = getTaskRequestMeta("deadline",$row->task_id);
                        if(!empty($deadline)){$task_deadline = date("d-m-Y", strtotime($deadline->meta_value));}
                        
                        if($task_priority=="urgent"){$color = "bg-danger";}
                        elseif($task_priority=="high"){$color = "bg-success";}
                        elseif($task_priority=="standard"){$color = "bg-warning";}
                        elseif($task_priority=="normal"){$color = "bg-lightblue";}
                        $taskpriority = ucwords($task_priority);

                        $taskstatus = ucwords(str_replace("_"," ",$row->task_status));
                        
                        echo "<tr>";
                        echo "<td>".$row->task_title."</td>";
                        echo "<td><span class='tbp btn btn-sm ".$color."'><span>".$taskpriority."</span></span></td>";
                        echo "<td>".$task_deadline."</td>";                        
                        echo "<td>".$taskstatus."</td>";   
                        echo "<td>".$row->task_date."</td>";
                        echo '<td class="project-actions">-</td>';
                        /*echo '<td class="project-actions">
                              <a class="btn btn-info btn-sm" href="'.base_url().'/admin/allTaskRequests/viewTaskRequest/'.$row->task_id.'"><i class="fas fa-pencil-alt"></i> Edit</a>
                              <a class="btn btn-danger btn-sm" href="'.base_url().'/admin/allTaskRequests/deleteTaskRequest/'.$row->task_id.'"><i class="fas fa-trash"></i> Delete</a>
                          </td>';*/
                        echo "</tr>";
                      }?>
                  </tbody>
              </table>        
            </div>        
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
          <?php }?>

          <?php if(isset($totaltaskno)){?>
            <div class="text-center"><div class="newtaskbtnd"><div class="tbp btn btn-block btn-info btn-primary">
              <?= $totaltaskno;?>
            </div></div></div>
          <?php } else {?><div class="text-center"><div class="newtaskbtn"><a class="btn btn-block btn-primary" href="<?= base_url();?>/taskRequest">Submit a new request</a></div></div><?php }?>

        </div>
        <div class="col-sm-2">       
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
<style>
.taskdashboard .content-wrapper {
   background-color: #fff;
}
.taskdashboard .main-header, .taskdashboard .main-footer, .taskdashboard .content-header, .taskdashboard .content-wrapper{
  margin-left:0px !important;
}
/*.taskdashboard .main-header, .taskdashboard .main-footer{
  padding-left: 30px;
  padding-right: 30px;
}*/
.site-description{
  margin-left: 0.4em;
  margin-top: 0.7em;
  text-transform: uppercase;
  font-size: 1.4em;
}
.taskdashboard .content-wrapper>.content{
  padding: 1em 2em 2em 2em;
}
.taskdashboard .newtaskbtn{
  padding-top: 25px;
  display: inline-block;
  padding-bottom: 30px;
}
.taskdashboard .tbp
{
  cursor: text !important;
  border: none !important;
}
.taskdashboard .newtaskbtn .btn,.taskdashboard .newtaskbtnd .btn {
  padding: 0.75rem 1.75rem;
}
.taskdashboard .newtaskbtnd .btn:focus,.taskdashboard .newtaskbtnd .btn:hover,.taskdashboard .newtaskbtnd .btn:active {
  color: #fff;
  background-color: #17a2b8;
}
.taskdashboard .tbp:focus,.taskdashboard .tbp:hover,.taskdashboard .tbp:active, {
    text-decoration: none !important;
    box-shadow: unset !important;
    border: none !important;
}
</style>