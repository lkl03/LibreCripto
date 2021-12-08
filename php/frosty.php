<head>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
</head>

<?php

echo '<script type="text/javascript">';
echo 'setTimeout(function () {';
echo 'swal("Success!","data successfully added","success").then( function(val) {';
echo 'if (val == true) window.location.href = \'../index.php\';';
echo '});';
echo '}, 200);  </script>';
 ?>