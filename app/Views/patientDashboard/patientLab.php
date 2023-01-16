<?= $this->extend('layout/dashboard-layout');?>
<?= $this->section('content');?>
<style>
   
   body{
   background-color:#B3E5FC;
   }
   .card-1{
   border: none;
   border-radius: 10px;
   width: 80%;
   background-color: #fff;
   margin-left:120px;
   }
   .icons i {
   margin-left: 20px;
   }
   .modal-confirm {		
         color: #434e65;
         width: 525px;
         }
         .modal-confirm .modal-content {
         padding: 20px;
         font-size: 16px;
         border-radius: 5px;
         border: none;
         }
         .modal-confirm .modal-header {
         background: #47c9a2;
         border-bottom: none;   
         position: relative;
         text-align: center;
         margin: -20px -20px 0;
         border-radius: 5px 5px 0 0;
         padding: 35px;
         }
         .modal-confirm h4 {
         text-align: center;
         font-size: 36px;
         margin: 10px 0;
         }
         .modal-confirm .form-control, .modal-confirm .btn {
         min-height: 40px;
         border-radius: 3px; 
         }
         .modal-confirm .close {
         position: absolute;
         top: 15px;
         right: 15px;
         color: #fff;
         text-shadow: none;
         opacity: 0.5;
         }
         .modal-confirm .close:hover {
         opacity: 0.8;
         }
         .modal-confirm .icon-box {
         color: #fff;		
         width: 95px;
         height: 95px;
         display: inline-block;
         border-radius: 50%;
         z-index: 9;
         border: 5px solid #fff;
         padding: 15px;
         text-align: center;
         }
         .modal-confirm .icon-box i {
         font-size: 64px;
         margin: -4px 0 0 -4px;
         }
         .modal-confirm.modal-dialog {
         margin-top: 80px;
         }
         .modal-confirm .btn, .modal-confirm .btn:active {
         color: #fff;
         border-radius: 4px;
         background: #eeb711 !important;
         text-decoration: none;
         transition: all 0.4s;
         line-height: normal;
         border-radius: 30px;
         margin-top: 10px;
         padding: 6px 20px;
         border: none;
         }
         .modal-confirm .btn:hover, .modal-confirm .btn:focus {
         background: #eda645 !important;
         outline: none;
         }
         .modal-confirm .btn span {
         margin: 1px 3px 0;
         float: left;
         }
         .modal-confirm .btn i {
         margin-left: 1px;
         font-size: 20px;
         float: right;
         }
         .trigger-btn {
         display: inline-block;
         margin: 100px auto;
         }
         .pagination {
         float: right;
         margin: 0 0 5px;
         }
         .pagination li a {
         border: none;
         font-size: 13px;
         min-width: 30px;
         min-height: 30px;
         color: #999;
         margin: 0 2px;
         line-height: 30px;
         border-radius: 2px !important;
         text-align: center;
         padding: 0 6px;
         }
         .pagination li a:hover {
         color: #666;
         }	
         .pagination li.active a {
         background: #03A9F4;
         }
         .pagination li.active a:hover {        
         background: #0397d6;
         }
         .pagination li.disabled i {
         color: #ccc;
         }
         .pagination li i {
         font-size: 16px;
         padding-top: 6px
         }
         .hint-text {
         float: left;
         margin-top: 10px;
         font-size: 13px;
         }    
         body {
         color: #566787;
         background: #f5f5f5;
         font-family: 'Roboto', sans-serif;
         }
         .table-responsive {
         margin: 30px 0;
         }
         .table-wrapper {
         width: 900px;
         background: #fff;
         margin: 0 auto;
         padding: 20px 30px 5px;
         box-shadow: 0 0 1px 0 rgba(0,0,0,.25);
         }
         .table-title .btn-group {
         float: right;
         }
         .table-title .btn {
         min-width: 50px;
         border-radius: 2px;
         border: none;
         padding: 6px 12px;
         font-size: 95%;
         outline: none !important;
         height: 30px;
         }
         .table-title {
         min-width: 100%;
         border-bottom: 1px solid #e9e9e9;
         padding-bottom: 15px;
         margin-bottom: 5px;
         background: purple;
         margin: -20px -31px 10px;
         padding: 15px 30px;
         color: #fff;
         }
         .table-title h2 {
         margin: 2px 0 0;
         font-size: 24px;
         }
         table.table {
         min-width: 100%;
         }
         table.table tr th, table.table tr td {
         border-color: #e9e9e9;
         padding: 12px 15px;
         vertical-align: middle;
         }
         table.table tr th:first-child {
         width: 40px;
         }
         table.table tr th:last-child {
         width: 150px;
         }
         table.table-striped tbody tr:nth-of-type(odd) {
         background-color: #fcfcfc;
         }
         table.table-striped.table-hover tbody tr:hover {
         background: #f5f5f5;
         }
         table.table td a {
         color: #2196f3;
         }
         table.table td .btn.manage {
         padding: 2px 10px;
         background: #37BC9B;
         color: #fff;
         border-radius: 2px;
         }
         table.table td .btn.manage:hover {
         background: #2e9c81;		
         }
