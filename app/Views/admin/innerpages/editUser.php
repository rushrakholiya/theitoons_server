<?php $session = \Config\Services::session();?>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  <?= $this->include("admin/innerpages/sidebar");?>

    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Users</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url();?>/dashboard">Home</a></li>
              <li class="breadcrumb-item active">Users</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <?php if($session->getTempdata('successeditUser')){?>
        <div class="alert alert-success">
          <?= $session->getTempdata('successeditUser');?>
        </div>
      <?php }?>

      <?php if($session->getTempdata('erroreditUser')){?>
        <div class="alert alert-danger">
          <?= $session->getTempdata('erroreditUser');?>
        </div>
      <?php }?>

      <?php if(isset($userinfoerror)){?>
      <div class="alert alert-danger">
        <?= $userinfoerror;?>
      </div>
      <?php }?>

      <?php if(isset($userinfo)){
        $id = $userinfo->user_id;
          /*echo "<pre>";
          print_r($userinfo);
          echo "</pre>";
          
          echo $userinfo->user_name;
          echo $userinfo->user_email;
          echo $userinfo->user_status;        

          $result = getUserMeta("nickname", $id);
          echo $result->meta_value;*/
      ?>
      <?= form_open_multipart('users/editUser/'.$id , 'id="fileForm"'); ?>
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
                <input type="text" id="username" name="username" class="form-control" value="<?= $userinfo->user_name;?>" disabled="disabled">
              </div>
              <div class="form-group">
                <label for="useremail">User Email</label>
                <input type="email" id="useremail" name="useremail" class="form-control" value="<?= $userinfo->user_email;?>" disabled="disabled">
              </div>
              <div class="form-group">
                <label for="userProfilePicture" class="control-label">Profile Picture</label>
                <input type="file" class="form-control userProfilePicture" name="avatar" />                 
              </div>
              <div class="form-group">
                <label for="firstname">First Name</label>
                <?php $first_name=getUserMeta("first_name", $id);?>
                <input type="text" id="firstname" name="firstname" class="form-control" value="<?= $first_name->meta_value;?>">
              </div>
              <div class="form-group">
                <label for="lastname">Last Name</label>
                <?php $last_name=getUserMeta("last_name", $id);?>
                <input type="text" id="lastname" name="lastname" class="form-control" value="<?= $last_name->meta_value;?>">
              </div>              
              <div class="form-group">
                <label for="userdescription">Biographical Info</label>
                <?php $user_description = getUserMeta("user_description", $id);?>
                <textarea id="userdescription" name="userdescription" class="form-control" rows="4"><?= $user_description->meta_value;?></textarea>
              </div>
              <div class="form-group">
                <label for="user_role">Role</label>
                <?php $user_role = getUserMeta("user_role", $id);?>
                <select id="user_role" name="user_role" class="form-control custom-select">
                  <option disabled>Select one</option>
                  <option value="admin" <?php if($user_role->meta_value=="admin"){echo "selected";}?>>Admin</option>
                  <option value="client" <?php if($user_role->meta_value=="client"){echo "selected";}?>>Client</option>
                </select>
              </div>
              <div class="form-group">
                <label for="userstatus">Status</label>
                <select id="userstatus" name="userstatus" class="form-control custom-select">
                  <option disabled>Select one</option>
                  <option value="1" <?php if($userinfo->user_status==1){echo "selected";}?>>Active</option>
                  <option value="0" <?php if($userinfo->user_status==0){echo "selected";}?>>Inactive</option>
                </select>
              </div>
              <div class="form-group">
                <label for="companyname">Company Name</label>
                <?php $company_name=getUserMeta("company_name", $id);?>
                <input type="text" id="companyname" name="companyname" class="form-control" value="<?= $company_name->meta_value;?>">
              </div>
              <div class="form-group">
                <label for="useraddressone">Address line 1</label>
                <?php $address_one=getUserMeta("address_one", $id);?>
                <input type="text" id="useraddressone" name="useraddressone" class="form-control" value="<?= $address_one->meta_value;?>">
              </div>
              <div class="form-group">
                <label for="useraddresstwo">Address line 2</label>
                <?php $address_two=getUserMeta("address_two", $id);?>
                <input type="text" id="useraddresstwo" name="useraddresstwo" class="form-control" value="<?= $address_two->meta_value;?>">
              </div>
              <div class="form-group selectcountry">
                <label for="usercountry">Country / Region</label>
                <?php $user_country=getUserMeta("user_country", $id);?>
                <select name="countryId" class="countries form-control custom-select" id="countryId">
                    <option value="">Select Country</option>
                </select>
              </div>
              <div class="form-group">
                <label for="inputProjectLeader">State / County</label>
                <?php $user_state=getUserMeta("user_state", $id);?>
                 <select name="stateId" class="states form-control custom-select" id="stateId">
                    <option value="">Select State</option>
                </select>
              </div>
              <div class="form-group">
                <label for="usercity">City</label>
                <?php $user_city=getUserMeta("user_city", $id);?>
                <select name="cityId" class="cities form-control custom-select" id="cityId">
                  <option value="">Select City</option>
                </select>
              </div>
              <div class="form-group">
                <label for="userzip">Postcode / ZIP</label>
                <?php $user_zip=getUserMeta("user_zip", $id);?>
                <input type="text" id="userzip" name="userzip" class="form-control" value="<?= $user_zip->meta_value;?>">
              </div>
              <div class="form-group">
                <label for="userphone">Phone</label>
                <?php $user_phone=getUserMeta("user_phone", $id);?>
                <input type="text" id="userphone" name="userphone" class="form-control" value="<?= $user_phone->meta_value;?>">
              </div>
              <div class="form-group">
                <label for="useranotheremail">Email</label>
                <?php $user_anoter_email=getUserMeta("user_anoter_email", $id);?>
                <input type="email" id="useranotheremail" name="useranotheremail" class="form-control" value="<?= $user_anoter_email->meta_value;?>">
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <?php $profile_picture=getUserMeta("profile_picture", $id);
        if(!empty($profile_picture->meta_value)){?>
        <div class="col-md-4">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Profile Picture</h3>
            </div>          
            <div class="card-body">
              <div class="form-group">
                  <img class="img-circle" src="<?= $profile_picture->meta_value;?>" height="160px" width="160px">
              </div>
            </div>
          </div>
        </div>
      <?php }?>
      </div>

      <div class="row ml-1">
        <div class="col-md-8 mb-5">
          <input type="submit" value="Save Changes" class="btn btn-success float-right">
        </div>
      </div>

      <script>
        setTimeout(function(){
          $("#countryId").val("<?= $user_country->meta_value;?>").change();
        }, 1500);
        setTimeout(function(){
          $("#stateId").val("<?= $user_state->meta_value;?>").change();
        }, 2000);
        setTimeout(function(){
          $("#cityId").val("<?= $user_city->meta_value;?>").change();
        }, 2500);
      </script>

      <?php }?>
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
  <style>
