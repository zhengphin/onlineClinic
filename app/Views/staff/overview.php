<?= $this->extend('layout/staffdashboard-layout');?>
<?= $this->section('content');?>
<Style>
   .stretch-card>.card {
   width: 100%;
   min-width: 100%
   }
   .flex {
   -webkit-box-flex: 1;
   -ms-flex: 1 1 auto;
   flex: 1 1 auto
   }
   .padding {
   padding: 5px;
   }
   .box {
   position: relative;
   border-radius: 0px;
   background: #ffffff;
   border-top: 3px solid #d2d6de;
   margin-bottom: 10px;
   width: 100%;
   box-shadow: 0 1px 1px rgba(0,0,0,0.1);
   }
   .box-header.with-border {
   border-bottom: 1px solid #f4f4f4;
   }
   .box-header {
   color: #444;
   display: block;
   padding: 10px;
   position: relative;
   }
   .box-header:before, .box-body:before, .box-footer:before, .box-header:after, .box-body:after, .box-footer:after {
   content: " ";
   display: table;
   }
   .box-header .box-title {
   display: inline-block;
   font-size: 18px;
   margin: 0;
   line-height: 1;
   }
   h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 {
   font-family: 'Source Sans Pro',sans-serif;
   }
   .box-header:after, .box-body:after, .box-footer:after {
   content: " ";
   display: table;
   }
   .box-body {
   border-top-left-radius: 0;
   border-top-right-radius: 0;
   border-bottom-right-radius: 3px;
   border-bottom-left-radius: 3px;
   padding: 0px;
   }
   .box-body>.table {
   margin-bottom: 0;
   }
   .table-bordered {
   border: 1px solid #f4f4f4;
   }
   .table {
   width: 100%;
   max-width: 100%;
   margin-bottom: 0px;
   }
   table {
   background-color: transparent;
   }
   .table tr td .progress {
   margin-top: 5px;
   }
   .progress-bar-danger {
   background-color: #dd4b39;
   }
   .progress-xs {
   height: 7px;
   }
   .bg-red{
   background-color: #dd4b39 !important;
   color:#fff;
   }
   .badge {
   display: inline-block;
   min-width: 0px;
   padding: 3px 7px;
   font-size: 12px;
   font-weight: 700;
   line-height: 1;
   color: #fff;
   text-align: center;
   white-space: nowrap;
   vertical-align: middle;
   background-color: #777;
   border-radius: 10px;
   }
   .progress-bar-yellow, .progress-bar-warning {
   background-color: #f39c12;
   }
   .bg-yellow{
   background-color: #f39c12;
   }
   .progress-bar-primary {
   background-color: #3c8dbc;
   }
   .bg-light-blue{
   background-color: #3c8dbc;
   }
   .progress-bar-success {
   background-color: #00a65a;
   }
   .bg-green{
   background-color: #00a65a;
   }
   .box-footer {
   border-top-left-radius: 0;
   border-top-right-radius: 0;
   border-bottom-right-radius: 3px;
   border-bottom-left-radius: 3px;
   border-top: 1px solid #f4f4f4;
   padding: 10px;
   background-color: #fff;
   }
   .pull-right {
   float: right!important;
   }
   .pagination>li {
   display: inline;
   }
   .pagination-sm>li:first-child>a, .pagination-sm>li:first-child>span {
   border-top-left-radius: 3px;
   border-bottom-left-radius: 3px;
   }
   .pagination>li:first-child>a, .pagination>li:first-child>span {
   margin-left: 0;
   border-top-left-radius: 4px;
   border-bottom-left-radius: 4px;
   }
   .pagination>li>a {
   background: #fafafa;
   color: #666;
   }
   .pagination-sm>li>a, .pagination-sm>li>span {
   padding: 5px 10px;
   font-size: 12px;
   line-height: 1.5;
   }
   .pagination>li>a, .pagination>li>span {
   position: relative;
   float: left;
   padding: 6px 12px;
   margin-left: -1px;
   line-height: 1.42857143;
   color: #337ab7;
   text-decoration: none;
   background-color: #fff;
   border: 1px solid #ddd;
   }
   a {
   background-color: transparent;
   }
