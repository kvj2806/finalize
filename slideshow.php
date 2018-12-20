<?php
    error_reporting(E_ALL & ~E_NOTICE);
    require_once 'output.php';
?>
<!DOCTYPE html>
<html>
<head>
 <title>Sequence Generator</title>

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        
</head>
<body>
    <?php output() ?>
</body>
<script src="script.js"></script>
</html>