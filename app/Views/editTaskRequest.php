<?php $session = \Config\Services::session();?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid text-center mt-4">        
        <h3>Submit your request</h3>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-3">       
        </div>
        <div class="col-sm-6">          
          <div class="card">
            <div class="card-body">
              <!-- <p class="login-box-msg">Submit your request</p> -->

              <?php if($session->getTempdata('success')){?>
                <div class="text-center"><span class="text-success mt-1 mb-2"><?= $session->getTempdata('success'); ?></span></div>
              <?php }?>

              <?php if($session->getTempdata('error')){?>
                <div class="text-center"><span class="text-danger mt-1 mb-2"><?= $session->getTempdata('error'); ?></span></div>
              <?php }?>

              <?php if(isset($success)){?>
                <div class="text-center"><span class="text-success mt-1 mb-2"><?= $success; ?></span></div>
              <?php }?>

              <?php if(isset($error)){?>
                <div class="text-center"><span class="text-danger mt-1 mb-2"><?= $error; ?></span></div>
              <?php }?>

              <?php if(isset($taskrequestinfo) && !empty($taskrequestinfo)){
                    //print_r($taskrequestinfo);
              $id = $taskrequestinfo->task_id;?>
              <?= form_open_multipart('dashboard/editTaskRequest/'.$id,'class="taskrequestForm" id="taskrequestForm1"'); ?>
                <?php $requesttype=getTaskRequestMeta("requesttype", $id);?>
                <div class="input-group mb-3">
                  <div class='col text-center'>
                    <input type="radio" name="requesttype" id="single" class="d-none imgbgchk" value="single" <?php if($requesttype->meta_value=="single"){echo "checked";}?>>
                    <label for="single" class="form-check-label">
                      <img src="<?= base_url();?>/public/assets/dist/img/single-request-icon-theitoons.png" alt="Single">
                      <div class="tick_container">
                        <div class="tick"><i class="fa fa-check"></i></div>
                      </div>
                      <span>Single</span>
                    </label>
                  </div>
                  <div class='col text-center'>
                    <input type="radio" name="requesttype" id="retainer" class="d-none imgbgchk" value="retainer" <?php if($requesttype->meta_value=="retainer"){echo "checked";}?>>
                    <label for="retainer" class="form-check-label">
                      <img src="<?= base_url();?>/public/assets/dist/img/retainer-request-icon-theitoons.png" alt="Retainer">
                      <div class="tick_container">
                        <div class="tick"><i class="fa fa-check"></i></div>
                      </div>
                      <span>Retainer</span>
                    </label>
                  </div>
                  <div class='col text-center'>
                    <input type="radio" name="requesttype" id="research" class="d-none imgbgchk" value="research" <?php if($requesttype->meta_value=="research"){echo "checked";}?>>
                    <label for="research" class="form-check-label">
                      <img src="<?= base_url();?>/public/assets/dist/img/research-development-icon.png" alt="Research">
                      <div class="tick_container">
                        <div class="tick"><i class="fa fa-check"></i></div>
                      </div>
                      <span>Research & Development</span>
                    </label>
                  </div>
                </div>

                <div class="form-group mb-4">
                  <label for="title" class="mb-0 ml-1">Task title</label>
                  <small class="form-text text-muted mt-0 pb-2 ml-1">What are you trying to achieve?</small>
                  <input type="text" class="form-control" placeholder="What are you trying to achieve? in a sentence." name="title" value="<?= $taskrequestinfo->task_title;?>">
                </div>

                <?php $priority_meta=getTaskRequestMeta("priority", $id);
                $priority=$priority_meta->meta_value;?>
                <div class="form-group mb-4">
                  <label for="priority" class="mb-0 ml-1">Priority of the task</label>
                  <small class="form-text text-muted mt-0 pb-2 ml-1">Choose an appropriate priority for getting our response.</small>
                  <select id="priority" name="priority" class="form-control custom-select">
                    <option value="" selected>-set a priority-</option>
                    <option value="urgent" <?php if($priority=="urgent"){echo "selected";}?>>Urgent (ASAP response)</option>
                    <option value="high" <?php if($priority=="high"){echo "selected";}?>>High (within 4 hours)</option>
                    <option value="standard" <?php if($priority=="standard"){echo "selected";}?>>Standard (within 12 hours)</option>
                    <option value="normal" <?php if($priority=="normal"){echo "selected";}?>>Normal (within 24 hours)</option>
                  </select>
                </div>

                <?php $task_description = getTaskRequestMeta("task_description", $id);?>
                <div class="form-group mb-4">
                  <label for="task_description" class="mb-0 ml-1">Task description</label>
                  <small class="form-text text-muted mt-0 pb-2 ml-1">Add a brief description of the task</small>
                  <textarea id="task_description" name="task_description" placeholder="Task description" class="form-control" rows="4"><?= $task_description->meta_value;?></textarea>
                </div>

                <?php $reference_img = getTaskRequestMeta("reference_img", $id);
                  if($reference_img->meta_value){                 
                  $refimg = explode('/', $reference_img->meta_value);
                  $refimgname = array_reverse($refimg);
                  //print_r($refimgname);
                  }?>
                <div class="form-group mb-4">
                  <label for="reference" class="mb-0 ml-1">Reference files (optional but recommended)</label>
                  <small class="form-text text-muted mt-0 pb-2 ml-1">Add files as reference to your task</small>
                  <input type="file" class="form-control userProfilePicture" name="reference" />
                  <?php if($reference_img->meta_value){?>
                  <a href="<?= $reference_img->meta_value;?>" data-toggle="lightbox" data-title="<?= $refimgname[0];?>" data-gallery="gallery">
                    <span class="col-sm-8"><?= $refimgname[0];?></span>
                  </a>  
                  <?php }?>            
                </div>

                <?php $constraint_meta=getTaskRequestMeta("constraint", $id);
                $constraint=$constraint_meta->meta_value;?>
                <div class="form-group mb-4">
                  <label for="constraint" class="mb-0 pb-2 ml-1">What is most important for you in this task</label>
                  <select id="constraint" name="constraint" class="form-control custom-select">
                    <option selected disabled="">-select a option-</option>
                    <option value="finance" <?php if($constraint=="finance"){echo "selected";}?>>Finance</option>
                    <option value="time" <?php if($constraint=="time"){echo "selected";}?>>Time</option>
                    <option value="quality" <?php if($constraint=="quality"){echo "selected";}?>>Quality</option>
                  </select> 
                </div>
                
                <?php $deadline=getTaskRequestMeta("deadline", $id);?>
                <div class="form-group mb-4">
                  <label for="deadline" class="mb-0 ml-1">Deadline</label>
                  <small class="form-text text-muted mt-0 pb-2 ml-1">Set a deadline</small>
                  <div class="input-group">
                    <input type="text" class="form-control" name="deadline" id="datepicker" value="<?= $deadline->meta_value;?>" placeholder="dd-mm-yyyy"/>
                    <div class="input-group-append">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                  </div>
                </div>

                <?php $budget_meta=getTaskRequestMeta("budget", $id);
                if($budget_meta->meta_value){$budget=$budget_meta->meta_value;}?>
                <div class="form-group mb-4">
                  <label for="budget" class="mb-0 ml-1">Your estimated budget</label>
                  <small class="form-text text-muted mt-0 pb-2 ml-1">Approx price that you are comfortable spending for this task</small>
                  <div class="slider-blue ml-2 mr-4">
                    <input type="text" name="budget" id="budget" value="" class="slider form-control" data-slider-min="20" data-slider-max="3000" data-slider-step="10" data-slider-value="<?php echo $budget;?>" data-slider-orientation="horizontal" data-slider-selection="before" data-slider-tooltip="show" style="width: 100%;">
                  </div>
                  <small class="form-text text-muted mt-0 ml-1">Your Total Amount : <span id="demo">$<?php if($budget){echo $budget;}else{?>20.00<?php }?></span></small>
                </div>

                <div class="row justify-content-center">          
                  <!-- /.col -->
                  <div class="col-6">
                    <button type="submit" class="btn btn-primary btn-block">Submit your request</button>
                  </div>
                  <!-- /.col -->
                </div>
              <?= form_close(); ?>
              <?php } ?>
            </div>
            <!-- /.login-card-body -->
          </div>          
        </div>
        <div class="col-sm-3">       
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->