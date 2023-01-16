<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<style>
    .text-danger strong {
    		color: #9f181c;
		}
		.receipt-main {
			background: #ffffff none repeat scroll 0 0;
			border-bottom: 12px solid #333333;
			border-top: 12px solid #9f181c;
			margin-top: 50px;
			margin-bottom: 50px;
			padding: 40px 30px !important;
			position: relative;
			box-shadow: 0 1px 21px #acacac;
			color: #333333;
			font-family: open sans;
		}
		.receipt-main p {
			color: #333333;
			font-family: open sans;
			line-height: 1.42857;
		}
		.receipt-footer h1 {
			font-size: 15px;
			font-weight: 400 !important;
			margin: 0 !important;
		}
		.receipt-main::after {
			background: #414143 none repeat scroll 0 0;
			content: "";
			height: 5px;
			left: 0;
			position: absolute;
			right: 0;
			top: -13px;
		}
		.receipt-main thead {
			background: #414143 none repeat scroll 0 0;
		}
		.receipt-main thead th {
			color:#fff;
		}
		.receipt-right h5 {
			font-size: 16px;
			font-weight: bold;
			margin: 0 0 7px 0;
		}
		.receipt-right p {
			font-size: 12px;
			margin: 0px;
		}
		.receipt-right p i {
			text-align: center;
			width: 18px;
		}
		.receipt-main td {
			padding: 9px 20px !important;
		}
		.receipt-main th {
			padding: 13px 20px !important;
		}
		.receipt-main td {
			font-size: 13px;
			font-weight: initial !important;
		}
		.receipt-main td p:last-child {
			margin: 0;
			padding: 0;
		}	
		.receipt-main td h2 {
			font-size: 20px;
			font-weight: 900;
			margin: 0;
			text-transform: uppercase;
		}
		.receipt-header-mid .receipt-left h1 {
			font-weight: 100;
			margin: 34px 0 0;
			text-align: right;
			text-transform: uppercase;
		}
		.receipt-header-mid {
			margin: 24px 0;
			overflow: hidden;
		}
		
		#container {
			background-color: #dcdcdc;
		}
</style>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<div class="container">
	<div class="row">
		
        <div class="receipt-main col-xs-10 col-sm-10 col-md-6 col-xs-offset-1 col-sm-offset-1 col-md-offset-3">
            <div class="row">
    			<div class="receipt-header">
					<div class="col-xs-6 col-sm-6 col-md-6">
						<div class="receipt-left">
							<img class="img-responsive" alt="M" src="https://i.ibb.co/nQDMYGz/8bb57515-fe3d-4859-9657-262a2f77a34b.jpg" style="width: 71px; border-radius: 43px;">
						</div>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6 text-right">
						<div class="receipt-right" style="float:right;">
							<h5>MENDIKLINIK KAMPAR</h5>
							<p>0137601108 <i class="fa fa-phone"></i></p>
							<p><i class="fa fa-envelope-o"></i></p>
							<p>2226, Jalan Batu Karang, Taman Bandar Baru, Bandar Baru, 31900 Kampar, Perak<i class="fa fa-location-arrow"></i></p>
						</div>
					</div>
				</div>
            </div>
			
			<div class="row">
				<div class="receipt-header receipt-header-mid">
					<div class="col-xs-8 col-sm-8 col-md-8 text-left">
						<div class="receipt-right">
							<h5>Patient Name:<?=$pData['name']?></h5>
							<h5>Contact No&nbsp;&nbsp;&nbsp;:<?=$pData['phone']?></h5>
							<h5>Identity No&nbsp;&nbsp;&nbsp;:<?=$pData['ic']?></h5>
						</div>
					</div>
					<div class="col-xs-4 col-sm-4 col-md-4">
						<div class="receipt-left">
							<h1>Clinic Receipt</h1>
						</div>
					</div>
				</div>
            </div>
			
            <div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
               if(!empty($orderDetails)){
                foreach ($orderDetails as $key => $row) {
               ?>
                        <tr>
                            <td class="col-md-9"><?=$row['itemName']?>&nbsp;|Quantity(<?=$row['quantity']?>)
                            <br>
                            Remark:&nbsp;<?=$row['remark']?>
                            </td>
                            <td class="col-md-3"><i class="fa fa-inr"></i><?=$row['subTotal']?></td>
                        </tr>
                <?php } }?>
                <?php 
               if(!empty($servicesOrderData)){
                foreach ($servicesOrderData as $key => $row) {
               ?>
                        <tr>
                            <td class="col-md-9"><?=$row['servicesName']?>&nbsp;|Quantity(<?=$row['quantity']?>)
        
                            </td>
                            <td class="col-md-3"><i class="fa fa-inr"></i><?=$row['subtotal']?></td>
                        </tr>
                <?php } }?>
                        <tr>
                            <td class="text-right">
                            <p>
                                <strong>Total Amount: </strong>
                            </p>
                            <p>
                                <strong>Cash Received: </strong>
                            </p>
							<p>
                                <strong>Change: </strong>
                            </p>

							</td>
                            <td>
                            <p>
                                <strong><i class="fa fa-inr"></i>RM<?=$qData['grant']?></strong>
                            </p>
                            <p>
                                <strong><i class="fa fa-inr"></i>RM<?=$qData['received']?></strong>
                            </p>
							<p>
                                <strong><i class="fa fa-inr"></i>RM<?=$qData['change']?></strong>
                            </p>
						
							</td>
                        </tr>
                        <tr>
                           
                            <td class="text-right"><h2><strong>Total: </strong></h2></td>
                            <td class="text-left text-danger"><h2><strong><i class="fa fa-inr"></i>RM<?=$qData['grant']?></strong></h2></td>
                        </tr>
                    </tbody>
                </table>
            </div>
			
			<div class="row">
				<div class="receipt-header receipt-header-mid receipt-footer">
					<div class="col-xs-8 col-sm-8 col-md-8 text-left">
						<div class="receipt-right">
							<p><b>Date : </b><?=$qData['date']?></p>
							<h5 style="color: rgb(140, 140, 140);">Thank you, have a good day.</h5>
						</div>
					</div>
					<div class="col-xs-4 col-sm-4 col-md-4">
						<div class="receipt-left">
							<h1>Signature: <i>zheng phin</i></h1>
						</div>
					</div>
				</div>
            </div>
			
        </div>    
	</div>
</div>