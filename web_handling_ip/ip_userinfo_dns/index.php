<?php
include("db_conn.php");

/*
print('<div style="background-color:white">');

$sql = "SELECT * FROM users WHERE users.user_name='userone' AND users.password='123'";
print($sql . '<hr>');
print_r($conn);
$result = mysqli_query($conn, $sql);

print_r($result);
if($row = mysqli_fetch_assoc($result)){
print_r($row);

}
print('</div>');
*/

//print_r($conn );

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
  
    <title>Login</title>
</head>
<body>

   
  
<div class="row justify-content-center">
  <div class="col-6 center-form">
    <form action="./login.php" method="post">
      <div class="mb-3">
        <h2>LOGIN</h2>
        <?php if (isset($_GET['error'])){ ?> 
            <p class="error"> <?php echo $_GET['error']; ?></p> 
            <p class="error"> <?php echo urldecode($_GET['sql']); ?></p> 
        <?php } ?>
        

        <label class="form-label">Username</label>
        <input type="text" name="uname" class="form-control" placeholder="User Name" >
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" placeholder="Password">
      </div>
      <div class="container text-center">
            <div class="row">
              <div class="col d-flex justify-content-start">
                <button type="submit" class="btn btn-primary">Login</button>
              </div>
              <div class="col d-flex justify-content-end" style="color:blue;">               
                <a href="signup.php" class="signup-link">Sign Up</a>
              </div>
            </div>
      </div>
    </form>
  </div>
</div>

<style>
  .signup-link {
    background-color: blue;
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
  }
</style>


 
    
</body>
</html>