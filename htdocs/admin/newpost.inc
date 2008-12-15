<?php
  // if form submitted then process
  if(isset($_POST['fromform'])) {
    // check for blank values
    if(($_POST['title'] == '') || ($_POST['content'] == '') || ($_POST['posttype'] == '')) {
      echo 'Fill in all fields!';
    }
    else {
      // build query to post in db
      $npQuery = "INSERT INTO posts (category, userid, posttitle, postbody, postdate) VALUES ('" . $_POST['posttype'] . "', '" . $_SESSION['id'] . "', '" . $_POST['title'] . "', '" . $_POST['content'] . "', '" . time() . "')";
      // send query
      pg_query($npQuery) or die('Query failed: ' . pg_last_error());
    
      // display result
      echo 'Posted Successfully';
    }
  }
  
  // elsewise show form
  else {
    echo '<div>';
   
    // section title
    echo '<h2>New Post:</h2>';
  
    // make form with hidden "from" value
    echo '<form name="newpost" method="post" action="' . $baseURL . '/admin/index.php?adminpage=newpost">';
    echo '<input name="fromform" type="hidden" value="1" />';
    
    // post title
    echo '<legend>Title</legend>';
  	echo '<div><input name="title" value="" id="title" type="text" /></div>';
  	
  	// post text box
    echo '<legend>Post</legend>';
    echo '<div><textarea name="content" id="content"></textarea></div>';
    
    // post blogroll
    echo '<legend>Type</legend>';
    echo '<div><input type="radio" name="posttype" value="homepage" />Homepage<br />';
    echo '<input type="radio" name="posttype" value="sports" />Sports<br />';
    echo '<input type="radio" name="posttype" value="contacts" />Contact<br /></div>';
    
    // post submit button
    echo '<div><input name="publish" id="publish" value="Publish" type="submit"></div>';
    
    echo '</div>';
  }
?>
