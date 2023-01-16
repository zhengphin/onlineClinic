<?= $this->extend('layout/dashboard-layout');?>
<?= $this->section('content');?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Bootstrap Data Table with Filter Row Feature</title>
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
      <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
      <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
      <style>
         .modal-confirm {		
         color: #434e65;
         width: 525px;
         }
         .modal-confirm .modal-content {
         padding: 20px;
         font-size: 16px;
         border-radius: 5px;
         border: none;
         }
         .modal-confirm .modal-header {
         background: #47c9a2;
         border-bottom: none;   
         position: relative;
         text-align: center;
         margin: -20px -20px 0;
         border-radius: 5px 5px 0 0;
         padding: 35px;
         }
         .modal-confirm h4 {
         text-align: center;
         font-size: 36px;
         margin: 10px 0;
         }
         .modal-confirm .form-control, .modal-confirm .btn {
         min-height: 40px;
         border-radius: 3px; 
         }
         .modal-confirm .close {
         position: absolute;
         top: 15px;
         right: 15px;
         color: #fff;
         text-shadow: none;
         opacity: 0.5;
         }
         .modal-confirm .close:hover {
         opacity: 0.8;
         }
         .modal-confirm .icon-box {
         color: #fff;		
         width: 95px;
         height: 95px;
         display: inline-block;
         border-radius: 50%;
         z-index: 9;
         border: 5px solid #fff;
         padding: 15px;
         text-align: center;
         }
         .modal-confirm .icon-box i {
         font-size: 64px;
         margin: -4px 0 0 -4px;
         }
         .modal-confirm.modal-dialog {
         margin-top: 80px;
         }
         .modal-confirm .btn, .modal-confirm .btn:active {
         color: #fff;
         border-radius: 4px;
         background: #eeb711 !important;
         text-decoration: none;
         transition: all 0.4s;
         line-height: normal;
         border-radius: 30px;
         margin-top: 10px;
         padding: 6px 20px;
         border: none;
         }
         .modal-confirm .btn:hover, .modal-confirm .btn:focus {
         background: #eda645 !important;
         outline: none;
         }
         .modal-confirm .btn span {
         margin: 1px 3px 0;
         float: left;
         }
         .modal-confirm .btn i {
         margin-left: 1px;
         font-size: 20px;
         float: right;
         }
         .trigger-btn {
         display: inline-block;
         margin: 100px auto;
         }
         .pagination {
         float: right;
         margin: 0 0 5px;
         }
         .pagination li a {
         border: none;
         font-size: 13px;
         min-width: 30px;
         min-height: 30px;
         color: #999;
         margin: 0 2px;
         line-height: 30px;
         border-radius: 2px !important;
         text-align: center;
         padding: 0 6px;
         }
         .pagination li a:hover {
         color: #666;
         }	
         .pagination li.active a {
         background: #03A9F4;
         }
         .pagination li.active a:hover {        
         background: #0397d6;
         }
         .pagination li.disabled i {
         color: #ccc;
         }
         .pagination li i {
         font-size: 16px;
         padding-top: 6px
         }
         .hint-text {
         float: left;
         margin-top: 10px;
         font-size: 13px;
         }    
         body {
         color: #566787;
         background: #f5f5f5;
         font-family: 'Roboto', sans-serif;
         }
         .table-responsive {
         margin: 30px 0;
         }
         .table-wrapper {
         width: 900px;
         background: #fff;
         margin: 0 auto;
         padding: 20px 30px 5px;
         box-shadow: 0 0 1px 0 rgba(0,0,0,.25);
         }
         .table-title .btn-group {
         float: right;
         }
         .table-title .btn {
         min-width: 50px;
         border-radius: 2px;
         border: none;
         padding: 6px 12px;
         font-size: 95%;
         outline: none !important;
         height: 30px;
         }
         .table-title {
         min-width: 100%;
         border-bottom: 1px solid #e9e9e9;
         padding-bottom: 15px;
         margin-bottom: 5px;
         background: purple;
         margin: -20px -31px 10px;
         padding: 15px 30px;
         color: #fff;
         }
         .table-title h2 {
         margin: 2px 0 0;
         font-size: 24px;
         }
         table.table {
         min-width: 100%;
         }
         table.table tr th, table.table tr td {
         border-color: #e9e9e9;
         padding: 12px 15px;
         vertical-align: middle;
         }
         table.table tr th:first-child {
         width: 40px;
         }
         table.table tr th:last-child {
         width: 150px;
         }
         table.table-striped tbody tr:nth-of-type(odd) {
         background-color: #fcfcfc;
         }
         table.table-striped.table-hover tbody tr:hover {
         background: #f5f5f5;
         }
         table.table td a {
         color: #2196f3;
         }
         table.table td .btn.manage {
         padding: 2px 10px;
         background: #37BC9B;
         color: #fff;
         border-radius: 2px;
         }
         table.table td .btn.manage:hover {
         background: #2e9c81;		
         }
      </style>
      <script>
         $(document).ready(function(){
         	$(".btn-group .btn").click(function(){
         		var inputValue = $(this).find("input").val();
         		if(inputValue != 'all'){
         			var target = $('table tr[data-status="' + inputValue + '"]');
         			$("table tbody tr").not(target).hide();
         			target.fadeIn();
         		} else {
         			$("table tbody tr").fadeIn();
         		}
         	});
         	// Changing the class of status label to support Bootstrap 4
             var bs = $.fn.tooltip.Constructor.VERSION;
             var str = bs.split(".");
             if(str[0] == 4){
                 $(".label").each(function(){
                 	var classStr = $(this).attr("class");
                     var newClassStr = classStr.replace(/label/g, "badge");
                     $(this).removeAttr("class").addClass(newClassStr);
                 });
             }
         });
      </script>
   </head>
   <body>
      <div class="container-xl">
         <div class="table-responsive">
            <?php if(!empty(session()->getFlashdata('fail'))):?>
            <div class="alert alert-danger"><?= session()->getFlashdata('fail');?></div>
            <?php endif ?>
            <?php if(!empty(session()->getFlashdata('success'))):?>
            <div class="alert alert-success"><?= session()->getFlashdata('success');?></div>
            <?php endif ?>
            <div class="table-wrapper">
               <div class="table-title">
                  <div class="row">
                     <div class="col-sm-6">
                        <h2>Appointment <b></b></h2>
                     </div>
                     <div class="col-sm-6">
                     </div>
                  </div>
               </div>
               <table class="table table-striped table-hover">
                  <thead>
                     <tr>
                        <th>#</th>
                        <th>Create On</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Services</th>
                        <th>Status</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php 
                        if(!empty($appointmentData))
                        {
                        	$i=1;
                        	foreach($appointmentData as $key => $row)
                        {?>
                     <tr>
                        <td><?php echo $i;?></td>
                        <td><?=$row['createdDatenTime']?></td>
                        <td><?php echo $row['date'];?></td>
                        <td><?=timeDisplay( $row['time'])?></td>
                        <td><?php echo $row['service'];?></td>
                        <?php 
                           if($row['status']=="approved"){
                           ?>
                        <td><span class="label label-success"><?=$row['status']?></span></td>
                        <?php
                           }
                           ?>
                        <?php 
                           if($row['status']=="pending"){
                           ?>
                        <td><span class="label label-warning"><?=$row['status']?></span></td>
                        <?php
                           }
                           ?>
                        <?php 
                           if($row['status']=="rejected"){
                           ?>
                        <td><span class="label label-danger"><?=$row['status']?></span></td>
                        <?php
                           }
                           ?>
                        <?php 
                           if($row['status']=="cancel"){
                           ?>
                        <td><span class="label label-danger"><?=$row['status']?></span></td>
                        <?php
                           }
                           ?>
                        <td hidden><?=isset($row['contact'])?$row['contact']:getUserInfoByEmail($row['user'],'phone')?></td>
                        <td hidden><?=isset($row['name'])?$row['name']:getUserInfoByEmail($row['user'],'name')?></td>
                        <td hidden><?=$row['ic']?></td>
                        <td hidden><?=$row['mode']?></td>
                        <td hidden><?=$row['who']?></td>
                        <td hidden><?=$row['reason']?></td>
                        <td hidden><?=$row['allergies']?></td>
                        <?php 
                           if($row['status']=="rejected"){
                           ?>
                        <td hidden><?=$row['rejectReason']?></td>
                        <?php
                           }
                           ?>
                        <td hidden><?=$row['time']?></td>
                        <td>
                           <a href="#deleteConfirmation" id="deletebtn" data-id=""  class="view" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">remove_red_eye</i></a>
                           <a href="" class="edit" data-id="<?= $row['key'];?>" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Change Appointment time">&#xE254;</i></a>
                           <a href="#cancelModal" id="deletebtn"  data-id="<?= $row['key'];?>" class="cancel" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Cancel Appointment">close</i></a>
                        </td>
                     </tr>
                     <?php
                        $i+=1;}
                        }
                        
                        ?>
                  </tbody>
               </table>
               <div class="clearfix">
                  <div class="hint-text">Total <b>
                     <?php 
                        if(empty($appointmentData))
                        {
                          echo "0";
                        }else{
                          $i=0;
                          foreach($appointmentData as $key)
                          {
                              $i++;
                          }
                          echo $i;
                        
                        }
                        ?>  
                     entries
                  </div>
                  <ul class="pagination justify-content-center">
                     <li class="page-item <?php if($page <= 1){ echo 'disabled'; } ?>">
                        <a class="page-link"
                           href="
                           <?php if($page <= 1){ echo '#'; }
                              else{
                                 echo base_url('patient/viewAppointment?page=').$prev;
                                 
                              }?>
                           ">Previous</a>
                     </li>
                     <?php for($i = 1; $i <= $totoalPages; $i++ ): ?>
                     <li class="page-item <?php if($page == $i) {echo 'active'; } ?>">
                        <a class="page-link" href="<?=route_to('patient.viewAppointment');?>?page=<?= $i; ?>"> <?= $i; ?> </a>
                     </li>
                     <?php endfor; ?>
                     <li class="page-item <?php if($page >= $totoalPages) { echo 'disabled'; } ?>">
                        <a class="page-link"
                           href="
                           <?php
                              if($page >= $totoalPages)
                              { echo '#'; } 
                              else {       
                               echo base_url('patient/viewAppointment?page='). $next; } ?>">Next</a>
                     </li>
                  </ul>
               </div>
            </div>
         </div>
      </div>
      <!-- Delete Modal HTML -->
      <div id="cancelModal" class="modal fade">
         <div class="modal-dialog">
            <div class="modal-content">
               <form action="<?=route_to('patient.cancelAppointment');?>" method="post">
                  <div class="modal-header">
                     <h4 class="modal-title">Cancel Appointment</h4>
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  </div>
                  <div class="modal-body">
                     <p>Are you sure you want to cancel this appointment?</p>
                     <p class="text-warning"><small>This action cannot be undone.</small></p>
                  </div>
                  <div class="modal-footer">
                     <input type="hidden" name="cancel_id" id="cancel_id" value="">		
                     <input type="hidden" name="status_id" id="status_id" value="">	
                     <input type="hidden" name="date_id" id="date_id" value="">				
                     <input type="hidden" name="time_id" id="time_id" value="">				
                     <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                     <input type="submit" name="deletedata" class="btn btn-danger" value="Submit">
                  </div>
               </form>
            </div>
         </div>
      </div>
      <!-- Modal HTML -->
      <div id="myModal" class="modal fade">
         <div class="modal-dialog modal-confirm">
            <div class="modal-content">
               <div class="modal-header justify-content-center">
                  <div class="icon-box">
                     <i class="material-icons">&#xE876;</i>
                  </div>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
               </div>
               <div class="modal-body text-center">
                  <h4>Cancel Successfully.</h4>
                  <p>Your appointment has been cancel successfully.</p>
                  <button class="btn btn-success" data-dismiss="modal"><span>Done</span> <i class="material-icons">&#xE5C8;</i></button>
               </div>
            </div>
         </div>
      </div>
      <!-- Modal HTML -->
      <div id="editmyModal" class="modal fade">
         <div class="modal-dialog modal-confirm">
            <div class="modal-content">
               <div class="modal-header justify-content-center">
                  <div class="icon-box">
                     <i class="material-icons">&#xE876;</i>
                  </div>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
               </div>
               <div class="modal-body text-center">
                  <h4>Update Successfully.</h4>
                  <p>Your appointment has been updated successfully.</p>
                  <button class="btn btn-success" data-dismiss="modal"><span>Done</span> <i class="material-icons">&#xE5C8;</i></button>
               </div>
            </div>
         </div>
      </div>
      <!-- ViewModal 1 -->
      <div class="modal fade" id="deleteConfirmation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <h4 class="modal-title" id="myModalLabel">Appointment Details</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               </div>
               <div class="modal-body">
                  <p class="name"><strong>Name: </strong>xxxxx</p>
                  <p class="ic"><strong>IC: </strong>xxxxx</p>
                  <div>
                     <p class="aller" id="abc">Allergies: <span ></span></p>
                  </div>
                  <p class="Contact"><strong>Contact: </strong>Yes</p>
                  <p class="date"><strong> Appointment Date: </strong>Yes</p>
                  <p class="time"><strong> Appointment Time: </strong>Yes</p>
                  <p class="mode"><strong> Mode: </strong>Yes</p>
                  <p class="service"><strong> Services: </strong>Yes</p>
                  <p class="status2" id="status2"><strong> Status: </strong><span style="color:white; background:orange;">Pending</span></p>
                  <p class="type"><strong> Register Type: </strong>Yes</p>
                  <p class="reason"><strong>Reason: </strong>Yes</p>
                  <p class="requestdate"><strong> Request Date: </strong>Yes</p>
                  <p class="rejectReason"><strong></strong></p>
               </div>
            </div>
         </div>
      </div>
      <!-- ViewModal 1 -->
      <div class="modal fade" id="editForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <h4 class="modal-title" id="myModalLabel">Change Appointment Date and Time</h4>
                  <button type="button" class="close" data-dismiss="modal" onclick='j()' aria-label="Close"><span aria-hidden="true">&times;</span></button>
               </div>
               <form action="<?=route_to('patient.editAppointment');?>" method="post">
                  <div class="form-group">
                     <div class="col-md-7">
                        <span class="form-label">Date</span>
                        <?php 
                           date_default_timezone_set('Asia/Kuala_Lumpur');
                           $DATE = date('Y-m-d');
                           ?>
                        <input class="form-control" id="date" value="<?php echo set_value('appdate') ?>" name="appdate" type="date" min="<?=$DATE?>"  max="2030-12-31" required>
                        <?php if(!empty(session()->getFlashdata('appdateError'))):?>
                        <div class="text-warning h5"><?= session()->getFlashdata('appdateError');?></div>
                        <?php endif ?>
                     </div>
                     <div class="col-md-7">
                        <div class="form-group">
                           <span class="form-label">Time</span>
                           <input class="form-control" id="time" value="<?php echo set_value('apptime') ?>"type="time" name="apptime" min="09:00" max="23:00" required> 
                           <?php if(!empty(session()->getFlashdata('apptimeError'))):?>
                           <div class="text-warning h5"><?= session()->getFlashdata('apptimeError');?></div>
                           <?php endif ?>
                        </div>
                     </div>
                  </div>
                  <small>*If you want to edit the whole appointment, please cancel this appointment and make an appointment again in order for us to re-arrange for you.</small>
                  <div class="modal-footer">
                     <input type="hidden" name="edit_id" id="edit_id" value="">	
                     <input type="hidden" name="edit_status" id="edit_status" value="">			
                     <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                     <input type="submit" class="btn btn-success" value="Update">
                  </div>
               </form>
            </div>
         </div>
      </div>
   </body>
