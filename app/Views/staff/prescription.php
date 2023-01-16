<?= $this->extend('layout/staffdashboard-layout');?>
<?= $this->section('content');?>

<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<style>
    .select2-container .select2-selection--single{
    height:34px !important;
}
.select2-container--default .select2-selection--single{
         border: 1px solid #ccc !important; 
     border-radius: 0px !important; 
}


</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script type="text/javascript">
    $(function () {
        $("#select2").change(function () {
            var selectedText = $(this).find("option:selected").text();
            var selectedValue = $(this).val();
            var arr = selectedValue.split("|");
            document.getElementById("quantity").max = arr[1];

        });
    });
</script>

<div id="booking" class="section">
   <div class="section-center">
   <?php if(!empty(session()->getFlashdata('failpre'))):?>
            <div class="alert alert-danger"><?= session()->getFlashdata('failpre');?></div>
            <?php endif ?>
            <?php if(!empty(session()->getFlashdata('successpre'))):?>
            <div class="alert alert-success"><?= session()->getFlashdata('successpre');?></div>
            <?php endif ?>
            <div class="container-fluid text-black" style="background-color:white;">
      <h4><u>Patient Information</u></h4>
      <div class="row mt-3">
         <div class="col-sm-6">Name: <?=$patientData['name']?></div>
         <div class="col-sm-6">IC NUMBER: <?=$patientData['ic']?></div>
      </div>
      <div class="row mt-3">
         <div class="col-sm-6">Contact No: <?=$patientData['phone']?></div>
         <div class="col-sm-6">Allergies: <span style="color:<?php echo ($patientData['Allergies'] == 'Yes') ? 'red' :'green' ; ?>;"> <?php echo ($patientData['Allergies'] == '') ? '-' :$patientData['Allergies'] ; ?></span></div>
      </div>
      <div class="row mt-3">
         <div class="col-sm-6">Ethicity: <?php echo ($patientData['Ethnicity'] == '') ? '-' :$patientData['Ethnicity'] ; ?></div>
         <div class="col-sm-6">Gender: <?=$patientData['gender']?></div>
      </div>
      <div class="row mt-3">
         <div class="col-sm-6">State: <?=$patientData['state']?></div>
         <div class="col-sm-6">Email: <?php echo ($patientData['email'] == '') ? '-' :$patientData['email'] ; ?></div>
      </div>
      <div class="row mt-3">
         <div class="col-sm-6">Services: <?=$qData['services']?></div>
      </div>
   </div>
   <br>

      <div class="container">
         <div class="row justify-content-left">
            <div class="booking-form card p-3 bg-primary">
               <div class="form-header">
                  <h4>Add Sales Item or Prescription</h4>
                  <hr class="mt-2 mb-2"/>
               </div>
               <form action="<?= route_to('staff.toBill');?>" method="post">
               <input type="hidden" name="queueID" value="<?=$queueID?>"/>
                  <div class="row">
                     <div class="col-md-12">
                        <div class="form-group">
                           <span class="form-label text-light">Add Item</span>
                           <div class="form-group" >
                           <select class="form-control select2" name="item" id="select2" required>
	           <option  selected></option> 
               <?php 
               $inventoryData=getInventory();
               if(!empty($inventoryData)){
                foreach ($inventoryData as $key => $row) {
               ?>
               <option value='<?=$row['key']?>|<?=$row['quantity']?>|<?=$row['price']?>|<?=$row['medicineName']?>'><?=$row['medicineName']?> (<?=$row['quantity']?>) (<?=$row['dispensation']?>)</option> 

               <?php }}?>
	        </select>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <span class="form-label text-light">Enter Quantity</span>
                           <div class="form-group">
                           <input type="number" min="1" max="" placeholder="0" name="quantity" id="quantity" required/>
                           </div>
                        </div>
                     </div>
                

           
            
                     <div class="col-md-12">
                        <div class="form-group">
               
                           <span class="select-arrow"></span> <span class="form-label">Remark</span> 
                           <textarea class="form-control"  name="remark" id="exampleFormControlTextarea1" rows="1" required></textarea>
                          
                           
                        </div>
                     </div>
                     
                  </div>
                  <div class="form-group">
                     <input type="submit" class="btn btn-success" value="Add" name="addBtn" id="addBtn">
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>





  <table class="table bg-white" style="margin-top:10px;">
  <div class="row header" style="text-align:center;color:green">
