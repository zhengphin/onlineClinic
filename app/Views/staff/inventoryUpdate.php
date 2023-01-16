<?= $this->extend('layout/staffdashboard-layout');?>
<?= $this->section('content');?>
<div class="container py-5">
   <div class="row">
      <div class="col-md-10 mx-auto">
      <form action="<?=route_to('staff.updateInventory');?>" method="post">
            <?= csrf_field(); ?>
           <?php if(!empty(session()->getFlashdata('failfail'))):?>
            <div class="alert alert-danger"><?= session()->getFlashdata('failfail');?></div>
            <?php endif ?>
            <?php if(!empty(session()->getFlashdata('successsuccess'))):?>
            <div class="alert alert-success"><?= session()->getFlashdata('successsuccess');?></div>
            <?php endif ?>
            <input type="hidden" id="key" name="key"  value="<?=$inventoryData['key']?>">

            <div class="form-group row">
               <div class="col-sm-6">
                  <label for="inputFirstname">Medicine Name</label>
                  <input type="text" class="form-control" id="inputname" name="name" placeholder="Enter medicine name"
                  <?php 
                            if(empty(session()->getFlashdata('error'))){
                            ?>
                            value="<?=$inventoryData['medicineName']?>"
                            
                            <?php }if(!empty(session()->getFlashdata('error'))){?>
                            value="<?php echo set_value('name') ?>"
                           <?php }?>   
                           >
                            <?php if(!empty(session()->getFlashdata('nameError'))):?>
                        <div class="text-danger"><?= session()->getFlashdata('nameError');?></div>
                          <?php endif ?>

               </div>
               <div class="col-sm-6">
                  <label for="inputLastname">Item Description</label>
                  <input type="text" class="form-control" id="inputDescription" name="description" placeholder="Enter description"
                  <?php 
                            if(empty(session()->getFlashdata('error'))){
                            ?>
                            value="<?=$inventoryData['desc']?>"
                            
                            <?php }if(!empty(session()->getFlashdata('error'))){?>
                            value="<?php echo set_value('description') ?>"
                           <?php }?>   
                           >
                            <?php if(!empty(session()->getFlashdata('descError'))):?>
                        <div class="text-danger"><?= session()->getFlashdata('descError');?></div>
                          <?php endif ?>

               </div>
            </div>
            <div class="form-group row">
               <div class="col-sm-6">
                  <label for="inputAddressLine1">Selling Price</label>
                  <input type="number" min="1"step="0.01" class="form-control" id="inputAddressLine1" name="price" placeholder="Enter price"
                  <?php 
                            if(empty(session()->getFlashdata('error'))){
                            ?>
                            value="<?=$inventoryData['price']?>"
                            
                            <?php }if(!empty(session()->getFlashdata('error'))){?>
                            value="<?php echo set_value('price') ?>"
                           <?php }?>   
                           >
                            <?php if(!empty(session()->getFlashdata('priceError'))):?>
                        <div class="text-danger"><?= session()->getFlashdata('priceError');?></div>
                          <?php endif ?>


               </div>
               <div class="col-sm-6">
                  <label for="inputAddressLine2">Quantity</label>
                  <input type="number" min="1" class="form-control" id="inputAddressLine2" name="quantity" placeholder="Enter quantity"
                  <?php 
                            if(empty(session()->getFlashdata('error'))){
                            ?>
                            value="<?=$inventoryData['quantity']?>"
                            
                            <?php }if(!empty(session()->getFlashdata('error'))){?>
                            value="<?php echo set_value('quantity') ?>"
                           <?php }?>   
                           >
                            <?php if(!empty(session()->getFlashdata('quantityError'))):?>
                        <div class="text-danger"><?= session()->getFlashdata('quantityError');?></div>
                          <?php endif ?>


               </div>
            </div>
            <div class="form-group row">
               <div class="col-sm-6">
                  <label for="inputCity">Expiry Date</label>
                  <?php 
                              date_default_timezone_set('Asia/Kuala_Lumpur');
                              $DATE = date('Y-m-d');
                              ?>
                  <input type="date"  min="<?=$DATE?>" required class="form-control" id="inputCity" name="date" 
                  <?php 
                            if(empty(session()->getFlashdata('error'))){
                            ?>
                            value="<?=$inventoryData['expiryDate']?>"
                            
                            <?php }if(!empty(session()->getFlashdata('error'))){?>
                            value="<?php echo set_value('date') ?>"
                           <?php }?>   
                           >
                            <?php if(!empty(session()->getFlashdata('expiryDateError'))):?>
                        <div class="text-danger"><?= session()->getFlashdata('expiryDateError');?></div>
                          <?php endif ?>

               </div>
               <div class="col-sm-6">
                  <label for="inputPostalCode">Supplier</label>
                  <input type="text" class="form-control" id="inputPostalCode" name="Supplier" placeholder="Enter Supplier Name"
                  <?php 
                            if(empty(session()->getFlashdata('error'))){
                            ?>
                            value="<?=$inventoryData['supplier']?>"
                            
                            <?php }if(!empty(session()->getFlashdata('error'))){?>
                            value="<?php echo set_value('Supplier') ?>"
                           <?php }?>   
                           >
                            <?php if(!empty(session()->getFlashdata('supplierError'))):?>
                        <div class="text-danger"><?= session()->getFlashdata('supplierError');?></div>
                          <?php endif ?>
               </div>
            </div>
            <div class="form-group row">
               <div class="col-sm-6">
                  <label for="inputContactNumber">Dispensation Unit</label>
                  <select  class="form-control" name="Dispensation" required>
                     <option value="TABLET"
                     <?php
                            if($inventoryData['dispensation']=="TABLET")
                            {
                            echo "selected";
                            }else{
                                echo "";
                            }
                            ?>
                     >TABLET</option>
                     <option value="STRIP"
                     <?php
                            if($inventoryData['dispensation']=="STRIP")
                            {
                            echo "selected";
                            }else{
                                echo "";
                            }
                            ?>
                     >STRIP </option>
                     <option value="BOTTLE"
                     <?php
                            if($inventoryData['dispensation']=="BOTTLE")
                            {
                            echo "selected";
                            }else{
                                echo "";
                            }
                            ?>
                     >BOTTLE</option>
                     <option value="TUBE"
                     <?php
                            if($inventoryData['dispensation']=="TUBE")
                            {
                            echo "selected";
                            }else{
                                echo "";
                            }
                            ?>
                     >TUBE</option>
                     <option value="VIAL"
                     <?php
                            if($inventoryData['dispensation']=="VIAL")
                            {
                            echo "selected";
                            }else{
                                echo "";
                            }
                            ?>
                     >VIAL</option>
                     <option value="SACHET"
                     <?php
                            if($inventoryData['dispensation']=="SACHET")
                            {
                            echo "selected";
                            }else{
                                echo "";
                            }
                            ?>
                     >SACHET</option>
                     <option value="BOX"
                     <?php
                            if($inventoryData['dispensation']=="BOX")
                            {
                            echo "selected";
                            }else{
                                echo "";
                            }
                            ?>
                     >BOX</option>
                     <option value="CAPSULE"
                     <?php
                            if($inventoryData['dispensation']=="CAPSULE")
                            {
                            echo "selected";
                            }else{
                                echo "";
                            }
                            ?>
                     >CAPSULE</option>

                  </select>
               </div>
<div class="col-sm-6">
                  <label for="inputPostalCode">Notes(Optional)</label>
                  <input type="text" class="form-control" id="inputPostalCode" name="Notes" placeholder="Enter Notes "
                  <?php 
                            if(empty(session()->getFlashdata('error'))){
                            ?>
                            value="<?=$inventoryData['notes']?>"
                            
                            <?php }if(!empty(session()->getFlashdata('error'))){?>
                            value="<?php echo set_value('Notes') ?>"
                           <?php }?>   
                           >
                            <?php if(!empty(session()->getFlashdata('notesError'))):?>
                        <div class="text-danger"><?= session()->getFlashdata('notesError');?></div>
                          <?php endif ?>


               </div>
            </div>
            <button type="submit" class="btn btn-success px-4 float-right">Save</button>
         </form>
      </div>
   </div>
</div>
<?=$this->endSection();?>