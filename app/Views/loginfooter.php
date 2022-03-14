<!-- jQuery -->
<script src="<?= base_url();?>/public/assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url();?>/public/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url();?>/public/assets/dist/js/adminlte.min.js"></script>

<?php $menu_name ="";
$uri = current_url();
$uriarray = explode('/', $uri);
if (in_array("taskRequest", $uriarray)) { $menu_name = 'taskRequest';}
if($menu_name=="taskRequest"){?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.5.3/js/bootstrapValidator.js"></script>
<script>
$(document).ready(function() {
    $('#taskrequestForm').bootstrapValidator({
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
            }
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
            dateFormat: "dd/mm/yy",
            minDate: 0,
        });
</script>

<?php }?>
</body>
</html>