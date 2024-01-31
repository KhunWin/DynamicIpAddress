
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
  
    <title>HOME</title>
</head>
<body>

    
<div class="container text-center">
        <div class="row">
          <div class="col">
            <button type="button" class="btn btn-primary full-width" id="loginBtn" >Login</button>
          </div>
          <div class="col">
          <button type="button" class="btn btn-primary btn-block full-width" id="signupBtn">AddHostname</button>
          </div>
          <div class="col">
            <button type="button" class="btn btn-primary btn-block full-width" id="signupBtn">SignUp</button>
          </div>
        </div>
</div>


    <style>
        .full-width {
          width: 100%;
        }
    </style>

    <script>
  document.getElementById('loginBtn').addEventListener('click', function() {
    window.location.href = './index.php';
  });
  document.getElementById('signupBtn').addEventListener('click', function() {
    window.location.href = './signup.php';
  });
  document.getElementById('signupBtn').addEventListener('click', function() {
    window.location.href = './host.php';
  });
</script>
    
    
    
</body>
</html>

