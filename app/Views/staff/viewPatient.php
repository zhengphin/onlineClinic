<?= $this->extend('layout/staffdashboard-layout');?>
<?= $this->section('content');?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.5.0.min.js"></script>

<style>
    @import url("https://fonts.googleapis.com/css2?family=Poppins:weight@100;200;300;400;500;600;700;800&display=swap");
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
         .pagination li.active a, .pagination li.active a.page-link {
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
.search{
position: relative;
box-shadow: 0 0 40px rgba(51, 51, 51, .1);
  
}

.search input{

 height: 60px;
 text-indent: 25px;
 border: 2px solid #d6d4d4;
}
.search input:focus{

 box-shadow: none;
 border: 2px solid blue;


}

.search .fa-search{

 position: absolute;
 top: 20px;
 left: 16px;

}
.search button{
 position: absolute;
 top: 5px;
 right: 5px;
 height: 50px;
 width: 110px;
 background: blue;

}
</style>
<div class="container">
<?php if(!empty(session()->getFlashdata('fail'))):?>
            <div class="alert alert-danger"><?= session()->getFlashdata('fail');?></div>
            <?php endif ?>
            <?php if(!empty(session()->getFlashdata('success'))):?>
            <div class="alert alert-success"><?= session()->getFlashdata('success');?></div>
            <?php endif ?>

                      <div class="col-md-12">

                        <div class="search">
                          <i class="fa fa-search"></i>
                          <form action="<?=route_to('patient.view');?>" method="post">
                          <input type="text" name="typeFilter" class="form-control" placeholder="Search By Identity Number">
                          <button type="submit" class="btn btn-primary">Search</button>
                        </form>
                        </div>
                        
                      </div>
                      
                    </div>
                    <div class="container mt-5">
                    <?php if(!empty($status)&&$status=="fail")
                    {
                     if($status=="fail")
                     {?>
            <div class="alert alert-danger">No Record Found!</div>
                <?php
                    }
                }?>
                <?php if(!empty($status)&&$status!="fail")
                    {
                     ?>
            <div class="alert alert-success"><?=$status;?></div>
                <?php
                    
                }?>
           
        <div class="row">

          <div class="col-md-12 mx-auto">

            <table class="table bg-white rounded border">
  <thead>
    <tr>
      <th scope="col">Name</th>
      <th scope="col">Gender</th>
      <th scope="col">Date of Birth</th>
      <th scope="col">Ic Number</th>
      <th scope="col"></th>
      <th scope="col"></th>

    </tr>
  </thead>
  <tbody>
    <?php
  if(!empty($patientData))
                        {
                        	foreach($patientData as $key => $row)
                        {
    ?>
        <tr>
      <td hidden><?=$row['key']?></td>
      <td><?=$row['name']?></td>
      <td><?=$row['gender']?></td>
      <td><?=$row['dob']?></td>
      <td><?=$row['ic']?></td>
      <td>
      <form action="<?=route_to('patient.panel');?>" method="post">
      <input type="hidden" name="id" value="<?=$row['key']?>"/>
      <button id="viewPanel" class="btn btn-info launch" type="submit">View Profile</button>
                        </form>
      </td>
      <td>
      <div class="divClass">
      <button data-id="<?= $row['key'];?>"  class="btn btn-info launch" data-toggle="modal" data-target="#myModal">Queue Patient</button>
                        </div>
    </td>
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
                        if(empty($patientData))
                        {
                          echo "0";
                        }else{
                          $i=0;
                          foreach($patientData as $key)
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
                                 echo base_url('patient/view?page=').$prev;
                                 
                              }?>
                           ">Previous</a>
                     </li>
                     <?php for($i = 1; $i <= $totoalPages; $i++ ): ?>
                     <li class="page-item <?php if($page == $i) {echo 'active'; } ?>">
                        <a class="page-link" href="<?=base_url('patient/view');?>?page=<?= $i; ?>"> <?= $i; ?> </a>
                     </li>
                     <?php endfor; ?>
                     <li class="page-item <?php if($page >= $totoalPages) { echo 'disabled'; } ?>">
                        <a class="page-link"
                           href="
                           <?php
                              if($page >= $totoalPages)
                              { echo '#'; } 
                              else {       
                               echo base_url('patient/view?page='). $next; } ?>">Next</a>
                     </li>
                  </ul>
               </div>
          </div>
          
        </div>
        

      </div>
      <div id="myModal" class="modal fade" role="dialog">
<div class="modal-dialog">


<div class="modal-content">
<div class="modal-header">
  <h4>SELECT ENCOUNTER TYPE</h4>
  <button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body">
<form action="<?=route_to('patient.moveQueue');?>" method="post">

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
                              </div>

</div>

<br/>

<div class="modal-footer">
<input type="hidden" id="patientKey" name="patientKey" value=""/>
<button type="submit" class="btn btn-out btn-warning btn-square">Move To Queue</button>
</form>
</div>
</div>
</div> 

</div>

<script>
      $(document).ready(function() {
          $(".divClass button").on("click", function() {
              let dataId = $(this).attr("data-id");
              document.getElementById("patientKey").value = dataId;
            });
        });
    </script>

<?=$this->endSection();?>
