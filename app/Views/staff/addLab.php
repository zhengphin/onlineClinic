<?= $this->extend('layout/staffdashboard-layout');?>
<?= $this->section('content');?>
<div class="container py-5">
   <div class="row">
      <div class="col-md-10 mx-auto">
      <form action="<?=base_url('Lab/saveLab');?>" method="post">

            <?= csrf_field(); ?>
         
           <?php if(!empty(session()->getFlashdata('faillab'))):?>
            <div class="alert alert-danger"><?= session()->getFlashdata('faillab');?></div>
            <?php endif ?>
            <?php if(!empty(session()->getFlashdata('successlab'))):?>
            <div class="alert alert-success"><?= session()->getFlashdata('successlab');?></div>
            <?php endif ?>
            <div class="form-group row">
            <input type="hidden" id="key" name="key"  value="<?= $patientData['key'] ?>">
               <div class="col-sm-6">
                  <label for="inputFirstname">Test Name</label>
                  <input type="text" class="form-control" id="inputFirstname" name="name" placeholder="Enter test name"value="<?php echo set_value('name') ?>">
                  <span class="text-danger"><?=isset($validation)?display_error($validation,'name'):''?></span>

               </div>
               <div class="col-sm-6">
                  <label for="inputLastname">Laboratory</label>
                  <input type="text" class="form-control" id="inputLastname" name="laboratory" placeholder="Enter Laboratory"value="<?php echo set_value('laboratory') ?>">
                  <span class="text-danger"><?=isset($validation)?display_error($validation,'laboratory'):''?></span>

               </div>
            </div>
            <div class="form-group row">
               <div class="col-sm-6">
                  <label for="inputAddressLine1">Specimens</label>
                  <input type="text" class="form-control" id="inputAddressLine1" name="specimens" placeholder="Enter specimens"value="<?php echo set_value('specimens') ?>">
                  <span class="text-danger"><?=isset($validation)?display_error($validation,'specimens'):''?></span>
               </div>
               <div class="col-sm-6">
                  <label for="inputAddressLine2">Description</label>
                  <input type="text" class="form-control" id="inputAddressLine2" name="desc" placeholder="Enter description"value="<?php echo set_value('desc') ?>">
                  <span class="text-danger"><?=isset($validation)?display_error($validation,'desc'):''?></span>

               </div>
            </div>
            
            <button type="submit" class="btn btn-success px-4 float-right">Add</button>
         </form>
      </div>
   </div>
</div>
<?=$this->endSection();?>