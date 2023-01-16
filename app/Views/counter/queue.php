<!DOCTYPE html>
<html lang="en">
<head>
  <title>Queue Real Time</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <style>
      body{
          background-color:#f8f4fc;
      }
      table, th, td {
  border: 2px solid black;
  border-collapse: collapse;
    border-color: #96D4D4;

}

.clock {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translateX(-50%) translateY(-50%);
    color: #17D4FE;
    font-size:40px;
    font-family: Orbitron;
    letter-spacing: 7px;
   


}
change your keyframe value in %

Try This

body{ 
    overflow: hidden;
}
h2{
    position: absolute;
    white-space: nowrap;
    animation: floatText 10s infinite alternate ease-in-out;
}

@-webkit-keyframes floatText{
  from {
    left: 00%;
  }

  to {
    /* left: auto; */
    left: 100%;
  }
}
  </style>
</head>
<body >
<section >
<div >
  <section class="news-message ">
    <h2 class="bg-danger">Welcome to Mediklinik Menglembu Kampar 18 Jam, Today is <?=getTodayDate()?>

    </h2>
    

    </section>

</div>
  </section>

<div class="container">
    <div class="row">
        <div class="col-xs-4" style="height: 100%; margin-top:100px; padding-left:0px;">
       
            <table class="table" id="page-content1">
  <thead>
 <caption style="background-color:#3630a3; 
                  color:white;  text-align:center;
                  padding:5px;"><b>In Progress</b></caption>
    <tr>
      <th scope="col" style="background-color:white;">No</th>
      <th scope="col" style="background-color:white;">Name</th>
    </tr>
  </thead>
  <tbody>

  <?php
                           if(!empty($progressData))
                           {
                               $i=1;
                               foreach($progressData as $key => $row)
                           {
                           ?>
    <tr>
      <th scope="row" style="background-color:#FFFAF;"><?=$i?></th>
      <td style="background-color:#FFFAF;"><?=getPatientInfoByEmail($row['patientkey'],'name')?></td>
    </tr>
    <?php 
        $i++;
      }
  }?>
  
  </tbody>
</table>

         
            <table class="table" id="page-content2">
               <caption style="background-color:red; 
                  color:white;  text-align:center;
                  padding:5px;"><b>In Waiting</b></caption>
  <thead>
    <tr>
      <th scope="col" style="background-color:white;">No</th>
      <th scope="col" style="background-color:white;">Name</th>
    </tr>
  </thead>
  <tbody>
  <?php
                           if(!empty($waitingData)&&($waitingData!="false"))
                           {
                               $i=1;
                               foreach($waitingData as $key => $row)
                           {
                           ?>
    <tr>
      <th scope="row" style="background-color:#FFFAF;"><?=$i?></th>
      <td style="background-color:#FFFAF;"><?=getPatientInfoByEmail($row['patientkey'],'name')?></td>
    </tr>
    <?php 
        $i++;

    }
  }?>
  </tbody>
</table>
        </div>
        <div class="col-xs-8">

            <div><img src="../../dist/img/earth.gif" alt="gif image"  width="100%" height="1280" controls  style="height: 100%; margin-top:80px; padding-left:0px;"></div>

            <div id="MyClockDisplay" class="clock"  onload="showTime()" style="background-color:black; margin-top:220px; padding-left:400;"></div>

          </div>
          
    </div>
</div>
</body>
<script src="jquery-3.6.0.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
   $(document).ready(function()
   {
       setInterval(function(){
         $("#page-content1").load(" #page-content1 > *");
         $("#page-content2").load(" #page-content2 > *");

       },5000);
       })

</script>
<script>
function showTime(){
    var date = new Date();
    var h = date.getHours(); // 0 - 23
    var m = date.getMinutes(); // 0 - 59
    var s = date.getSeconds(); // 0 - 59
    var session = "AM";
    
    if(h == 0){
        h = 12;
    }
    
    if(h > 12){
        h = h - 12;
        session = "PM";
    }
    
    h = (h < 10) ? "0" + h : h;
    m = (m < 10) ? "0" + m : m;
    s = (s < 10) ? "0" + s : s;
    
    var time = h + ":" + m + ":" + s + " " + session;
    document.getElementById("MyClockDisplay").innerText = time;
    document.getElementById("MyClockDisplay").textContent = time;
    
    setTimeout(showTime, 1000);
    
}

showTime();
</script>
</html>
