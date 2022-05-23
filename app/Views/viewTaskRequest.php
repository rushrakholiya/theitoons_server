<?php $session = \Config\Services::session();?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header row justify-content-center text-center mr-0">
      <div class="col-sm-6 container-fluid mt-4 pl-4">        
        <h3><?php if(isset($taskrequestinfo)){ echo $taskrequestinfo->task_title; }?></h3>

        <?php if($session->getTempdata('success')){?>
          <div class="text-center"><span class="text-success mt-1"><?= $session->getTempdata('success');?></span></div>
        <?php }?>

        <?php if($session->getTempdata('error')){?>
          <div class="text-center"><span class="text-danger input-group mt-1"><?= $session->getTempdata('error');?></span></div>
        <?php }?>

      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <?php if(isset($taskrequestinfo)){?>
    <section class="content">
      <div class="row justify-content-center">
        
        <div class="col-sm-5 mr-3">
          <?php
          /*echo "<pre>";
          print_r($taskrequestinfo);
          echo "</pre>"; */
          $task_description = getTaskRequestMeta("task_description",$taskrequestinfo->task_id);
          $reference_img = getTaskRequestMeta("reference_img",$taskrequestinfo->task_id);
          $task_status = $taskrequestinfo->task_status;
          $task_budget = getTaskRequestMeta("budget",$taskrequestinfo->task_id);
          $task_priority = getTaskRequestMeta("priority",$taskrequestinfo->task_id);
          $task_submitted_date = date("d-m-Y", strtotime($taskrequestinfo->task_date));
          $deadline = getTaskRequestMeta("deadline",$taskrequestinfo->task_id);
          if(!empty($deadline->meta_value)){
            $task_deadline =  date("d-m-Y", strtotime($deadline->meta_value));
          }?> 
          
          <?php if($task_description->meta_value || $reference_img->meta_value){?>
          <div class="panel panel-default">
            <?php if($task_description->meta_value){?>
            <div class="panel-body">
              <?php echo $task_description->meta_value;?> 
            </div>
            <?php } if($reference_img->meta_value){?>
            <div  class="panel-body" id="dvPassport" style="display: none">
              <p class="p-like">Attached image:</p>
              <img src="<?php echo $reference_img->meta_value;?>" height="200px" width="300px">
            </div>            
            <div class="panel-footer">
              <input id="btnPassport" type="button" value="View more..." class="panel-button" onclick="ShowHideDiv(this)">
            </div>
          <?php }?>
          </div>
          <?php }?>

          <h6 class="h6-like">Task status: <span><?php echo ucwords(str_replace("_"," ",$task_status));?></span></h6>

          <?php if($task_budget->meta_value){?>
          <h6 class="h6-like">Esstimated budget:<span>$<?php echo $task_budget->meta_value;?></span></h6>
          <?php }

          if($task_priority->meta_value){?>
          <h6 class="h6-like">Priority:<span class="red-icon<?php echo $task_priority->meta_value?>"><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;<?php echo ucwords($task_priority->meta_value);?></span></h6>
          <?php }?>

          <h6 class="h6-like">Date submitted:<span><?php echo $task_submitted_date;?></span></h6>
          <?php if($task_deadline){?>
          <h6 class="h6-like">Deadline:<span><?php echo $task_deadline;?></span></h6>
          <?php }?>

          <div class=""><div class="newtaskbtn"><a class="btn btn-block btn-primary" href="<?= base_url();?>/taskRequest">Submit a new request</a></div></div>

        </div>
        
        <!-- <div class="col-sm-5 ml-3">
          <div class="comment-box-main">
            <div class="comments">
               <h2>Comments</h2>                
            </div>
            <div id="comment-box"><ul class="ul" id="commentul"></ul></div>
            <form>  
              <div class="form-div">
                <?php $profile_picture=getUserMeta("profile_picture", $taskrequestinfo->user_id);
                if(!empty($profile_picture->meta_value)){$userimage = $profile_picture->meta_value;}else{$userimage = base_url()."/public/assets/dist/img/default_avatar.jpg";}?>
                <img src="<?= $userimage;?>" class="img">
                <input type="hidden" value="<?= $userimage;?>" id="img1">
                <input id="text1" type="text" placeholder="Add Your Comment"  class="textbox"/> 
                <div class="btn" style="display:none;">
                  <input id="submit" type="submit" value="Comment" >                         
                </div> 
              </div>  
            </form>

          </div>
        </div> -->
        
      </div>
    </section>
    <?php }?>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
