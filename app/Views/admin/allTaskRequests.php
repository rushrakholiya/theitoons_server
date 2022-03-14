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
            <h1>All Task Requests</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
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

      <?php if(isset($error)){?>
        <div class="alert alert-danger">
          <?= $error;?>
        </div>
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
                      <th>Id</th>
                      <th>Title</th>
                      <th>Status</th>
                      <th>Email</th>
                      <th>Priority</th>
                      <th>Submitted Date</th>
                      <th></th>
                  </tr>
              </thead>
              <tbody>
                <?php 
                 foreach($taskrequestdata as $row)
                  {
                    $userdata = getLoggedInUserData($row->user_id);
                    if(!empty($userdata)){ $task_useremail = $userdata->user_email;}
                    if($row->task_status=="pending"){$color = "bg-secondary";}
                    elseif($row->task_status=="processing"){$color = "bg-secondary";}
                    elseif($row->task_status=="in_review"){$color = "bg-orange";}
                    elseif($row->task_status=="accepted"){$color = "bg-success";}
                    elseif($row->task_status=="completed"){$color = "bg-success";}
                    elseif($row->task_status=="cancelled"){$color = "bg-danger";}
                    elseif($row->task_status=="declined"){$color = "bg-danger";}
                    elseif($row->task_status=="refunded"){$color = "bg-black";}
                    $taskstatus = ucwords(str_replace("_"," ",$row->task_status));
                    
                    echo "<tr>";
                    echo "<td>".$row->task_id."</td>";
                    echo "<td>".$row->task_title."</td>";
                    echo "<td><span class='btn-sm ".$color."'><span class='text-white'>".$taskstatus."</span></span></td>";
                    echo "<td>".$task_useremail."</td>";
                    echo "<td>".$row->meta_value."</td>";
                    echo "<td>".$row->task_date."</td>";
                    echo '<td class="project-actions text-right">
                          <a class="btn btn-info btn-sm" href="'.base_url().'/admin/allTaskRequests/viewTaskRequest/'.$row->task_id.'"><i class="fas fa-pencil-alt"></i> Edit</a>
                          <a class="btn btn-danger btn-sm" href="'.base_url().'/admin/allTaskRequests/deleteTaskRequest/'.$row->task_id.'"><i class="fas fa-trash"></i> Delete</a>
                      </td>';
                    echo "</tr>";
                  }?>
              </tbody>
          </table>        
        </div>        
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
      <?php }?>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->