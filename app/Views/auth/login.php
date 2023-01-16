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
               LOGIN 
            </h2>
            <form action="<?=base_url('auth/check');?>" method="post">
            <?= csrf_field(); ?>
            <?php if(!empty(session()->getFlashdata('fail'))):?>
            <div class="alert alert-danger"><?= session()->getFlashdata('fail');?></div>
            <?php endif ?>
            <?php if(!empty(session()->getFlashdata('success'))):?>
            <div class="alert alert-success"><?= session()->getFlashdata('success');?></div>
            <?php endif ?>
            <div class="form-group">
               <label for="">Email</label>
               <input type="text" class="form-control" name="email" placeholder="Enter your email" value="<?php echo set_value('email') ?>">  
               <span class="text-danger"><?=isset($validation)?display_error($validation,'email'):''?></span>
               <br>
               <div class="form-group">
                  <label for="">Password</label>
                  <input type="password" class="form-control" name="password" placeholder="Enter password"> 
                  <span class="text-danger"><?=isset($validation)?display_error($validation,'password'):''?></span>
               </div>
               <hr>
               <div class="form-group">
                  <button class="btn btn-primary btn-block" type="submit">Login</button> 
               </div>
               <div class="form-group">
                  <a href="<?= base_url('Auth/forgot')?>">Forgot Password?</a>
                  or
                  <a href="<?= base_url('Auth/register')?>">No have account yet ?</a>
               </div>
         </form>
         </div>
      </div>
   </div>
</div>
<?php include '../public/design/footer.php';?>