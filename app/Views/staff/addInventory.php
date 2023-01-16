<?= $this->extend('layout/staffdashboard-layout');?>
<?= $this->section('content');?>
<div class="container py-5">
   <div class="row">
      <div class="col-md-10 mx-auto">
      <form action="<?=route_to('staff.addInventory');?>" method="post">
            <?= csrf_field(); ?>
           <?php if(!empty(session()->getFlashdata('fail'))):?>
            <div class="alert alert-danger"><?= session()->getFlashdata('fail');?></div>
            <?php endif ?>
            <?php if(!empty(session()->getFlashdata('success'))):?>
            <div class="alert alert-success"><?= session()->getFlashdata('success');?></div>
            <?php endif ?>
            <div class="form-group row">
               <div class="col-sm-6">
                  <label for="inputFirstname">Medicine Name</label>
                  <input type="text" class="form-control" id="inputname" name="name" placeholder="Enter medicine name"value="<?php echo set_value('name') ?>">
                  <span class="text-danger"><?=isset($validation)?display_error($validation,'name'):''?></span>

               </div>
               <div class="col-sm-6">
                  <label for="inputLastname">Item Description</label>
                  <input type="text" class="form-control" id="inputDescription" name="description" placeholder="Enter description"value="<?php echo set_value('description') ?>">
                  <span class="text-danger"><?=isset($validation)?display_error($validation,'description'):''?></span>

               </div>
            </div>
            <div class="form-group row">
               <div class="col-sm-6">
                  <label for="inputAddressLine1">Selling Price</label>
                  <input type="number" min="1"step="0.01" class="form-control" id="inputAddressLine1" name="price" placeholder="Enter price"value="<?php echo set_value('price') ?>">
                  <span class="text-danger"><?=isset($validation)?display_error($validation,'price'):''?></span>

               </div>
               <div class="col-sm-6">
                  <label for="inputAddressLine2">Quantity</label>
                  <input type="number" min="1" class="form-control" id="inputAddressLine2" name="quantity" placeholder="Enter quantity"value="<?php echo set_value('quantity') ?>">
                  <span class="text-danger"><?=isset($validation)?display_error($validation,'quantity'):''?></span>

               </div>
            </div>
            <div class="form-group row">
               <div class="col-sm-6">
                  <label for="inputCity">Expiry Date</label>
                  <?php 
                              date_default_timezone_set('Asia/Kuala_Lumpur');
                              $DATE = date('Y-m-d');
                              ?>
                  <input type="date"  min="<?=$DATE?>" required class="form-control" id="inputCity" name="date" value="<?php echo set_value('date') ?>">
                  <span class="text-danger"><?=isset($validation)?display_error($validation,'date'):''?></span>

               </div>
               <div class="col-sm-6">
                  <label for="inputPostalCode">Supplier</label>
                  <input type="text" class="form-control" id="inputPostalCode" name="Supplier" placeholder="Enter Supplier Name"value="<?php echo set_value('Supplier') ?>">
                  <span class="text-danger"><?=isset($validation)?display_error($validation,'Supplier'):''?></span>

               </div>
            </div>
            <div class="form-group row">
               <div class="col-sm-6">
                  <label for="inputContactNumber">Dispensation Unit</label>
                  <select  class="form-control" name="Dispensation" required>
                     <option value="" selected hidden>SELECT FROM THE DROPDOWN LIST</option>
                     <option value="TABLET">TABLET</option>
                     <option value="STRIP">STRIP </option>
                     <option value="BOTTLE">BOTTLE</option>
                     <option value="TUBE">TUBE</option>
                     <option value="VIAL">VIAL</option>
                     <option value="SACHET">SACHET</option>
                     <option value="BOX">BOX</option>
                     <option value="CAPSULE">CAPSULE</option>

                  </select>
               </div>
<div class="col-sm-6">
                  <label for="inputPostalCode">Notes</label>
                  <input type="text" class="form-control" id="inputPostalCode" name="Notes" placeholder="Enter Notes "value="<?php echo set_value('Notes') ?>">
                  <span class="text-danger"><?=isset($validation)?display_error($validation,'Notes'):''?></span>

               </div>
            </div>
            <button type="submit" class="btn btn-success px-4 float-right">Save</button>
         </form>
      </div>
   </div>
</div>
<?=$this->endSection();?>