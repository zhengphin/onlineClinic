<?= $this->extend('layout/dashboard-layout');?>
<?= $this->section('content');?>

<div id="booking" class="section">
   <div class="section-center">
   <?php if(!empty(session()->getFlashdata('fail'))):?>
            <div class="alert alert-danger"><?= session()->getFlashdata('fail');?></div>
            <?php endif ?>
            <?php if(!empty(session()->getFlashdata('success'))):?>
            <div class="alert alert-success"><?= session()->getFlashdata('success');?></div>
            <?php endif ?>
      <div class="container">
         <div class="row justify-content-center">
            <div class="booking-form card p-3 bg-info">
               <div class="form-header">
                  <h4>Appointment Form  <i class="far fa-calendar-alt"></i></h4>
                  <p>To schedule appointment , please fill out the information below</p>
                  <hr class="mt-2 mb-2"/>
               </div>
               <form action="<?=base_url('patient/appointment');?>" method="post">
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                           <span class="form-label text-light">Do you have allergies?</span>
                           <div class="form-group" >
                              <input type="radio"  name="allergies" value="Yes" required <?php echo set_radio('allergies','Yes');?>/>Yes
                              <input type="radio" name="allergies" value="No"  <?php echo set_radio('allergies','No');?>/>No                              
                           </div>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <span class="form-label text-light">I am registering for</span>
                           <div class="form-group">
                              <select class="form-control"  name="who"  id = "ddlwho" onchange = "ShowHideDiv2()" required>
                                 <option value="" selected hidden>----------</option>
                                 <option value="My Self" <?php echo  set_select('who', 'My Self'); ?>>My Self</option>
                                 <option value="Others" <?php echo  set_select('who', 'Others'); ?>>Others</option>
                              </select>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-4" id="ss"  style="display: none">
                        <div class="form-group">             
                           <span class="form-label">Full Name</span>
                           <input class="form-control" id="name" name="name" type="text" value="<?php echo set_value('name') ?>" >
                           <?php if(!empty(session()->getFlashdata('nameError'))):?>
                        <div class="text-warning h5"><?= session()->getFlashdata('nameError');?></div>
                          <?php endif ?>
                        </div>   
                     </div>
                     <div  class="col-md-4" id="sd" style="display: none">
                        <div class="form-group">             
                           <span class="form-label">IC Number</span>
                           <input class="form-control" id="ic" name="ic" type="text" placeholder="no need dash"  value="<?php echo set_value('ic') ?>" >
                           <?php if(!empty(session()->getFlashdata('icError'))):?>
                        <div class="text-warning h5"><?= session()->getFlashdata('icError');?></div>
                          <?php endif ?>
                        </div>
                     </div>
                     <div  class="col-md-4" id="sf"  style="display: none">
                        <div class="form-group">             
                           <span class="form-label">Contact Number</span>
                           <input class="form-control" id="contact" name="contact" type="text" placeholder="no need dash"  value="<?php echo set_value('contact') ?>" >
                           <?php if(!empty(session()->getFlashdata('contactError'))):?>
                        <div class="text-warning h5"><?= session()->getFlashdata('contactError');?></div>
                          <?php endif ?>
                        </div>
                     </div>
                     <div  class="col-md-4" id="sh"  style="display: none">
                        <div class="form-group">             
                           <span class="form-label">Postcode</span>
                           <input class="form-control" id="postcode" name="postcode" type="text" placeholder=""   value="<?php echo set_value('postcode') ?>" >
                           <?php if(!empty(session()->getFlashdata('postcodeError'))):?>
                        <div class="text-warning h5"><?= session()->getFlashdata('postcodeError');?></div>
                          <?php endif ?>
                        </div>
                     </div>
                     <div class="col-md-12" id="sg"  style="display: none">
                        <div class="form-group">             
                           <span class="form-label">Home Address</span>
                           <input class="form-control" id="address" name="address" type="text" placeholder=""  >
                           <?php if(!empty(session()->getFlashdata('addressError'))):?>
                        <div class="text-warning h5"><?= session()->getFlashdata('addressError');?></div>
                          <?php endif ?>

                        </div>
                     </div>
                     
                     <div class="col-md-12">
                        <div class="form-group">             
                           <label for="appt-time" class="text-dark">
                           Mon-Sat(9am-11pm) Sun(9am-11am)
                           </label>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">             
                           <span class="form-label">Date</span>
                           <?php 
                              date_default_timezone_set('Asia/Kuala_Lumpur');
                              $DATE = date('Y-m-d');
                              ?>
                           <input class="form-control" id="date" value="<?php echo set_value('appdate') ?>" name="appdate" type="date" min="<?=$DATE?>"  max="2030-12-31" required>
                           <?php if(!empty(session()->getFlashdata('appdateError'))):?>
                           <div class="text-warning h5"><?= session()->getFlashdata('appdateError');?></div>
                          <?php endif ?>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group"> 
                           <span class="form-label">Time</span>
                           <input class="form-control" value="<?php echo set_value('apptime') ?>"type="time" name="apptime" min="09:00" max="23:00" required> 
                           <?php if(!empty(session()->getFlashdata('apptimeError'))):?>
                        <div class="text-warning h5"><?= session()->getFlashdata('apptimeError');?></div>
                          <?php endif ?>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                           <span class="select-arrow"></span> <span class="form-label">Select consult mode</span> 
                           <select class="form-control" name="mode"  id = "ddlType" onchange = "ShowHideDiv()" required>
                              <option value="" selected hidden>----------</option>
                              <option value="Walk In" name="type"<?php echo  set_select('mode', 'Walk In'); ?> >Walk In</option>
                              <option value="E-Consult" name="type"<?php echo  set_select('mode', 'E-Consult'); ?> >E-Consult</option>
                           </select>
                        </div>
                     </div>
                     <div class="col-md-6" id="servicestype"  style="display: none">
                        <div class="form-group">
                           <span class="select-arrow"></span> <span class="form-label">Service Type</span> 
                           <select class="form-control" name="services"  >
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
                     <div class="col-md-12">
                        <div class="form-group">
                        <?php if(!empty(session()->getFlashdata('reasonError'))):?>
                        <div class="text-warning h5"><?= session()->getFlashdata('reasonError');?></div>
                          <?php endif ?>
                           <span class="select-arrow"></span> <span class="form-label">Briefly explain reason</span> 
                           <textarea class="form-control"  name="reason" id="exampleFormControlTextarea1" rows="3" required><?php echo set_value('reason') ?></textarea>
                          
                           
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <input type="submit" class="btn btn-warning">
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script type="text/javascript">

   function ShowHideDiv() {
       var ddlType = document.getElementById("ddlType");
       var servicestype = document.getElementById("servicestype");
       servicestype.style.display = ddlType.value == "Walk In" ? "block" : "none";
   }
   function showAddress() {
      ShowHideDiv();
   }
