<?php 
$site_name = getGeneralData("site_name");
  if(!empty($site_name->option_value))
  {$sitename=$site_name->option_value;}else{$sitename="TheIToons";}

$menu_name ="";
$uri = current_url();
$uriarray = explode('/', $uri);
if (in_array("login", $uriarray)) { $menu_name = 'login';}
if (in_array("forgotPassword", $uriarray)) { $menu_name = 'forgotPassword';}
if (in_array("register", $uriarray)) { $menu_name = 'register';}
if (in_array("resetPassword", $uriarray)) { $menu_name = 'resetPassword';}

if (in_array("taskRequest", $uriarray)) { $menu_name = 'taskRequest';}
if (in_array("editTaskRequest", $uriarray)) { $menu_name = 'editTaskRequest';}

if($menu_name !="login" && $menu_name !="forgotPassword" && $menu_name !="register" && $menu_name !="resetPassword"){?>
  <footer class="main-footer">
    <strong>© <?= $sitename;?> - <?= date("Y");?></strong>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

</div>
<!-- ./wrapper -->
<?php }?>
<!-- jQuery -->
<script src="<?= base_url();?>/public/assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url();?>/public/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url();?>/public/assets/dist/js/adminlte.min.js"></script>

<style>
.HW_badge, .HW_badge.HW_softHidden {
    background: none !important;
    opacity: 1 !important;
    transform: unset !important;
    color: rgba(0,0,0,.9) !important;
    font-size: 1rem !important;
    font-weight: 400 !important;
    line-height: 1.5 !important;
    top: 0px !important;
    left: 0px !important;
    height: auto !important;
    width: auto !important;
    position: unset !important;
}
.HW_badge_cont {
    height: auto !important;
    width: auto !important;
}
.appcount {
    border-radius: 20px;
    background: #CD4B5B;
    height: 16px;
    width: 16px;
    color: #fff;
    text-align: center;
    line-height: 16px;
    font-size: 11px;
    cursor: pointer;
    position: absolute;
    opacity: 1;
}
</style>
<?php 
if($menu_name=="taskRequest" || $menu_name=="editTaskRequest"){?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.5.3/js/bootstrapValidator.js"></script>
<script>
$(document).ready(function() {
    $('.taskrequestForm').bootstrapValidator({
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            reference: {
                validators: {
                    file: {
                        extension: 'jpg,jpeg,png,gif,pdf',
                        type: 'image/jpg,image/jpeg,image/png,image/gif,application/pdf',
                        //maxSize: 2048 * 1024,
                        message: 'The selected file is not valid (only jpg,jpeg,png,gif,pdf allow)'
                    }
                }
            },
            title: {
                validators: {
                    notEmpty: {
                        message: 'The title field is required.'
                    },
                }
            },
            priority: {
                validators: {
                    notEmpty: {
                        message: 'The priority field is required.'
                    },
                }
            },
            task_description: {
                validators: {
                    notEmpty: {
                        message: 'The Task Description field is required.'
                    },
                }
            },
        }
    });
});
</script>
<!-- Bootstrap slider -->
<script src="<?= base_url();?>/public/assets/plugins/bootstrap-slider/bootstrap-slider.min.js"></script>
<script>
$('#budget').slider({
	formatter: function(value) {
		return '$' + value + 'USD';
	}
});
$("#budget").on("slide", function(slideEvt) {
	$("#demo").text('$' + slideEvt.value + '.00');
});
</script>

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>-->
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
<script> 
    $("#datepicker").datepicker({
            dateFormat: "dd-mm-yy",
            minDate: 0,
        });
</script>

<?php }?>

<?php if($menu_name =="editTaskRequest"){?>
<!-- Ekko Lightbox -->
<script src="<?= base_url();?>/public/assets/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
<script>
  $(function () {
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
      event.preventDefault();
      $(this).ekkoLightbox({
        alwaysShowClose: true
      });
    });

    $('.btn[data-filter]').on('click', function() {
      $('.btn[data-filter]').removeClass('active');
      $(this).addClass('active');
    });
  })
</script>
<?php }?>

</body>
</html>