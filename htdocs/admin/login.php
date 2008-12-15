<?php
  // set base DIR for includes
  $baseDIR = $_SERVER['DOCUMENT_ROOT'] . '/';
  // set base URL for page
  $baseURL = 'http://radio.mines.edu';
  // start sessions for page
  session_start();
  // includes go here
  // open database
  include($baseDIR . 'dbopen.inc');
  // if not logged in, check password or display login page
  if(!session_is_registered(username) || !session_is_registered(id)) {
    // if form posted, check password
    if(isset($_REQUEST['uname'], $_REQUEST['pword'])) {
      // setup output buffer to keep from outputing login checks
      //ob_start();
      
      // check uname and password submitted
      // password in form md5(uname).sha1(pword).sha1(uname.md5(pword))
      $phash = md5($_REQUEST['uname']) . sha1($_REQUEST['pword']) . sha1($_REQUEST['uname'].md5($_REQUEST['pword']));
      $pwQuery = "SELECT id, username FROM users WHERE username = '" . $_REQUEST['uname'] . "' AND password = '" . $phash . "'";
      $pwResult = pg_query($pwQuery) or die('Query failed: ' . pg_last_error());
      
      // if good, set sessions and send to admin
      if(pg_num_rows($pwResult) == 1) {
        $username = pg_fetch_result($pwResult, 0, username);
        $id = pg_fetch_result($pwResult, 0, id);
        session_register("username");
        session_register("id");
        header('location:' . $baseURL . '/admin/index.php');
      }
      // elsewise send back to login page
      else {
        header('location:' . $baseURL . '/admin/login.php?dud=1');
      }
      
      // end discarding output (silences password / encryption errors)
      //ob_end_clean();
    }
    
    // else display form for login
    else {
      ?>
      <html>
      <head><title>MIR Login</title>
      <style type="text/css" media="all">
      @import "<?php echo $baseURL; ?>/mir.css";
      </style></head>
      <body id="loginbody">
      <div id="container">
        <div id="pagetop">
          <h1>MIR Login</h1>
        </div>
        <center>
        <div id="loginform">
          <?php
            if(isset($_REQUEST['dud'])) {
              echo '<div style="color: #ff0000;">Bad Username or Password!</div>';
            }
          ?>
          <form name="login" method="post" action="login.php">
            <table style="width:95%;">
              <tr>
                <td style="width:25%;">
                  Username:
                </td>
                <td style="width:74%;">
                  <input name="uname" type="text" id="uname" style="width:100%;" />
                </td>
              </tr>
              <tr>
                <td>
                  Password:
                </td>
                <td>
                  <input name="pword" type="password" id="pword" style="width:100%;" />
                </td>
              </tr>
              <tr>
                <td>
                </td>
                <td>
                  <input name="submit" type="submit" id="submit" value="Login" />
                </td>
              </tr>
            </table>
          </form>
        </div>
        </center>
      </div></body></html>
      <?php
    }
  }
  
  // elsewise go to admin interface
  else {
    header('location:' . $baseURL . '/admin/index.php');
  }
  
  // close the db connectio  
  include($baseDIR . '/dbclose.inc');
?>