.userProfilePicture {line-height: 1.2;}
.has-success .help-block,
.has-success .control-label,
.has-success .radio,
.has-success .checkbox,
.has-success .radio-inline,
.has-success .checkbox-inline {
 color:#3c763d
}
.has-success .form-control {
 border-color:#3c763d;
 -webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,.075);
 box-shadow:inset 0 1px 1px rgba(0,0,0,.075)
}
.has-success .form-control:focus {
 border-color:#2b542c;
 -webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,.075),0 0 6px #67b168;
 box-shadow:inset 0 1px 1px rgba(0,0,0,.075),0 0 6px #67b168
}
.has-success .input-group-addon {
 color:#3c763d;
 background-color:#dff0d8;
 border-color:#3c763d
}
.has-success .form-control-feedback {
 color:#3c763d
}
.has-warning .help-block,
.has-warning .control-label,
.has-warning .radio,
.has-warning .checkbox,
.has-warning .radio-inline,
.has-warning .checkbox-inline {
 color:#8a6d3b
}
.has-warning .form-control {
 border-color:#8a6d3b;
 -webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,.075);
 box-shadow:inset 0 1px 1px rgba(0,0,0,.075)
}
.has-warning .form-control:focus {
 border-color:#66512c;
 -webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,.075),0 0 6px #c0a16b;
 box-shadow:inset 0 1px 1px rgba(0,0,0,.075),0 0 6px #c0a16b
}
.has-warning .input-group-addon {
 color:#8a6d3b;
 background-color:#fcf8e3;
 border-color:#8a6d3b
}
.has-warning .form-control-feedback {
 color:#8a6d3b
}
.has-error .help-block,
.has-error .control-label,
.has-error .radio,
.has-error .checkbox,
.has-error .radio-inline,
.has-error .checkbox-inline {
 color:#a94442
}
.has-error .form-control {
 border-color:#a94442;
 -webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,.075);
 box-shadow:inset 0 1px 1px rgba(0,0,0,.075)
}
.has-error .form-control:focus {
 border-color:#843534;
 -webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,.075),0 0 6px #ce8483;
 box-shadow:inset 0 1px 1px rgba(0,0,0,.075),0 0 6px #ce8483
}
.has-error .input-group-addon {
 color:#a94442;
 background-color:#f2dede;
 border-color:#a94442
}
.has-error .form-control-feedback {
 color:#a94442
}
.has-feedback label.sr-only~.form-control-feedback {
 top:0
}
.help-block {
 display:block;
 margin-top:5px;
 margin-bottom:10px;
 color:#737373
}
  </style>