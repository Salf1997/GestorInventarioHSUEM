<?php
// Enter your Host, username, password, database below.
// I left password empty because i do not set password on localhost.
$con = mysqli_connect("localhost","root","","hsuem");
//$con = mysqli_connect("localhost","hsimulado","h.Simu_33","hsimulado");
// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

  mysqli_set_charset($con, "utf8");
?>