</style>

<h3>Today Date  <?=getTodayDate()?></h3>
<?php if(!empty(session()->getFlashdata('fail'))):?>
            <div class="alert alert-danger"><?= session()->getFlashdata('fail');?></div>
            <?php endif ?>
            <?php if(!empty(session()->getFlashdata('successtobill'))):?>
            <div class="alert alert-success"><?= session()->getFlashdata('successtobill');?></div>
            <?php endif ?>
<div class="page-content page-container" id="page-content1">
   <div class="padding">
      <div class="row container d-flex justify-content-center">
         <div class="col-md-12">
            <div class="box ">
               <div class="box-header bg-danger with-border ">
                  <h3 class="box-title">Waiting</h3>
                  <p  class="float-right">Total:<?= countQueue('waiting',getTodayDate())?></p>
               </div>
               <!-- /.box-header -->
               <div class="box-body" >
                  <table class="table table-bordered" >
                     <tbody >
                        <tr>
                           <th >#</th>
                           <th>Arrival Time</th>
                           <th>Encounter Type</th>
                           <th>Name</th>
                           <th>IC Number</th>
                           <th>Gender</th>
                           <th>Action</th>

                        </tr>
                        <?php
                           if(!empty($todayQueue))
                           {
                               $i=1;
                               foreach($todayQueue as $key => $row)
                           {if($row['status']=='waiting'){
                           ?>
                        
                        <tr id="<?=$row['key']?>">
                           <td><?=$i?></td>
                           <td><?=$row['Arrivaltime']?></td>
                           <td><?=$row['services']?></td>
                           <td>
                           <a href="staff/panel?patient=<?=$row['patientkey']?>"><u><?=getPatientInfoByEmail($row['patientkey'],'name')?></u></a>
                           </td>
                           <td><?=getPatientInfoByEmail($row['patientkey'],'ic')?></td>
                           <td><?=getPatientInfoByEmail($row['patientkey'],'gender')?></td>
                           <td><button id="viewPanel" style="margin:2px;" class="btn btn-info launch" value="<?=getPatientInfoByEmail($row['patientkey'],'name')?>"  onclick="speech('<?=getPatientInfoByEmail($row['patientkey'],'name')?>')">Notify</button>
                           <button id="toProgress" style="margin:2px;" onclick="toProgress('<?=$row['key']?>')" class="btn btn-info launch" value="<?=$row['key']?>">To Progress</button>
                        <button id="remove" style="margin:2px;" onclick="remove('<?=$row['key']?>')" class="btn btn-danger launch" value="<?=$row['key']?>"><i class="fa fa-trash" aria-hidden="true"></i>
</button>
                        </td>
                        </tr>
                        <?php                            $i++;
}}
                             }?>
                     </tbody>
                  </table>
               </div>
               <!-- /.box-body -->
            </div>
         </div>
      </div>
   </div>
