<?= $this->extend('layout/staffdashboard-layout');?>
<?= $this->section('content');?>
<style>
    
    @import url('https://fonts.googleapis.com/css2?family=PT+Sans:wght@700&family=Poppins:wght@600&display=swap');
*{
    box-sizing: border-box;
}

.h2{
    color: #444;
    font-family: 'PT Sans', sans-serif;
}
thead{
    font-family: 'Poppins', sans-serif;
    font-weight: bolder;
    font-size: 15px;
    color: #666;
}
img{
    width: 40px;
    height: 40px;
}
.name{
    display: inline-block;
}
.bg-blue{
    background-color: #EBF5FB;
    border-radius: 8px;
}
.fa-check,.fa-minus{
    color: blue;
}
.bg-blue:hover{
    background-color: #3e64ff;
    color: #eee;
    cursor: pointer;
}
.bg-blue:hover .fa-check,
.bg-blue:hover .fa-minus{
    background-color: white;
    color: #eee;
}

.table thead th,.table td{
    border: none;
}

.table tbody td:first-child{
    border-bottom-left-radius: 10px;
    border-top-left-radius: 10px;
}
.table tbody td:last-child{
    border-bottom-right-radius: 10px;
    border-top-right-radius: 10px;
}
#spacing-row{
    height: 10px;
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
</style>
</style>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"></script>
<script src="jquery-3.6.1.min.js"></script>

<div class="container rounded mt-5 bg-white p-md-5">
<?php if(!empty(session()->getFlashdata('fail'))):?>
            <div class="alert alert-danger"><?= session()->getFlashdata('fail');?></div>
            <?php endif ?>
            <?php if(!empty(session()->getFlashdata('success'))):?>
            <div class="alert alert-success"><?= session()->getFlashdata('success');?></div>
            <?php endif ?>
    <div class="h2 font-weight-bold">Meetings</div>
    <div class="table-responsive">

    <form action="<?= route_to('staff.consult'); ?>" method="post">
    <input type="hidden" name="filterall" value="filterall"/>
    <button class="btn btn-primary launch" type="submit">Click <small>to view all meetings</small></button>
    </form>
                   
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">RoomID</th>   
                    <th scope="col">Name</th>                 
                    <th scope="col">Date</th>     
                    <th scope="col">Time</th>  
                    <th scope="col">Day</th>                    
                  
                    <th scope="col">Status</th> 
                    <th scope="col">Reason</th> 

                    <th scope="col">Remark</th> 

                    <th scope="col">Action</th>                    
                   
                </tr>
            </thead>
            <tbody>
            <?php 
                        if(!empty($appointmentData))
                        {
                        	foreach($appointmentData as $key => $row)
                        {
                ?>
                <tr class="bg-blue">            
                <td class="pt-3">&nbsp;&nbsp;&nbsp;<?=$row['room']?></td>
                <td><?=isset($row['name'])?$row['name']:getUserInfoByEmail($row['user'],'name')?></td>

                    <td class="pt-3 mt-1"><?=date("Y-M-d", strtotime($row['date']))?></td>
                    <td class="pt-3">11:00 AM</td>
                    <td class="pt-3 mt-1"><?=date("l", strtotime($row['date']))?></td>
                 
                    <?php
                    if($row['session']=="completed")
                    {?>
                    <td class="pt-3 bg-success"><span class="bg-success"><?=$row['session']?></span></td>

                   <?php } 
                    else{?>
                                        <td class="pt-3 bg-warning"><span ><?=$row['session']?></span></td>
                <?php }?>
                <td>
                    <?=$row['reason']?>
                </td>
                <td>
                    <?php
                    if(isset($row['remark']))
                    {?>
                    <?=$row['remark']?>
                    <?php } ?>
                    <?php
                    if(!isset($row['remark']))
                    {?>
                    No Remark
                    <?php } ?>
                    </td>

                    <td>
                    <form action="<?=base_url('Consult/meet?room='.$row['room'])?> "  method="post"  target="_blank">
                    <button class="btn btn-warning launch"
                    <?php 
                    if($row['session']=="completed")
                    {
                        echo "disabled";
                    }else{
                        echo "";
                    }
                    ?>
                    >Join</button>
                    </a> 
                </form>
               </td>
               <td>
         
<a href="#addEmployeeModal" id="addremark" data-id="<?=$row['key'];?>"   class="addremark btn btn-danger <?php 
                    if($row['session']=="completed")
                    {
                        echo "disabled";
                    }else{
                        echo "";
                    }
                    ?>"data-toggle="modal" ><span >Close</span></a>

 
               </td>
          
                <tr id="spacing-row">
                  
                </tr>
            <?php 
            }
            }?>
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
                                 echo base_url('consult?page=').$prev;
                                 
                              }?>
                           ">Previous</a>
                     </li>
                     <?php for($i = 1; $i <= $totoalPages; $i++ ): ?>
                     <li class="page-item <?php if($page == $i) {echo 'active'; } ?>">
                        <a class="page-link" href="<?=base_url('consult');?>?page=<?= $i; ?>"> <?= $i; ?> </a>
                     </li>
                     <?php endfor; ?>
                     <li class="page-item <?php if($page >= $totoalPages) { echo 'disabled'; } ?>">
                        <a class="page-link"
                           href="
                           <?php
                              if($page >= $totoalPages)
                              { echo '#'; } 
                              else {       
                               echo base_url('consult?page='). $next; } ?>">Next</a>
                     </li>
                  </ul>
               </div>
    </div>
</div>
  <!-- Edit Modal HTML -->
  <div id="addEmployeeModal" class="modal fade">
         <div class="modal-dialog">
            <div class="modal-content">
               <form action="<?=route_to('staff.close');?>" method="post">
                  <div class="modal-header">
                     <h4 class="modal-title">Close consulatation</h4>
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  </div>

                  <div class="modal-body">
                    
                     <div class="form-group">
                     <input type="hidden" name="key" id="key" value="">			

                        <label>Remark</label>
                        <input type="text" name="remarkSym" class="form-control" 
                           value=""
                           required>
                     </div>
                    
                  </div>
                  <div class="modal-footer">
                     <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                     <input type="submit" class="btn btn-success" value="Close" name="addSym">
                  </div>
               </form>
            </div>
         </div>
      </div>

<script>
       $('.addremark').click(function(){
   var id=$(this).data('id');
   document.getElementById("key").value = id;
   //$('#deleteEmployeeModal').attr('href','delete-cover.php?id='+id);
   //alert("The variable named x1 has value:  " +id);
   })
                              </script>
<?=$this->endSection();?>