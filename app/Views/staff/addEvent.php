<?= $this->extend('layout/staffdashboard-layout');?>
<?= $this->section('content');?>
<script>
  function ajaxRequest(url){
  $.ajax({
    url:"<?=site_url('handle-myajax-event')?>",//current url
    type:"POST",
    data:{
      name:url.toString(),
      key:"<?=session()->getFlashdata('eventKey')?>"
    },
    dataType:'JSON',
    success:function(response){
      $('.result').html(response);
      if(!alert('Event Posted Successfully.')){window.location.reload();}
      
    }
  });
}
</script>
<script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<div class="container py-5">
   <div class="row">
      <div class="col-md-10 mx-auto">
      <form action="<?=route_to('staff.saveEvent');?>" method="post" enctype="multipart/form-data">
            <?= csrf_field(); ?>
           <?php if(!empty(session()->getFlashdata('failEvent'))):?>
            <div class="alert alert-danger"><?= session()->getFlashdata('failEvent');?></div>
            <?php endif ?>
            <?php if(!empty(session()->getFlashdata('successEvent'))):?>
            <div class="alert alert-success"><?= session()->getFlashdata('successEvent');?></div>
            <?php endif ?>
            <div class="form-group row">
               <div class="col-sm-12">
                  <label for="inputFirstname">Event Title</label>
                  <input type="text" class="form-control" id="inputname" name="name" placeholder="Enter title name"value="<?php echo set_value('name') ?>">
                  <span class="text-danger"><?=isset($validation)?display_error($validation,'name'):''?></span>

               </div>
               <div class="col-sm-12">
                  <label for="inputLastname">Description</label>
                  <input type="text"  class="form-control" id="inputDescription" name="description" placeholder="Enter description"value="<?php echo set_value('description') ?>">
                  <span class="text-danger"><?=isset($validation)?display_error($validation,'description'):''?></span>

               </div>
            </div>
            <div class="form-group row">
            
               <div class="col-sm-6">
                  <label for="inputAddressLine2">Validity</label>
                  <input type="number" min="1" class="form-control" id="inputAddressLine2" name="Validity" placeholder="Enter Validity Of The Event"value="<?php echo set_value('Validity') ?>" required>
                  <span class="text-danger"><?=isset($validation)?display_error($validation,'Validity'):''?></span>

               </div>
               <div class="col-sm-6">
                  <label for="inputFirstname">Upload Image(Optional)</label>
                  <input type="file" id="image" name="image"><br><br>
                  <span class="text-danger"><?=isset($validation)?display_error($validation,'image'):''?></span>

                  

                  </div>
            
            </div>
          
            <div class="form-group row">
            
            
            </div>
            <button type="submit" class="btn btn-success px-4 float-right">Save</button>
         </form>
      </div>
   </div>
</div>
<script>
  
function newImage(src){
    var tmp = new Image();
    tmp.src = src;
    return tmp
}
    function upload() {
 
    var img = newImage("../../images/event/<?=session()->getFlashdata('dir')?>");
    fetch(img.src).then(res => res.blob()).then(blob => 
    {var image = new File([blob], '<?=session()->getFlashdata('dir')?>', blob)
      console.log(image);
    var imageName=image.name;
    var storageRef=firebase.storage().ref('imageEvent/'+imageName);
    //upload image to selected storage reference

    var uploadTask=storageRef.put(image);
    uploadTask.on('state_changed',function (snapshot) {
        var progress=(snapshot.bytesTransferred/snapshot.totalBytes)*100;
        console.log("upload is " + progress +" done");
    },function (error) {
        //handle error here
        alert("Upload Profile Image Failed....");
        console.log(error.message);
    },function () {
       //handle successful uploads on complete
        uploadTask.snapshot.ref.getDownloadURL().then(function (downlaodURL) {
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
