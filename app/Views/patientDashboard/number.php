<?= $this->extend('layout/dashboard-layout');?>
<?= $this->section('content');?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Card</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <script src="jquery-3.6.0.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:wght@300;400;500;700&display=swap');
:root {
     --primary-color:#f2726a;
     --white-color: #fff;
}
* {
     padding: 0;
     margin: 0;
     box-sizing: border-box;
}

.card {
    height: 300px;
    width: 100%;
    border-radius: 30px;
    background-color:  #242628;
    text-align: center;
    overflow: hidden;
}

.card__img {
    height: 116px;
    width: 116px;
    border-radius: 50%;
    background-color: white;
    margin: 0 auto 15px;
    border: 4px solid var(--primary-color);
    overflow: hidden;
    transition: 0.4s;
    transform: translateY(25px);
}

.card__img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position:70% 0%;
}
.card__img:hover {
    width: 100%;
    height: 100%;
    border: none;
    transform: unset;
    border-radius: unset;
}

.card__name {
    font-weight: 600;
    color: var(--white-color);
    margin-top: 0px;
}

.card__job {
    margin-top: 40px;

    color: var(--primary-color);
}
.card__link {
    margin: 20px;
}

.card__link a{
    color: var(--white-color);
    text-decoration: none;
    font-size: 1.5rem;
    margin: 25px 16px;
}
.card__link i {
    transition: 0.3s;
}

.card__link i:hover {
    color: var(--primary-color);
}

.card__btn-contact {
    margin: 18px;
    background-color: transparent;
    color: var(--white-color);
    padding: 12px 23px;
    border: 1px solid  var(--primary-color);
    font-size: 0.9rem;
    border-radius: 10px;
    transition: 0.3s;
    cursor: pointer;
}

.card__btn-contact:hover {
    background-color: var(--primary-color);
    
}
</style>
<body>
    
    <div class="card" id="position" >
    <div class="card__job">
            <span>Your now position is</span>
        </div>
        <div class="card__name">
        
            <?php 
 if(!empty($waitingData))
 {
     $i=1;
     foreach($waitingData as $key => $row)
 {
    if($row['patientkey']==readPatientKeyByIC($userInfo['ic']))
    {
?>
    
    <h1 ><?=$i?></h1>
    
<?php 
    }
$i++;
}
}?>
<?php 
 if(empty($waitingData))
 {?>
    <h1>Invalid</h1>
    <?php
 }?>

            Time:
            <small id="MyClockDisplay" class="clock"  onload="showTime()" style="background-color:black; margin-top:220px; padding-left:400;"></small>
            Date:<small><?=getTodayDate()?></small>
        </div>
   
        <div class="card__btn">
            <button class="card__btn-contact bg-danger">Please wait patiently for your position to be 1, and arrival on time. </button>
        </div>
    </div>
</body>
<script src="./assets/js/html.js"></script>
</html>
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
<script>
   $(document).ready(function()
   {
       setInterval(function(){
         $("#position").load(" #position > *");

       },5000);
       })

</script>
<?=$this->endSection();?>