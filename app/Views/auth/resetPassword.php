<?php include '../public/design/header.php';?>
<div class="light-background-color">
   <div class="container py-2 py-lg-7 position-relative">
      <div class="row align-items-center justify-content-between">
         <div class="row col-lg-6">
            <img src="<?= base_url('landingPage/img/leading.png') ?>" alt="">
         </div>
         <div class="col-lg-5 my-5 my-lg-0">
            <div class="primary-color" style="height: 7px; width: 94px"></div>
            <h2 class="h3 text-color" style="margin-top:15px">
               Reset Password 
            </h2>
          
            <?php if(!empty(session()->getFlashdata('success'))):?>
            <div class="alert alert-success"><?= session()->getFlashdata('success');?></div>
            <?php endif ?>
            <?php if(!empty(session()->getFlashdata('fail'))):?>
            <div class="alert alert-danger"><?= session()->getFlashdata('fail');?></div>
            <?php endif ?>
            <?php if(isset($error)):?>
               <div class="alert alert-danger"><?= $error;?></div>
            <?php else:?>
            <?=form_open();?>
            <div class="form-group">
               <hr>
               <div class="form-group">
                  <label for="">Password</label>
                  <input type="password" class="form-control" name="password" placeholder="Enter your password" value="<?php echo set_value('password') ?>"> 
                  <?php if(!empty(session()->getFlashdata('validation'))):?>
                <div class="text-danger"><?= session()->getFlashdata('validation');?></div>
                  <?php endif ?>
                </div>
               <div class="form-group">
                  <label for="">Confirm Password</label>
                  <input type="password" class="form-control" name="cpassword" placeholder="Enter your password" value="<?php echo set_value('cpassword') ?>">
                  <?php if(!empty(session()->getFlashdata('validation2'))):?>
                <div class="text-danger"><?= session()->getFlashdata('validation2');?></div>
                  <?php endif ?>
                </div>
               <br>
               <hr>
               <div class="form-group">
                  <button class="btn btn-primary btn-block" type="submit">Update</button> 
               </div>
              
         </form>
         </div>
            <?=form_close();?>
            <?php endif?>
   
      </div>
   </div>
</div>
<?php include '../public/design/footer.php';?>