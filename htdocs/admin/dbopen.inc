<?php
// Connecting, selecting database
$dbconn = pg_connect("host=localhost dbname=mirweb user=miredit password=xxxx")
    or die('Could not connect: ' . pg_last_error());
?>
