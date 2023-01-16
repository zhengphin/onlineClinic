<?php include '../public/design/header.php';?>
<div class="light-background-color">
   <div class="container py-2 py-lg-4 position-relative">
      <div class="row align-items-center justify-content-between">
         <div class="row col-lg-6">
            <img src="<?= base_url('landingPage/img/register.png')?>" alt="">
         </div>
         <div class="col-lg-5 my-5 my-lg-0">
            <div class="primary-color" style="height: 7px; width: 94px"></div>
            <h2 class="h3 text-color" style="margin-top:15px">
               REGISTER NOW
            </h2>
            <form action="<?=base_url('Auth/save');?>" method="post">
            <?= csrf_field(); ?>
           <?php if(!empty(session()->getFlashdata('fail'))):?>
            <div class="alert alert-danger"><?= session()->getFlashdata('fail');?></div>
            <?php endif ?>
            <?php if(!empty(session()->getFlashdata('success'))):?>
            <div class="alert alert-success"><?= session()->getFlashdata('success');?></div>
            <?php endif ?>
               <div class="form-group">
                  <label for="">Name</label>
                  <input type="text" class="form-control" name="name" placeholder="Enter your name" value="<?php echo set_value('name') ?>">  
                  <span class="text-danger"><?=isset($validation)?display_error($validation,'name'):''?></span>
               </div>
               <div class="form-group">
                  <label for="">Email</label>
                  <input type="text" class="form-control" name="email" placeholder="Enter your email" value="<?php echo set_value('email') ?>">  
                  <span class="text-danger"><?=isset($validation)?display_error($validation,'email'):''?></span>

               </div>
               
               <div class="form-group">
                  <label for="">Contact Number (+60)</label>
                  <input type="text" class="form-control" name="contact" placeholder="Enter your contact number without -" value="<?php echo set_value('contact') ?>">  
                  <span class="text-danger"><?=isset($validation)?display_error($validation,'contact'):''?></span>

               </div>
               <div class="form-group">
                  <label for="">Identity Number (No Dash)</label>
                  <input type="text" class="form-control" name="identityNum" placeholder="Enter your identity number without -" value="<?php echo set_value('identityNum') ?>">  
                  <span class="text-danger"><?=isset($validation)?display_error($validation,'identityNum'):''?></span>

               </div>
               <div class="form-group">
                  <label for="">Home Address</label>
                  <input type="text" class="form-control" name="address" placeholder="Enter your home address" value="<?php echo set_value('address') ?>">  
                  <span class="text-danger"><?=isset($validation)?display_error($validation,'address'):''?></span>

               </div>
               <div class="form-group">
                  <label for="">Post Code</label>
                  <input type="text" class="form-control" name="postcode" placeholder="Enter your post code" value="<?php echo set_value('postcode') ?>">  
                  <span class="text-danger"><?=isset($validation)?display_error($validation,'postcode'):''?></span>

               </div>
               <div class="form-group">
                  <label for="">Password</label>
                  <input type="password" class="form-control" name="password" placeholder="Enter your password"> 
                  <span class="text-danger"><?=isset($validation)?display_error($validation,'password'):''?></span>

                </div>
               <div class="form-group">
                  <label for="">Confirm Password</label>
                  <input type="password" class="form-control" name="cpassword" placeholder="Enter your password"> 
                  <span class="text-danger"><?=isset($validation)?display_error($validation,'cpassword'):''?></span>

                </div>
               <hr>
               <div class="form-group">
                  <button class="btn btn-primary btn-block" type="submit">Sign up</button> 
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
<?php include '../public/design/footer.php';?>