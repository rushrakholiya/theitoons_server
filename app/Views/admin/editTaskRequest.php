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
      $id = $taskrequestinfo->task_id;

      $task_submitted_date = date("d-m-Y", strtotime($taskrequestinfo->task_date));
      $task_submitted_time = date("h:i a", strtotime($taskrequestinfo->task_date));

      //$curr_time = "2013-07-10 09:09:09";
      $curr_time = $taskrequestinfo->task_date;
      $time_ago = strtotime($curr_time);?>

      <?= form_open('admin/allTaskRequests/editTaskRequest/'.$id); ?>
      <div class="row">
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
                /*$refimg = explode('/', $reference_img->meta_value);
                $refimgname = array_reverse($refimg);
                //print_r($refimgname);?>
                <a href="<?= $reference_img->meta_value;?>" data-toggle="lightbox" data-title="<?= $refimgname[0];?>" data-gallery="gallery">
                  <span class="col-sm-8"><?= $refimgname[0];?></span>
                </a>
                <?php */
                  if($reference_img->meta_value){
                    $refimgarray = array_filter(explode(',',$reference_img->meta_value));
                    foreach($refimgarray as $rimga){
                    $rimgaresult = str_replace("'", '', $rimga);
                    $refimg = explode('/', $rimgaresult);
                    $refimgname = array_reverse($refimg);?>
                  <a href="<?php echo $rimgaresult;?>" data-toggle="lightbox" data-title="<?= $refimgname[0];?>" data-gallery="gallery">
                    <span class="col-sm-8"><?= $refimgname[0];?></span>
                  </a>  
                  <?php } }?> 
              </div>
              <div class="form-group row">
                <label for="constraint" class="col-sm-4 col-form-label">Constraint:</label>
                <?php $constraint=getTaskRequestMeta("constraint", $id);?>
                <input type="text" id="constraint" name="constraint" class="form-control col-sm-8" value="<?= $constraint->meta_value;?>">
              </div>
              <div class="form-group row">
                <label for="deadline" class="col-sm-4 col-form-label">Deadline:</label>
                <?php $deadline=getTaskRequestMeta("deadline", $id);?>
                <input type="text" id="deadline" name="deadline" class="form-control col-sm-4" value="<?= $deadline->meta_value;?>" placeholder="dd-mm-yyyy">
                <?php
                $current_date = new DateTime();
                $deadlinedate    = new DateTime($deadline->meta_value);
                if($deadline->meta_value && $current_date < $deadlinedate){
                  $task_deadlineago = date("Y-m-d h:m:s", strtotime($deadline->meta_value));
                  $date=strtotime($task_deadlineago);//Converted to a PHP date (a second count)
                  $diff=$date-time();//time returns current time in seconds
                  $days=floor($diff/(60*60*24));//seconds/minute*minutes/hour*hours/day)
                  //$hours=round(($diff-$days*60*60*24)/(60*60));
                  //echo "$days days $hours hours remain<br />";?>
                  <span class="col-sm-4" style="padding: 0.375rem 0.75rem;"> ( <?php echo "$days days to complete";?> )</span>
                <?php }else if($deadline->meta_value){
                  $curr_time1 = date("Y-m-d h:m:s", strtotime($deadline->meta_value));
                  $time_ago1 = strtotime($curr_time1);?>
                  <span class="col-sm-4" style="padding: 0.375rem 0.75rem;"> ( <?php echo time_Ago($time_ago1);?> )</span>
                <?php }?>
              </div>
              <!--<div class="form-group row">
                <label class="col-sm-4"></label>
                <a href="#" data-toggle="modal" data-target="#modaldeadline<?= $id;?>" class="col-sm-4">Set Revised Deadline</a>
              </div>-->
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
          
          <?php $deliver_file = getTaskRequestMeta("deliver_file", $id);
          $task_deliver_description = getTaskRequestMeta("task_deliver_description", $id);
          //print_r($deliver_file);
          //print_r($task_deliver_description);
          if($deliver_file || $task_deliver_description){
            if(!empty($deliver_file->meta_value) || !empty($task_deliver_description->meta_value)){?>
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Deliver Details</h3>
            </div>          
            <div class="card-body">
              <div class="form-group row">
                <label class="col-sm-4">Uploaded file:</label>
                <?php /*$drefimg = explode('/', $deliver_file->meta_value);
                $drefimgname = array_reverse($drefimg);
                //print_r($refimgname);
                <a href="<?= $deliver_file->meta_value;?>" data-toggle="lightbox" data-title="<?= $drefimgname[0];?>" data-gallery="gallery">
                  <span class="col-sm-8"><?= $drefimgname[0];?></span>
                </a>*/
                $drefimgarray = array_filter(explode(',',$deliver_file->meta_value));
                foreach($drefimgarray as $drimga){
                $drimgaresult = str_replace("'", '', $drimga);
                $drefimg = explode('/', $drimgaresult);
                $drefimgname = array_reverse($drefimg);?>
                <a href="<?= $drimgaresult;?>" data-toggle="lightbox" data-title="<?= $drefimgname[0];?>" data-gallery="gallery">
                  <span class="col-sm-8"><?= $drefimgname[0];?></span>
                </a> 
                <?php }?>                
              </div>
              <div class="form-group row">
                <label class="col-sm-4">Description:</label>
                <span class="col-sm-8"><?= $task_deliver_description->meta_value; ?></span>
              </div>        
            </div>
          </div>
          <?php }}?>

          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Lead Details</h3>
            </div>          
            <div class="card-body">
              <div class="row">
                <label class="col-sm-4 col-form-label">Submitted:</label>
                <span class="col-sm-8 col-form-label"><?= $task_submitted_date; ?><span style='font-weight: 600;font-size: 10px;color: #939393;text-transform: uppercase;'> <?= $task_submitted_time;?></span><span> ( <?php echo time_Ago($time_ago);?> )</span></span>

              </div>
              <?php $userdata = getLoggedInUserData($taskrequestinfo->user_id);
              if(!empty($userdata)){ $task_username = $userdata->user_name;?>
              <div class="row">
                <label class="col-sm-4 col-form-label">Submitted by:</label>
                <span class="col-sm-8 col-form-label"><?= $task_username;?></span>          
              </div>
              <?php }?>
              <div class="row mt-2 mb-3">
                <label for="task_status" class="col-sm-4 col-form-label">Status:</label>
                <?php $task_status = $taskrequestinfo->task_status;?>
                <select id="task_status" name="task_status" class="form-control custom-select col-sm-8 col-form-label">
                  <option disabled>Select one</option>
                  <option value="pending" <?php if($task_status=="pending"){echo "selected";}?>>Pending</option>
                  <option value="processing" <?php if($task_status=="processing"){echo "selected";}?>>Processing</option>
                  <option value="in_review" <?php if($task_status=="in_review"){echo "selected";}?>>In Review</option>
                  <option value="in_revision" <?php if($task_status=="in_revision"){echo "selected";}?>>In Revision</option>
                  <option value="accepted" <?php if($task_status=="accepted"){echo "selected";}?>>Accepted</option>
                  <option value="completed" <?php if($task_status=="completed"){echo "selected";}?>>Completed</option>
                  <option value="cancelled" <?php if($task_status=="cancelled"){echo "selected";}?>>Cancelled</option>
                  <option value="declined" <?php if($task_status=="declined"){echo "selected";}?>>Declined</option>
                  <option value="refunded" <?php if($task_status=="refunded"){echo "selected";}?>>Refunded</option>
                </select>
              </div>
            </div>
            <div class="card-footer">
              <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-default<?= $id;?>"><i class="fas fa-pencil-alt"></i> Deliver</button>
              <a class="btn btn-danger" href="<?= base_url();?>/admin/allTaskRequests/deleteTaskRequest/<?= $id;?>"><i class="fas fa-trash"></i> Delete task</a>
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

  <!--Delivered detail model -->
  <div class="modal fade" id="modal-default<?= $id;?>">
    <div class="modal-dialog">
      <div class="modal-content">
        <?= form_open_multipart('admin/allTaskRequests/addDeliverDataTask/'.$id,'id="deliver_form"'); ?>          
        <div class="modal-header">
          <h4 class="modal-title">Add Data</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-div">                       
            <div class="form-group">
              <label for="uploadfile" class="control-label">Upload Files</label>
              <input type="file" class="form-control userProfilePicture" name="deliver_file[]" multiple="multiple"/>
              <?php $ddeliver_file = getTaskRequestMeta("deliver_file", $id);
                if($ddeliver_file && !empty($ddeliver_file->meta_value)){
                  /*$ddrefimg = explode('/', $ddeliver_file->meta_value);
                  $ddrefimgname = array_reverse($ddrefimg);
                  print_r($refimgname);
                  <a href="<?= $ddeliver_file->meta_value;?>" data-toggle="lightbox" data-title="<?= $ddrefimgname[0];?>" data-gallery="gallery">
                    <span class="col-sm-8"><?= $ddrefimgname[0];?></span>
                  </a>*/
                  $drefimgarray = array_filter(explode(',',$ddeliver_file->meta_value));
                  foreach($drefimgarray as $drimga){
                  $drimgaresult = str_replace("'", '', $drimga);
                  $ddrefimg = explode('/', $drimgaresult);
                  $ddrefimgname = array_reverse($ddrefimg);?>
                  <a href="<?= $drimgaresult;?>" data-toggle="lightbox" data-title="<?= $ddrefimgname[0];?>" data-gallery="gallery">
                    <span class="col-sm-8"><?= $ddrefimgname[0];?></span>
                  </a> 
                  <?php }
                }?>
            </div>
            <div class="form-group">
              <?php $dtask_deliver_description = getTaskRequestMeta("task_deliver_description", $id);?>
              <label for="task_deliver_description" class="control-label">Description</label>
              <textarea id="task_deliver_description" name="task_deliver_description" class="form-control" rows="4"><?php if($dtask_deliver_description && !empty($dtask_deliver_description->meta_value)){echo $dtask_deliver_description->meta_value;}?></textarea>
            </div>
          </div>                                                      
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        <?= form_close();?>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  <!-- Revised deadline model-->
  <div class="modal fade" id="modaldeadline<?= $id;?>">
    <div class="modal-dialog">
      <div class="modal-content">
        <?= form_open('admin/allTaskRequests/sendRevisedDate/'.$id,'id="reviseddate_form"'); ?>       
        <div class="modal-header">
          <h4 class="modal-title">Add Revised Deadline</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-div">
            <div class="form-group row">
              <label for="rdeadline" class="control-label col-sm-4">Revised Deadline:</label>
              <?php $deadline=getTaskRequestMeta("deadline", $id);?>
              <input type="text" id="rdeadline" name="rdeadline" class="deadline form-control col-sm-4" value="<?= $deadline->meta_value;?>" placeholder="dd-mm-yyyy">
            </div>
          </div>                                                      
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Send</button>
        </div>
        <?= form_close();?>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.5.3/js/bootstrapValidator.js"></script>
  <script>
  $('#modal-default<?= $id;?>').on('hidden.bs.modal', function (e) {
    $('#deliver_form').bootstrapValidator('resetForm', true);
  });
  $('#modal-default<?= $id;?>').on('show.bs.modal', function (e) {
    <?php $deliverd ="";
    $dtask_deliver_description = getTaskRequestMeta("task_deliver_description", $id);?>
    <?php if($dtask_deliver_description && !empty($dtask_deliver_description->meta_value)){
      $deliverd = $dtask_deliver_description->meta_value;}else{ $deliverd = "";}?>
    $("textarea#task_deliver_description").val("<?= $deliverd;?>");
  });
  $(document).ready(function() {
    $('#deliver_form').bootstrapValidator({
      feedbackIcons: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
      },
      excluded: ':disabled',
      fields: {
        "deliver_file[]": {
          validators: {
            file: {
              extension: 'jpg,jpeg,png,gif,pdf',
              type: 'image/jpg,image/jpeg,image/png,image/gif,application/pdf',
              //maxSize: 2048 * 1024,
              message: 'The selected file is not valid (only jpg,jpeg,png,gif,pdf allow)'
            }
          }
        },
        task_deliver_description: {
          validators: {
            notEmpty: {
              message: 'The Description is required and cannot be empty'
            },
            stringLength: {
              max: 500,
              message: 'The Description must be less than 500 characters long'
            }
          }
        }
      }
    });
  });
  
  $('#modaldeadline<?= $id;?>').on('hidden.bs.modal', function (e) {
    $('#reviseddate_form').bootstrapValidator('resetForm', true);
  });
  $('#modaldeadline<?= $id;?>').on('show.bs.modal', function (e) {
    <?php $rdeadline ="";
    $deadline=getTaskRequestMeta("deadline", $id);
    if($deadline && !empty($deadline->meta_value)){
      $rdeadline = $deadline->meta_value;}else{ $rdeadline = "";}?>
    $("#rdeadline").val("<?= $rdeadline;?>");
  });
  $(document).ready(function() {
    $('#reviseddate_form').bootstrapValidator({
      feedbackIcons: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
      },
      excluded: ':disabled',
      fields: {
        rdeadline: {
          validators: {
            notEmpty: {
              message: 'The Deadline is required'
            }
          }
        }
      }
    });
  });
  </script>
  <link rel="stylesheet" href="<?= base_url();?>/public/assets/dist/css/userforms.css">