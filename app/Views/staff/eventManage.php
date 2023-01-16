<?= $this->extend('layout/staffdashboard-layout'); ?>
<?= $this->section('content'); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        <style>

            .table-responsive {
                margin: 30px 0;
            }
            .table-wrapper {
                background: #fff;
                padding: 20px 25px;
                border-radius: 3px;
                min-width: 1000px;
                box-shadow: 0 1px 1px rgba(0,0,0,.05);
            }
            .table-title {
                padding-bottom: 15px;
                background: #435d7d;
                color: #fff;
                padding: 16px 30px;
                min-width: 100%;
                margin: -20px -25px 10px;
                border-radius: 3px 3px 0 0;
            }
            .table-title h2 {
                margin: 5px 0 0;
                font-size: 24px;
            }
            .table-title .btn-group {
                float: right;
            }
            .table-title .btn {
                color: #fff;
                float: right;
                font-size: 13px;
                border: none;
                min-width: 50px;
                border-radius: 2px;
                border: none;
                outline: none !important;
                margin-left: 10px;
            }
            .table-title .btn i {
                float: left;
                font-size: 21px;
                margin-right: 5px;
            }
            .table-title .btn span {
                float: left;
                margin-top: 2px;
            }
            table.table tr th, table.table tr td {
                border-color: #e9e9e9;
                padding: 12px 15px;
                vertical-align: middle;
            }
            table.table tr th:first-child {
                width: 60px;
            }
            table.table tr th:last-child {
                width: 100px;
            }
            table.table-striped tbody tr:nth-of-type(odd) {
                background-color: #fcfcfc;
            }
            table.table-striped.table-hover tbody tr:hover {
                background: #f5f5f5;
            }
            table.table th i {
                font-size: 13px;
                margin: 0 5px;
                cursor: pointer;
            }
            table.table td:last-child i {
                opacity: 0.9;
                font-size: 22px;
                margin: 0 5px;
            }
            table.table td a {
                font-weight: bold;
                color: #566787;
                display: inline-block;
                text-decoration: none;
                outline: none !important;
            }
            table.table td a:hover {
                color: #2196F3;
            }
            table.table td a.edit {
                color: #FFC107;
            }
            table.table td a.delete {
                color: #F44336;
            }
            table.table td i {
                font-size: 19px;
            }
            table.table .avatar {
                border-radius: 50%;
                vertical-align: middle;
                margin-right: 10px;
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
            .hint-text {
                float: left;
                margin-top: 10px;
                font-size: 13px;
            }
            /* Custom checkbox */
            .custom-checkbox {
                position: relative;
            }
            .custom-checkbox input[type="checkbox"] {
                opacity: 0;
                position: absolute;
                margin: 5px 0 0 3px;
                z-index: 9;
            }
            .custom-checkbox label:before{
                width: 18px;
                height: 18px;
            }
            .custom-checkbox label:before {
                content: '';
                margin-right: 10px;
                display: inline-block;
                vertical-align: text-top;
                background: white;
                border: 1px solid #bbb;
                border-radius: 2px;
                box-sizing: border-box;
                z-index: 2;
            }
            .custom-checkbox input[type="checkbox"]:checked + label:after {
                content: '';
                position: absolute;
                left: 6px;
                top: 3px;
                width: 6px;
                height: 11px;
                border: solid #000;
                border-width: 0 3px 3px 0;
                transform: inherit;
                z-index: 3;
                transform: rotateZ(45deg);
            }
            .custom-checkbox input[type="checkbox"]:checked + label:before {
                border-color: #03A9F4;
                background: #03A9F4;
            }
            .custom-checkbox input[type="checkbox"]:checked + label:after {
                border-color: #fff;
            }
            .custom-checkbox input[type="checkbox"]:disabled + label:before {
                color: #b8b8b8;
                cursor: auto;
                box-shadow: none;
                background: #ddd;
            }
            /* Modal styles */
            .modal .modal-dialog {
                max-width: 400px;
            }
            .modal .modal-header, .modal .modal-body, .modal .modal-footer {
                padding: 20px 30px;
            }
            .modal .modal-content {
                border-radius: 3px;
                font-size: 14px;
            }
            .modal .modal-footer {
                background: #ecf0f1;
                border-radius: 0 0 3px 3px;
            }
            .modal .modal-title {
                display: inline-block;
            }
            .modal .form-control {
                border-radius: 2px;
                box-shadow: none;
                border-color: #dddddd;
            }
            .modal textarea.form-control {
                resize: vertical;
            }
            .modal .btn {
                border-radius: 2px;
                min-width: 100px;
            }
            .modal form label {
                font-weight: normal;
            }
        </style>
        <script>
            $(document).ready(function () {
                // Activate tooltip
                $('[data-toggle="tooltip"]').tooltip();

                // Select/Deselect checkboxes
                var checkbox = $('table tbody input[type="checkbox"]');
                $("#selectAll").click(function () {
                    if (this.checked) {
                        checkbox.each(function () {
                            this.checked = true;
                        });
                    } else {
                        checkbox.each(function () {
                            this.checked = false;
                        });
                    }
                });
                checkbox.click(function () {
                    if (!this.checked) {
                        $("#selectAll").prop("checked", false);
                    }
                });
            });
        </script>
        <script src="js/jquery-3.5.1.min.js"></script>
    </head>
    <body>
        <div class="container-xl">
            <div class="table-responsive">
                <?php if (!empty(session()->getFlashdata('failev'))): ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('failev'); ?></div>
                <?php endif ?>
                <?php if (!empty(session()->getFlashdata('successev'))): ?>
                    <div class="alert alert-success"><?= session()->getFlashdata('successev'); ?></div>
                <?php endif ?>
                <?php if (!empty(session()->getFlashdata('failevup'))): ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('failevup'); ?></div>
                <?php endif ?>
                <?php if (!empty(session()->getFlashdata('successevup'))): ?>
                    <div class="alert alert-success"><?= session()->getFlashdata('successevup'); ?></div>
                <?php endif ?>
                <div class="table-wrapper">
                    <div class="table-title">
                        <div class="row">
                            <div class="col-sm-4">
                                <h2>Manage <b>Events</b></h2>
                            </div>
                            <div class="col-sm-8 ">						
                     </div>
                        </div>

                    </div>
                    <div class="table-filter">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="show-entries">
                                
                                    
                                </div>

                            </div>
                       
                            <div class="col-sm-3">
                                <div class="show-entries">
                                    
                                    
                                </div>

                            </div>
                            
                        </div>
                    </div>
                    <br>

                    <table class="table table-striped table-hover"  style="width:100%">
                        <thead>
                            <tr>
                                <th style="width:30%">Title</th>
                                <th>Create Date</th>
                                <th>Expiry Date</th>
                                <th>Image</th>
                                <th>Validity</th>
                                <th>Difference Days</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($eventData)) {
                                $i = 1;
                                foreach ($eventData as $key => $row) {
                                    ?>
                                    <tr>
                                    <?php if(checkAppDate($row['expiryDate'])==false){?>
                                          <td class="text-danger"><?php echo $row['title']; ?></td>
                                    
                                       <?php
                                    }
                                    ?>
                                        <?php if(checkAppDate($row['expiryDate'])==true){?>
                                          <td class="text-success"><?php echo $row['title']; ?></td>
                                    
                                       <?php
                                    }
                                    ?>
                                        <td><?php echo $row['createdDate']; ?></td>
                                        <td><?php echo $row['expiryDate']; ?></td>
                                        <td>
                                        <?php if($row['expiryDate']==""){?>
                                         no image
                                    
                                       <?php
                                    }else{?>
                                        <img src="<?=$row['image']?>" alt="event photo" style="width:100px; height:100px;">
                                       <?php } ?></td>
                                        <td><?php echo $row['validity']; ?></td>
                                        <td><?=diffDay($row['expiryDate'])?></td>
                                        <td hidden><?php echo $row['desc']; ?></td>

                                        <td>
                                            <a href="#editEmployeeModal" class="edit" data-id="<?= $row['key']; ?>" data-toggle="modal"><i class="fa fa-eye" style="color:blue"></i></a>

                                            <br>
                                            <a href="#deleteEmployeeModal" id="deletebtn" data-id="<?= $row['key']; ?>"  class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
                                            <br>
                                            <form action="<?= route_to('staff.updateEvent'); ?>" method="post">
                                                <input type="hidden" name="id" value="<?= $row['key'] ?>"/>
                                                <button id="viewPanel" class="btn btn-white launch" style="padding-left:0px" type="submit"><i class="fa fa-edit" style="color:blue"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                    <div class="clearfix">
                        <div class="hint-text">Total <b><?= $allRecords ?> entries</div>
                        <ul class="pagination justify-content-center">
                            <li class="page-item <?php
                            if ($page <= 1) {
                                echo 'disabled';
                            }
                            ?>">
                                <a class="page-link"
                                   href="
                                   <?php
                                   if ($page <= 1) {
                                       echo '#';
                                   } else {
                                       echo base_url('staff/eventManage?page=') . $prev;
                                   }
                                   ?>
                                   ">Previous</a>

                            </li>
                            <?php for ($i = 1; $i <= $totoalPages; $i++): ?>
                                <li class="page-item <?php
                                if ($page == $i) {
                                    echo 'active';
                                }
                                ?>">
                                    <a class="page-link" href="<?= base_url('staff/eventManage'); ?>?page=<?= $i; ?>"> <?= $i; ?> </a>
                                </li>
                            <?php endfor; ?>
                            <li class="page-item <?php
                            if ($page >= $totoalPages) {
                                echo 'disabled';
                            }
                            ?>">
                                <a class="page-link"
                                   href="
                                   <?php
                                   if ($page >= $totoalPages) {
                                       echo '#';
                                   } else {
                                       echo base_url('staff/eventManage?page=') . $next;
                                   }
                                   ?>">Next</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>     
        <!-- Edit Modal HTML -->
        <div id="editEmployeeModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">EXTRA INFORMATION</h4>
                    </div>
                    <div class="modal-body">
                     
                        <div class="form-group">
                            <label>Description</label>

                            <textarea  name="ic" rows="15" cols="50" id="editic"class="form-control"  disabled></textarea>


                        </div>



                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="edit_id" id="edit_id" 
                               >		
                        <input type="button" class="btn btn-default"  data-dismiss="modal" value="Close">
                    </div>
                </div>
            </div>
        </div>
        <!-- Delete Modal HTML -->
        <div id="deleteEmployeeModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="<?= base_url('NewsEvent/eventDelete'); ?>" method="post">
                        <div class="modal-header">
                            <h4 class="modal-title">Delete Event</h4>
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
    </body>
</html>
<script>
            function ShowHideDiv2() {
                var position = document.getElementById("position");

                var specialist = document.getElementById("specialist");//name


                specialist.style.display = position.value == "Doctor" ? "block" : "none";

            }
            function ShowHideDiv3() {
                var position = document.getElementById("position2");

                var specialist = document.getElementById("editspecialist");//name


                specialist.style.display = position.value == "Doctor" ? "block" : "none";

            }
            function selectDoctor() {
                ShowHideDiv2();
            }
            function ggg() {
                $(document).ready(function () {
                    $("#addEmployeeModal").modal('show');
                });
            }
            function showEditFrom() {
                $(document).ready(function () {
                    $("#editEmployeeModal").modal('show');
                });
            }
</script>
<?php
if (!empty(session()->getFlashdata('addFormError'))) {
    echo '<script>',
    'ggg();',
    '</script>';
}
if (!empty(session()->getFlashdata('fieldValue'))) {
    echo '<script>',
    'selectDoctor();',
    '</script>';
}
if (!empty(session()->getFlashdata('addFormErrorEdit'))) {
    echo '<script>',
    'showEditFrom();',
    '</script>';
}
if (!empty(session()->getFlashdata('fieldValue2'))) {
    echo '<script>',
    'ShowHideDiv3();',
    '</script>';
}
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
<script>

            function j() {
                location.reload();
            }

            $(document).ready(function () {

                $('.deletebtn').on('click', function () {

                    $('#deleteEmployeeModal').modal('show');



                });
            });

            $('.delete').click(function () {
                var id = $(this).data('id');
                document.getElementById("delete_id").value = id;
                //$('#deleteEmployeeModal').attr('href','delete-cover.php?id='+id);
                //alert("The variable named x1 has value:  " +id);
            })
            $(document).ready(function () {

                $('.edit').on('click', function () {

                    $('#editEmployeeModal').modal('show');
                    var id = $(this).data('id');
                    document.getElementById("edit_id").value = id;

                    $tr = $(this).closest('tr');

                    var data = $tr.children("td").map(function () {
                        return $(this).text();
                    }).get();

                    $('#editic').val(data[6]);

                });
            });
</script>
<?= $this->endSection(); ?>