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
    header('location:login.php');
  }
  // otherwise show main admin page
  else {
    ?>
    <html>
      <head>
        <title>MIR Admin Interface</title>
        <style type="text/css" media="all">
          @import "<?php echo $baseURL; ?>/mir.css";
        </style>
      </head>
      <body>
        <center>
          <div id="container">
            <?php
              // include header for page
              include($baseDIR . 'admin/header.inc');
              
              // switch for which function to include
	      $string = explode('?', $_SERVER['REQUEST_URI'], 2);
	      $string = explode('/', $string[0], 4);
              switch($string[3]) {
                case "newpost":
                  include($baseDIR . 'admin/newpost.inc');
                  break;
                case "managepost":
                  include($baseDIR . 'admin/managepost.inc');
                  break;
                case "editpost":
                  include($baseDIR . 'admin/editpost.inc');
                  break;
                case "newshow":
                  include($baseDIR . 'admin/newshow.inc');
                  break;
                case "manageshow":
                  include($baseDIR . 'admin/manageshow.inc');
                  break;
                case "editshow":
                  include($baseDIR . 'admin/editshow.inc');
                  break;
                case "manageuser":
                  include($baseDIR . 'admin/manageuser.inc');
                  break;
                case "editprofile":
                  include($baseDIR . 'admin/editprofile.inc');
                  break;
                default:
                  include($baseDIR . 'admin/editprofile.inc');
                  break;
              }
            ?>
          </div> 
        </center> 
      </body>
    </html>
    <?php
  }
  
  //close db after page completes
  //tidying up after page
  include($baseDIR . "admin/dbclose.inc");
?>
