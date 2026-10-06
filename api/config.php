<?php
$dbhost = getenv("DB_HOST");
$dbuser = getenv("DB_USER");
$dbpass = getenv("DB_PASS");
$dbname = getenv("DB_NAME");


$conn=mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

if(!$conn)
{
die("could not connect database".mysqli_connect_error());
}
?>
