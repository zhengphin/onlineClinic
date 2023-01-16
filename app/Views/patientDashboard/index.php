<?= $this->extend('layout/dashboard-layout');?>
<?= $this->section('content');?>
<section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?=countRecord('appointment','user',$userInfo['email'])?>&nbsp; <i class="fa fa-calendar-day fa-1x" aria-hidden="true"></i></h3>
            
                <p>Total Appointment</p>

              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="<?=route_to('patient.viewAppointment');?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">  
              <div class="inner">
              <h3><?=countRecord2('appointment','user',$userInfo['email'])?>&nbsp; <i class="fab fa-cc-visa	 fa-1x" aria-hidden="true"></i></h3>

                <p>Unpaid E-consultation</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="<?=route_to('patient.payment');?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?=countRecord3('appointment','user',$userInfo["email"])?></h3>

                <p>Pending Appointment
                <i class="bi bi-stopwatch"></i>

                </p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="<?=route_to('patient.viewAppointment');?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?=CountreadQueueDataByPatientKey($patientKey)?></h3>

                <p>Visit History &nbsp;<i class="nav-icon fa fa-history"></i>
</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="<?=route_to('patient.history');?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
</section>



<?=$this->endSection();?>