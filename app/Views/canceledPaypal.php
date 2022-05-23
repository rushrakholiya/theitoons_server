<?php $session = \Config\Services::session();?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper text-center">
    <!-- Content Header (Page header) -->
    <!-- <section class="content-header row justify-content-center mr-0"> -->
    <section class="row justify-content-center mr-0 pt-5">
      <div class="col-sm-6 container-fluid mt-4 pl-4">        
        <h1>Oops!</h1>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row justify-content-center">
        <div class="col-sm-8">
          <h3 class="pb-3">Sorry! Your payment has been not received successfully.</h3>
          <h5>Please try again later. <b><a href="<?= base_url();?>/dashboard">View Requests</a></b></h5>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->