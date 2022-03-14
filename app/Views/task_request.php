<?php $session = \Config\Services::session();?>
<body class="hold-transition login-page">
<div class="login-box">   
  <div class="login-logo">
    <?php $site_logo=getGeneralData("site_logo");
    if(!empty($site_logo->option_value))
    {$site_logo=$site_logo->option_value;}else{$site_logo = base_url()."/public/assets/dist/img/logo.png";}?>
    <img src="<?= $site_logo;?>" alt="Logo" class="brand-image img-circle elevation-3" style="width: 20%;"><br>
    <b>Task Request</b>

    <a href="<?= base_url();?>/admin/dashboard/logout" style="color: #007bff;text-decoration: none;font-size: 1rem;" class="float-right pt-4 pr-1">Logout</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Submit your request</p>

      <?php if($session->getTempdata('success')){?>
        <span class="text-success input-group mt-1 ml-1 mb-2"><?= $session->getTempdata('success'); ?></span>
      <?php }?>

      <?php if($session->getTempdata('error')){?>
        <span class="text-danger input-group mt-1 ml-1 mb-2"><?= $session->getTempdata('error'); ?></span>
      <?php }?>

      <?= form_open_multipart('','id="taskrequestForm"'); ?>
        <div class="input-group mb-3">
          <div class='col text-center'>
            <input type="radio" name="requesttype" id="single" class="d-none imgbgchk" value="single">
            <label for="single" class="form-check-label">
              <img src="<?= base_url();?>/public/assets/dist/img/single-request-icon-theitoons.png" alt="Single">
              <div class="tick_container">
                <div class="tick"><i class="fa fa-check"></i></div>
              </div>
              <span>Single</span>
            </label>
          </div>
          <div class='col text-center'>
            <input type="radio" name="requesttype" id="retainer" class="d-none imgbgchk" value="retainer">
            <label for="retainer" class="form-check-label">
              <img src="<?= base_url();?>/public/assets/dist/img/retainer-request-icon-theitoons.png" alt="Retainer">
              <div class="tick_container">
                <div class="tick"><i class="fa fa-check"></i></div>
              </div>
              <span>Retainer</span>
            </label>
          </div>
        </div>

        <div class="form-group mb-4">
          <label for="title" class="mb-0 ml-1">Task title</label>
          <small class="form-text text-muted mt-0 pb-2 ml-1">What are you trying to achieve?</small>
          <input type="text" class="form-control" placeholder="What are you trying to achieve? in a sentence." name="title" value="<?= set_value('title');?>">
          <?php if(isset($validation)){?>
          <span class="text-danger input-group mt-1 ml-1"><?php echo displayError($validation,'title'); ?></span><?php }?> 
        </div>

        <div class="form-group mb-4">
          <label for="priority" class="mb-0 ml-1">Priority of the task</label>
          <small class="form-text text-muted mt-0 pb-2 ml-1">Choose an appropriate priority for getting our response.</small>
          <select id="priority" name="priority" class="form-control custom-select">
            <option selected disabled="">-set a priority-</option>
            <option value="urgent">Urgent (ASAP response)</option>
            <option value="high">High (within 4 hours)</option>
            <option value="standard">Standard (within 12 hours)</option>
            <option value="normal">Normal (within 24 hours)</option>
          </select>
          <?php if(isset($validation)){?>
          <span class="text-danger input-group mt-1 ml-1"><?php echo displayError($validation,'priority'); ?></span><?php }?> 
        </div>

        <div class="form-group mb-4">
          <label for="task_description" class="mb-0 ml-1">Task description</label>
          <small class="form-text text-muted mt-0 pb-2 ml-1">Add a brief description of the task</small>
          <textarea id="task_description" name="task_description" placeholder="Task description" class="form-control" rows="4"></textarea>
          <?php if(isset($validation)){?>
          <span class="text-danger input-group mt-1 ml-1"><?php echo displayError($validation,'task_description'); ?></span><?php }?>
        </div>

        <div class="form-group mb-4">
          <label for="reference" class="mb-0 ml-1">Reference files (optional but recommended)</label>
          <small class="form-text text-muted mt-0 pb-2 ml-1">Add files as reference to your task</small>
          <input type="file" class="form-control userProfilePicture" name="reference" />              
        </div>

        <div class="form-group mb-4">
          <label for="constraint" class="mb-0 pb-2 ml-1">What is most important for you in this task</label>
          <select id="constraint" name="constraint" class="form-control custom-select">
            <option selected disabled="">-select a option-</option>
            <option value="finance">Finance</option>
            <option value="time">Time</option>
            <option value="quality">Quality</option>
          </select> 
        </div>
        
        <div class="form-group mb-4">
          <label for="deadline" class="mb-0 ml-1">Deadline</label>
          <small class="form-text text-muted mt-0 pb-2 ml-1">Set a deadline</small>
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Set a deadline" name="deadline" id="datepicker"/>
            <div class="input-group-append">
                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
            </div>
          </div>
        </div>

        <div class="form-group mb-4">
          <label for="budget" class="mb-0 ml-1">Your estimated budget</label>
          <small class="form-text text-muted mt-0 pb-2 ml-1">Approx price that you are comfortable spending for this task</small>
          <div class="slider-blue ml-2 mr-4">
            <input type="text" name="budget" id="budget" value="" class="slider form-control" data-slider-min="0" data-slider-max="3000" data-slider-step="10" data-slider-value="20" data-slider-orientation="horizontal" data-slider-selection="before" data-slider-tooltip="show" style="width: 100%;">
          </div>
          <small class="form-text text-muted mt-0 ml-1">Your Total Amount : <span id="demo">$20.00</span></small>
        </div>

        <div class="row justify-content-center">          
          <!-- /.col -->
          <div class="col-8">
            <button type="submit" class="btn btn-primary btn-block">Submit your request</button>
          </div>
          <!-- /.col -->
        </div>
      <?= form_close(); ?>
     
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<link rel="stylesheet" href="<?= base_url();?>/public/assets/dist/css/userforms.css"> 
<style>
.col img{
  height:150px;
  width: 100%;
  cursor: pointer;
  transition: transform 1s;
  object-fit: cover;
}
.col label{
  overflow: hidden;
  position: relative;
}
.imgbgchk:checked + label>.tick_container{
  opacity: 1;
}
/*ANIMATION */
.imgbgchk:checked + label>img{
  background-color: #000;
  opacity: .4;
}
.tick_container {
  transition: .5s ease;
  opacity: 0;
  position: absolute;
  top: 20px;
  right: -10px;
  left: inherit;
  transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  cursor: pointer;
  text-align: center;
}
.tick {
  background-color: #FFFFFF;
  color: #999999;
  font-size: 20px;
  text-align: center;
  height: 30px;
  width: 30px;
  border-radius: 100%;
}
</style>