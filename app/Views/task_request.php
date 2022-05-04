<?php $session = \Config\Services::session();?>
<?php $site_name = getGeneralData("site_name");
  if(!empty($site_name->option_value))
  {$sitename=$site_name->option_value;}else{$sitename="TheIToons";}?>
<?php $site_logo=getGeneralData("site_logo");
  if(!empty($site_logo->option_value))
  {$site_logo=$site_logo->option_value;}else{$site_logo = base_url()."/public/assets/dist/img/logo.png";}?>
<body class="hold-transition layout-fixed taskdashboard">
<div class="wrapper taskrequest">
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

              <?php if(isset($totaltaskno)){?>
              <div class="newtaskbtnd">
                <div class="tbp btn btn-danger btn-block">
                  <?= $totaltaskno;?>
                </div>
              </div>
              <style>#taskrequestForm{display: none;}</style>
              <?php } else{?><style>#taskrequestForm{display: block;}</style><?php }?>

              <?= form_open_multipart('','class="taskrequestForm" id="taskrequestForm"'); ?>
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
                  <div class='col text-center'>
                    <input type="radio" name="requesttype" id="research" class="d-none imgbgchk" value="research">
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
                  <input type="text" class="form-control" placeholder="What are you trying to achieve? in a sentence." name="title" value=""> 
                </div>

                <div class="form-group mb-4">
                  <label for="priority" class="mb-0 ml-1">Priority of the task</label>
                  <small class="form-text text-muted mt-0 pb-2 ml-1">Choose an appropriate priority for getting our response.</small>
                  <select id="priority" name="priority" class="form-control custom-select">
                    <option value="" selected>-set a priority-</option>
                    <option value="urgent">Urgent (ASAP response)</option>
                    <option value="high">High (within 4 hours)</option>
                    <option value="standard">Standard (within 12 hours)</option>
                    <option value="normal">Normal (within 24 hours)</option>
                  </select>
                </div>

                <div class="form-group mb-4">
                  <label for="task_description" class="mb-0 ml-1">Task description</label>
                  <small class="form-text text-muted mt-0 pb-2 ml-1">Add a brief description of the task</small>
                  <textarea id="task_description" name="task_description" placeholder="Task description" class="form-control" rows="4"></textarea>
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
                    <input type="text" class="form-control" placeholder="dd/mm/yyyy" name="deadline" id="datepicker"/>
                    <div class="input-group-append">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                  </div>
                </div>

                <div class="form-group mb-4">
                  <label for="budget" class="mb-0 ml-1">Your estimated budget</label>
                  <small class="form-text text-muted mt-0 pb-2 ml-1">Approx price that you are comfortable spending for this task</small>
                  <div class="slider-blue ml-2 mr-4">
                    <input type="text" name="budget" id="budget" value="" class="slider form-control" data-slider-min="20" data-slider-max="3000" data-slider-step="10" data-slider-value="20" data-slider-orientation="horizontal" data-slider-selection="before" data-slider-tooltip="show" style="width: 100%;">
                  </div>
                  <small class="form-text text-muted mt-0 ml-1">Your Total Amount : <span id="demo">$20.00</span></small>
                </div>

                <div class="row justify-content-center">          
                  <!-- /.col -->
                  <div class="col-6">
                    <button type="submit" class="btn btn-primary btn-block">Submit your request</button>
                  </div>
                  <!-- /.col -->
                </div>
              <?= form_close(); ?>
             
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