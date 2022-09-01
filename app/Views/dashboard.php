<?php $session = \Config\Services::session();?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid text-center mt-4">        
        <h3>Your active requests</h3>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row justify-content-center">        
        <div class="col-sm-10">          
          <!-- Default box -->
          <?php if($session->getTempdata('success')){?>
            <div class="text-center mb-3"><span class="text-success"><?= $session->getTempdata('success'); ?></span></div>
          <?php }?>

          <?php if($session->getTempdata('error')){?>
            <div class="text-center mb-3"><span class="text-danger"><?= $session->getTempdata('error'); ?></span></div>
          <?php }?>

          <?php if(isset($error)){
            $frame1 = base_url()."/public/assets/dist/img/frame.png";?>
            <center>
              <img src="<?= $frame1;?>" width="250">
              <br><span><?= $error;?></span><br>
              <!-- <div class="newtaskbtn"><a class="btn btn-block btn-primary" href="<?php //echo base_url();?>/taskRequest">Submit a new request</a></div> -->
            </center>
          <?php }?>

          <?php if(isset($taskrequestdata)){
              /*echo "<pre>";
              print_r($taskrequestdata);
              echo "</pre>";*/ ?> 
          <div class="card">
            <div class="card-body table-responsive p-0">        
              <table class="table table-striped projects text-nowrap">
                  <thead>
                      <tr>
                          <th>Task Title</th>
                          <th>Priority</th>
                          <th>Deadline</th>
                          <th>Status</th>                       
                          <th>Submitted Date</th>
                          <th>Payment Status</th>
                          <th>Actions</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php 
                     foreach($taskrequestdata as $row)
                      {
                        
                        $priority = getTaskRequestMeta("priority",$row->task_id);
                        if(!empty($priority->meta_value)){$task_priority = $priority->meta_value;}
                        else{$task_priority = "-";}

                        $deadline = getTaskRequestMeta("deadline",$row->task_id);
                        if(!empty($deadline->meta_value)){$task_deadline = $deadline->meta_value;}
                        else{$task_deadline = "-";}
                        
                        if($task_priority=="urgent"){$color = "bg-danger";}
                        elseif($task_priority=="high"){$color = "bg-success";}
                        elseif($task_priority=="standard"){$color = "bg-warning";}
                        elseif($task_priority=="normal"){$color = "bg-lightblue";}
                        $taskpriority = ucwords($task_priority);

                        $taskstatus = ucwords(str_replace("_"," ",$row->task_status));
                        
                        $task_submitted_date = date("d-m-Y", strtotime($row->task_date));
                        $task_submitted_time = date("h:i a", strtotime($row->task_date));

                        $paymentstatus = getTaskRequestPaymentData($row->task_id);
                        
                        if(!empty($paymentstatus->payment_status)){$pay_status = $paymentstatus->payment_status;}
                        else{$pay_status = "-";}
                        
                        echo "<tr>";
                        echo "<td>".$row->task_title."</td>";
                        echo "<td><span class='tbp btn btn-sm ".$color."'><span>".$taskpriority."</span></span></td>";
                        echo "<td>".$task_deadline."</td>";                        
                        echo "<td>".$taskstatus."</td>";   
                        echo '<td>'.$task_submitted_date.'<span style="font-weight: 600;font-size: 10px;color: #939393;text-transform: uppercase;">  '.$task_submitted_time.'</span></td>';
                        echo "<td>".ucwords($pay_status)."</td>";
                        echo '<td class="project-actions">';
                        echo '<a class="contactentryview" href="'.base_url().'/dashboard/viewTaskRequest/'.$row->task_id.'" title="View Request"> 👁 </a>';
                        if($row->task_status=="pending"){
                        echo '<a href="'.base_url().'/dashboard/editTaskRequest/'.$row->task_id.'" style="padding-left: 10px;" title="Edit Request"> 📝 </a>';
                        echo '<a href="'.base_url().'/dashboard/deleteTaskRequest/'.$row->task_id.'" style="padding-left: 10px;" title="Delete Request"> ❌ </a>';
                        }
                        if($row->task_status=="in_review"){
                        echo '<a href="'.base_url().'/dashboard/completeTaskRequest/'.$row->task_id.'" style="padding-left: 10px;" title="Complete Request"> ✔ </a>';
                        }                        
                        if($row->task_status=="accepted" && $pay_status != "Completed"){
                        $task_budget = getTaskRequestMeta("budget",$row->task_id);
                        echo '<a href="'.base_url().'/dashboard/paymentTaskRequest/'.$row->task_id.'" style="padding-left: 10px;" title="Pay $'.$task_budget->meta_value.'"> 💳</a>';
                        }

                        $deliver_file = getTaskRequestMeta("deliver_file",$row->task_id);
                        $task_deliver_description = getTaskRequestMeta("task_deliver_description",$row->task_id);
                        if($deliver_file || $task_deliver_description){
                          if(!empty($deliver_file->meta_value) || !empty($task_deliver_description->meta_value)){
                            echo '<a href="#" data-toggle="modal" data-target="#modal-default'.$row->task_id.'" style="margin-left: 10px;" title="Download Deliver" class="btn btn-outline-info btn-sm"> <span style="vertical-align: text-bottom;">📥</span> Download</a>';
                          }
                        }
                        echo '</td>';
                        echo "</tr>";?>

                        <div class="modal fade" id="modal-default<?= $row->task_id;?>">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h4 class="modal-title">Add Data</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <div class="form-div">                       
                                  <div class="form-group">
                                    <label for="uploadfile" class="control-label">Uploaded File :</label>
                                    <?php $ddeliver_file = getTaskRequestMeta("deliver_file", $row->task_id);
                                      if($ddeliver_file && !empty($ddeliver_file->meta_value)){
                                      /*$ddrefimg = explode('/', $ddeliver_file->meta_value);
                                      $ddrefimgname = array_reverse($ddrefimg);
                                      //print_r($refimgname);
                                      <a href="<?= $ddeliver_file->meta_value;?>" download>
                                        <span class=""><?= $ddrefimgname[0];?></span>
                                      </a>*/
                                      $drefimgarray = array_filter(explode(',',$ddeliver_file->meta_value));
                                      foreach($drefimgarray as $drimga){
                                      $drimgaresult = str_replace("'", '', $drimga);
                                      $ddrefimg = explode('/', $drimgaresult);
                                      $ddrefimgname = array_reverse($ddrefimg);?>
                                      <a href="<?= $drimgaresult;?>" download>
                                        <span class=""><?= $ddrefimgname[0];?></span>
                                      </a>
                                      <?php }
                                      }else{echo "-";}?>
                                  </div>
                                  <div class="form-group">
                                    <?php $dtask_deliver_description = getTaskRequestMeta("task_deliver_description", $row->task_id);?>
                                    <label for="task_deliver_description" class="control-label">Description : </label>
                                    <?php if($dtask_deliver_description && !empty($dtask_deliver_description->meta_value)){echo $dtask_deliver_description->meta_value;}?>
                                  </div>
                                </div>                                                      
                              </div>
                            </div>
                            <!-- /.modal-content -->
                          </div>
                          <!-- /.modal-dialog -->
                        </div>
                    <?php }?>
                  </tbody>
              </table>        
            </div>        
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
          <?php }?>

          <?php if(isset($totaltaskno)){?>
            <div class="text-center"><div class="newtaskbtnd"><div class="tbp btn btn-block btn-info btn-primary">
              <?= $totaltaskno;?>
            </div></div></div>
          <?php } else {?><div class="text-center"><div class="newtaskbtn"><a class="btn btn-block btn-primary" href="<?= base_url();?>/taskRequest">Submit a new request</a></div></div><?php }?>

        </div>        
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->