<h5>&nbsp;&nbsp;&nbsp;Sales Item</h5>
</div>
  <thead>


    <tr>
      <th scope="col">Item Name</th>
      <th scope="col">Price(RM)</th>
      <th scope="col">Quantity</th>
      <th scope="col">SubTotal(RM)</th>
      <th scope="col">Remark</th>
      <th scope="col">Action</th>

    </tr>
  </thead>
  <tbody>
  <?php 
               if(!empty($orderDetails)){
                foreach ($orderDetails as $key => $row) {
               ?>
               <tr>
               <td><?=$row['itemName']?></td>
               <td><?=$row['price']?></td>
               <td><?=$row['quantity']?></td>
               <td><?=$row['subTotal']?></td>
               <td><?=$row['remark']?></td>
               <td>
               <form action="<?= route_to('staff.removePrescription');?>" method="post">
               <input type="hidden" name="orderDetailsID" value="<?=$row['key']?>"/>
               <input type="hidden" name="queueID" value="<?=$queueID?>"/>

               <input type="submit" class="btn btn-danger" value="Delete" name="deleteBtn" id="deleteBtn">

                </form>
                </tr>

   <?php } }?>

  </tbody>
</table>
<div class="table-wrapper">
               <div class="table-title">
                  <div class="row">
                     <div class="col-sm-10">
                     <div class="row header" style="text-align:center;color:red">
