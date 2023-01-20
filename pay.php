<link rel="stylesheet" type="text/css" href="recipt.css">

<?php

require('config.php');
require('razorpay-php/Razorpay.php');
session_start();

// Create the Razorpay Order

use Razorpay\Api\Api;

$api = new Api($keyId, $keySecret);

//
// We create an razorpay order using orders api
// Docs: https://docs.razorpay.com/docs/orders
//
if(isset($_POST['customername']) && $_POST['customername'] != '' ){
  
  $price = 100;
  $customername = $_POST['customername'];
  $email = $_POST['email'];
  $contactno = $_POST['contactno'];
  
  $check_query = "SELECT * FROM `orders` WHERE email = '".$email."'";
  $result = mysqli_query($conn, $check_query);
  if(mysqli_num_rows($result) === 1){
        header("Location:signup.php?error=Email ID Already in Use");
        exit();
    }else{
        $_SESSION['price'] = $price;
        $_SESSION['email'] = $email;
        $_SESSION['name'] = $customername;
        $_SESSION['contactno']= $contactno;
        $_SESSION['password']= $_POST['password'];

        $orderData = [
            'receipt'         => 3456,
            'amount'          => $price * 100, // 2000 rupees in paise
            'currency'        => 'INR',
            'payment_capture' => 1 // auto capture
        ];

        $razorpayOrder = $api->order->create($orderData);

        $razorpayOrderId = $razorpayOrder['id'];

        $_SESSION['razorpay_order_id'] = $razorpayOrderId;

        $displayAmount = $amount = $orderData['amount'];

        if ($displayCurrency !== 'INR')
        {
            $url = "https://api.fixer.io/latest?symbols=$displayCurrency&base=INR";
            $exchange = json_decode(file_get_contents($url), true);

            $displayAmount = $exchange['rates'][$displayCurrency] * $amount / 100;
        }

        $data = [
            "key"               => $keyId,
            "amount"            => $amount,
            "name"              => "Neha Yadav",
            "description"       => "Pay the amount to Neha",
            "image"             => "https://s29.postimg.org/r6dj1g85z/daft_punk.jpg",
            "prefill"           => [
            "name"              => $customername,
            "email"             => $email,
            "contact"           => $contactno,
            ],
            "notes"             => [
            "address"           => "Hello World",
            "merchant_order_id" => "12312321",
            ],
            "theme"             => [
            "color"             => "#F37254"
            ],
            "order_id"          => $razorpayOrderId,
        ];

        if ($displayCurrency !== 'INR')
        {
            $data['display_currency']  = $displayCurrency;
            $data['display_amount']    = $displayAmount;
        }

        $json = json_encode($data);
        ?>


        <body>
          <div id="invoiceholder">
          <div id="invoice" class="effect2">
            
            <div id="invoice-top">
              <div class="title">
                <h1>Payment <span class="invoiceVal invoice_num"></span></h1><br>
                <p>Paymemt Date: <span id="invoice_date"><?php echo date('d/M/Y')?></span>
                </p>
              </div>
            </div>
            <div id="invoice-mid">   
              <div id="message">
                <h2>Hello <?php echo $customername; ?></h2>
                <p>A payment of Rs.100 will be charged for the Registeration of the User and this is the registration fees of the user if already have a account <a href="index.php">Click here</a> to login to view the invoice.</p>
              </div>  
            </div><!--End Invoice Mid-->
            
            <div id="invoice-bot">
              
              <div id="table">
                <table class="table-main">
                  <thead>    
                      <tr class="tabletitle">
                        <th>Name</th>
                        <th>Email</th>
                        <th>COnatct</th>
                        <th>Purpose</th>
                        <th>Price</th>
                        <th>Total</th>
                      </tr>
                  </thead>
                  <tr class="list-item">
                    <td data-label="Type" class="tableitem"><?php echo $customername?></td>
                    <td data-label="Description" class="tableitem"><?php echo $email?></td>
                    <td data-label="Quantity" class="tableitem"><?php echo $contactno?></td>
                    <td data-label="Unit Price" class="tableitem">Registration</td>
                    <td data-label="Taxable Amount" class="tableitem"><?php echo $price?></td>
                    <td data-label="Tax Code" class="tableitem"><?php echo $price?></td>
                  </tr>
                    <tr class="list-item total-row">
                        <th colspan="5" class="tableitem">Grand Total</th>
                        <th data-label="Grand Total" class="tableitem"><?php echo $price?></th>
                    </tr>
                </table>
              </div><!--End Table-->
              <div class="cta-group">
                <a href="javascript:void(0);" class="btn-primary">


                <form action="verify.php" method="POST">
                  <script
                    src="https://checkout.razorpay.com/v1/checkout.js"
                    data-key="<?php echo $data['key']?>"
                    data-amount="<?php echo $data['amount']?>"
                    data-currency="INR"
                    data-name="<?php echo $data['name']?>"
                    data-image="<?php echo $data['image']?>"
                    data-description="<?php echo $data['description']?>"
                    data-prefill.name="<?php echo $data['prefill']['name']?>"
                    data-prefill.email="<?php echo $data['prefill']['email']?>"
                    data-prefill.contact="<?php echo $data['prefill']['contact']?>"
                    data-notes.shopping_order_id="3456"
                    data-order_id="<?php echo $data['order_id']?>"
                    <?php if ($displayCurrency !== 'INR') { ?> data-display_amount="<?php echo $data['display_amount']?>" <?php } ?>
                    <?php if ($displayCurrency !== 'INR') { ?> data-display_currency="<?php echo $data['display_currency']?>" <?php } ?>
                  >
                  </script>
                  <input type="hidden" name="shopping_order_id" value="3456">
                </form>


                </a>
                <a href="signup.php" class="btn-default">Reject</a>
            </div> 
              
            </div><!--End InvoiceBot-->
            <footer>
              <div id="legalcopy" class="clearfix">
                <p class="col-right">Our mailing address is:
                    <span class="email"><a href="yadavneha1383@gmail.com">yadavneha1383@gmail.com</a></span>
                </p>
              </div>
            </footer>
          </div><!--End Invoice-->
        </div><!-- End Invoice Holder-->
        </body>

  
      <?php
    } 
}else{
  header("Location: signup.php?error=Please fill the form and then Proceed&$user_data");
	exit();
}
 ?>