</div>
<div class="page-content page-container" id="page-content2">
   <div class="padding">
      <div class="row container d-flex justify-content-center">
         <div class="col-md-12">
            <div class="box">
               <div class="box-header with-border bg-warning">
                  <h3 class="box-title">In Progress</h3>
                  <p  class="float-right">Total:<?= countQueue('progress',getTodayDate())?></p>
               </div>
               <!-- /.box-header -->
               <div class="box-body">
                  <table class="table table-bordered">
                  <tbody >
                        <tr>
                           <th >#</th>
                           <th>Arrival Time</th>
                           <th>Encounter Type</th>
                           <th>Name</th>
                           <th>IC Number</th>
                           <th>Gender</th>
                           <th>Action</th>
                        </tr>
                        <?php
                           if(!empty($todayQueue))
                           {
                               $i=1;
                               foreach($todayQueue as $key => $row)
                           {if($row['status']=='progress'){
                           ?>
                        <tr>
                           <td><?=$i?></td>
                           <td><?=$row['Arrivaltime']?></td>
                           <td><?=$row['services']?></td>
                           <td>                           <a href="staff/panel?patient=<?=$row['patientkey']?>"><u><?=getPatientInfoByEmail($row['patientkey'],'name')?></u></a>
</td>
                           <td><?=getPatientInfoByEmail($row['patientkey'],'ic')?></td>
                           <td><?=getPatientInfoByEmail($row['patientkey'],'gender')?></td>
                           <td>
                           <form action="<?= route_to('staff.toBill'); ?>" method="post" target="_blank">
                           <input type="hidden" name="queueID" value="<?=$row['key']?>"/>
                           <button id="toBilling" type="submit" style="margin:2px;"  class="btn btn-warning launch" >To Billing</button>
                           </form>
                           <button id="toWaiting" onclick="toWaiting('<?=$row['key']?>')" style="margin:2px;" class="btn btn-warning launch" value="<?=$row['key']?>">Reverse</button>

                        </td>

                        </tr>
                        <?php }}
                           $i++;
                             }?>
                     </tbody>
                  </table>
               </div>
               <!-- /.box-body -->
            </div>
         </div>
      </div>
   </div>
</div>
<div class="page-content page-container"  id="page-content3">
   <div class="padding">
      <div class="row container d-flex justify-content-center">
         <div class="col-md-12">
            <div class="box">
               <div class="box-header with-border bg-primary">
                  <h3 class="box-title">Billing</h3>
                  <p  class="float-right">Total:<?= countQueue('to bill',getTodayDate())?></p>
               </div>
               <!-- /.box-header -->
               <div class="box-body">
                  <table class="table table-bordered">
                     <tbody>
                        <tr>
                           <th >#</th>
                           <th>Arrival Time</th>
                           <th>Encounter Type</th>
                           <th>Name</th>
                           <th>IC Number</th>
                           <th>Gender</th>
                           <th>Action</th>
                        </tr>
                        <?php
                           if(!empty($todayQueue))
                           {
                               $i=1;
                               foreach($todayQueue as $key => $row)
                           {
                              if($row['status']=='to bill'){
                           ?>
                        <tr>
                           <td><?=$i?></td>
                           <td><?=$row['Arrivaltime']?></td>
                           <td><?=$row['services']?></td>
                           <td>                           <a href="staff/panel?patient=<?=$row['patientkey']?>"><u><?=getPatientInfoByEmail($row['patientkey'],'name')?></u></a>
</td>
                           <td><?=getPatientInfoByEmail($row['patientkey'],'ic')?></td>
                           <td><?=getPatientInfoByEmail($row['patientkey'],'gender')?></td>
                           <td>

                           <button id="toProgress" onclick="toProgress('<?=$row['key']?>')" style="margin:2px;" class="btn btn-warning launch" value="<?=$row['key']?>">Reverse</button>

                        </td>

                        </tr>
                        <?php }}
                           $i++;
                             }?>
                     </tbody>
                  </table>
               </div>
               <!-- /.box-body -->
            </div>
         </div>
      </div>
   </div>
