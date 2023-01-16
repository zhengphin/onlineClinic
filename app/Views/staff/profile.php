<?= $this->extend('layout/staffdashboard-layout');?>
<?= $this->section('content');
use App\Libraries\FirebaseCon;
use App\Libraries\StaffLib;
?>

 <!-- Main content -->
 <?php if(!empty(session()->getFlashdata('success'))):?>
            <div class="alert alert-success"><?= session()->getFlashdata('success');?></div>
            <?php endif ?>
            <?php if(!empty(session()->getFlashdata('fail'))):?>
            <div class="alert alert-danger"><?= session()->getFlashdata('fail');?></div>
            <?php endif ?>
 <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">
            <!-- Profile Image -->
            <div class="card card-primary card-outline bg-light">
              <div class="card-body box-profile">
                <div class="text-center">
                <?php if(isset($userInfo['img'])&&!empty($userInfo['img'])):?>
                  <img class="profile-user-img " id="gg"
                       src="<?=$userInfo['img']?>"
                       alt="User profile picture">
                  <?php endif ?>
                  <?php if(!isset($userInfo['img'])||empty($userInfo['img'])):?>
                  <img class="profile-user-img " id="gg"
                       src="../../dist/img/usericon.png"
                       alt="User profile picture">
                  <?php endif ?>
            
            
                </div>
           
                <h3 class="profile-username text-center"><?=$userInfo['name']?></h3>

                <p class="text-muted text-center">Create At: <?=$userInfo['createdDatenTime']?></p>
                <p class="text-muted text-center"><strong>Position: </strong> <?=$userInfo['position']?></p>

                <div class="form-group">
               
            <form enctype="multipart/form-data" action=" <?=base_url('staff/uploadImage');?>" method="post">
        <label>select image : </label>
        <input type="file" id="image" name="image" ><br><br>
        <input  type="submit" class="btn btn-primary btn-block"  value="upload">
        </form>
               </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">About Me</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <strong><i class="fas fa-address-card mr-1"></i> Identity Number</strong>

                <p class="text-muted">
                <?=$userInfo['ic']?>
                </p>

                <hr>
                <strong><i class="fas fa-map-marker-alt mr-1"></i>State</strong>

                <p class="text-muted"> 
              <?=$userInfo['state']?>
                </p>
                <hr>

                <strong><i class="fas fa-phone-alt mr-1"></i> Contact Number</strong>

                <p class="text-muted">
                  <span class="tag tag-danger"><?=$userInfo['phone']?></span>
                </p>

                <hr>

                <strong><i class="fas fa-mars mr-1"></i>Gender</strong>
                <p class="text-muted"><?=$userInfo['gender']?></p>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link 
                  <?php 
                  if(!empty(session()->getFlashdata('passError'))){
                    echo "";
                  }else{
                    echo "active";

                  }

                  ?>
                  " href="#settings " data-toggle="tab">Update Profile</a></li>
                  <li class="nav-item"><a class="nav-link 
                  <?php 
                  if(!empty(session()->getFlashdata('passError'))){
                    echo "active";
                  }else{
                    echo "";

                  }

                  ?>
                  " href="#change" data-toggle="tab">Change Password</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
              
                

                <div class="
                <?php 
                  if(!empty(session()->getFlashdata('passError'))){
                    echo "";
                  }else{
                    echo "active";

                  }

                  ?>
                tab-pane" id="settings">
                  <form class="form-horizontal" action="<?=route_to('staff.updateProfile');?>" method="post">
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputName" name="name" placeholder="Name" value="<?=$userInfo['name']?>">
                          <?php if(!empty(session()->getFlashdata('nameError'))):?>
                        <div class="text-danger"><?= session()->getFlashdata('nameError');?></div>
                          <?php endif ?>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                          <input type="email" class="form-control" id="inputEmail"  name="email" placeholder="Email" disabled value="<?=$userInfo['email']?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputName2" class="col-sm-2 col-form-label">Contact </label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputphone"  name="contact"  placeholder="phone number" value="<?=$userInfo['phone']?>">
                          <?php if(!empty(session()->getFlashdata('contactError'))):?>
                        <div class="text-danger"><?= session()->getFlashdata('contactError');?></div>
                          <?php endif ?>                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputName2" class="col-sm-2 col-form-label">Identity </label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputic"  name="identityNum"  placeholder="ic number" value="<?=$userInfo['ic']?>">
                          <?php if(!empty(session()->getFlashdata('icError'))):?>
                        <div class="text-danger"><?= session()->getFlashdata('icError');?></div>
                          <?php endif ?>                        </div>
                      </div>
                     
                    
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-primary ">Update</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <div class="
                  <?php 
                  if(!empty(session()->getFlashdata('passError'))){
                    echo "active";
                  }

                  ?>
                  tab-pane" id="change">
                  <form class="form-horizontal" action="<?=route_to('staff.updatePassword');?>" method="post">
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Current Password</label>
                        <div class="col-sm-10">
                          <input type="password" class="form-control"  name="currentp" >
                          <?php if(!empty(session()->getFlashdata('currentPError'))):?>
                        <div class="text-danger"><?= session()->getFlashdata('currentPError');?></div>
                          <?php endif ?>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">New Password</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control"  name="newpassword"  >  
                          <?php if(!empty(session()->getFlashdata('newPError'))):?>
                        <div class="text-danger"><?= session()->getFlashdata('newPError');?></div>
                          <?php endif ?>
                          <?php if(!empty(session()->getFlashdata('existingPasswordError'))):?>
                        <div class="text-danger"><?= session()->getFlashdata('existingPasswordError');?></div>
                          <?php endif ?>
                        </div>    
                      </div>
                      <div class="form-group row">
                        <label for="inputName2" class="col-sm-2 col-form-label">Confirm  Password </label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control"   name="cpassword" >  
                          <?php if(!empty(session()->getFlashdata('cPError'))):?>
                        <div class="text-danger"><?= session()->getFlashdata('cPError');?></div>
                          <?php endif ?>                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-primary ">Update</button>
                        </div>
                      </div>
                      </div>
                     
                    </form>
                 
                  <!-- /.tab-pane -->
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
     
    </section>
    <!-- /.content -->
