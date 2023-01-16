<?= $this->extend('layout/staffdashboard-layout');?>
<?= $this->section('content');?>
<div class="container py-5">
   <div class="row">
      <div class="col-md-10 mx-auto">
      <form action="<?=base_url('patient/register');?>" method="post">
            <?= csrf_field(); ?>
           <?php if(!empty(session()->getFlashdata('fail'))):?>
            <div class="alert alert-danger"><?= session()->getFlashdata('fail');?></div>
            <?php endif ?>
            <?php if(!empty(session()->getFlashdata('success'))):?>
            <div class="alert alert-success"><?= session()->getFlashdata('success');?></div>
            <?php endif ?>
            <div class="form-group row">
               <div class="col-sm-6">
                  <label for="inputFirstname">Full Name</label>
                  <input type="text" class="form-control" id="inputFirstname" name="name" placeholder="Enter full name"value="<?php echo set_value('name') ?>">
                  <span class="text-danger"><?=isset($validation)?display_error($validation,'name'):''?></span>

               </div>
               <div class="col-sm-6">
                  <label for="inputLastname">Email(Optional)</label>
                  <input type="text" class="form-control" id="inputLastname" name="email" placeholder="Enter email"value="<?php echo set_value('email') ?>">
                  <span class="text-danger"><?=isset($validation)?display_error($validation,'email'):''?></span>

               </div>
            </div>
            <div class="form-group row">
               <div class="col-sm-6">
                  <label for="inputAddressLine1">Identity Number</label>
                  <input type="text" class="form-control" id="inputAddressLine1" name="identityNum" placeholder="Enter Identify Number"value="<?php echo set_value('identityNum') ?>">
                  <span class="text-danger"><?=isset($validation)?display_error($validation,'identityNum'):''?></span>

               </div>
               <div class="col-sm-6">
                  <label for="inputAddressLine2">Contact Number</label>
                  <input type="text" class="form-control" id="inputAddressLine2" name="contact" placeholder="Enter Contact Number"value="<?php echo set_value('contact') ?>">
                  <span class="text-danger"><?=isset($validation)?display_error($validation,'contact'):''?></span>

               </div>
            </div>
            <div class="form-group row">
               <div class="col-sm-6">
                  <label for="inputCity">Address</label>
                  <input type="text" class="form-control" id="inputCity" name="address" placeholder="Enter Address"value="<?php echo set_value('address') ?>">
                  <span class="text-danger"><?=isset($validation)?display_error($validation,'address'):''?></span>

               </div>
               <div class="col-sm-6">
                  <label for="inputPostalCode">Postal Code</label>
                  <input type="text" class="form-control" id="inputPostalCode" name="postcode" placeholder="Postal Code"value="<?php echo set_value('postcode') ?>">
                  <span class="text-danger"><?=isset($validation)?display_error($validation,'postcode'):''?></span>

               </div>
            </div>
            <div class="form-group row">
               <div class="col-sm-6">
                  <label for="inputContactNumber">Ethnicity</label>
                  <select  class="form-control" name="Ethnicity" required>
                     <option value="" selected hidden>----------</option>
                     <option value="Malay">Malay</option>
                     <option value="Chinese">Chinese </option>
                     <option value="Indians">Indians</option>
                  </select>
               </div>
               <div class="col-sm-6">
                  <label for="inputWebsite">Allergies</label>
                  <select  class="form-control" name="Allergies" required>
                     <option value="" selected hidden>----------</option>
                     <option value="Yes">Yes</option>
                     <option value="No ">No </option>
                  </select>
               </div>
            </div>
            <button type="submit" class="btn btn-success px-4 float-right">Save</button>
         </form>
      </div>
   </div>
</div>
<?=$this->endSection();?>