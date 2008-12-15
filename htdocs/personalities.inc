<?php
// create profile page for user
// DBs:
//      -users:       id, username, password
//      -users_data:  id, userid, email, aim, url, description, displayname, hidden
//      -programhost: id, programid, userid

// if user id is sent to page
// then display single user
if(isset($_GET["id"])) {

  // get user info
	$query = "SELECT * FROM users, users_data WHERE users.id = users_data.userid AND users.id = " . $_GET['id'];
	$userProfile = pg_fetch_array(pg_query($query)) or die('Query failed: ' . pg_last_error());
	$imageALT = "Image of " . $userProfile['displayname'];
	
	if(file_exists($baseDIR . "/images/users/" . $userProfile['username'] . ".jpg"))
	 	$imageURL = $baseURL . "/images/users/" . $userProfile['username'].".jpg";
	else
		$imageURL = $baseURL . "/images/users/unknown.jpg";;
	
	echo "<img src=\"" . $imageURL . "\" style=\"float:right; height:100px; padding: 2px 2px 2px 2px; border: solid #ffffff 1px;\" alt=\"" . $imageALT . "\" />";		
	
	echo '<h3>' . $userProfile['displayname'] . ':</h3>';
	echo '<br />';
	echo "<p>" . $userProfile['description'] . "</p>";
	echo '<br />';
	
	echo '<h3>Contact:</h3>';
	echo '<p>';
	echo 'eMail: <a href="mailto:' . $userProfile['email'] . '">' . $userProfile['email'] . '</a><br />';
	if(isset($userProfile['aim'])) {
	  echo 'AIM: ' . $userProfile['aim'] . '<br />';
	}
	if(isset($userProfile['url'])) {
	  echo 'URL: <a href="' . $userProfile['url'] . '">' . $userProfile['url'] . '</a><br />';
	}
	echo '</p>';

	echo "<h3>Shows:</h3>";
	
	// get show host info
  $query2 = "SELECT programlist.id, programlist.name FROM programhost JOIN programlist ON programhost.programid = programlist.id WHERE programhost.userid = " . $_GET['id'];
  $shows = pg_query($query2) or die('Query failed: ' . pg_last_error());
  echo '<p>';
  for($i=(pg_num_rows($shows)-1); $i >= 0; $i--) {
	  echo '<a href="../programming/?id=' . pg_fetch_result($shows, $i, 'id') . '">' . pg_fetch_result($shows, $i, 'name') . '</a><br />';
  }
  echo '</p>';
}

// else display list of visible users
else {

	echo '<h2 class="ojheader">Personalities</h2>';
	echo '<div><br />';

  // get user list
	$query = "SELECT users.id, users_data.displayname FROM users, users_data WHERE users.id = users_data.userid AND users_data.hidden = FALSE ORDER BY users_data.displayname DESC";
	$userList = pg_query($query) or die('Query failed: ' . pg_last_error());	
	
	if (pg_num_rows($userList) == 0) {
	  echo "No DJs doing shows right now. Sorry.";
	}
	else {
	  // display each user in the 
	  for($i = (pg_num_rows($userList)-1); $i>=0; $i--) {
	    $userSingle = pg_fetch_array($userList, $i);
		  echo '-- <a href="./?id=' . $userSingle['id'] . '">' . $userSingle['displayname'] . "</a><br />";
	  }
	}
	echo '<br /></div>';
}
?>