</html>
<script>
   function showEditForm(){
    $(document).ready(function(){
       $("#editForm").modal('show');
    });
   } 
     function j(){
   location.reload();
   }
   
   $('.cancel').on('click', function () {
    var id=$(this).data('id');
   document.getElementById("cancel_id").value = id;
   
   $tr = $(this).closest('tr');
   var data = $tr.children("td").map(function () {
   return $(this).text();
   }).get();
   $('#status_id').val(data[5]);
   $('#date_id').val(data[2]);
   $('#time_id').val(data[3]);
   
   
   }); 
   $('.edit').on('click', function () {
   
   var id=$(this).data('id');
   document.getElementById("edit_id").value = id;
   
   $tr = $(this).closest('tr');
   var data = $tr.children("td").map(function () {
   return $(this).text();
   }).get();
   
   if(data[5]=="cancel")
   {
    alert("Sorry, cancel appointment cannot modify please make a new appointment in order for us to re-arrange the best time for you thanks.");
   
   }
   else if(data[5]=="rejected")
   {
    alert("Sorry, rejected appointment cannot modify please make a new appointment in order for us to re-arrange the best time for you thanks.");
   
   } else if(data[5]=="approved")
   {
    alert("Sorry, approved appointment cannot modify please cancel this appointment and make a new appointment in order for us to re-arrange the best time for you thanks.");
   }
   else{
   $("#editForm").modal('show');
   
   document.getElementById("date").value = data[2];
   document.getElementById("time").value = String(data[14]);
   if(data[5]=="pending")
   {
   document.getElementById("time").value = String(data[13]);
   
   }
   if(data[5]=="cancel")
   {
   document.getElementById("time").value = String(data[13]);
   
   }
   document.getElementById("edit_status").value = data[5];
   }
   
   
   
   }); 
   function showmodal(){
   $(document).ready(function(){
       $("#myModal").modal('show');
    });
   }
   function showmodal2(){
   $(document).ready(function(){
       $("#editmyModal").modal('show');
    });
   }
   $('.view').on('click', function () {
   
   $tr = $(this).closest('tr');
   var data = $tr.children("td").map(function () {
   return $(this).text();
   }).get();
   $(".name").text("Name: "+data[7]);
   $(".ic").text("IC: "+data[8]);
   $(".Contact").text("Contact: "+data[6]);
   $(".date").text("Date: "+data[2]);
   $(".time").text("Time: "+data[3]);
   $(".mode").text("Mode: "+data[9]);
   $(".service").text("Service: "+data[4]);
   $(".type").text("Register Type: "+data[10]);
   $(".requestdate").text("Reason : "+data[11]);
   $(".reason").text("Request Date: "+data[1]);
   
   if(data[12]=="Yes")
   {
    $('.aller span').text(data[12]);
    $('.aller span').css({'backgroundColor':'red'});
    $('.aller span').css({'color':'white'});
   
   }else{
    $('.aller span').text(data[12]);
    $('.aller span').css({'backgroundColor':'green'});
    $('.aller span').css({'color':'white'});
   }
   if(data[5]=="rejected"){
   $(".rejectReason").text("Rejected Reason: "+data[13]);
   $('.status2 span').text(data[5]);
    $('.status2 span').css({'backgroundColor':'red'});
    $('.status2 span').css({'color':'white'});
   }
   if(data[5]=="approved"){
   $('.status2 span').text(data[5]);
    $('.status2 span').css({'backgroundColor':'green'});
    $('.status2 span').css({'color':'white'});
   }
   if(data[5]=="cancel"){
   $('.status2 span').text(data[5]);
    $('.status2 span').css({'backgroundColor':'red'});
    $('.status2 span').css({'color':'white'});
   }
   });
   
</script>   
<?php
   if(!empty(session()->getFlashdata('successCancel')))
   {
     echo '<script>',
     'showmodal();',
     '</script>';
   }
   if(!empty(session()->getFlashdata('editError')))
   {
     echo '<script>',
     'showEditForm();',
     '</script>';
   }
   if(!empty(session()->getFlashdata('successEdit')))
   {
     echo '<script>',
     'showmodal2();',
     '</script>';
   }
   ?>
<?=$this->endSection();?>