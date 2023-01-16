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
<script src="jquery-3.6.1.min.js"></script>
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


<?php if(!empty(session()->getFlashdata('failtocheckout'))):?>
            <div class="alert alert-danger"><?= session()->getFlashdata('failtocheckout');?></div>
            <?php endif ?>
            <?php if(!empty(session()->getFlashdata('successtocheckout'))):?>
            <div class="alert alert-success"><?= session()->getFlashdata('successtocheckout');?></div>
            <?php endif ?>

<div>
   <div class="container-fluid text-black" style="background-color:white;">
      <h4><u>Order Details</u></h4>
      <div class="row mt-3">
         <div class="col-sm-6">Order ID: <?=$queueID?></div>
         <div class="col-sm-6">Name: <?=$patientData['name']?></div>
      </div>
      <div class="row mt-3">
      <div class="col-sm-6">Order Date: <?=$qData['date']?></div>

         <div class="col-sm-6">Contact No: <?=$patientData['phone']?></div>
      </div>
      <div class="row mt-3">
         <div class="col-sm-6">Time: <?=$qData['Arrivaltime']?></div>
         <div class="col-sm-6">IC Number: <?=$patientData['ic']?></div>
      </div>
      <div class="row mt-3">
         <div class="col-sm-6">Remark: <?=$remark?></div>
         <div class="col-sm-6">Service: <?=$service?></div>
      </div>
   </div>

   
   <div class="container-fluid text-black mt-4" style="background-color:white;">
      <h4><u>Order Summary</u></h4>
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

   <div class="container-fluid text-black mt-4" style="background-color:white;">
      <h4><u>Services Charges</u> 

    </h4>
    
      <div class="table-wrapper">
               <div class="table-title">
                  <div class="row">
                     <div class="col-sm-10">
                     <div class="row header" style="text-align:center;color:red">
</div>
                     </div>
               
                  </div>
               </div>
               <table class="table table-striped table-hover">
                  <thead>
                     <tr>
                     <th style="background-color:white;">No</th>
                        <th style="background-color:white;">Name</th>
                        <th style="background-color:white;">Price(RM)</th>
                        <th style="background-color:white;">Quantity</th>
                        <th style="background-color:white;">Sub Total(RM)</th>

                     </tr>
                  </thead>
                  <tbody>
                     <!--Table data-->
                     <?php 
                        if(!empty($servicesOrderData))
                        {
                        	$i=1;
                            $subtotal2=0;

                        	foreach($servicesOrderData as $key => $row)
                        	
                        {?>
                     <tr>
                        <td><?php echo $i;?></td>
                        <td><?php echo $row['servicesName'];?></td>
                        <td><?php echo $row['price'];?></td>
                        <td><?php echo $row['quantity'];?></td>
                        <td><?php echo $row['subtotal'];?></td>

                     
                     </tr>
                     <?php $subtotal2+=$row['subtotal']?>

                     <?php
                        $i+=1;
                    
                    }
                        }
                        
                        ?>
                   
                  </tbody>
                  <div style="float:right;">Total Price: RM<?php if(isset($subtotal2)){
                  echo $subtotal2;   
                  }?></div></div>

               </table>
                     </div>
<br>
   </div>
   <div class="container-fluid text-black mt-2" style="background-color:white;">
      <h4><u>Symptons & Diagnosis</u> 

    </h4>
    
      <div class="table-wrapper">
               <div class="table-title">
                  <div class="row">
                     <div class="col-sm-10">
                     <div class="row header" style="text-align:center;color:red">
