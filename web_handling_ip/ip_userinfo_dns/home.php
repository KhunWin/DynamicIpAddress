<?php
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {

?>


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
          <button type="button" class="btn btn-primary full-width" onclick="downloadFile('IpAddr_v4.msix')">Window</button>
        </div>
        <div class="col">
          <button type="button" class="btn btn-primary btn-block full-width" onclick="downloadFile('macos_ipaddr_v4.dmg')">Mac</button>
        </div>
        <div class="col">
          <button type="button" class="btn btn-primary btn-block full-width">Linux</button>
        </div>
      </div>
    </div>

    <h1>Hello, <?php echo $_SESSION['name']; ?></h1>

    <a href="logout.php"> Logout</a>

    <a href="host.php"> Add a Hostname</a>

    <style>
      .full-width {
        width: 100%;
      }
    </style>
    <script>
      function downloadFile(filename) {
        var link = document.createElement('a');
        link.href = filename;
        link.download = filename.split('/').pop();
        link.click();
      }
    </script>


  </body>

  </html>

<?php

} else {
  header("Location: index.php");
  exit();
}

?>