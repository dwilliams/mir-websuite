<?php
  //set base DIR of website to non-root dir
  $baseDIR = $_SERVER['DOCUMENT_ROOT'] . '/';
  //set base URL of website to non-root dir
  $baseURL = 'http://localhost';
  // includes go here
  // start page session for logins
  session_start();
  //open database for usage in page
  include($baseDIR . 'admin/dbopen.inc');
  // if not logged in go to login page
  if(!session_is_registered(username) || !session_is_registered(id)) {
    $header = 'location:login.php';
  }
  //process data sent from forms
  else {
    switch($_POST['formtype']) {
      case editprofile:
        //set return page
        $header = 'location:' . $baseURL . '/admin/index.php/editprofile';
        //if is a password change
        if(isset($_POST['newpassword1'], $_POST['newpassword2']) && $_POST['newpassword1'] != '' && $_POST['newpassword2'] != '') {
          //if same (retyped properly), set password
          if($_POST['newpassword1'] == $_POST['newpassword2']) {
            $phash = md5($_POST['username']) . sha1($_POST['newpassword2']) . sha1($_POST['username'].md5($_POST['newpassword1']));
            $passwdUpdateQuery = 'UPDATE users SET password = ' . "'" . $phash . "'" . ' WHERE id = ' . $_POST['userid'];
            pg_query($passwdUpdateQuery) or die('Query failed: ' . pg_last_error());
          }
          //otherwise send error
          else {
            $header = 'location:' . $baseURL . '/admin/index.php/editprofile?dud=passwd';
          }
        }
        //now process field changes
        $userUpdateQuery = 'UPDATE users SET email = ' . "'" . $_POST['email'] . "'" . ', level = ' . "'" . $_POST['level'] . "'" . ' WHERE id = ' . $_POST['userid'];
        $userDataUpdateQuery = 'UPDATE users_data SET firstname = ' . "'" . $_POST['firstname'] . "'" . ', lastname = ' . "'" . $_POST['lastname'] . "'" . ', displayname = ' . "'" . $_POST['displayname'] . "'" . ', url = ' . "'" . $_POST['url'] . "'" . ', aim = ' . "'" . $_POST['aim'] . "'" . ', description = ' . "'" . $_POST['description'] . "'" . ' WHERE userid = ' . $_POST['userid'];
        pg_query($userUpdateQuery) or die('Query failed: ' . pg_last_error());
        pg_query($userDataUpdateQuery) or die('Query failed: ' . pg_last_error());
        break;
      default:
        $header = 'location:' . $baseURL . '/admin/index.php';
        break;
    }
  }
  //close database
  include($baseDIR . 'admin/dbclose.inc');
  //go to page
  header($header);
?>