</div>
                     </div>
               
                  </div>
               </div>
               <table class="table table-striped table-hover">
                  <thead>
                     <tr>
                     <th style="background-color:white;">No</th>
                        <th style="background-color:white;">Date</th>
                        <th style="background-color:white;">Name</th>
                        <th style="background-color:white;">Remark</th>

                     </tr>
                  </thead>
                  <tbody>
                     <!--Table data-->
                     <?php 
                        if(!empty($symData))
                        {
                        	$i=1;

                        	foreach($symData as $key => $row)
                        	
                        {?>
                     <tr>
                        <td><?php echo $i;?></td>
                        <td><?php echo $row['date'];?></td>
                        <td><?php echo $row['name'];?></td>
                        <td><?php echo $row['remark'];?></td>

                     
                     </tr>

                     <?php
                        $i+=1;
                    
                    }
                        }
                        
                        ?>
                   
                  </tbody>

               </table>
                     </div>
<br>
   </div>
                    </div>

<!--This is add services-->
<div id="addEmployeeModal" class="modal fade">
         <div class="modal-dialog">
            <div class="modal-content">
               <form action="<?= route_to('staff.toPayment');?>" method="post">
                  <div class="modal-header">
                     <h4 class="modal-title">Services</h4>
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  </div>
                  <input type="hidden" name="queueID" value="<?=$queueID?>"/>

                  <div class="modal-body">
                     <div class="form-group">
                        <div class="form-group">
                           <span class="select-arrow"></span> <span class="form-label">Service Type</span> 
                           <select class="form-control" name="services"  required>
                              <option value="" selected hidden>Choose a service type</option>
                              <option value="General Consultation and Treament" <?php echo  set_select('services', 'General Consultation and Treament'); ?>>General Consultation and Treament</option>
                              <option value="Immunization and Vaccination"<?php echo  set_select('services', 'Immunization and Vaccination'); ?>>Immunization and Vaccination</option>
                              <option value="Blood and Urine Test" <?php echo  set_select('services', 'Blood and Urine Test'); ?>>Blood and Urine Test</option>
                              <option value="Minor Surgery"<?php echo  set_select('services', 'Minor Surgery'); ?>>Minor Surgery</option>
                              <option value="X-ray"<?php echo  set_select('services', 'X-ray'); ?>>X-ray</option>
                              <option value="Medical Check Up"<?php echo  set_select('services', 'Medical Check Up'); ?>>Medical Check Up</option>
                              <option value="Ultra Sound"<?php echo  set_select('services', 'Ultra Sound'); ?>>Ultra Sound</option>
                              <option value="Spirometry"<?php echo  set_select('services', 'Spirometry'); ?>>Spirometry</option>
                              <option value="Circumcision"<?php echo  set_select('services', 'Circumcision'); ?>>Circumcision</option>
                              <option value="Antenatal and Postnatal Carea"<?php echo  set_select('services', 'Antenatal and Postnatal Carea'); ?>>Antenatal and Postnatal Carea</option>
                              <option value="Audiometry"<?php echo  set_select('services', 'Audiometry'); ?>>Audiometry</option>
                              <option value="Gynae Service"<?php echo  set_select('services', 'Gynae Service'); ?>>Gynae Service</option>

                           </select>
                           <?php if(!empty(session()->getFlashdata('servicesError'))):?>
                        <div class="text-warning h5"><?= session()->getFlashdata('servicesError');?></div>
                          <?php endif ?>
                        </div>
                     </div>
                     <div class="form-group">
                        <label>Quantity</label>
                        <input type="number" name="servicesQuantity" class="form-control" min="1" 
                           value="1"
                           required>
                     </div>
                     <div class="form-group">
                        <label>Price</label>
                        <input type="number" step="0.01" name="servicesPrice" class="form-control" min="1" 
                           value=""
                           required>
                     </div>
                  </div>
                  <div class="modal-footer">
                     <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                     <input type="submit" class="btn btn-success" value="Add Services" name="addServices">
                  </div>
               </form>
            </div>
         </div>
      </div>
