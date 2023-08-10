<?php
//connect to mysql database
$con = mysqli_connect("localhost", "root",  "", "lms") or die("Error ". mysqli_connect_error() . mysqli_error($con));
$con->query("set names utf8");
date_default_timezone_set("Africa/Cairo");
?>