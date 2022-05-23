<?php $session = \Config\Services::session();?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper text-center">
    <!-- Content Header (Page header) -->
    <section class="row justify-content-center mr-0 pt-5">
      <div class="col-sm-6 container-fluid mt-4 pl-4">        
        <h1>You are awesome!</h1>
        <?php /*if(isset($datacomplete)){
        echo "<pre>";
        print_r($datacomplete);
        echo "</pre>";
        }*/?>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row justify-content-center">
        <div class="col-sm-8">
          <h3 class="pb-3">Thank you! Your payment has been successfully received.</h3>
          <h5>TheIToons team will reply soon.<b><a href="<?= base_url();?>/dashboard">View Requests</a></b></h5>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->