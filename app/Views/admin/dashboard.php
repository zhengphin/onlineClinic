<?= $this->extend('layout/admindashboard-layout');?>
<?= $this->section('content');?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Bootstrap CRUD Data Table for Database with Modal Form</title>
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
         background: #fff;
         padding: 20px 25px;
         border-radius: 3px;
         min-width: 1000px;
         box-shadow: 0 1px 1px rgba(0,0,0,.05);
         }
         .table-title {        
         padding-bottom: 15px;
         background: #435d7d;
         color: #fff;
         padding: 16px 30px;
         min-width: 100%;
         margin: -20px -25px 10px;
         border-radius: 3px 3px 0 0;
         }
         .table-title h2 {
         margin: 5px 0 0;
         font-size: 24px;
         }
         .table-title .btn-group {
         float: right;
         }
         .table-title .btn {
         color: #fff;
         float: right;
         font-size: 13px;
         border: none;
         min-width: 50px;
         border-radius: 2px;
         border: none;
         outline: none !important;
         margin-left: 10px;
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
         table.table tr th, table.table tr td {
         border-color: #e9e9e9;
         padding: 12px 15px;
         vertical-align: middle;
         }
         table.table tr th:first-child {
         width: 60px;
         }
         table.table tr th:last-child {
         width: 100px;
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
         table.table td:last-child i {
         opacity: 0.9;
         font-size: 22px;
         margin: 0 5px;
         }
         table.table td a {
         font-weight: bold;
         color: #566787;
         display: inline-block;
         text-decoration: none;
         outline: none !important;
         }
         table.table td a:hover {
         color: #2196F3;
         }
         table.table td a.edit {
         color: #FFC107;
         }
         table.table td a.delete {
         color: #F44336;
         }
         table.table td i {
         font-size: 19px;
         }
         table.table .avatar {
         border-radius: 50%;
         vertical-align: middle;
         margin-right: 10px;
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
         .pagination li.active a, .pagination li.active a.page-link {
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
         /* Custom checkbox */
         .custom-checkbox {
         position: relative;
         }
         .custom-checkbox input[type="checkbox"] {    
         opacity: 0;
         position: absolute;
         margin: 5px 0 0 3px;
         z-index: 9;
         }
         .custom-checkbox label:before{
         width: 18px;
         height: 18px;
         }
         .custom-checkbox label:before {
         content: '';
         margin-right: 10px;
         display: inline-block;
         vertical-align: text-top;
         background: white;
         border: 1px solid #bbb;
         border-radius: 2px;
         box-sizing: border-box;
         z-index: 2;
         }
         .custom-checkbox input[type="checkbox"]:checked + label:after {
         content: '';
         position: absolute;
         left: 6px;
         top: 3px;
         width: 6px;
         height: 11px;
         border: solid #000;
         border-width: 0 3px 3px 0;
         transform: inherit;
         z-index: 3;
         transform: rotateZ(45deg);
         }
         .custom-checkbox input[type="checkbox"]:checked + label:before {
         border-color: #03A9F4;
         background: #03A9F4;
         }
         .custom-checkbox input[type="checkbox"]:checked + label:after {
         border-color: #fff;
         }
         .custom-checkbox input[type="checkbox"]:disabled + label:before {
         color: #b8b8b8;
         cursor: auto;
         box-shadow: none;
         background: #ddd;
         }
         /* Modal styles */
         .modal .modal-dialog {
         max-width: 400px;
         }
         .modal .modal-header, .modal .modal-body, .modal .modal-footer {
         padding: 20px 30px;
         }
         .modal .modal-content {
         border-radius: 3px;
         font-size: 14px;
         }
         .modal .modal-footer {
         background: #ecf0f1;
         border-radius: 0 0 3px 3px;
         }
         .modal .modal-title {
         display: inline-block;
         }
         .modal .form-control {
         border-radius: 2px;
         box-shadow: none;
         border-color: #dddddd;
         }
         .modal textarea.form-control {
         resize: vertical;
         }
         .modal .btn {
         border-radius: 2px;
         min-width: 100px;
         }	
         .modal form label {
         font-weight: normal;
         }	
      </style>
      <script>
         $(document).ready(function(){
         	// Activate tooltip
         	$('[data-toggle="tooltip"]').tooltip();
         	
         	// Select/Deselect checkboxes
         	var checkbox = $('table tbody input[type="checkbox"]');
         	$("#selectAll").click(function(){
         		if(this.checked){
         			checkbox.each(function(){
         				this.checked = true;                        
         			});
         		} else{
         			checkbox.each(function(){
         				this.checked = false;                        
         			});
         		} 
         	});
         	checkbox.click(function(){
         		if(!this.checked){
         			$("#selectAll").prop("checked", false);
         		}
         	});
         });
      </script>
      <script src="js/jquery-3.5.1.min.js"></script>
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
                        <h2>Manage <b>Employees</b></h2>
                     </div>
                     <div class="col-sm-6">
                        <a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Add New Employee</span></a>
                        <!--	<a href="#deleteEmployeeModal" class="btn btn-danger" data-toggle="modal"><i class="material-icons">&#xE15C;</i> <span>Delete</span></a>-->				
                     </div>
                  </div>
               </div>
               <table class="table table-striped table-hover">
                  <thead>
                     <tr>
                        <th>No</th>
                        <th>Email</th>
                        <th>Name</th>
                        <th>Identity Number</th>
                        <th>Phone</th>
                        <th>Position</th>
                        <th>Join Date</th>
                        <th>Actions</th>
                     </tr>
                  </thead>
                  <tbody>
                     <!--Table data-->
                     <?php 
                        if(!empty($employData))
                        {
                        	$i=1;
                        	foreach($employData as $key => $row)
                        	//echo $key;
                        	//print_r($row['email']);
                        	//
                        {?>
                     <tr>
                        <td><?php echo $i;?></td>
                        <td><?php echo $row['email'];?></td>
                        <td><?php echo $row['name'];?></td>
                        <td><?php echo $row['ic'];?></td>
                        <td><?php echo $row['phone'];?></td>
                        <td><?php echo $row['position'];?></td>
                        <td hidden>
                           <?php 
                              if($row['position']=="Doctor")
                              {
                              	echo $row['specialist'];
                              }
                              ?>
                        </td>
                        <td><?php echo $row['createdDatenTime'];?></td>
                        <td>
                           <a href="#editEmployeeModal" class="edit" data-id="<?=  $row['key'];?>" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
                           <a href="#deleteEmployeeModal" id="deletebtn" data-id="<?= $row['key'];?>"  class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
                        </td>
                     </tr>
                     <?php
                        $i+=1;}
                        }
                        
                        ?>
                     <!--
                        <tr>
                        	<td>
                        		<span class="custom-checkbox">
                        			<input type="checkbox" id="checkbox1" name="options[]" value="1">
                        			<label for="checkbox1"></label>
                        		</span>
                        	</td>
                        	<td>Thomas Hardy</td>
                        	<td>thomashardy@mail.com</td>
                        	<td>89 Chiaroscuro Rd, Portland, USA</td>
                        	<td>(171) 555-2222</td>
                        	<td>Doctor</td>
                        	<td>2020-12-11</td>
                        	<td>
                        		<a href="#editEmployeeModal" class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
deleteEmployeeModal                        		<a href="#" class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
                        	</td>
                        </tr>-->
                     <!--End of Table data-->
                  </tbody>
               </table>
               <div class="clearfix">
                  <div class="hint-text">Total <b><?=  $allRecords?> entries</div>
                  <ul class="pagination justify-content-center">
                  <li class="page-item <?php if($page <= 1){ echo 'disabled'; } ?>">
            <a class="page-link"
                href="
                <?php if($page <= 1){ echo '#'; }
               else{
                  echo base_url('admin/manage?page=').$prev;
                  
               }?>
               ">Previous</a>
              
        </li>
        <?php for($i = 1; $i <= $totoalPages; $i++ ): ?>
        <li class="page-item <?php if($page == $i) {echo 'active'; } ?>">
            <a class="page-link" href="<?=base_url('admin/manage');?>?page=<?= $i; ?>"> <?= $i; ?> </a>
        </li>
        <?php endfor; ?>
        <li class="page-item <?php if($page >= $totoalPages) { echo 'disabled'; } ?>">
            <a class="page-link"
                href="
                <?php
                 if($page >= $totoalPages)
                 { echo '#'; } 
                 else {       
                  echo base_url('admin/manage?page='). $next; } ?>">Next</a>
        </li>
    </ul>
               </div>
            </div>
         </div>
      </div>
      <!-- Edit Modal HTML -->
      <div id="addEmployeeModal" class="modal fade">
         <div class="modal-dialog">
            <div class="modal-content">
               <form action="<?=base_url('admin/addEmployee');?>" method="post">
                  <div class="modal-header">
                     <h4 class="modal-title">Add Employee</h4>
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  </div>
                  <div class="modal-body">
                     <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" 
                           value="<?php if(!empty(session()->getFlashdata('fieldValue')))
                              {
                              $m=session()->getFlashdata('fieldValue');
                              echo $m['name'];
                              }else{
                              	echo"";	
                              }
                              ?>"
                           required>
                        <?php if(!empty(session()->getFlashdata('nameError'))):?>
                        <div class="alert alert-danger"><?= session()->getFlashdata('nameError');?></div>
                        <?php endif ?>
                     </div>
                     <div class="form-group">
                        <label>IC</label>
                        <input type="text" name="ic" class="form-control" 
                           value="<?php if(!empty(session()->getFlashdata('fieldValue')))
                              {
                              $m=session()->getFlashdata('fieldValue');
                              echo $m['ic'];
                              }else{
                              	echo"";	
                              }
                              ?>"
                           required>
                        <?php if(!empty(session()->getFlashdata('icError'))):?>
                        <div class="alert alert-danger"><?= session()->getFlashdata('icError');?></div>
                        <?php endif ?>
                     </div>
                     <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" 
                           value="<?php if(!empty(session()->getFlashdata('fieldValue')))
                              {
                              $m=session()->getFlashdata('fieldValue');
                              echo $m['email'];
                              }else{
                              	echo"";	
                              }
                              ?>"
                           required>
                        <?php if(!empty(session()->getFlashdata('emailError'))):?>
                        <div class="alert alert-danger"><?= session()->getFlashdata('emailError');?></div>
                        <?php endif ?>
                     </div>
                     <div class="form-group">
                        <label>Contact</label>
                        <input type="text" name="contact"  class="form-control" 
                           value="<?php if(!empty(session()->getFlashdata('fieldValue')))
                              {
                              $m=session()->getFlashdata('fieldValue');
                              echo $m['contact'];
                              }else{
                              	echo"";	
                              }
                              ?>"
                           required>
                        <?php if(!empty(session()->getFlashdata('contactError'))):?>
                        <div class="alert alert-danger"><?= session()->getFlashdata('contactError');?></div>
                        <?php endif ?>
                     </div>
                     <div class="form-group">
                        <label>Position</label>
                        <select class="form-control"  name="position"  onchange = "ShowHideDiv2()" id = "position" required>
                           <option value="" selected hidden>----------</option>
                           <option value="Doctor"
                              <?php if(!empty(session()->getFlashdata('fieldValue')))
                                 {
                                 $m=session()->getFlashdata('fieldValue');
                                 echo "selected";
                                 }else{
                                 	echo"";	
                                 }
                                 ?>
                              >Doctor</option>
                           <option value="Receiptionist" >Receiptionist</option>
                           <option value="Pharmacist">Pharmacist</option>
                        </select>
                        <?php if(!empty(session()->getFlashdata('positionError'))):?>
                        <div class="alert alert-danger"><?= session()->getFlashdata('positionError');?></div>
                        <?php endif ?>
                     </div>
                     <div class="form-group" id="specialist"  style="display: none">
                        <label>Specialist:</label>
                        <input type="text" name="specialist"  class="form-control" 
                           value="<?php if(!empty(session()->getFlashdata('fieldValue')))
                              {
                              if(isset($m['specialist'])){
                              	$m=session()->getFlashdata('fieldValue');
                              	echo $m['specialist'];
                              }
                              
                              }else{
                              	echo"";	
                              }
                              ?>"
                           >
                        <?php if(!empty(session()->getFlashdata('specialistError'))):?>
                        <div class="alert alert-danger"><?= session()->getFlashdata('specialistError');?></div>
                        <?php endif ?>
                     </div>
                  </div>
                  <div class="modal-footer">
                     <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                     <input type="submit" class="btn btn-success" value="Add">
                  </div>
               </form>
            </div>
         </div>
      </div>
      <!-- Edit Modal HTML -->
      <div id="editEmployeeModal" class="modal fade">
         <div class="modal-dialog">
            <div class="modal-content">
			<form action="<?=base_url('admin/editEmployee');?>" method="post">
                  <div class="modal-header">
                     <h4 class="modal-title">Edit Employee Details</h4>
                     <button type="button" class="close" onclick="j()" data-dismiss="modal" aria-hidden="true">&times;</button>
                  </div>
                  <div class="modal-body">
                     <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="editname" id="editname" class="form-control"  
                           value="<?php if(!empty(session()->getFlashdata('fieldValue2')))
                              {
                              $m=session()->getFlashdata('fieldValue2');
                              echo $m['name'];
                              }else{
                              	echo"";	
                              }
                              ?>"
                           required>
                        <?php if(!empty(session()->getFlashdata('nameError2'))):?>
                        <div class="alert alert-danger"><?= session()->getFlashdata('nameError2');?></div>
                        <?php endif ?>
                     </div>
                     <div class="form-group">
                        <label>IC</label>
                        <input type="text" name="ic" id="editic"class="form-control" 
                           value="<?php if(!empty(session()->getFlashdata('fieldValue2')))
                              {
                              $m=session()->getFlashdata('fieldValue2');
                              echo $m['ic'];
                              }else{
                              	echo"";	
                              }
                              ?>"
                           required>
                        <?php if(!empty(session()->getFlashdata('icError2'))):?>
                        <div class="alert alert-danger"><?= session()->getFlashdata('icError2');?></div>
                        <?php endif ?>
                     </div>
                     <div class="form-group">
                        <label>Contact</label>
                        <input type="text" name="contact"  id="editcontact"class="form-control" 
                           value="<?php if(!empty(session()->getFlashdata('fieldValue2')))
                              {
                              $m=session()->getFlashdata('fieldValue2');
                              echo $m['contact'];
                              }else{
                              	echo"";	
                              }
                              ?>"
                           required>
                        <?php if(!empty(session()->getFlashdata('contactError2'))):?>
                        <div class="alert alert-danger"><?= session()->getFlashdata('contactError2');?></div>
                        <?php endif ?>
                     </div>
                     <div class="form-group">
                        <label>Position</label>
                        <select class="form-control"  name="position" onchange = "ShowHideDiv3()" id = "position2" required>
                           <option value="" selected hidden>----------</option>
                           <option value="Doctor"
                              <?php if(!empty(session()->getFlashdata('fieldValue2')
                              &&empty(session()->getFlashdata('receiptionPosi'))
                              &&empty(session()->getFlashdata('PharmacistPosi'))))
                                 {
                                 $m=session()->getFlashdata('fieldValue2');
                                 echo "selected";
                                 }else{
                                 	echo"";	
                                 }
                                 ?>
                              >Doctor</option>
                           <option value="Receiptionist"  <?php if(!empty(session()->getFlashdata('receiptionPosi')))
                                 {
                                 $m=session()->getFlashdata('receiptionPosi');
                                 echo "selected";
                                 }else{
                                 	echo"";	
                                 }
                                 ?>>Receiptionist</option>
                           <option value="Pharmacist"<?php if(!empty(session()->getFlashdata('PharmacistPosi')))
                                 {
                                 $m=session()->getFlashdata('PharmacistPosi');
                                 echo "selected";
                                 }else{
                                 	echo"";	
                                 }
                                 ?>>Pharmacist</option>
                        </select>
                        <?php if(!empty(session()->getFlashdata('positionError2'))):?>
                        <div class="alert alert-danger"><?= session()->getFlashdata('positionError2');?></div>
                        <?php endif ?>
                     </div>
                     <div class="form-group" id="editspecialist"  style="display: none">
                        <label>Specialist:</label>
                        <input type="text" name="specialist" id="editspeval"  class="form-control" 
                           value="  <?php if(!empty(session()->getFlashdata('fieldValue2')
                              &&empty(session()->getFlashdata('receiptionPosi'))
                              &&empty(session()->getFlashdata('PharmacistPosi'))))
                              {
                              if(isset($m['specialist'])){
                              	$m=session()->getFlashdata('fieldValue2');
                              	echo $m['specialist'];
                              }
                              
                              }else{
                              	echo"";	
                              }
                              ?>"
                           >
                        <?php if(!empty(session()->getFlashdata('specialistError2'))):?>
                        <div class="alert alert-danger"><?= session()->getFlashdata('specialistError2');?></div>
                        <?php endif ?>
                     </div>
                  </div>
                  <div class="modal-footer">
                     <input type="hidden" name="edit_id" id="edit_id" 
					 value="<?php if(!empty(session()->getFlashdata('fieldValue2')))
                              {
                              if(isset($m['id'])){
                              	$m=session()->getFlashdata('fieldValue2');
                              	echo $m['id'];
                              }
                              
                              }else{
                              	echo"";	
                              }
                              ?>"
                           >		
                     <input type="button" class="btn btn-default"  data-dismiss="modal" value="Cancel">
                     <input type="submit" class="btn btn-info" value="Save">
                  </div>
               </form>
            </div>
         </div>
      </div>
      <!-- Delete Modal HTML -->
      <div id="deleteEmployeeModal" class="modal fade">
         <div class="modal-dialog">
            <div class="modal-content">
               <form action="<?=base_url('admin/delete');?>" method="post">
                  <div class="modal-header">
                     <h4 class="modal-title">Delete Employee</h4>
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  </div>
                  <div class="modal-body">
                     <p>Are you sure you want to delete these Records?</p>
                     <p class="text-warning"><small>This action cannot be undone.</small></p>
                  </div>
                  <div class="modal-footer">
                     <input type="hidden" name="delete_id" id="delete_id" value="">			
                     <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                     <input type="submit" name="deletedata" class="btn btn-danger" value="Delete">
                  </div>
               </form>
            </div>
         </div>
      </div>
   </body>
</html>
<script>
   function ShowHideDiv2() {
         var position = document.getElementById("position");
         
         var specialist = document.getElementById("specialist");//name
        
   
         specialist.style.display = position.value == "Doctor" ? "block" : "none";
   
     }
	 function ShowHideDiv3() {
         var position = document.getElementById("position2");
         
         var specialist = document.getElementById("editspecialist");//name
        
   
         specialist.style.display = position.value == "Doctor" ? "block" : "none";
   
     }
     function selectDoctor(){
   ShowHideDiv2();
     }
     function ggg(){
     $(document).ready(function(){
         $("#addEmployeeModal").modal('show');
      });
   } function showEditFrom(){
     $(document).ready(function(){
         $("#editEmployeeModal").modal('show');
      });
   }
</script>
<?php 
   if(!empty(session()->getFlashdata('addFormError')))
   {
     echo '<script>',
     'ggg();',
     '</script>';
   }
   if(!empty(session()->getFlashdata('fieldValue')))
   {
     echo '<script>',
     'selectDoctor();',
     '</script>';
   }
   if(!empty(session()->getFlashdata('addFormErrorEdit')))
   {
     echo '<script>',
     'showEditFrom();',
     '</script>';
   }
   if(!empty(session()->getFlashdata('fieldValue2')))
   {
     echo '<script>',
     'ShowHideDiv3();',
     '</script>';
   }
   
   ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
<script>

function j(){
location.reload();
}

   $(document).ready(function () {
   
       $('.deletebtn').on('click', function () {
   
           $('#deleteEmployeeModal').modal('show');
   
        
   
       });
   });
   
   $('.delete').click(function(){
   var id=$(this).data('id');
   document.getElementById("delete_id").value = id;
   //$('#deleteEmployeeModal').attr('href','delete-cover.php?id='+id);
   //alert("The variable named x1 has value:  " +id);
   })
   $(document).ready(function () {
   
   $('.edit').on('click', function () {
   
   $('#editEmployeeModal').modal('show');
   var id=$(this).data('id');
   document.getElementById("edit_id").value = id;
   
   $tr = $(this).closest('tr');
   
   var data = $tr.children("td").map(function () {
   return $(this).text();
   }).get();
   /*
   if(data[5]=="Doctor")
   {
	
	var specialist = document.getElementById("editspecialist");//name
	$('#editspeval').val($.trim(data[6]));
	specialist.style.display = "block";
	
   }else{
	var specialist = document.getElementById("editspecialist");//name
    specialist.style.display = "none";
   }*/
   $('#position2').val(data[5]);

   if(data[5]=="Doctor")
   {
	var specialist = document.getElementById("editspecialist");//name
	specialist.style.display = "block";

	$('#editspeval').val($.trim(data[6]));
   }else{
	var specialist = document.getElementById("editspecialist");//name
    specialist.style.display = "none";
   }
   console.log(data);
   //is id
   //$('#update_id').val(data[0]);
   $('#editname').val(data[2]);
   $('#editic').val(data[3]);
   $('#editcontact').val(data[4]);
   
   });
   });
</script>
<?=$this->endSection();?>