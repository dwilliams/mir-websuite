<?php
  // if id is set - display show with id
  if(isset($_GET["id"])) {
 
    // get show info
  	$query = "SELECT * FROM programlist JOIN programtime ON programlist.id = programtime.programid WHERE programlist.id = " . $_GET['id'];
  	$showProfile = pg_fetch_array(pg_query($query)) or die('Query failed: ' . pg_last_error());
   	$imageALT = "Image of " . $showProfile['name'];
	
    if(file_exists($baseDIR . "/images/show/" . $showProfile['shortname'] . ".jpg"))
  	 	$imageURL = $baseURL . "/images/show/" . $showProfile['shortname'].".jpg";
    else
	    $imageURL = $baseURL . "/images/show/unknown.jpg";;
	
    echo "<img src=\"" . $imageURL . "\" style=\"float:right; height:100px; padding: 2px 2px 2px 2px; border: solid #ffffff 1px;\" alt=\"" . $imageALT . "\" />";		
	
    echo "<h3><a href=\"" . $showProfile['url'] . "\">" . $showProfile['name'] . "</a></h3>";
    echo '<br />';
    echo '<p>' . $showProfile['description'] . '</p>';
    
    if(isset($showProfile['url'])) {
	    echo '<p>URL: <a href="' . $showProfile['url'] . '">' . $showProfile['url'] . '</a></p>';
	  }
	
    echo '<h3>Hosts:</h3><p>';
    
    // get show host info
  	$query2 = "SELECT users_data.userid, users_data.displayname FROM programhost JOIN users_data ON programhost.userid = users_data.userid WHERE programhost.programid = " . $_GET['id'];
  	$showHosts = pg_query($query2) or die('Query failed: ' . pg_last_error());
  	for($i=(pg_num_rows($showHosts)-1); $i >= 0; $i--) {
  	  echo '<a href="../personalities/?id=' . pg_fetch_result($showHosts, $i, 'userid') . '">' . pg_fetch_result($showHosts, $i, 'displayname') . '</a><br />';
  	}

    //echo "email: <script language\"javascript\">document.write(Decode('".str_rot13($singleUser["user_email"])."'))</script>";
    echo "</p>";
  }
  // else - show schedule
  else {
    // Array to iterate through week
    $get3CharDay = array("Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat");

    // set cell class
    // change to css class for website
    $class = "style=\"border: solid #000000 1px; width:120px; height: 2.0em;\"";
    //$class = "";
    
    echo '<table id="schedule" summary="Programing Schedule"><caption>Schedule</caption>';
    echo '<!-- prints the column headers for schedule --><tr>';
    echo '<th scope="col" width="70px">&nbsp;</th>';
    echo '<th scope="col">Sunday</th>';
    echo '<th scope="col">Monday</th>';
    echo '<th scope="col">Tuesday</th>';
    echo '<th scope="col">Wednesday</th>';
    echo '<th scope="col">Thursday</th>';
    echo '<th scope="col">Friday</th>';
    echo '<th scope="col">Saturday</th></tr>';

    // prints body of the schedule
	  for($scheduleTime=7; $scheduleTime <24; $scheduleTime++) {

		  echo "<tr>\n";

		  // prints time on left ( first ) column of row
		  echo "<th scope=\"row\">" . "$scheduleTime:00" . "</th>\n";

		  // prints the shows for each day ( if one exists 
 		  for($scheduleDay = 0; $scheduleDay<7;$scheduleDay++) {

		    // Performing SQL query
        $query = "SELECT programlist.name, programlist.id, programtime.timestart, programtime.timeend FROM programtime, programlist WHERE programlist.id = programtime.programid AND programtime.day = '" . $get3CharDay[$scheduleDay] . "' AND programtime.timestart <= '" . $scheduleTime . ":00' AND programtime.timeend > '" . $scheduleTime . ":00'";
        $cow = pg_query($query) or die('Query failed: ' . pg_last_error());

        // if only one show at this time
        if(pg_num_rows($cow) == 1) {

          // display show in table
          if(pg_fetch_result($cow, 0, 'timestart') == $scheduleTime) {

            // calculate times for setting rowspan
  					$timeStart = split(":", pg_fetch_result($cow, 0, 'timestart'));
	  				$timeStart = $timeStart[0];
					  $timeEnd = split(":", pg_fetch_result($cow, 0, 'timeend'));
					  $timeEnd = $timeEnd[0];

					  // set rowspan to fill up timeslot
					  $rowspan = "rowspan=\"".($timeEnd-$timeStart)."\"";

					  // get the show name and id
            $show = pg_fetch_result($cow, 0, 'name');
            $showid = pg_fetch_result($cow, 0, 'id');
					  echo '<td ' . $class . ' ' . $rowspan . '><p><a href="' . $baseURL . '/programming/?id=' . $showid . '">' . $show . '</a></p></td>';
					}
        }
        else {

          // echo blank cell
          echo "<td " . $class . ">&nbsp;</td>";
        }
      }

      // Free resultset
      pg_free_result($cow);
    }
    echo "</tr>\n";
  }
?>		
		
</table>
