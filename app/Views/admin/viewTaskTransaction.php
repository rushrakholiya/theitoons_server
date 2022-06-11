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
            <h1>Transacion Information</h1>
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

      <?php if(isset($error)){?>
      <div class="alert alert-danger">
        <?= $error;?>
      </div>
      <?php }?>

      <?php if(isset($tasktransactioninfo)){
        //print_r($tasktransactioninfo);          

          $transactionmeta = json_decode($tasktransactioninfo->meta_value);
          $nameid = explode("-",$transactionmeta->transactions[0]->description);
          
          $paymentid = $tasktransactioninfo->payment_title;
          //$paymentstatus = $tasktransactioninfo->payment_status;
          $paymentstatus = $transactionmeta->transactions[0]->related_resources[0]->sale->state;
          $payeremail = $transactionmeta->payer->payer_info->email;
          $itemname = "Name: ".$nameid[0]." ,Id: ".$nameid[1];
          $amount = $transactionmeta->transactions[0]->amount->total." ".$transactionmeta->transactions[0]->amount->currency;
          $submitteddate = $tasktransactioninfo->payment_date;

          $paymentmode = $transactionmeta->transactions[0]->related_resources[0]->sale->payment_mode;
          $payerpayermethod = $transactionmeta->payer->payment_method;
          $payerpayerstatus = $transactionmeta->payer->status;
          $payerfname = $transactionmeta->payer->payer_info->first_name;
          $payerlname = $transactionmeta->payer->payer_info->last_name;
          $payerpayerid = $transactionmeta->payer->payer_info->payer_id;
          $payeraddress = $transactionmeta->payer->payer_info->shipping_address;
        ?>
      <div class="row">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header">
                <h3 class="card-title">Order Details</h3>
            </div>
            <div class="card-body">
              <dl class="row">
                <dt class="col-sm-3">Payment Methos</dt><dd class="col-sm-9"><?= $payerpayermethod;?></dd>
                <dt class="col-sm-3">Payment Mode</dt><dd class="col-sm-9"><?= $paymentmode;?></dd>
                <dt class="col-sm-3">Payment ID</dt><dd class="col-sm-9"><?= $paymentid;?></dd>
                <dt class="col-sm-3">Payment status</dt><dd class="col-sm-9"><?= $paymentstatus;?></dd>
                <dt class="col-sm-3">Payer Email</dt><dd class="col-sm-9"><?= $payeremail;?></dd>
                <dt class="col-sm-3">Item</dt><dd class="col-sm-9"><?= $itemname;?></dd>
                <dt class="col-sm-3">Amount</dt><dd class="col-sm-9"><?= $amount;?></dd>
                <dt class="col-sm-3">Submitted Date</dt><dd class="col-sm-9"><?= $submitteddate;?></dd>
              </dl>
            </div>
            <!-- /.card-body -->
          </div>
          <div class="card">
            <div class="card-header">
                <h3 class="card-title">Payer Details</h3>
            </div>
            <div class="card-body">
              <dl class="row">
                <dt class="col-sm-3">Payer Status</dt><dd class="col-sm-9"><?= $payerpayerstatus;?></dd>
                <dt class="col-sm-3">Payer Email</dt><dd class="col-sm-9"><?= $payeremail;?></dd>
                <dt class="col-sm-3">First Name</dt><dd class="col-sm-9"><?= $payerfname;?></dd>
                <dt class="col-sm-3">Last Name</dt><dd class="col-sm-9"><?= $payerlname;?></dd>
                
                <dt class="col-sm-3">Payer Id</dt><dd class="col-sm-9"><?= $payerpayerid;?></dd>
                <dt class="col-sm-3">Address</dt><dd class="col-sm-9">
                    <b>Street:</b> <?= $payeraddress->line1; ?><br>
                    <b>Zipcode:</b> <?= $payeraddress->postal_code;?><br>
                    <b>City:</b> <?= $payeraddress->city;?><br>
                    <b>State:</b> <?= $payeraddress->state;?><br>
                    <b>Country Code:</b> <?= $payeraddress->country_code;?></dd>
              </dl>
            </div>
            <div class="deletebtn">
                <a class="btn btn-danger float-right mt-3 mr-3 mb-3" href="<?= base_url();?>/admin/AllTaskTransactions/deleteTaskTransaction/<?= $tasktransactioninfo->payment_id;?>"><i class="fas fa-trash"></i> Delete</a>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>      
      <?php }?>
    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper --> 