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
            <h1>Users</h1>
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

      <?php if(isset($userdataerror)){?>
        <div class="alert alert-danger">
          <?= $userdataerror;?>
        </div>
      <?php }?>

      <?php if(isset($userdata)){
          /*echo "<pre>";
          print_r($userdata);
          echo "</pre>";*/?> 
      <div class="card">       
        <div class="card-body p-0">        
          <table class="table table-striped projects">
              <thead>
                  <tr>
                      <th>Id</th>
                      <th>User Name</th>
                      <th>Email</th>
                      <th>Role</th>
                      <th>Status</th>
                      <th></th>
                  </tr>
              </thead>
              <tbody>
                <?php
                 foreach($userdata as $row)
                  {
                    echo "<tr>";
                    echo "<td>".$row->user_id."</td>";
                    echo "<td>".$row->user_name."</td>";
                    echo "<td>".$row->user_email."</td>";
                    echo "<td>".$row->meta_value."</td>";
                    echo "<td>";
                       if($row->user_status == 0){
                          echo "inactive";
                       }else{
                          echo "active";
                       }
                    echo "</td>";
                    echo '<td class="project-actions text-right">
                          <a class="btn btn-info btn-sm" href="'.base_url().'/admin/users/viewUser/'.$row->user_id.'">
                              <i class="fas fa-pencil-alt">
                              </i>
                              Edit
                          </a>
                          <a class="btn btn-danger btn-sm" href="'.base_url().'/admin/users/deleteUser/'.$row->user_id.'">
                              <i class="fas fa-trash">
                              </i>
                              Delete
                          </a>
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