<?= $this->extend('layout/staffdashboard-layout'); ?>
<?= $this->section('content'); ?>

<style>

    @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');




    .breadcrumb {
        background-color: #c5cee4;

    }

    .breadcrumb a {
        text-decoration: none;
    }

    .container {
        max-width: 1000px;
        padding: 0;
    }

    p {
        margin: 0;
    }

    .d-flex a {
        text-decoration: none;
        color: #686868;
    }

    img {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
    }

    .fab.fa-twitter {
        color: #8ab7f1;
    }

    .fab.fa-instagram {
        color: #E1306C;
    }

    .fab.fa-facebook-f {
        color: #5999ec;
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
<script><link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"></script>
    <script><link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
        <script><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"></script>
<?php if (!empty(session()->getFlashdata('fail'))): ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('fail'); ?></div>
<?php endif ?>
<?php if (!empty(session()->getFlashdata('success'))): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
<?php endif ?>

<div class="container">
    <div class="row">
        <div class="col-md-5">
            <div class="row">
                <div class="col-12 bg-white p-0 px-3 py-3 mb-3">
                    <div class="d-flex flex-column align-items-center">
                        <img class="photo"
                             src="https://upload.wikimedia.org/wikipedia/commons/9/99/Sample_User_Icon.png"
                             alt="">
                        <p class="fw-bold h4 mt-3"><?= $patientData['name'] ?></p>
                        <p class="text-muted">Join at:<?= $patientData['createdDate'] ?> 
                            <br>DOB:<?= $patientData['dob'] ?> 
                            <br>Gender:<?= $patientData['gender'] ?> 
                            <br>State:<?= $patientData['state'] ?>
                            <br>Allergies:
                            <?php if ($patientData['Allergies'] == "No") {
                                ?>
                                <span class="bg-green"><?= $patientData['Allergies'] ?></span>
                            <?php } ?>
                            <?php if ($patientData['Allergies'] == "Yes") {
                                ?>
                                <span class="bg-red"><?= $patientData['Allergies'] ?></span>
                            <?php } ?>
                        </p>

                        <div class="d-flex ">
                        <form action="<?= route_to('staff.createAppointment'); ?>" method="post" target="_blank">
                        <input type="hidden" value="<?= $patientData['key'] ?>" name="addAppPatientID"/>
                        <button type="submit" class="btn btn-warning follow me-2" style="margin:5px" >Make Appointment</button>
                       </form>
                            </div>
                        <br>
                        <br>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-md-7 ps-md-4">
            <div class="row">

                <div class="col-12 bg-white px-3 mb-3 pb-3">

                    <form action="<?= route_to('patient.updatePanel'); ?>" method="post">
                        <div class="d-flex align-items-center justify-content-between border-bottom">
                            <input type="hidden" id="key" name="key"  value="<?= $patientData['key'] ?>">

                            <p class="py-2">Full Name</p>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputName" name="name" placeholder="Name" 
                                <?php
                                if (empty(session()->getFlashdata('error'))) {
                                    ?>
                                           value="<?= $patientData['name'] ?>"

                                       <?php }if (!empty(session()->getFlashdata('error'))) { ?>
                                           value="<?php echo set_value('name') ?>"
                                       <?php } ?>   
                                       >
                                       <?php if (!empty(session()->getFlashdata('nameError'))): ?>
                                    <div class="text-danger"><?= session()->getFlashdata('nameError'); ?></div>
                                <?php endif ?>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between border-bottom">
                            <p class="py-2">Email</p>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputEmail" name="email" placeholder="Email"
                                <?php
                                if (empty(session()->getFlashdata('error'))) {
                                    ?>
                                           value="<?= $patientData['email'] ?>"

                                       <?php }if (!empty(session()->getFlashdata('error'))) { ?>
                                           value="<?php echo set_value('email') ?>"
                                       <?php } ?>   
                                       >

                                <?php if (!empty(session()->getFlashdata('emailError'))): ?>
                                    <div class="text-danger"><?= session()->getFlashdata('emailError'); ?></div>
                                <?php endif ?>  
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between border-bottom">
                            <p class="py-2">Phone</p>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputphone"  name="contact"  placeholder="phone number" 
                                <?php
                                if (empty(session()->getFlashdata('error'))) {
                                    ?>
                                           value="<?= $patientData['phone'] ?>"

                                       <?php }if (!empty(session()->getFlashdata('error'))) { ?>
                                           value="<?php echo set_value('contact') ?>"
                                       <?php } ?>   
                                       >
                                       <?php if (!empty(session()->getFlashdata('contactError'))): ?>
                                    <div class="text-danger"><?= session()->getFlashdata('contactError'); ?></div>
                                <?php endif ?>    
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between border-bottom">
                            <p class="py-2">Identify</p>
                            <div class="col-sm-10">
                            <input type="hidden" name="oldic"   value="<?= $patientData['ic'] ?>"/>
                                <input type="text" class="form-control" id="inputic"  name="identityNum"  placeholder="ic number"

                               <?php
                                if (empty(session()->getFlashdata('error'))) {
                                    ?>
                                           value="<?= $patientData['ic'] ?>"

                                       <?php }if (!empty(session()->getFlashdata('error'))) { ?>
                                           value="<?php echo set_value('identityNum') ?>"
                                       <?php } ?>   
                                       >
                                       <?php if (!empty(session()->getFlashdata('icError'))): ?>
                                    <div class="text-danger"><?= session()->getFlashdata('icError'); ?></div>
                                <?php endif ?>       
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="py-2">Address</p>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputaddress"  name="address"  placeholder="home address" 
                                <?php
                                if (empty(session()->getFlashdata('error'))) {
                                    ?>
                                           value="<?= $patientData['address'] ?>"

                                       <?php }if (!empty(session()->getFlashdata('error'))) { ?>
                                           value="<?php echo set_value('address') ?>"
                                       <?php } ?>   
                                       >
                                       <?php if (!empty(session()->getFlashdata('addressError'))): ?>
                                    <div class="text-danger"><?= session()->getFlashdata('addressError'); ?></div>
                                <?php endif ?>          
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="py-2">Post Code</p>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputpostcode"  name="postcode"  placeholder="Post Code"  <?php
                                if (empty(session()->getFlashdata('error'))) {
                                    ?>
                                           value="<?= $patientData['postCode'] ?>"

                                       <?php }if (!empty(session()->getFlashdata('error'))) { ?>
                                           value="<?php echo set_value('postcode') ?>"
                                       <?php } ?>   
                                       >
                                       <?php if (!empty(session()->getFlashdata('postcodeError'))): ?>
                                    <div class="text-danger"><?= session()->getFlashdata('postcodeError'); ?></div>
                                <?php endif ?>            
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="py-2">Ethnicity</p>
                            <div class="col-sm-10">
                                <select  class="form-control" name="Ethnicity">

                                    <option value="" selected hidden required></option>
                                    <option value="Malay"<?php
                                    if ($patientData['Ethnicity'] == "Malay") {
                                        echo "selected";
                                    } else {
                                        echo "";
                                    }
                                    ?>
                                            >Malay</option>
                                    <option value="Chinese"
                                    <?php
                                    if ($patientData['Ethnicity'] == "Chinese") {
                                        ?>
                                        <?= 'selected'; ?>
                                    <?php } ?>
                                            >Chinese </option>
                                    <option value="Indians"
                                    <?php
                                    if ($patientData['Ethnicity'] == "Indians ") {
                                        ?>
                                        <?= 'selected'; ?>
                                    <?php } ?>
                                            >Indians</option>
                                </select>                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="py-2">Allergies</p>
                            <div class="col-sm-10">
                                <select  class="form-control" name="Allergies">

                                    <option value="" selected hidden required></option>
                                    <option value="Yes"<?php
                                    if ($patientData['Allergies'] == "Yes") {
                                        echo "selected";
                                    } else {
                                        echo "";
                                    }
                                    ?>
                                            >Yes</option>
                                    <option value="No"
                                    <?php
                                    if ($patientData['Allergies'] == "No") {
                                        ?>
                                        <?= 'selected'; ?>
                                    <?php } ?>
                                            >No </option>

                                </select>                            </div>
                        </div>
                        <br>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="offset-sm-2 col-sm-10">
                                <button type="submit" class="btn btn-success ">Update</button>
                            </div>
                        </div>
                </div>
            </div>
            </form>

        </div>
        <div class="container d-flex justify-content-center mt-50 mb-50">

            <div class="card w-100">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title">Laboratory Test</h5>
                    <form action="<?= route_to('patient.addLab'); ?>" method="post" target="_blank">
                        <input type="hidden" value="<?= $patientData['key'] ?>" name="addLabPatientID"/>
                        <button type="submit" class="btn btn-success" style="float:right;">Add Lab</button>
                    </form>
                    <div class="header-elements">
                        <div class="list-icons text-muted font-weight-light"> <a class="list-icons-item" data-action="collapse" data-abc="true"><i class="fa fa-minus font-weight-light"></i></a> <a class="list-icons-item" data-action="reload" data-abc="true"><i class="fa fa-refresh"></i></a> <a class="list-icons-item" data-action="remove" data-abc="true"><i class="fa fa-close"></i></a> </div>
                    </div>
                </div>



                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Test Name</th>
                                <th>Laboratory</th>
                                <th>Date</th>
                                <th>Specimens</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Report</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($labData)) {
                                $i = 1;
                                foreach ($labData as $key => $row) {
                                    ?>
                                    <tr>
                                        <td><?= $i ?></td>
                                        <td><?= $row['testname'] ?></td>
                                        <td><?= $row['laboratory'] ?></td>
                                        <td><?= $row['date'] ?></td>
                                        <td><?= $row['specimens'] ?></td>
                                        <td><?= $row['desc'] ?></td>
        <?php
        if ($row['status'] == "processing") {
            ?>
                                            <td class="text-warning"><?= $row['status'] ?></td>
                                        <?php } ?>
                                        <?php
                                        if ($row['status'] == "completed") {
                                            ?>
                                            <td class="text-success"><?= $row['status'] ?></td>
                                        <?php } ?>

                                        <?php
                                        if ($row['report'] == "") {
                                            ?>
                                            <td>No upload</td>
                                        <?php }else{ ?>
                                            <td>
                                            <a href="<?=$row['report']?>" target="_blank"><u>View Report</u></a>
                                            </td>

                                         <?php }?>
                                        <td>
                                        <form action="<?= route_to('lab.updatePage'); ?>" method="post" target="_blank">
                                                <input type="hidden" name="id" value="<?= $row['key'] ?>"/>
                                                <button id="viewPanel" class="btn btn-white launch" style="padding-left:0px; " type="submit"><i class="fa fa-edit" style="color:blue"></i></button>
                                            </form>
                                            <a href="#deleteEmployeeModal" id="deletebtn" data-id="<?= $row['key']; ?>"  class="delete" data-toggle="modal"><i class="fa fa-trash" aria-hidden="true" style="color:red;"></i></a>


                                        </td>
                                       
                                    </tr>
        <?php $i++;
    }
} ?>

                        </tbody>
                    </table>
                </div>
            </div>
            </div>
        </div>
        <div class="container d-flex justify-content-center mt-50 mb-50">

