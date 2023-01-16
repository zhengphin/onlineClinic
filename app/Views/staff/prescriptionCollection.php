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


    

<div>
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
   </div>
   <div class="container-fluid text-black mt-3" style="background-color:white;">
      <h4><u>Remark</u></h4>
      <div class="row mt-3">
         <div class="col-sm-6">Remark: <?=$remark?></div>
      </div>
      <div class="row mt-3">
         <div class="col-sm-6">Service: <?=$service?></div>
      </div>
   </div>
   
   <div class="container-fluid text-black mt-4" style="background-color:white;">
      <h4><u>Medicine to collect</u></h4>
      <table class="table"  style="background-color:rgb(0, 191, 255); margin:5px;">
  <thead style="background-color:white;">
    <tr >
      <th scope="col">Item Name</th>
      <th scope="col">Unit Price</th>
      <th scope="col">Quantity</th>
      <th scope="col">SubTotal</th>
      <th scope="col">Remark</th>

    </tr>
  </thead>
  <tbody>
  <?php 
               if(!empty($orderDetails)){
                  $subtotal=0;
                foreach ($orderDetails as $key => $row) {
               ?>
               <tr style="background-color:rgb(232,232,232);">
               <td><?=$row['itemName']?></td>
               <td >RM <?=$row['price']?></td>
               <td><?=$row['quantity']?></td>
               <td>RM <?=$row['subTotal']?></td>
               <td><?=$row['remark']?></td>
                </tr>
                <?php $subtotal+=$row['subTotal']?>
   

   <?php } }?>
  </tbody>
  <div style="float:right;">Total Price: RM<?=$subtotal?></div>
</table>
<br>
   </div>
 <div class="mt-2">
 <form action="<?= route_to('staff.toPayment');?>" method="post">
 <input type="hidden" name="queueID" value="<?=$queueID?>"/>
<button type="submit" class="btn btn-info">Checkout</button>

</form>
</div>
</div>

 


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