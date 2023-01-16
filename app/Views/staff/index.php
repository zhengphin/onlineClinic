<?= $this->extend('layout/staffdashboard-layout');?>
<script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js'></script>

<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
<?= $this->section('content');?>
<section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?=$totalonlineuser?></h3>

                <p>Total Online Patient <small style="color:black;">Register</small></p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
           
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?=countRecord('appointment','status','pending')?></h3>

                <p>Pending Appointment
                <i class="bi bi-stopwatch"></i>

                </p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="<?=route_to('staff.pending');?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
               <!-- ./col -->
               <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?=$totalvisitorweek?></h3>

                <p>Total Visitors <small>past one week</small></p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?=$totalvisitor?></h3>

                <p>Total Visitors <small>past 30 days</small></p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          
        </div>

     
   </div>
    <!-- /.row -->
    <div class="container-fluid text-black" style="background-color:white;">
      <p>
      <h4><u style="padding-left:10%;">Top Popular Services</u><u style="padding-left:25%;">Revenue Segementation</u></h4>
      <div class="row mt-3" style="padding-left:70px;">
         <div class="col-sm-6"> <canvas id="countries" width="350" height="250"></canvas></div>
         <div class="col-sm-6"> <canvas id="revenue" width="350" height="250"></canvas></div>
      </div>
      <div class="row mt-3">
      <div class="col-sm-6"><label>Popular serives pie chart</label></div>

         <div class="col-sm-6"><label>Segmenting revenue pie chart</label></div>
      </div>
      <br>
      <h4><u style="padding-left:10%;">User Segmentation</u><u style="padding-left:25%;">Top 4 Selling Product</u></h4>
      <div class="row mt-3" style="padding-left:70px;">
         <div class="col-sm-6"><canvas id="usersegment" width="300" height="300"></canvas>
      </div>
         <div class="col-sm-6">
         <canvas id="topsalesprod" width="300" height="300"></canvas>
         </div>
         <br>

      </div>
    </div>
    <div class="container-fluid text-black" style="background-color:white;">
      <p>
      <h4 style="padding-left:30%;">Inventory Running In <span style="color:red;">Low Than 10</span> Quantity</h4>
      <div class="row mt-3" style="padding-left:70px;">
         <div class="col-sm-12"> 

         <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Item Name</th>
      <th scope="col">Quantity</th>
    </tr>
  </thead>
  <tbody>
    <?php if(!empty($lowInventory)){ 
      $i=1;
      foreach ($lowInventory as $key => $row){?>
    <tr>
      <th scope="row"><?=$i?></th>
      <td><?=$row['medicineName']?></td>
      <td><?=$row['quantity']?></td>
    </tr>
  <?php $i++;} } ?>
  </tbody>
</table>
        </div>
      </div>
      <div class="container-fluid text-black" style="background-color:white;">
      <p>
      <h4 style="padding-left:30%;">Inventory <span style="color:red;">Expired Date Less Than 30</span> days</h4>
      <div class="row mt-3" style="padding-left:70px;">
         <div class="col-sm-12"> 

         <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Item Name</th>
      <th scope="col">Expired Date</th>
    </tr>
  </thead>
  <tbody>
    <?php if(!empty($almostExpiredInventory)){ 
      $i=1;
      foreach ($almostExpiredInventory as $key => $row){?>
    <tr>
      <th scope="row"><?=$i?></th>
      <td><?=$row['medicineName']?></td>
      <td><?=$row['expiryDate']?></td>
    </tr>
  <?php $i++;} } ?>
  </tbody>
</table>
        </div>
      </div>
    </div>
    <script type="text/javascript">
            // pie chart data
            // topServicesData
            const randColor = () =>  {
    return "#" + Math.floor(Math.random()*16777215).toString(16).padStart(6, '0').toUpperCase();
}
<?php
$totalOnlineConsultationRevenue = $totalOnlineConsultationRevenue;
$totalWalkInRevenue = $totalWalkInRevenue;

?>
  var pieData2 = [
                {
                    value: '<?php echo $totalOnlineConsultationRevenue;?>',
                    color:"#4ACAB4",
                    label: 'E-Consultation Segment(RM)',

                },
                {
                  value:'<?php echo $totalWalkInRevenue;?>',
                    color:"#FFEA88",
                    label: 'Walk In Segment(RM)',
                }
            ];
            var pieData = [
              <?php if(!empty($topServicesData)){
              foreach ($topServicesData as $key => $row) {
                                  ?>
                {
                  <?php
$count = $row['count'];
$name = $row['services'];

?>
                    value:  '<?php echo $count ;?>',
                    color:randColor(),
                    label: '<?php echo $name ;?>',
                },
              <?php } }?>
            ];
            
            // pie chart options
            var pieOptions = {
                 segmentShowStroke : false,
                 animateScale : true
            }
            // get pie chart canvas
            var countries= document.getElementById("countries").getContext("2d");
            // draw pie chart
            new Chart(countries).Pie(pieData, pieOptions);
             

              // get pie chart canvas
              var revenue= document.getElementById("revenue").getContext("2d");
            // draw pie chart
            new Chart(revenue).Pie(pieData2, pieOptions);
      

            
            // bar chart data
            var barData = {
                labels : ["Online User","Clinic User"],
                datasets : [
                   
                    {
                        fillColor : "rgba(73,188,170,0.4)",
                        strokeColor : "rgba(72,174,209,0.4)",
                        data : [<?=$totalonlineuser?>,<?=$totalClinicUser?>]
                    }
                ]
            }
            // get bar chart canvas
            var usersegment = document.getElementById("usersegment").getContext("2d");
            // draw bar chart
            new Chart(usersegment).Bar(barData);

            //$haha[0]['medicineName']
                // bar chart data
            var barData2 = {
              labels : ['<?php echo $topsalesproduct[0]['medicineName']?>',
              '<?php echo $topsalesproduct[1]['medicineName']?>',
              '<?php echo $topsalesproduct[2]['medicineName']?>',
              '<?php echo $topsalesproduct[4]['medicineName']?>'],
                datasets : [
                  
                    {
                        fillColor : "rgba(73,188,170,0.4)",
                        strokeColor : "rgba(72,174,209,0.4)",
                        data : [
                          '<?php echo $topsalesproduct[0]['count']?>',
                          '<?php echo $topsalesproduct[1]['count']?>',
                          '<?php echo $topsalesproduct[2]['count']?>',
                          '<?php echo $topsalesproduct[3]['count']?>']
                    }
                ]
            }
            // get bar chart canvas
            var topsalesprod = document.getElementById("topsalesprod").getContext("2d");
            // draw bar chart
            new Chart(topsalesprod).Bar(barData2);
           
    </script>
</section>

<?=$this->endSection();?>