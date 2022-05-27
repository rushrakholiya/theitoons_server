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
            <h1>Comments</h1>
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

      <?php if(isset($commentdataerror)){?>
        <div class="alert alert-danger">
          <?= $commentdataerror;?>
        </div>
      <?php }?>

      <?php if(isset($commentsdata)){
          /*echo "<pre>";
          print_r($commentsdata);
          echo "</pre>";*/?> 
      <div class="card">       
        <div class="card-body p-0">        
          <table class="table table-striped projects">
              <thead>
                  <tr>
                      <th>Id</th>
                      <th>Author Name</th>
                      <th>Comment</th>
                      <th>Task Name</th>
                      <th>Submitted on</th>
                      <th></th>
                  </tr>
              </thead>
              <tbody>
                <?php
                 foreach($commentsdata as $row)
                  {
                    $comment_submitted_date = date("d-m-Y", strtotime($row['comment_date']));
                    $comment_submitted_time = date("h:i a", strtotime($row['comment_date']));
                    $taskdata = getTaskRequest($row['task_id']);
                    
                    $uid = session()->get('logged_user');        
                    $loggedinuserdata = getLoggedInUserData($uid);
                    $cuser_id = $loggedinuserdata->user_id;
                    $comment_author = $loggedinuserdata->user_name;
                    $comment_author_email = $loggedinuserdata->user_email;

                    $parentData = getParentCommentData($row['comment_parent']);
                    if(!empty($parentData)){
                      $parenttakid = $parentData[0]['task_id'];
                      $ptaskdata = getTaskRequest($parenttakid);
                      $ptasktitle = $ptaskdata->task_title;
                    }else{
                      $ptasktitle = "";
                    }
                    
                    echo "<tr id=".$row['comment_id'].">";
                    echo "<td>".$row['comment_id']."</td>";
                    echo "<td>".$row['comment_author']."</td>";
                    echo "<td style='width: 30%;'>";
                      if($ptasktitle){
                        echo "<a href=".$row['comment_parent']." class='linkrow'>In reply to a $ptasktitle (id:".$row['comment_parent'].")<br></a>";
                      }
                    echo $row['comment_content']."</td>";
                    echo "<td style='width: 20%;'>".$taskdata->task_title."</td>";
                    echo "<td>".$comment_submitted_date."<span style='font-weight: 600;font-size: 10px;color: #939393;text-transform: uppercase;'>  ".$comment_submitted_time."</span></td>";                 
                    echo '<td class="project-actions text-right">
                          <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-default'.$row['comment_id'].'"><i class="fas fa-pencil-alt"></i>
                              Reply
                          </button>

                          <a class="btn btn-danger btn-sm" href="'.base_url().'/admin/comments/deleteComment/'.$row['comment_id'].'">
                              <i class="fas fa-trash">
                              </i>
                              Delete
                          </a>
                      </td>';
                    echo "</tr>";?>

                    <div class="modal fade" id="modal-default<?= $row['comment_id'];?>">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <?= form_open_multipart('admin/comments/addCommentReply' , 'id="acomment_form"'); ?>
                            
                          <div class="modal-header">
                            <h4 class="modal-title">Reply to Comment</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <div class="form-div form-group">                       
                              <input id="comment_text" name="comment_text" type="text" placeholder="Add Your Comment"  class="form-control"/>
                              <input type="hidden" value="<?= $cuser_id;?>" id="cuser_id" name="cuser_id">  
                              <input type="hidden" value="<?= $row['task_id'];?>" id="ctask_id" name="ctask_id">
                              <input type="hidden" value="<?= $comment_author;?>" id="comment_author" name="comment_author">
                              <input type="hidden" value="<?= $comment_author_email;?>" id="comment_author_email" name="comment_author_email">
                              <input type="hidden" value="<?= $row['comment_id'];?>" id="comment_parent" name="comment_parent">
                            </div>                                                      
                          </div>
                          <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Reply</button>
                          </div>
                          <?= form_close();?>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->

                    <script>
                      $('a.linkrow').on('click',function(e){
                         e.preventDefault();
                         var scrollTo = $(this).attr('href');
                         $('html, body').animate({
                              scrollTop: $("#"+scrollTo).offset().top
                          }, 2000);
                      });
                    </script>
              <?php }?>
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