<div class="card w-100">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Visited Record</h5>
        
        <div class="header-elements">
            <div class="list-icons text-muted font-weight-light"> <a class="list-icons-item" data-action="collapse" data-abc="true"><i class="fa fa-minus font-weight-light"></i></a> <a class="list-icons-item" data-action="reload" data-abc="true"><i class="fa fa-refresh"></i></a> <a class="list-icons-item" data-action="remove" data-abc="true"><i class="fa fa-close"></i></a> </div>
        </div>
    </div>



    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Services</th>
                    <th>Arrival Time</th>
                    <th>Total Price</th>
                    <th></th>
                    <th></th>

                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($visitedRecord)) {
                    $i = 1;
                    foreach ($visitedRecord as $key => $row) {
                        ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td><?= $row['date'] ?></td>
                            <td><?= $row['services'] ?></td>
                            <td><?= $row['Arrivaltime'] ?></td>
                            <td>RM<?=$row['grant'] ?></td>

                            <td>
                            <form action="<?= route_to('staff.visitDetails'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="queueID" value="<?= $row['key'] ?>"/>
                                    <button id="viewPanel" class="btn btn-white launch"  type="submit"><u style="color:blue;">View</u></button>
                                    </form>
                                  
                            </td>
                            <td>
                            <form action="<?= route_to('staff.viewReceipt'); ?>" method="post" target="_blank">
                                    <input type="hidden" name="queueID" value="<?= $row['key'] ?>"/>
                                    <button id="viewPanel" class="btn btn-white launch" type="submit"><u style="color:blue;">Receipt</u></button>
                                    </form>
                            </td>
                           
                        </tr>
<?php $i++;
}
} ?>

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
                                       echo base_url('Patient/panel?page=') . $prev;
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
                                    <a class="page-link" href="<?= base_url('Patient/panel'); ?>?page=<?= $i; ?>"> <?= $i; ?> </a>
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
                                       echo base_url('Patient/panel?page=') . $next;
                                   }
                                   ?>">Next</a>
                            </li>
                        </ul>
                    </div>
                
    </div>
    
