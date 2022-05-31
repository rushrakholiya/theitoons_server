  <footer class="main-footer">
    <?php $site_name = getGeneralData("site_name");
        if(!empty($site_name->option_value))
        {$sitename=$site_name->option_value;}else{$sitename="TheIToons";}?>
    <strong>© <?= $sitename;?> - <?= date("Y");?></strong>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<?php $menu_name ="";
$uri = current_url();
$uriarray = explode('/', $uri);
if (in_array("dashboard", $uriarray)) { $menu_name = 'dashboard';}
if (in_array("allTaskRequests", $uriarray)) { $menu_name = 'allTaskRequests';}?>

<?php if($menu_name =="allTaskRequests"){?>
<!-- Ekko Lightbox -->
<script src="<?= base_url();?>/public/assets/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
<script>
  $(function () {
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
      event.preventDefault();
      $(this).ekkoLightbox({
        alwaysShowClose: true,
        showArrows:false
      });
    });

    $('.btn[data-filter]').on('click', function() {
      $('.btn[data-filter]').removeClass('active');
      $(this).addClass('active');
    });
  })
</script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
<script> 
    $("#deadline").datepicker({
            dateFormat: "dd-mm-yy",
            minDate: 0,
        });
</script>
<?php }

if($menu_name=="dashboard"){?>
<!-- jQuery UI 1.11.4 -->
<script src="<?= base_url();?>/public/assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- ChartJS -->
<script src="<?= base_url();?>/public/assets/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="<?= base_url();?>/public/assets/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="<?= base_url();?>/public/assets/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="<?= base_url();?>/public/assets/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?= base_url();?>/public/assets/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?= base_url();?>/public/assets/plugins/moment/moment.min.js"></script>
<script src="<?= base_url();?>/public/assets/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?= base_url();?>/public/assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="<?= base_url();?>/public/assets/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?= base_url();?>/public/assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?= base_url();?>/public/assets/dist/js/pages/dashboard.js"></script>
<?php }?>

<!-- AdminLTE App -->
<script src="<?= base_url();?>/public/assets/dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= base_url();?>/public/assets/dist/js/demo.js"></script>

</body>
</html>