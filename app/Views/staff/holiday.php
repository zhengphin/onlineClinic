<?= $this->extend('layout/staffdashboard-layout');?>
<?= $this->section('content');?>
<?php if(!empty(session()->getFlashdata('failh'))):?>
            <div class="alert alert-danger"><?= session()->getFlashdata('failh');?></div>
            <?php endif ?>
            <?php if(!empty(session()->getFlashdata('successh'))):?>
            <div class="alert alert-success"><?= session()->getFlashdata('successh');?></div>
            <?php endif ?>
<div class="min-h-screen flex justify-center items-center bg-gray-200">
    <div class="h-96 w-96 p-2">
        <div class="flex w-full gap-3 mt-4">
            <div class="mt-3 w-full">
                <div class="col-md-6">
                        <div class="form-group">  
                        <form action="<?=route_to('staff.holiday');?>" method="post">
           
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
            </div>        
        </div>
        <div class="mt-7">
            <div class="col-sm-6">
                  <label for="inputLastname"> Description</label>
                  <span class="text-danger" style="margin-left:0px;"><?=isset($validation)?display_error($validation,'description'):''?></span>
                  <input type="text" class="form-control" id="inputDescription" name="description" placeholder="Enter description"value="<?php echo set_value('description') ?>" required>
                  <button type="submit" class="btn btn-success px-4 float-left" style="margin-top:20px; margin-bottom:20px;">Save</button>

               </div>              
        </div>
         </form>
    </div>
    
</div>
<table class="table bg-white" style="margin-top:20px;">
  <thead>
    <tr>
      <th scope="col">Date</th>
      <th scope="col">Description</th>
      <th scope="col">Action</th>

    </tr>
  </thead>
  <tbody>
    <?php       if (!empty($holidayData)) {
                                $i = 1;
                                foreach ($holidayData as $key => $row) {
                                    ?>
    <tr>
      <th scope="row"><?=$row['date']?></th>
      <td><?=$row['desc']?></td>
     <td> <a href="#deleteEmployeeModal" id="deletebtn" data-id="<?= $row['key']; ?>"  class="delete text-danger" data-toggle="modal">Delete</a></td>
<?php }}?>
    </tr>
  </tbody>
</table>
  <!-- Delete Modal HTML -->
  <div id="deleteEmployeeModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="<?= base_url('Staff/deleteHoliday'); ?>" method="post">
                        <div class="modal-header">
                            <h4 class="modal-title">Delete Holiday</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete these Records?</p>
                            <p class="text-warning"><small>This action cannot be undone.</small></p>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="delete_id" id="delete_id" value="">			
                            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                            <input type="submit" name="deletedata" class="btn btn-danger" value="Delete">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script src="jquery-3.6.1.min.js"></script>

        <script>

   $('.delete').click(function () {
                var id = $(this).data('id');
                document.getElementById("delete_id").value = id;
                //$('#deleteEmployeeModal').attr('href','delete-cover.php?id='+id);
                //alert("The variable named x1 has value:  " +id);
            })
        <script>
<?=$this->endSection();?>