</div>

    </div>
    <div class="container d-flex justify-content-center mt-50 mb-50">

<div class="card w-100">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Symptons & Diagnosis</h5>
        <form action="<?= route_to('patient.panel'); ?>" method="post">
        <input type="hidden" name="id" value="<?=$patientData['key']?>"/>
        <input type="text" class="form-control" name="searchName"  style="float:right;" placeholder="Search by name">
        </form>
        <div class="header-elements">
            <div class="list-icons text-muted font-weight-light"> <a class="list-icons-item" data-action="collapse" data-abc="true"><i class="fa fa-minus font-weight-light"></i></a> <a class="list-icons-item" data-action="reload" data-abc="true"><i class="fa fa-refresh"></i></a> <a class="list-icons-item" data-action="remove" data-abc="true"><i class="fa fa-close"></i></a> </div>
        </div>
    </div>



    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Name</th>
                    <th>Remark</th>

                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($symData)) {
                    $i = 1;
                    foreach ($symData as $key => $row) {
                        ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td><?= $row['date'] ?></td>
                            <td><?= $row['name'] ?></td>
                            <td><?= $row['remark'] ?></td>
                           
                           
                        </tr>
<?php $i++;
}
} ?>

            </tbody>
        </table>
        <div class="clearfix">
                        <div class="hint-text">Total <b><?= $allRecords2 ?> entries</div>
                        <ul class="pagination justify-content-center">
                            <li class="page-item <?php
                            if ($page2 <= 1) {
                                echo 'disabled';
                            }
                            ?>">
                                <a class="page-link"
                                   href="
                                   <?php
                                   if ($page2 <= 1) {
                                       echo '#';
                                   } else {
                                       echo base_url('Patient/panel?page2=') . $prev2;
                                   }
                                   ?>
                                   ">Previous</a>

                            </li>
                            <?php for ($i = 1; $i <= $totoalPages2; $i++): ?>
                                <li class="page-item <?php
                                if ($page == $i) {
                                    echo 'active';
                                }
                                ?>">
                                    <a class="page-link" href="<?= base_url('Patient/panel2'); ?>?page=<?= $i; ?>"> <?= $i; ?> </a>
                                </li>
                            <?php endfor; ?>
                            <li class="page-item <?php
                            if ($page2 >= $totoalPages2) {
                                echo 'disabled';
                            }
                            ?>">
                                <a class="page-link"
                                   href="
                                   <?php
                                   if ($page2 >= $totoalPages2) {
                                       echo '#';
                                   } else {
                                       echo base_url('Patient/panel?page=') . $next2;
                                   }
                                   ?>">Next</a>
                            </li>
                        </ul>
                    </div>
                
    </div>
    
</div>

    </div>
    <div id="deleteEmployeeModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="<?= base_url('Lab/delete'); ?>" method="post">
                        <div class="modal-header">
                            <h4 class="modal-title">Delete Employee</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete these Records?</p>
                            <p class="text-warning"><small>This action cannot be undone.</small></p>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="delete_id" id="delete_id" value="">	
                            <input type="hidden" name="patient_key" id="patient_key" value="<?=$patientData['key']?>">			
		
                            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                            <input type="submit" name="deletedata" class="btn btn-danger" value="Delete">
                        </div>
                    </form>
                </div>
            </div>
        </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
<script>
$('.delete').click(function () {
                var id = $(this).data('id');
                document.getElementById("delete_id").value = id;
             
})
</script>
     
<?= $this->endSection(); ?>
