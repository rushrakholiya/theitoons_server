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
            <h1>Add New User</h1>
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

      <?php if(isset($userinfoerror)){?>
      <div class="alert alert-danger">
        <?= $userinfoerror;?>
      </div>
      <?php }?>

      <?= form_open_multipart('admin/users/addNewUser' , 'id="fileForm"'); ?>
      <div class="row ml-1">
        <div class="col-md-8">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Profile</h3>
              <div class="card-tools"></div>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="username">User Name</label>
                <input type="text" id="username" name="username" class="form-control" value="<?= set_value('username');?>">
                <?php if(isset($validation)){?>
                <span class="text-danger input-group mt-1 ml-1"><?php echo displayError($validation,'username'); ?></span> <?php }?>  
              </div>
              <div class="form-group">
                <label for="email">User Email</label>
                <input type="text" id="email" name="email" class="form-control" value="<?= set_value('email');?>">
                <?php if(isset($validation)){?>
                <span class="text-danger input-group mt-1 ml-1"><?php echo displayError($validation,'email'); ?></span><?php }?> 
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control">
                <?php if(isset($validation)){?>
                <span class="text-danger input-group mt-1 ml-1"><?php echo displayError($validation,'password'); ?></span><?php }?>
              </div>
              <div class="form-group">
                <label for="userProfilePicture" class="control-label">Profile Picture</label>
                <input type="file" class="form-control userProfilePicture" name="avatar" />              
              </div>
              <div class="form-group">
                <label for="firstname">First Name</label>
                <input type="text" id="firstname" name="firstname" class="form-control">
              </div>
              <div class="form-group">
                <label for="lastname">Last Name</label>
                <input type="text" id="lastname" name="lastname" class="form-control">
              </div>              
              <div class="form-group">
                <label for="userdescription">Biographical Info</label>
                <textarea id="userdescription" name="userdescription" class="form-control" rows="4"></textarea>
              </div>
              <div class="form-group">
                <label for="user_role">Role</label>
                <select id="user_role" name="user_role" class="form-control custom-select">
                  <option disabled>Select one</option>
                  <option value="admin">Admin</option>
                  <option value="client">Client</option>
                </select>
              </div>
              <div class="form-group">
                <label for="userstatus">Status</label>
                <select id="userstatus" name="userstatus" class="form-control custom-select">
                  <option disabled>Select one</option>
                  <option value="1">Active</option>
                  <option value="0">Inactive</option>
                </select>
              </div>
              <div class="form-group">
                <label for="companyname">Company Name</label>
                <input type="text" id="companyname" name="companyname" class="form-control">
              </div>
              <div class="form-group">
                <label for="useraddressone">Address line 1</label>
                <input type="text" id="useraddressone" name="useraddressone" class="form-control">
              </div>
              <div class="form-group">
                <label for="useraddresstwo">Address line 2</label>
                <input type="text" id="useraddresstwo" name="useraddresstwo" class="form-control">
              </div>
              <div class="form-group selectcountry">
                <label for="usercountry">Country / Region</label>
                <select name="countryId" class="countries form-control custom-select" id="countryId">
                    <option value="">Select Country</option>
                </select>
              </div>
              <div class="form-group">
                <label for="inputProjectLeader">State / County</label>
                <select name="stateId" class="states form-control custom-select" id="stateId">
                    <option value="">Select State</option>
                </select>
              </div>
              <div class="form-group">
                <label for="usercity">City</label>
                <select name="cityId" class="cities form-control custom-select" id="cityId">
                  <option value="">Select City</option>
                </select>
              </div>
              <div class="form-group">
                <label for="userzip">Postcode / ZIP</label>
                <input type="text" id="userzip" name="userzip" class="form-control">
              </div>
              <div class="form-group">
                <label for="userphone">Phone</label>
                <input type="text" id="userphone" name="userphone" class="form-control">
              </div>
              <div class="form-group">
                <label for="useranotheremail">Email</label>
                <input type="text" id="useranotheremail" name="useranotheremail" class="form-control">
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>

      <div class="row ml-1">
        <div class="col-md-8 mb-5">
          <input type="submit" value="Create New User" class="btn btn-success float-right">
        </div>
      </div>
      <?= form_close();?>
    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->
  <script src="//geodata.solutions/includes/countrystatecity.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.5.3/js/bootstrapValidator.js"></script>
  <script>
    $(document).ready(function() {
        $('#fileForm').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                avatar: {
                    validators: {
                        file: {
                            extension: 'jpg,jpeg,png',
                            type: 'image/jpg,image/jpeg,image/png',
                            //maxSize: 2048 * 1024,
                            message: 'The selected file is not valid'
                        }
                    }
                }
            }
        });
    });
  </script>
 <link rel="stylesheet" href="<?= base_url();?>/public/assets/dist/css/userforms.css"> 