/*
$("#ddlwho").change(function() {
  var cloneCount = $(this).find(":selected").text();
  $("#Div_Quick_Clone").find("div.row").remove();
  for (var i = 1; i <= cloneCount; i++) {
    $("#Div_Quick_Clone").append('<div class="row" style="margin-top:10px;"> Serial Number:<input type="text" name="" class="form-control "> <div>  </div> </div>');
  }
});
*/

   function ShowHideDiv2() {
       var ddlwho = document.getElementById("ddlwho");
       
       var ss = document.getElementById("ss");//name
       var ic = document.getElementById("sd");//ic
       var contact = document.getElementById("sf");//contact
       var address = document.getElementById("sg");//address
       var postcode = document.getElementById("sh");//address

       ss.style.display = ddlwho.value == "Others" ? "block" : "none";
       ic.style.display = ddlwho.value == "Others" ? "block" : "none";
       contact.style.display = ddlwho.value == "Others" ? "block" : "none";
       address.style.display = ddlwho.value == "Others" ? "block" : "none";
       postcode.style.display = ddlwho.value == "Others" ? "block" : "none";

   }

function gg(){
   ShowHideDiv();
}
function ggg(){
   ShowHideDiv();

   ShowHideDiv2();
}
</script>

<?php 

if(!empty(session()->getFlashdata('otherForm')))
{
  echo '<script>',
  'ggg();',
  '</script>';
}
/*
 if(!empty(session()->getFlashdata('showAddress')))
 {
   echo '<script>',
   'gg();',
   '</script>';
 }
*/
?>
<?=$this->endSection();?>