</div>
<div class="page-content page-container" id="page-content4">
   <div class="padding">
      <div class="row container d-flex justify-content-center">
         <div class="col-md-12">
            <div class="box">
               <div class="box-header with-border bg-success">
                  <h3 class="box-title">Completed</h3>
                  <p  class="float-right">Total:<?= countQueue('completed',getTodayDate())?></p>
               </div>
               <!-- /.box-header -->
               <div class="box-body">
                  <table class="table table-bordered">
                     <tbody>
                        <tr>
                           <th >#</th>
                           <th>Arrival Time</th>
                           <th>Encounter Type</th>
                           <th>Name</th>
                           <th>IC Number</th>
                           <th>Gender</th>
                        </tr>
                        <?php
                           if(!empty($todayQueue))
                           {
                               $i=1;
                               foreach($todayQueue as $key => $row)
                           {if($row['status']=='completed'){
                           ?>
                        <tr>
                           <td><?=$i?></td>
                           <td><?=$row['Arrivaltime']?></td>
                           <td><?=$row['services']?></td>
                           <td>                           <a href="staff/panel?patient=<?=$row['patientkey']?>"><u><?=getPatientInfoByEmail($row['patientkey'],'name')?></u></a>
</td>
                           <td><?=getPatientInfoByEmail($row['patientkey'],'ic')?></td>
                           <td><?=getPatientInfoByEmail($row['patientkey'],'gender')?></td>
                       

                        </tr>
                        <?php }}
                           $i++;
                             }?>
                     </tbody>
                  </table>
               </div>
               <!-- /.box-body -->
            </div>
         </div>
      </div>
   </div>
</div>
                             
<script>
   
   $(document).ready(function()
   {
       setInterval(function(){
         $("#page-content1").load(" #page-content1 > *");
         $("#page-content2").load(" #page-content2 > *");
         $("#page-content3").load(" #page-content3 > *");
         $("#page-content4").load(" #page-content4 > *");

       },5000);
       });
</script>
<script>
function remove(value){
   var key=value 

   $('#'+key).remove();
   ajaxRequestRemove(key);


}
function toWaiting(value)
{
   var key=value 
   ajaxRequestToWaiting(key);
}
function toProgress(value)
{
 
   var key=value 
   ajaxRequest(key);
}
function speech(value) {
  // stop any speaking in progress
  window.speechSynthesis.cancel(); 
  var name=value 
  //alert(name);

  var appenText=" Now is your turn";
   var result=name.concat(appenText);
    const utterance = new SpeechSynthesisUtterance(result);
    utterance.lang= 'en-US'; //en-US id-ID
  utterance.rate = 0.7; window.speechSynthesis.speak(utterance);
}
/*
function speech() {
  // stop any speaking in progress
  window.speechSynthesis.cancel();
var name=document.getElementById("viewPanel").value;
var appenText=" Sekarang giliran anda";
var result=name.concat(appenText);
const utterance = new SpeechSynthesisUtterance(result);
utterance.lang= 'id-ID';
utterance.rate = 0.7;  
window.speechSynthesis.speak(utterance);
}
/*
$("#viewPanel").click(function() {
   var name  = $(this).val();
   var appenText=" Sekarang giliran anda";
   var result=name.concat(appenText);
   const utterance = new SpeechSynthesisUtterance(result);
   utterance.lang= 'id-ID';
   utterance.rate = 0.7;  
   window.speechSynthesis.speak(utterance);

});*/
function ajaxRequestRemove(key){
  $.ajax({
    url:"<?=site_url('handle-myajax-remove')?>",//current url
    type:"POST",
    data:{
      key:key.toString(),
   
    },
    dataType:'JSON',
    success:function(response){
      $('.result').html(response);
      
      if(!alert('Queue remove successfully.'))
      {
       //  var key=document.getElementById("remove").value;
        // $('#'+key).remove();
        //console.log(response);
         //window.location.reload();
         
      }

    }
  });
}
function ajaxRequest(key){
  $.ajax({
    url:"<?=site_url('handle-myajax-progress')?>",//current url
    type:"POST",
    data:{
      key:key.toString(),
      
    },
    dataType:'JSON',
    success:function(response){
      $('.result').html(response);
      if(!alert('Queue updated successfully.'))
      {
    
         //window.location.reload();
      
      }

    }
  });
}
function ajaxRequestToWaiting(key){
  $.ajax({
    url:"<?=site_url('handle-myajax-waiting')?>",//current url
    type:"POST",
    data:{
      key:key.toString(),
      
    },
    dataType:'JSON',
    success:function(response){
      $('.result').html(response);
      if(!alert('Queue updated successfully.'))
      {
    
         //window.location.reload();
      
      }

    }
  });
}
  </script>
<?=$this->endSection();?>