<?= $this->extend('layout/staffdashboard-layout');?>
<?= $this->section('content');?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title></title>
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
      <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
      <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
      <style>
         body {
         color: #566787;
         background: #f5f5f5;
         font-family: 'Varela Round', sans-serif;
         font-size: 13px;
         }
         .table-responsive {
         margin: 30px 0;
         }
         .table-wrapper {
         min-width: 1000px;
         background: #fff;
         padding: 20px 25px;
         border-radius: 3px;
         box-shadow: 0 1px 1px rgba(0,0,0,.05);
         }
         .table-wrapper .btn {
         float: right;
         color: #333;
         background-color: #fff;
         border-radius: 3px;
         border: none;
         outline: none !important;
         margin-left: 10px;
         }
         .table-wrapper .btn:hover {
         color: #333;
         background: #f2f2f2;
         }
         .table-wrapper .btn.btn-primary {
         color: #fff;
         background: #03A9F4;
         }
         .table-wrapper .btn.btn-primary:hover {
         background: #03a3e7;
         }
         .table-title .btn {		
         font-size: 13px;
         border: none;
         }
         .table-title .btn i {
         float: left;
         font-size: 21px;
         margin-right: 5px;
         }
         .table-title .btn span {
         float: left;
         margin-top: 2px;
         }
         .table-title {
         color: #fff;
         background: #4b5366;		
         padding: 16px 25px;
         margin: -20px -25px 10px;
         border-radius: 3px 3px 0 0;
         }
         .table-title h2 {
         margin: 5px 0 0;
         font-size: 24px;
         }
         .show-entries select.form-control {        
         width: 60px;
         margin: 0 5px;
         }
         .table-filter .filter-group {
         float: right;
         margin-left: 10px;
         }
         .table-filter input, .table-filter select {
         height: 34px;
         border-radius: 3px;
         border-color: #ddd;
         box-shadow: none;
         }
         .table-filter {
         padding: 5px 0 15px;
         border-bottom: 1px solid #e9e9e9;
         margin-bottom: 5px;
         }
         .table-filter .btn {
         height: 34px;
         }
         .table-filter label {
         font-weight: normal;
         margin-left: 10px;
         }
         .table-filter select, .table-filter input {
         display: inline-block;
         margin-left: 5px;
         }
         .table-filter input {
         width: 200px;
         display: inline-block;
         }
         .filter-group select.form-control {
         width: 100px;
         }
         .filter-icon {
         float: right;
         margin-top: 7px;
         }
         .filter-icon i {
         font-size: 18px;
         opacity: 0.7;
         }	
         table.table tr th, table.table tr td {
         border-color: #e9e9e9;
         padding: 12px 15px;
         vertical-align: middle;
         }
         table.table tr th:first-child {
         width: 60px;
         }
         table.table tr th:last-child {
         width: 80px;
         }
         table.table-striped tbody tr:nth-of-type(odd) {
         background-color: #fcfcfc;
         }
         table.table-striped.table-hover tbody tr:hover {
         background: #f5f5f5;
         }
         table.table th i {
         font-size: 13px;
         margin: 0 5px;
         cursor: pointer;
         }	
         table.table td a {
         font-weight: bold;
         color: #566787;
         display: inline-block;
         text-decoration: none;
         }
         table.table td a:hover {
         color: #2196F3;
         }
         table.table td a.view {        
         width: 30px;
         height: 30px;
         color: #2196F3;
         border: 2px solid;
         border-radius: 30px;
         text-align: center;
         }
         table.table td a.view i {
         font-size: 22px;
         margin: 2px 0 0 1px;
         }   
         table.table .avatar {
         border-radius: 50%;
         vertical-align: middle;
         margin-right: 10px;
         }
         .status {
         font-size: 30px;
         margin: 2px 2px 0 0;
         display: inline-block;
         vertical-align: middle;
         line-height: 10px;
         }
         .text-success {
         color: #10c469;
         }
         .text-info {
         color: #62c9e8;
         }
         .text-warning {
         color: #FFC107;
         }
         .text-danger {
         color: #ff5b5b;
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
      </style>
      <script>
         $(document).ready(function(){
         	$('[data-toggle="tooltip"]').tooltip();
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
                     <div class="col-sm-4">
                        <h2>Approved <b>Appointment</b></h2>
                     </div>
                     <div class="col-sm-8   ">						
                        <a href="<?=route_to('staff.approvedAppointment');?>" class="btn btn-primary"><i class="material-icons">&#xE863;</i> <span>Refresh List</span></a>
                     </div>
                  </div>
               </div>
               <div class="table-filter">
                  <div class="row">
                     <div class="col-sm-2">
                        <div class="show-entries">
                           <form action="<?=route_to('staff.approvedAppointment');?>" method="post">
                              <select name="records-limit" id="records-limit" class="custom-select" onchange='this.form.submit()'>
                                 <option disabled selected>Show Entries</option>
                                 <?php foreach([5,10,20,50] as $limit) : ?>
                                 <option
                                    <?php if(!empty(session()->get('records-limit')) && session()->get('records-limit') == $limit) echo 'selected'; ?>
                                    value="<?= $limit; ?>">
                                    <?= $limit; ?>
                                 </option>
                                 <?php endforeach; ?>
                              </select>
                           </form>
                        </div>
                     </div>
                     <div class="col-sm-9">
                        <form action="<?=route_to('staff.approvedAppointment');?>" method="post">
                           <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                           <div class="filter-group">
                              <input type="text" class="form-control" name="searchIc" placeholder="Identity Number">
                        </form>
                        </div>
                        <form action="<?=route_to('staff.approvedAppointment');?>" method="post">
                           <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                           <div class="filter-group">
                              <input type="text" class="form-control" name="searchDate" placeholder="2022-12-12">
                           </div>
                        </form>
                        <form action="<?=route_to('staff.approvedAppointment');?>" method="post">
                           <div class="filter-group">
                              <label>Type</label>
                              <select class="form-control"name="typeFilter" onchange='this.form.submit()'>
                                 <option disabled selected>-----</option>
                                 <option value="Any"
                                    <?php 
                                       if(!empty(session()->get('typeFilter')))
                                       {
                                           if(session()->get('typeFilter')=="Any")
                                           {
                                               echo "Selected";
                                           }
                                       }
                                       ?>
                                    >Any</option>
                                 <option value="Walk In"
                                    <?php 
                                       if(!empty(session()->get('typeFilter')))
                                       {
                                           if(session()->get('typeFilter')=="Walk In")
                                           {
                                               echo "Selected";
                                           }
                                       }
                                       ?>
                                    >Walk In</option>
                                 <option value="E-Consult"
                                    <?php 
                                       if(!empty(session()->get('typeFilter')))
                                       {
                                           if(session()->get('typeFilter')=="E-Consult")
                                           {
                                               echo "Selected";
                                           }
                                       }
                                       ?>
                                    >E-Consult</option>
                              </select>
                           </div>
                           <span class="filter-icon"><i class="fa fa-filter"></i></span>
                        </form>
                     </div>
                  </div>
               </div>
               <table class="table table-striped table-hover">
                  <thead>
                     <tr>
                        <th>No</th>
                        <th>Patient</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Mode</th>
                        <th>Services</th>
                        <th>Status</th>
                        <th>Action</th>
                        <th>Add Queue</th>

                     </tr>
                  </thead>
                  <tbody>
                     <?php 
                        if(!empty($appointmentData))
                        {
                        	$i=1;
                        	foreach($appointmentData as $key => $row)
                        	//echo $key;
                        	//print_r($row['email']);
                        	//
                        {?>
                     <tr>
                        <td hidden><?=$row['createdDatenTime']?></td>
                        <td hidden><?=$row['who']?></td>
                        <td hidden><?=$row['reason']?></td>
                        <td hidden><?=$row['ic']?></td>
                        <td hidden><?=$row['allergies']?></td>
                        <td hidden><?=isset($row['contact'])?$row['contact']:getUserInfoByEmail($row['user'],'phone')?></td>
                        <td><?php echo $i;?></td>
                        
                        <td>
                            <a href="staff/panel?patient=<?=getPatientKeyByIc($row['ic'])?>"><u><?=isset($row['name'])?$row['name']:getUserInfoByEmail($row['user'],'name')?></u></a>
                          
                        </td>
                        <td><?php echo $row['date'];?></td>
                        <td><?=timeDisplay( $row['time'])?></td>
                        <td><?php echo $row['mode'];?></td>
                        <td><?php echo $row['service'];?></td>
                        <td><span class="status text-success">&bull;</span><?php echo $row['status'];?></td>
                        <td hidden><?=$row['user']?></td>

                        <td>
                           <a href="#deleteConfirmation" id="viewbtn" data-id="<?= $row['key'];?>"  class="view" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="View Details">&#xE417;</i></a>
                           <a href="#updateConfirmation" id="updatebtn" data-id="<?= $row['key'];?>"  class="update" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Update Status">&#xE254;</i></a>
                          
                        </td>
                        <?php if($row['mode']=="Walk In"){?>

                        <td>
                        <form action="<?=route_to('patient.addQueue');?>" method="post">
                          <input type="hidden" name="id" value="<?=$row['key']?>"/>
                          <button type="submit" class="btn btn-success">
                          <i class="material-icons" data-toggle="tooltip" title="Add Queue">&plus;</i>
                        </button>
                        </form>
                        </td>
                        <?php }?>
                     </tr>
                     <?php
                        $i+=1;}
                        }
                        
                        ?>
                     <!--
                        <tr>
                            <td>1</td>
                            <td>name</td>
                            <td>2020-11-22</td>
                            <td>12pm</td>          
                            <td>E-consultation</td>
                            <td>Online consultation</td>
                            <td><span class="status text-warning">&bull;</span> pending</td>
                            <td>
                                <a href="#" class="view" title="View" data-toggle="tooltip"><i class="material-icons">&#xE417;</i></a>
                                <a href="#" class="edit" title="Edit" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
                            </td>
                        </tr>
                        -->
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
                                 echo base_url('staff/approvedAppointment?page=').$prev;
                                 
                              }?>
                           ">Previous</a>
                     </li>
                     <?php for($i = 1; $i <= $totoalPages; $i++ ): ?>
                     <li class="page-item <?php if($page == $i) {echo 'active'; } ?>">
                        <a class="page-link" href="<?=base_url('staff/approvedAppointment');?>?page=<?= $i; ?>"> <?= $i; ?> </a>
                     </li>
                     <?php endfor; ?>
                     <li class="page-item <?php if($page >= $totoalPages) { echo 'disabled'; } ?>">
                        <a class="page-link"
                           href="
                           <?php
                              if($page >= $totoalPages)
                              { echo '#'; } 
                              else {       
                               echo base_url('staff/approvedAppointment?page='). $next; } ?>">Next</a>
                     </li>
                  </ul>
               </div>
            </div>
         </div>
      </div>
      <!-- View Modal HTML -->
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
                  <p class="status2"><strong> Status: </strong><span style="color:white; background:green;">Approved</span></p>
                  <p class="type"><strong> Register Type: </strong>Yes</p>
                  <p class="reason"><strong>Reason: </strong>Yes</p>
                  <p class="requestdate"><strong> Request Date: </strong>Yes</p>
               </div>
            </div>
         </div>
      </div>
      <!-- UpdateModal 1 -->
      <div class="modal fade" id="updateConfirmation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <h4 class="modal-title" id="myModalLabel">Update Status</h4>
                  <button type="button" class="close"  data-dismiss="modal" aria-hidden="true">&times;</button>
               </div>
               <div class="modal-body">
                  <form action="<?=route_to('staff.updateStatus');?>" method="post">
                     <input type="hidden" name="update_id" id="update_id" value="">			
                     <input type="hidden" name="mode_type" id="mode_type" value="">			
                     <input type="hidden" name="appemail" id="appemail" value="">			
                     <input type="hidden" name="appname" id="appname" value="">			

                     <div class="form-group">
                        <label>Status</label>
                        <select class="form-control"  name="statuschange"  onchange = "ShowHideDiv2()" id = "statuschange" required>
                           <option value="" selected hidden>----------</option>
                           <option value="Approved"
                              >Approved</option>
                           <option value="Reject" >Reject</option>
                           <option value="Cancel" >Cancel</option>

                        </select>
                     </div>
                     <div class="form-group" id="rejectedreason"  style="display: none">
                        <label>Rejected reason:</label>
                        <input type="text" name="rejectedreason"pattern="[a-zA-Z0-9 ,./-]+" title="Only accept number,alpha,dot,comma and -/" minlength="8" minlength="100" class="form-control" >
                     
                     </div>
                     <div class="modal-footer">
                     <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                     <input type="submit" class="btn btn-success" value="Update">
                  </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </body>
</html>
<script>
   function j(){
location.reload();
}
    function ShowHideDiv2() {
         var statuschange = document.getElementById("statuschange");
         
         var rejectedreason = document.getElementById("rejectedreason");//name
        
   
         rejectedreason.style.display = statuschange.value == "Reject" ? "block" : "none";
   
     }
   $('.update').click(function(){
   var id=$(this).data('id');
   document.getElementById("update_id").value = id;
   })
   $('.view').on('click', function () {
   
   $tr = $(this).closest('tr');
   var data = $tr.children("td").map(function () {
   return $(this).text();
   }).get();
   $name=data[7];
   $(".name").text("Name: "+data[7]);
   $(".ic").text("IC: "+data[3]);
   $(".Contact").text("Contact: "+data[5]);
   $(".date").text("Date: "+data[8]);
   $(".time").text("Time: "+data[9]);
   $(".mode").text("Mode: "+data[10]);
   $(".service").text("Service: "+data[11]);
   $(".type").text("Register Type: "+data[1]);
   $(".requestdate").text("Reason : "+data[2]);
   $(".reason").text("Request Date: "+data[0]);
   
   if(data[4]=="Yes")
   {
      $('.aller span').text(data[4]);
      $('.aller span').css({'backgroundColor':'red'});
      $('.aller span').css({'color':'white'});
   
   }else{
      $('.aller span').text(data[4]);
      $('.aller span').css({'backgroundColor':'green'});
      $('.aller span').css({'color':'white'});
   }
   
   });
   $('.update').on('click', function () {
      var id=$(this).data('id');
   document.getElementById("update_id").value = id;
   
   $tr = $(this).closest('tr');
   var data = $tr.children("td").map(function () {
   return $(this).text();
   }).get();
   $('#mode_type').val(data[10]);
   $('#appemail').val(data[13]);
   $('#appname').val(data[7]);

     }); 
</script>
<?=$this->endSection();?>