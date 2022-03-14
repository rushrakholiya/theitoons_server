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
            <h1>Task Request</h1>
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

      <?php if(isset($error)){?>
      <div class="alert alert-danger">
        <?= $error;?>
      </div>
      <?php }?>

      <?php if(isset($taskrequestinfo)){
        //print_r($taskrequestinfo);
      $id = $taskrequestinfo->task_id;?>
      <?= form_open('admin/allTaskRequests/editTaskRequest/'.$id); ?>
      <div class="row ml-1">
        <div class="col-md-7">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Lead Information</h3>
              <div class="card-tools"></div>
            </div>
            <div class="card-body">
              <div class="form-group row">
                <label for="tasktitle" class="col-sm-4 col-form-label">Task Title:</label>
                <input type="text" id="tasktitle" name="tasktitle" class="form-control col-sm-8" value="<?= $taskrequestinfo->task_title;?>" disabled>
              </div>
              <?php $userdata = getLoggedInUserData($taskrequestinfo->user_id);
              if(!empty($userdata)){ $task_useremail = $userdata->user_email;?>
              <div class="form-group row">
                <label for="useremail" class="col-sm-4 col-form-label">Email:</label>
                <input type="email" id="useremail" name="useremail" class="form-control col-sm-8" value="<?= $task_useremail;?>" disabled>
              </div>
              <?php }?>
              <div class="form-group row">
                <label for="requesttype" class="col-sm-4 col-form-label">Type:</label>
                <?php $requesttype=getTaskRequestMeta("requesttype", $id);?>
                <input type="text" id="requesttype" name="requesttype" class="form-control col-sm-8" value="<?= $requesttype->meta_value;?>">
              </div>
              <div class="form-group row">
                <label for="priority" class="col-sm-4 col-form-label">Priority:</label>
                <?php $priority=getTaskRequestMeta("priority", $id);?>
                <input type="text" id="priority" name="priority" class="form-control col-sm-8" value="<?= $priority->meta_value;?>">
              </div>              
              <div class="form-group row">
                <label for="task_description" class="col-sm-4 col-form-label">Description:</label>
                <?php $task_description = getTaskRequestMeta("task_description", $id);?>
                <textarea id="task_description" name="task_description" class="form-control col-sm-8" rows="4"><?= $task_description->meta_value;?></textarea>
              </div>
              <div class="form-group row">
                <label for="reference_img" class="col-sm-4">Reference files:</label>
                <?php $reference_img = getTaskRequestMeta("reference_img", $id);
                $refimg = explode('/', $reference_img->meta_value);
                $refimgname = array_reverse($refimg);
                //print_r($refimgname);?>
                <a href="<?= $reference_img->meta_value;?>" data-toggle="lightbox" data-title="<?= $refimgname[0];?>" data-gallery="gallery">
                  <span class="col-sm-8"><?= $refimgname[0];?></span>
                </a>
              </div>
              <div class="form-group row">
                <label for="constraint" class="col-sm-4 col-form-label">Constraint:</label>
                <?php $constraint=getTaskRequestMeta("constraint", $id);?>
                <input type="text" id="constraint" name="constraint" class="form-control col-sm-8" value="<?= $constraint->meta_value;?>">
              </div>
              <div class="form-group row">
                <label for="deadline" class="col-sm-4 col-form-label">Deadline:</label>
                <?php $deadline=getTaskRequestMeta("deadline", $id);?>
                <input type="text" id="deadline" name="deadline" class="form-control col-sm-8" value="<?= $deadline->meta_value;?>" placeholder="dd/mm/yyyy">
              </div>
              <div class="form-group row">
                <label for="budget" class="col-sm-4 col-form-label">Estimated budget:</label>
                <?php $budget=getTaskRequestMeta("budget", $id);?>
                <input type="text" id="budget" name="budget" class="form-control col-sm-8" value="<?= $budget->meta_value;?>">
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <div class="col-md-5">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Lead Details</h3>
            </div>          
            <div class="card-body">
              <div class="row">
                <label class="col-sm-4 col-form-label">Submitted:</label>
                <span class="col-sm-8 col-form-label"><?= $taskrequestinfo->task_date;?></span>          
              </div>
              <?php $userdata = getLoggedInUserData($taskrequestinfo->user_id);
              if(!empty($userdata)){ $task_username = $userdata->user_name;?>
              <div class="row">
                <label class="col-sm-4 col-form-label">Submitted by:</label>
                <span class="col-sm-8 col-form-label"><?= $task_username;?></span>          
              </div>
              <?php }?>
              <div class="form-group row mt-2">
                <label for="task_status" class="col-sm-4 col-form-label">Status:</label>
                <?php $task_status = $taskrequestinfo->task_status;?>
                <select id="task_status" name="task_status" class="form-control custom-select col-sm-8 col-form-label">
                  <option disabled>Select one</option>
                  <option value="pending" <?php if($task_status=="pending"){echo "selected";}?>>Pending</option>
                  <option value="processing" <?php if($task_status=="processing"){echo "selected";}?>>Processing</option>
                  <option value="in_review" <?php if($task_status=="in_review"){echo "selected";}?>>In Review</option>
                  <option value="accepted" <?php if($task_status=="accepted"){echo "selected";}?>>Accepted</option>
                  <option value="completed" <?php if($task_status=="completed"){echo "selected";}?>>Completed</option>
                  <option value="cancelled" <?php if($task_status=="cancelled"){echo "selected";}?>>Cancelled</option>
                  <option value="declined" <?php if($task_status=="declined"){echo "selected";}?>>Declined</option>
                  <option value="refunded" <?php if($task_status=="refunded"){echo "selected";}?>>Refunded</option>
                </select>
              </div>
            </div>
            <div class="card-footer">
              <a class="btn btn-danger" href="'.base_url().'/admin/allTaskRequests/deleteTaskRequest/'.$row->task_id.'"><i class="fas fa-trash"></i> Delete</a>
              <button type="submit" class="btn btn-success float-right">Save Changes</button>
            </div>
          </div>
        </div>
      </div>
      <?= form_close();?>
      <?php }?>
    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper --> 