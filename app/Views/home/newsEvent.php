<?php include '../public/design/header.php';?>
<style>
    .height-100{
 height:100vh;   
}

.card{
    width:700px;
    border:dotted ;
    border-radius:2px;
}
.content span{
    color:green; 
    font-weight:500;
}
.content p{
    font-size:13px;
}
.angle i{
    font-size:19px;
    cursor:pointer;
}

.angle i:nth-child(1){
    margin-right:10px;
}

    </style>
<section class="light-background-color">
<h3 class="text-center">NEWS AND EVENTS</h3>
<?php  if (!empty($record)) {
                                $i = 1;
                                foreach ($record as $key => $row) {
                                    ?>

<div class="container height-40 d-flex justify-content-center align-items-center" style="margin-top:50px;">

<div class="card" >

<?php if($row['image']==""){?>

<?php }else{?>
<img src="<?=$row['image']?>" alt="event photo">
<?php }?>    
<div class="p-3 content">
    <div>
        <span>Event Date : <?=$row['createdDate']?></span>
        <span style="float:right;" class="text-danger">Expiry Date : <?=$row['expiryDate']?></span>
        <div>
        <span>Remaining Days : <?=diffDay($row['expiryDate'])?></span>
        <h4> <?=$row['title']?></h4>
        <p> <?=$row['desc']?></p>
    </div>
    
    <div class="p-3 d-flex justify-content-between align-items-center">
    </div>
</div>
</div>
</div>
</div>
<?php }}else{?>
    <br><br><br>
<h3 class="text-center">Sorry, Currently don't have any event thank you.</h3>
<br><br><br><br><br><br><br>

    <?php } ?>


    </section>
<?php include '../public/design/footer.php';?>