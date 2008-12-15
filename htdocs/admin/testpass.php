<?php
  //password maker for mir site
  $phash = md5($_REQUEST['uname']) . sha1($_REQUEST['pword']) . sha1($_REQUEST['uname'].md5($_REQUEST['pword']));
  echo 'Username: ' . $_REQUEST['uname'] . '<br />Password: ' . $_REQUEST['pword'] . '<br />Hash: ' . $phash;
?> 