<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>

<!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#config-web-app -->

<script>

function a() {
    //var x1="<?=session()->getFlashdata('dir')?>";
    //alert("The variable named x1 has value:  " + x1);
    const img = document.getElementById('gg');
    fetch(img.src).then(res => res.blob()).then(blob => 
    {var file = new File([blob], 'dot.jpg', blob)
      console.log(file);
      var imageName=file.name;
      alert("The variable named x1 has value:  " + imageName);
    });



}


function ajaxRequest(url){
  $.ajax({
    url:"<?=site_url('handle-myajax2')?>",//current url
    type:"POST",
    data:{
      name:url.toString(),
      key:"<?=$userInfo['key']?>",
      email:"<?=$userInfo['email']?>"
    },
    dataType:'JSON',
    success:function(response){
      $('.result').html(response);
      if(!alert('Image Upload Succesfully.')){window.location.reload();}

      //window.location.reload();
      //window. onbeforeunload = function() { return “Profile Image Upload Successfully”; };
      //alert("Upload Profile Image Successfully.");
    }
  });
}

function newImage(src){
    var tmp = new Image();
    tmp.src = src;
    return tmp
}
//src="../../images/users/1667096671_0efeb6b0bdb95e6bf995.jpg"
    function upload() {
    //get your select image
    //var image=document.getElementById("image").files[0];
    //console.log(image);
    //const img = document.getElementById('gg');
    var img = newImage("../../images/users/<?=session()->getFlashdata('dir')?>");
    fetch(img.src).then(res => res.blob()).then(blob => 
    {var image = new File([blob], '<?=session()->getFlashdata('dir')?>', blob)
      console.log(image);
    //var imageName=file.name;
       //now get your image name
    var imageName=image.name;
    //firebase  storage reference
    //it is the path where yyour image will store
    var storageRef=firebase.storage().ref('image/'+imageName);
    //upload image to selected storage reference

    var uploadTask=storageRef.put(image);

    uploadTask.on('state_changed',function (snapshot) {
        //observe state change events such as progress , pause ,resume
        //get task progress by including the number of bytes uploaded and total
        //number of bytes
        var progress=(snapshot.bytesTransferred/snapshot.totalBytes)*100;
        console.log("upload is " + progress +" done");
    },function (error) {
        //handle error here
        alert("Upload Profile Image Failed....");

        console.log(error.message);
    },function () {
       //handle successful uploads on complete
       const img = document.getElementById('gg');
       //alert("Upload Successfully:  " + imageName);
        //herela
      // alert("Upload Profile Image Successfully.");
       //img.src="../../images/users/<?=session()->getFlashdata('dir')?>";
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