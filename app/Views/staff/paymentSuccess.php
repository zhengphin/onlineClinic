<html>
  <head>
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap" rel="stylesheet">
  </head>
    <style>
      body {
        text-align: center;
        padding: 40px 0;
        background: #EBF0F5;
      }
        h1 {
          color: #88B04B;
          font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
          font-weight: 900;
          font-size: 40px;
          margin-bottom: 10px;
        }
        p {
          color: #404F5E;
          font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
          font-size:20px;
          margin: 0;
        }
      i {
        color: #9ABC66;
        font-size: 100px;
        line-height: 200px;
        margin-left:-15px;
      }
      .card {
        background: white;
        padding: 60px;
        border-radius: 4px;
        box-shadow: 0 2px 3px #C8D0D8;
        display: inline-block;
        margin: 0 auto;
      }
    </style>
    <body>
      <div class="card">
        
      <div style="border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto;">
        <i class="checkmark">✓</i>
      </div>
        <h1>Success</h1> 
        <h2>Payment succesfully record.<br/></h2>
        <p style="align:justify; text-align:left;">Order ID:<?=$queueID?><br/>
        <p style="text-align:left;">Grant Total:RM<?=$grant?><br/></p>
        <p style="text-align:left;">Amount Received:RM<?=$received?><br/></p>
        <p style="text-align:left;">Change:RM<?=$change?><br/></p>
        <br><br>
        <form action="<?=base_url('Checkout/');?>" method="post">
<button type="submit" class="btn btn-info" >Back to collection</button>
</form>
<form action="<?= route_to('staff.receipt');?>" method="post" target="_blank">
<input type="hidden" name="queueID" value="<?=$queueID?>"/>

<button type="submit" class="btn btn-info" >Generate Receipt</button>
</form>
      </div>

    </body>
</html>