<?= $this->extend('layout/staffdashboard-layout');?>
<?= $this->section('content');?>
<div class="container py-5">
   <div class="row">
      <div class="col-md-10 mx-auto">
      <form action="<?=base_url('Lab/update');?>" method="post">
            <?= csrf_field(); ?>
            <?php if(!empty(session()->getFlashdata('failUploadReport'))):?>
            <div class="alert alert-danger"><?= session()->getFlashdata('failUploadReport');?></div>
            <?php endif ?>
           <?php if(!empty(session()->getFlashdata('failab'))):?>
            <div class="alert alert-danger"><?= session()->getFlashdata('failab');?></div>
            <?php endif ?>
            <?php if(!empty(session()->getFlashdata('successlab'))):?>
            <div class="alert alert-success"><?= session()->getFlashdata('successlab');?></div>
            <?php endif ?>
            <input type="hidden" id="key" name="key"  value="<?=$labData['key']?>">

            <div class="form-group row">
               <div class="col-sm-6">
                  <label for="inputFirstname">Test Name</label>
                  <input type="text" class="form-control" id="inputname" name="name" placeholder="Enter test name"
                  <?php 
                            if(empty(session()->getFlashdata('error'))){
                            ?>
                            value="<?=$labData['testname']?>"
                            
                            <?php }if(!empty(session()->getFlashdata('error'))){?>
                            value="<?php echo set_value('name') ?>"
                           <?php }?>   
                           >
                            <?php if(!empty(session()->getFlashdata('nameError'))):?>
                        <div class="text-danger"><?= session()->getFlashdata('nameError');?></div>
                          <?php endif ?>

                            </div>
                            <div class="col-sm-6">
                  <label for="inputLastname">Laboratory</label>
                  <input type="text" class="form-control" id="inputDescription" name="laboratory" placeholder="Enter description"
                  <?php 
                            if(empty(session()->getFlashdata('error'))){
                            ?>
                            value="<?=$labData['laboratory']?>"
                            
                            <?php }if(!empty(session()->getFlashdata('error'))){?>
                            value="<?php echo set_value('laboratory') ?>"
                           <?php }?>   
                           >
                            <?php if(!empty(session()->getFlashdata('laboratoryError'))):?>
                        <div class="text-danger"><?= session()->getFlashdata('laboratoryError');?></div>
                          <?php endif ?>

               </div>
            <div class="col-sm-6">
                  <label for="inputLastname">Specimens</label>
                  <input type="text" class="form-control" id="inputDescription" name="specimens" placeholder="Enter description"
                  <?php 
                            if(empty(session()->getFlashdata('error'))){
                            ?>
                            value="<?=$labData['specimens']?>"
                            
                            <?php }if(!empty(session()->getFlashdata('error'))){?>
                            value="<?php echo set_value('specimens') ?>"
                           <?php }?>   
                           >
                            <?php if(!empty(session()->getFlashdata('specimensError'))):?>
                        <div class="text-danger"><?= session()->getFlashdata('specimensError');?></div>
                          <?php endif ?>

               </div>
            <div class="col-sm-6">
                  <label for="inputLastname">Description</label>
                  <input type="text" class="form-control" id="inputDescription" name="desc" placeholder="Enter description"
                  <?php 
                            if(empty(session()->getFlashdata('error'))){
                            ?>
                            value="<?=$labData['desc']?>"
                            
                            <?php }if(!empty(session()->getFlashdata('error'))){?>
                            value="<?php echo set_value('desc') ?>"
                           <?php }?>   
                           >
                            <?php if(!empty(session()->getFlashdata('descError'))):?>
                        <div class="text-danger"><?= session()->getFlashdata('descError');?></div>
                          <?php endif ?>

               </div>
               <div class="col-sm-6">
                  <label for="inputLastname">Status</label>
                  <select  class="form-control" name="status" required>
                     <option value="processing"
                     <?php
                            if($labData['status']=="processing")
                            {
                            echo "selected";
                            }else{
                                echo "";
                            }
                            ?>
                     >processing</option>
                     <option value="completed"
                     <?php
                            if($labData['status']=="completed")
                            {
                            echo "selected";
                            }else{
                                echo "";
                            }
                            ?>
                     >completed </option>
                  </select>

               </div>
                            

                            </div>
                            
            <button type="submit" class="btn btn-success px-4 float-right">Save</button>
         </form>
         
      </div>
      
   </div>
   
</div>
<div class="container py-5">
   <div class="row">
      <div class="col-md-10 mx-auto">
      <form action="<?=route_to('lab.uploadPdf');?>" method="post"  enctype="multipart/form-data">
            <?= csrf_field(); ?>
            <input type="hidden" id="key" name="key"  value="<?=$labData['key']?>">

            <div class="form-group row">
               <div class="col-sm-6">
                  <label for="inputFirstname">Upload Laboratory Report</label>
                  <input type="file" id="labReport" name="labReport"><br><br>


                  </div>
            </div>
 
            <button type="submit" class="btn btn-success px-4 float-left">Upload</button>
         </form>
         
      </div>
      
   </div>
   
</div>

<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>

<script>
   function ajaxRequest(url){
  $.ajax({
    url:"<?=site_url('handle-myajax-uploadPdf')?>",//current url
    type:"POST",
    data:{
      name:url.toString(),
      key:"<?=$labData['key']?>"
    },
    dataType:'JSON',
    success:function(response){
      $('.result').html(response);
      if(!alert('Report Upload Succesfully.')){
         
      }
    
    }
  });
}
 function upload() {
  
   var file_object = fetch('../../labReport/users/<?=session()->getFlashdata('dir')?>') 
          .then(r => r.blob())
          .then(blob => {
              var file_name = '<?=session()->getFlashdata('filename')?>'; //e.g ueq6ge1j_name.jpeg
              var file_object = new File([blob], file_name, {type: 'application/pdf'});
              console.log(file_object); //Output
              var storageRef=firebase.storage().ref('labReport/'+file_name);
              var uploadTask=storageRef.put(file_object);
              uploadTask.on('state_changed',function (snapshot) {
    
        var progress=(snapshot.bytesTransferred/snapshot.totalBytes)*100;
        console.log("upload is " + progress +" done");
    },function (error) {
        //handle error here
        alert("Upload Report Failed....");
        console.log(error.message);
    },function () {
       //handle successful uploads on complete
       uploadTask.snapshot.ref.getDownloadURL().then(function (downlaodURL) {
            //get your upload image url here...
            //upload url to realtime database
            //ajax
            //updateUrl(downlaodURL);
            ajaxRequest(downlaodURL);
            console.log(downlaodURL);
        });
           });
         });
      
}
</script>
<?php
if(!empty(session()->getFlashdata('processing'))){
  echo '<script>',
                             'upload();',
                             '</script>';
}  
?>
<?=$this->endSection();?>