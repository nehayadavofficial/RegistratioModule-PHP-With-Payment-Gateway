<!DOCTYPE html>
<html>
<head>
	<title>SIGN UP</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
     <form action="pay.php" method="post">
     	<h2>SIGN UP</h2>
     	<?php if (isset($_GET['error'])) { ?>
     		<p class="error"><?php echo $_GET['error']; ?></p>
     	<?php } ?>

          <?php if (isset($_GET['success'])) { ?>
               <p class="success"><?php echo $_GET['success']; ?></p>
          <?php } ?>

          <label>Name</label>
          <?php if (isset($_GET['customername'])) { ?>
               <input type="text" 
                      name="customername" 
                      placeholder="Name"
                      value="<?php echo $_GET['customername']; ?>"><br>
          <?php }else{ ?>
               <input type="text" 
                      name="customername" 
                      placeholder="Name"><br>
          <?php }?>

          <label>Email</label>
          <?php if (isset($_GET['email'])) { ?>
               <input type="email" 
                      name="email" 
                      placeholder="User Email"
                      value="<?php echo $_GET['email']; ?>"><br>
          <?php }else{ ?>
               <input type="email" 
                      name="email" 
                      placeholder="User Email"><br>
          <?php }?>


          <label>Email</label>
          <?php if (isset($_GET['contactno'])) { ?>
               <input type="number" 
                      name="contactno" 
                      placeholder="User Conatct"
                      value="<?php echo $_GET['contactno']; ?>"><br>
          <?php }else{ ?>
               <input type="number" 
                      name="contactno" 
                      placeholder="User Contact"><br>
          <?php }?>


     	<label>Password</label>
     	<input type="password" 
                 name="password" 
                 placeholder="Password"><br>

          <label>Re Password</label>
          <input type="password" 
                 name="re_password" 
                 placeholder="Re_Password"><br>

     	<button type="submit">Sign Up</button>
          <a href="index.php" class="ca">Already have an account?</a>
     </form>

</body>
</html>