</style>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"></script>

<section class="content">
        <div class="container-xl">
         <div class="table-responsive">
         <?php if(!empty(session()->getFlashdata('fail'))):?>
            <div class="alert alert-danger"><?= session()->getFlashdata('fail');?></div>
            <?php endif ?>
            <?php if(!empty(session()->getFlashdata('success'))):?>
            <div class="alert alert-success"><?= session()->getFlashdata('success');?></div>
            <?php endif ?>
            <div class="table-wrapper">
               <div class="table-title">
                  <div class="row">
                     <div class="col-sm-6">
                        <h2>Laboratory Report<b></b></h2>
                     </div>
                     <div class="col-sm-6">
                     </div>
                  </div>
               </div>
               <table class="table table-striped table-hover">
                  <thead>
                     <tr class="border-bottom">
                     <th>
                  <span class="ml-2">#</span>
               </th>
               <th>
                  <span class="ml-2">Date</span>
               </th>
               <th>
                  <span class="ml-2">Test Name</span>
               </th>
               <th>
                  <span class="ml-2">Status</span>
               </th>
               <th>
                  <span class="ml-4">Report</span>
               </th>
            </tr>
                  </thead>
                  <tbody>
                  <?php 
                        if(!empty($labData))
                        {
                            $i=1;
                        	foreach($labData as $key => $row)
                        {?>
                           <tr class="border-bottom">
               <td>
                  <div class="p-2">
                     <span class="d-block font-weight-light"><?=$i?></span>
                  </div>
               </td>
               <td>
                  <div class="p-2">
                     <span class="d-block font-weight-light"><?php echo $row['date'];?></span>
                  </div>
               </td>
               <td>
                  <div class="p-2">
                     <span class="d-block font-weight-light"><?=$row['testname']?></span>
                  </div>
               </td>
               <td>
                  <div class="p-2">
                    <?php if($row['status']=="processing"){?>
                        <span class="text-warning"><?php echo $row['status'];?></span>
                    <?php }?>
                    <?php if($row['status']=="completed"){?>
                        <span class="text-success"><?php echo $row['status'];?></span>
                    <?php }?>                  </div>
               </td>
               <td>
                  <div class="p-2">
                  <?php if($row['report']==""){?>
                        <span class="d-block font-weight-light">No Upload</span>
                    <?php } else{?>
                        <a href="<?=$row['report']?>" target="_blank"><u>View Report</u></a>
                    <?php }?>                               
                 </div>
               </td>
    
               <?php
                        $i++;}
                        }
                        
                        ?>
                  </tbody>
               </table>
         
               <div class="clearfix">
                  <div class="hint-text">Total <b>
                     <?php 
                        if(empty($labData))
                        {
                          echo "0";
                        }else{
                          $i=0;
                          foreach($labData as $key)
                          {
                              $i++;
                          }
                          echo $i;
                        
                        }
                        ?>  
                     entries
                  </div>
                  <ul class="pagination justify-content-center">
                     <li class="page-item <?php if($page <= 1){ echo 'disabled'; } ?>">
                        <a class="page-link"
                           href="
                           <?php if($page <= 1){ echo '#'; }
                              else{
                                 echo base_url('PatientLab/lab?page=').$prev;
                                 
                              }?>
                           ">Previous</a>
                     </li>
                     <?php for($i = 1; $i <= $totoalPages; $i++ ): ?>
                     <li class="page-item <?php if($page == $i) {echo 'active'; } ?>">
                        <a class="page-link" href="<?=base_url('PatientLab/lab');?>?page=<?= $i; ?>"> <?= $i; ?> </a>
                     </li>
                     <?php endfor; ?>
                     <li class="page-item <?php if($page >= $totoalPages) { echo 'disabled'; } ?>">
                        <a class="page-link"
                           href="
                           <?php
                              if($page >= $totoalPages)
                              { echo '#'; } 
                              else {       
                               echo base_url('PatientLab/lab?page='). $next; } ?>">Next</a>
                     </li>
                  </ul>
               </div>
            </div>
         </div>
      </div>
      </div>
      </div>

</section>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
   
</div>
<script>
 $('#paybtn').on('click', function () {
   
   var id=$(this).data('id');
   document.getElementById("paymentid").value = id;
 });
</script>
<?=$this->endSection();?>
