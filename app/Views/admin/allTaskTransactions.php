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
            <h1>All Task Transactions</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
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

      <?php if(isset($tasktransactionsdata)){
          /*echo "<pre>";
          print_r($tasktransactionsdata);
          echo "</pre>";*/?> 
      <div class="card">       
        <div class="card-body table-responsive p-0">        
          <table class="table table-striped projects text-nowrap">
              <thead>
                  <tr>
                      <th>Payment ID</th>
                      <th>Payment status</th>
                      <th>Email</th>
                      <th>Item</th>
                      <th>Amount</th>
                      <th>Submitted Date</th>
                      <th></th>
                  </tr>
              </thead>
              <tbody>
                <?php 
                 foreach($tasktransactionsdata as $row)
                  {                    
                    $transactionmeta = json_decode($row->meta_value);
                    //print_r($transactionmeta);echo"<br>";
                    //print_r($transactionmeta->transactions[0]->amount->total);echo"<br>";
                    $nameid = explode("-",$transactionmeta->transactions[0]->description);
                    //print_r($nameid);
                    echo "<tr>";
                    echo "<td>".$row->payment_title."</td>";
                    echo "<td>".$transactionmeta->transactions[0]->related_resources[0]->sale->state."</td>";
                    echo "<td>".$transactionmeta->payer->payer_info->email."</td>";
                    echo "<td>Name: ".$nameid[0]."<br>Id: ".$nameid[1]."</td>";
                    echo "<td>".$transactionmeta->transactions[0]->amount->total." ".$transactionmeta->transactions[0]->amount->currency."</td>";
                    echo "<td>".$row->payment_date."</td>";
                    echo '<td class="project-actions text-right">
                          <a class="btn btn-info btn-sm" href="'.base_url().'/admin/AllTaskTransactions/viewTaskTransaction/'.$row->payment_id.'"><i class="fas fa-pencil-alt"></i> View</a>
                          <a class="btn btn-danger btn-sm" href="'.base_url().'/admin/AllTaskTransactions/deleteTaskTransaction/'.$row->payment_id.'"><i class="fas fa-trash"></i> Delete</a>
                      </td>';
                    echo "</tr>";
                  }?>
              </tbody>
          </table>        
        </div>        
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
      <?php }?>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->