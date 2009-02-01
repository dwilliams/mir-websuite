<?php
  //set base DIR of website to non-root dir
  $baseDIR = $_SERVER['DOCUMENT_ROOT'] . '/';
  //set base URL of website to non-root dir
  $baseURL = 'http://radio.mines.edu';
  //open database for usage in page
  include($baseDIR . 'dbopen.inc');
  
  //output for the vista gadget
  //title, artist, album of last played song
  
  // Perform SQL query for last played
  $lpquery = "SELECT title, artist, album FROM lastplayed ORDER BY time DESC LIMIT 1";
  $lp = pg_query($lpquery) or die('Query failed: ' . pg_last_error());
  $lprow = pg_fetch_array($lp, 0);
  echo $lprow["title"] . "<br />";
  echo $lprow["artist"] . "<br />";
  echo $lprow["album"];
  pg_free_result($lp);
  
  //tidying up after page
  include($baseDIR . "dbclose.inc");
?>