<h5>&nbsp;&nbsp;&nbsp;Symptoms & Diagnosis</h5>
</div>
                     </div>
                     <div class="col-sm-2">
                        <a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal"  style="float:right;"><i class="material-icons">&#xE147;</i> <span>Add +</span></a>
                        <!--	<a href="#deleteEmployeeModal" class="btn btn-danger" data-toggle="modal"><i class="material-icons">&#xE15C;</i> <span>Delete</span></a>-->				
                     </div>
                  </div>
               </div>
               <table class="table table-striped table-hover">
                  <thead>
                     <tr>
                     <th style="background-color:white;">No</th>
                        <th style="background-color:white;">Name</th>
                        <th style="background-color:white;">Remark</th>
                        <th style="background-color:white;">Action</th>

                     </tr>
                  </thead>
                  <tbody>
                     <!--Table data-->
                     <?php 
                        if(!empty($sympData))
                        {
                        	$i=1;
                        	foreach($sympData as $key => $row)
                        	//echo $key;
                        	//print_r($row['email']);
                        	//
                        {?>
                     <tr>
                        <td><?php echo $i;?></td>
                        <td><?php echo $row['name'];?></td>
                        <td><?php echo $row['remark'];?></td>
                        <td>
                           <a href="#editEmployeeModal" class="edit" data-id="<?=  $row['key'];?>" data-toggle="modal">Edit</a>
                           <a href="#deleteEmployeeModal" id="deletebtn" data-id="<?= $row['key'];?>"  class="delete" data-toggle="modal">Delete</a>
                        </td>
                     </tr>
                     <?php
                        $i+=1;}
                        }
                        
                        ?>
                   
                  </tbody>
               </table>
                     </div>
            <form action="<?= route_to('staff.toBill');?>" method="post">
            <input type="hidden" name="queueID" value="<?=$queueID?>"/>
            <div class="form-group">
                        <label>Remark(Optional)</label>
                        <input type="text" name="remarkCon" class="form-control" 
                           value="
                           <?php if(isset($remark)){
                           $remark?>
         
                           <?php } ?>"
                           >
                     </div>
                     <input type="submit" class="btn btn-success" value="To Bill" name="toBill">
      
            </form>
                      <!-- Edit Modal HTML -->
      <div id="addEmployeeModal" class="modal fade">
         <div class="modal-dialog">
            <div class="modal-content">
               <form action="<?= route_to('staff.toBill');?>" method="post">
                  <div class="modal-header">
                     <h4 class="modal-title">Symptoms & Diagnosis</h4>
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  </div>
                  <input type="hidden" name="queueID" value="<?=$queueID?>"/>

                  <div class="modal-body">
                     <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="nameSym" class="form-control" 
                           value=""
                           required>
                     </div>
                     <div class="form-group">
                        <label>Remark</label>
                        <input type="text" name="remarkSym" class="form-control" 
                           value=""
                           required>
                     </div>
                    
                  </div>
                  <div class="modal-footer">
                     <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                     <input type="submit" class="btn btn-success" value="Add" name="addSym">
                  </div>
               </form>
            </div>
         </div>
      </div>
      <!-- Edit Mode-->
          <!-- Edit Modal HTML -->
          <div id="editEmployeeModal" class="modal fade">
         <div class="modal-dialog">
            <div class="modal-content">
               <form action="<?= route_to('staff.toBill');?>" method="post">
                  <div class="modal-header">
                     <h4 class="modal-title">Update Symptoms & Diagnosis</h4>
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  </div>
                  <input type="hidden" name="queueID" value="<?=$queueID?>"/>

                  <div class="modal-body">
                     <div class="form-group">
                     <input type="hidden" name="edit_id" id="edit_id" />

                        <label>Name</label>
                        <input type="text" name="nameSym" class="form-control" id="editnamesym"
                           value=""
                           required>
                     </div>
                     <div class="form-group">
                        <label>Remark</label>
                        <input type="text" name="remarkSym" class="form-control"  id="editremarksym"
                           value=""
                           required>
                     </div>
                    
                  </div>
                  <div class="modal-footer">
                     <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                     <input type="submit" class="btn btn-success" value="Update" name="updateSym">
                  </div>
               </form>
            </div>
         </div>
      </div>
     
       <!-- Delete Modal HTML -->
       <div id="deleteEmployeeModal" class="modal fade">
         <div class="modal-dialog">
            <div class="modal-content">
               <form action="<?= route_to('staff.toBill');?>" method="post">
                  <div class="modal-header">
                     <h4 class="modal-title">Delete Record</h4>
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  </div>
                  <div class="modal-body">
                     <p>Are you sure you want to delete these Records?</p>
                     <p class="text-warning"><small>This action cannot be undone.</small></p>
                  </div>
                  <div class="modal-footer">
                  <input type="hidden" name="queueID" value="<?=$queueID?>"/>
                     <input type="hidden" name="delete_id" id="delete_id" value="">			
                     <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                     <input type="submit" name="deleteSym" class="btn btn-danger" value="Delete">
                  </div>
               </form>
            </div>
         </div>
      </div>
<script>
      $('.delete').click(function(){
   var id=$(this).data('id');
   document.getElementById("delete_id").value = id;
   //$('#deleteEmployeeModal').attr('href','delete-cover.php?id='+id);
   //alert("The variable named x1 has value:  " +id);
   })
   </script>
<script>
   $(document).ready(function () {
   
   $('.edit').on('click', function () {
   
   $('#editEmployeeModal').modal('show');
   var id=$(this).data('id');
   document.getElementById("edit_id").value = id;
   
   $tr = $(this).closest('tr');
   
   var data = $tr.children("td").map(function () {
   return $(this).text();
   }).get();

   $('#editnamesym').val(data[1]);
   $('#editremarksym').val(data[2]);
   
   });
   });
</script>
<script>
    $('.select2').select2();
</script>
<?=$this->endSection();?>