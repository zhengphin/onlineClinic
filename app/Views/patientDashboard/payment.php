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
                        <h2>Payment<b></b></h2>
                     </div>
                     <div class="col-sm-6">
                     </div>
                  </div>
               </div>
               <table class="table table-striped table-hover">
                  <thead>
                     <tr class="border-bottom">
               <th>
                  <span class="ml-2">Date</span>
               </th>
               <th>
                  <span class="ml-2">Time</span>
               </th>
               <th>
                  <span class="ml-2">Mode</span>
               </th>
               <th>
                  <span class="ml-2">Payment Status</span>
               </th>
               <th>
                  <span class="ml-4">Action</span>
               </th>
            </tr>
                  </thead>
                  <tbody>
                  <?php 
                        if(!empty($appointmentData))
                        {
                        	foreach($appointmentData as $key => $row)
                        {?>
                           <tr class="border-bottom">
               <td>
                  <div class="p-2">
                     <span class="d-block font-weight-light"><?php echo $row['date'];?></span>
                  </div>
               </td>
               <td>
                  <div class="p-2">
                     <span class="d-block font-weight-light"><?=timeDisplay( $row['time'])?></span>
                  </div>
               </td>
               <td>
                  <div class="p-2">
                     <span class="d-block font-weight-light"><?php echo $row['mode'];?></span>
                  </div>
               </td>
               <td>
                  <div class="p-2">
                     <span class="d-block font-weight-light"><?php echo $row['payment'];?></span>
                  </div>
               </td>
               <?php 
               if($row['payment']=="unpaid")
               {?>
                <td>
                  <div class="p-2 icons">
                     <button type="button"  id="paybtn" class="btn btn-warning launch" data-id="<?= $row['key'];?>"  data-toggle="modal" data-target="#staticBackdrop">  Pay Now
                     </button>
                  </div>
               </td>
               <?php }else{?>
                  <td>
                  <div class="p-2 icons">
                     <button type="button" class="btn btn-success " >  Paid
                     </button>
                  </div>
               </td>
               <?php }?>
               </tr>
               <?php
                        }
                        }
                        
                        ?>
                  </tbody>
               </table>
         
               <div class="clearfix">
                  <div class="hint-text">Total <b>
                     <?php 
                        if(empty($appointmentData))
                        {
                          echo "0";
                        }else{
                          $i=0;
                          foreach($appointmentData as $key)
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
                                 echo base_url('admin/manage?page=').$prev;
                                 
                              }?>
                           ">Previous</a>
                     </li>
                     <?php for($i = 1; $i <= $totoalPages; $i++ ): ?>
                     <li class="page-item <?php if($page == $i) {echo 'active'; } ?>">
                        <a class="page-link" href="<?=base_url('admin/manage');?>?page=<?= $i; ?>"> <?= $i; ?> </a>
                     </li>
                     <?php endfor; ?>
                     <li class="page-item <?php if($page >= $totoalPages) { echo 'disabled'; } ?>">
                        <a class="page-link"
                           href="
                           <?php
                              if($page >= $totoalPages)
                              { echo '#'; } 
                              else {       
                               echo base_url('admin/manage?page='). $next; } ?>">Next</a>
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
         <div class="modal-body">

            <div class="text-right"> <i class="fa fa-close close" data-dismiss="modal"></i> </div>
            <div class="tabs mt-3">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item" role="presentation"> <a class="nav-link active" id="visa-tab" data-toggle="tab" href="#visa" role="tab" aria-controls="visa" aria-selected="true"> <img src="https://i.imgur.com/sB4jftM.png" width="80"> </a> </li>
               </ul>
               <ul class="nav nav-tabs" id="myTab" role="tablist">
                     <Strong>E-consulation serivce price RM40.</Strong> 
               </ul>
               <div class="tab-content" id="myTabContent">
                  <div class="tab-pane fade show active" id="visa" role="tabpanel" aria-labelledby="visa-tab">
                     <div class="mt-4 mx-4">
                        <div class="text-center">
                           <h5>Credit card</h5>
                        </div>
                        <form action="<?=route_to('patient.processPayment');?>" method="post">
                        <div class="form mt-3">
                        <span>Cardholder Name</span>
                           <div class="inputbox"> <input type="text" oninput="this.value = this.value.toUpperCase()"  name="holdername" class="form-control" required="required"></div>
                           <span>Card Number</span>
                           <div class="inputbox"> <input type="text" name="cardnumber" pattern="\d{12}" title="invalid format dash no required with 12 length"  class="form-control" required="required"> <i class="fa fa-eye"></i> </div>
                           <div class="d-flex flex-row">
                              <div class="inputbox"> <input type="text" name="exp" pattern="([0-9]{2}[/]?){2}" title="format should follow 02/23" class="form-control" placeholder="Expiration Date 02/24" required="required"> </div>
                              <div class="inputbox"> <input type="text" name="cvv" pattern="\d{3}" title="invalid format with 3 digit" class="form-control" placeholder="CVV"required="required"> </div>
                           </div>
                           <br>
                           <input type="hidden" name="paymentid" id="paymentid" value="">		

                           <div class="px-5 pay"> <button type="submit" class="btn btn-success btn-block">Pay Now</button> </div>
                        </div>
                        </form>
                     </div>
                     </div>
                     </div>
                     </div>
                     </div>
                     </div>
<script>
 $('#paybtn').on('click', function () {
   
   var id=$(this).data('id');
   document.getElementById("paymentid").value = id;
 });
</script>
<?=$this->endSection();?>
