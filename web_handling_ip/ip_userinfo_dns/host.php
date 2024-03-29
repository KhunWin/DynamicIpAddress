<?php
include("db_conn.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">

  <title>SIGNUP</title>
</head>

<body>


<div class="row justify-content-center">
    <div class="col-6 center-form">
      <form action="./add_hostname.php" method="POST">
        <div class="mb-3">
          <h2>Create Hostname</h2>

          <label class="form-label">Hostname</label>
          <input type="text" name="host_name" class="form-control" placeholder="User Name">
        </div>
        <div class="mb-3">
          <label class="form-label">IPAddress</label>
          <input type="text" name="ipaddr" class="form-control" placeholder="IpAddress" value="<?php echo getPublicIPAddress(); ?>">
        </div>
        

        <div class="container text-center">
          <div class="row">
            <div class="col d-flex justify-content-start">
              <button type="submit" class="btn btn-primary">Add Hostname</button>
            </div>

          </div>
        </div>
      </form>
    </div>
</div>



</body>

</html>

<?php
function getPublicIPAddress() {
    $ip = file_get_contents('https://api.ipify.org');
    return $ip ? $ip : 'Unable to retrieve IP address';
}
?>