<!-- end of add services -->
   <!-- Edit Modal HTML -->
 <!-- Edit Modal HTML -->
 <div id="editEmployeeModal" class="modal fade">
         <div class="modal-dialog">
            <div class="modal-content">
               <form action="<?= route_to('staff.toPayment');?>" method="post">
                  <div class="modal-header">
                     <h4 class="modal-title">Update Services</h4>
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  </div>
                  <input type="hidden" name="queueID" value="<?=$queueID?>"/>
                  <input type="hidden" name="edit_id" id="edit_id" />


                  <div class="modal-body">
                  <div class="form-group">
                        <div class="form-group">
                           <span class="select-arrow"></span> <span class="form-label">Service Type</span> 
                           <select class="form-control" name="services"  required>
                              <option value="" selected hidden>Choose a service type</option>
                              <option value="General Consultation and Treament" <?php echo  set_select('services', 'General Consultation and Treament'); ?>>General Consultation and Treament</option>
                              <option value="Immunization and Vaccination"<?php echo  set_select('services', 'Immunization and Vaccination'); ?>>Immunization and Vaccination</option>
                              <option value="Blood and Urine Test" <?php echo  set_select('services', 'Blood and Urine Test'); ?>>Blood and Urine Test</option>
                              <option value="Minor Surgery"<?php echo  set_select('services', 'Minor Surgery'); ?>>Minor Surgery</option>
                              <option value="X-ray"<?php echo  set_select('services', 'X-ray'); ?>>X-ray</option>
                              <option value="Medical Check Up"<?php echo  set_select('services', 'Medical Check Up'); ?>>Medical Check Up</option>
                              <option value="Ultra Sound"<?php echo  set_select('services', 'Ultra Sound'); ?>>Ultra Sound</option>
                              <option value="Spirometry"<?php echo  set_select('services', 'Spirometry'); ?>>Spirometry</option>
                              <option value="Circumcision"<?php echo  set_select('services', 'Circumcision'); ?>>Circumcision</option>
                              <option value="Antenatal and Postnatal Carea"<?php echo  set_select('services', 'Antenatal and Postnatal Carea'); ?>>Antenatal and Postnatal Carea</option>
                              <option value="Audiometry"<?php echo  set_select('services', 'Audiometry'); ?>>Audiometry</option>
                              <option value="Gynae Service"<?php echo  set_select('services', 'Gynae Service'); ?>>Gynae Service</option>

                           </select>
                           <?php if(!empty(session()->getFlashdata('servicesError'))):?>
                        <div class="text-warning h5"><?= session()->getFlashdata('servicesError');?></div>
                          <?php endif ?>
                        </div>
                     </div>
                     
                     <div class="form-group">
                        <label>Quantity</label>
                        <input type="number" name="editservicesQuantity" id="editservicesQuantity" class="form-control" min="1" 
                           value="1"
                           required>
                     </div>
                     <div class="form-group">
                        <label>Price</label>
                        <input type="number" step="0.01" name="editservicesPrice" id="editservicesPrice" class="form-control" min="1" 
                           value=""
                           required>
                     </div>
                    
                  </div>
                  <div class="modal-footer">
                     <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                     <input type="submit" class="btn btn-success" value="Update" name="updateServices">
                  </div>
               </form>
            </div>
         </div>
      </div>
 <!-- Delete Modal HTML -->
 <div id="deleteEmployeeModal" class="modal fade">
         <div class="modal-dialog">
            <div class="modal-content">
               <form action="<?= route_to('staff.toPayment');?>" method="post">
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
                     <input type="submit" name="deleteServices" class="btn btn-danger" value="Delete">
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

   $('#editservicesQuantity').val(data[3]);
   $('#editservicesPrice').val(data[2]);
   
   });
   });
</script>
<script>
    $(function(){
            $('#value1, #value2').keyup(function(){
               var value1 = parseFloat($('#value1').val()) || 0;
               var value2 = parseFloat($('#value2').val()) || 0;
               $('#sum').val(value1 - value2);
            });
         });
</script>
<?=$this->endSection();?>