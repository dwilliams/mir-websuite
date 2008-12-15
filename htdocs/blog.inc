<?php
  //for testing
  //echo '<div class="post">';
  //echo $category;
  //echo '</div>';
  
  // Blog post page for MIR
  // post table has columns: id, posttitle, postdate, postbody
  
  // pull list of last 10 posts from db
  $postQuery = "SELECT posttitle, postbody FROM posts WHERE category = '" . $category . "' ORDER BY postdate DESC LIMIT 10";
  $postdb = pg_query($postQuery) or die('Query failed: ' . pg_last_error());
  
  // iterate through list of posts
  $numPosts = pg_num_rows($postdb);
  if($numPosts == 0) {
    echo '<div class="post"><p>No Posts Here!!</p></div>';
  }
  else {
    for($i = 0; $i < $numPosts; $i++) {
      $currentPost = pg_fetch_array($postdb, $i);
      echo '<div class="post"><h3>' . $currentPost['posttitle'] . '</h3>';
      echo '<p>' . $currentPost['postbody'] . '</p></div>';
    }
  }
?>
