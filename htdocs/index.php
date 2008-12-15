<?php
  //set base DIR of website to non-root dir
  $baseDIR = $_SERVER['DOCUMENT_ROOT'] . '/';
  //set base URL of website to non-root dir
  $baseURL = 'http://localhost';
  //open database for usage in page
  include($baseDIR . 'dbopen.inc');
  //set day for schedules (3 letter capped)
  $day = date('D');
  //echo first line because "<?xml" tag causes issues with php
  echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<!-- Daniel Williams - 2008.02.08          -->
<!-- Written for the CSM Broadcasting Club -->
<!-- Revision 0.1.0:                       -->
<!--   -Initial Revision                   -->

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>Mines Internet Radio</title>
    <!-- meta tags go here -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <!-- list css files inside style tags -->
    <style type="text/css" media="all">
      @import "<?php echo $baseURL; ?>/mir.css";
    </style>
  </head>
  <body>
    <center>
      <div id="pagewhole">
        <!-- banner at top of page -->
        <div id="pagetop">
          <h1>Mines Internet Radio</h1>
          <h2>http://radio.mines.edu/ -- 303-273-3304 -- AIM: MinesRadio</h2>
        </div>
        <div>
          <?php include($baseDIR . "/menu.inc"); ?>
        </div>
        <!-- END: top banner -->
        <!-- container for columns -->
        <div class="container">
          <div id="pagesidebar">
            <!-- always same -->
            <div class="sidebardiv">
              <h2>listen:</h2>
              <div style="text-align: right;">
                Studio One:<a href="<?php echo $baseURL; ?>/streams/mirstudioone128.m3u">HIGH</a>&nbsp;&nbsp;<a href="<?php echo $baseURL; ?>/streams/mirstudioone32.m3u">LOW</a><br />
                Sports:<a href="<?php echo $baseURL; ?>/streams/mirsports128.m3u">HIGH</a>&nbsp;&nbsp;<a href="<?php echo $baseURL; ?>/streams/mirsports32.m3u">LOW</a>
              </div>
            </div>
            <!-- created via php from SQL -->
            <!-- same on all pages -->
            <div class="sidebardiv">
              <h2 class="ojheader">Now Playing:</h2>
            </div>
            <!-- seven pages - one for each day -->
            <!-- start off just displaying todays -->
            <div class="sidebardiv">
              <h2 class="ojheader">Schedule:</h2>
              <h2><?php echo date('l'); ?></h2>
              <!-- get schedule here -->
              <?php
              // Performing SQL query
              $query = "SELECT programlist.name, programlist.id, programtime.timestart, programtime.timeend FROM programtime, programlist WHERE programlist.id = programtime.programid AND programtime.day = '" . $day . "' ORDER BY timestart ASC";
              $cow = pg_query($query) or die('Query failed: ' . pg_last_error());
              $todayShow = pg_fetch_all($cow);

              if($todayShow == "") {
                echo "No shows for today!";
              }
              else {
                foreach($todayShow as $thisShow) {
                  echo $thisShow["timestart"]." - ".$thisShow["timeend"]."<br /><a href=\"". 'get_bloginfo("url")' ."/programming/?submit=".md5(rand())."&ID=".$thisShow["ID"]."\">".stripslashes($thisShow["name"])."</a>";
                }
              }
              // Free resultset
              pg_free_result($cow);
              ?>
            </div>
            <!-- always the same -->
            <div class="sidebardiv">
              <h2><a href="http://www.savenetradio.org">SaveNetRadio.org</a></h2>
            </div>
            <!-- makes poll via php from SQL -->
            <!-- two pages - poll & results -->
            <div class="sidebardiv">
              <h2 class="ojheader">Poll:</h2>
            </div>
          </div>
          <!-- posts generated via php from SQL -->
          <!-- lots of work goes here!! -->
          <div id="pagebody">
            <?php
              $string = explode('?', $_SERVER['REQUEST_URI'], 2);
              switch($string[0]) {
                // programming page when requested
                case "/programming/":
                  echo '<div class="post">';
                  include($baseDIR . "programming.inc");
                  echo '</div>';
                  break;
                // personalities page when requested
                case "/personalities/":
                  echo '<div class="post">';
                  include($baseDIR . "personalities.inc");
                  echo '</div>';
                  break;
                // sports page when requested
                case "/sports/":;
                  $category = sports;
                  include($baseDIR . "blog.inc");
                  break;
                // sports page when requested
                case "/contacts/":;
                  $category = contacts;
                  include($baseDIR . "blog.inc");
                  break;
                // home page on all-else
                default:
                  // for testing:
                  //echo '<!-- home goes here -->';
                  //echo '<p class="post">hello world!<br />yay better radio website!</p>';
                  $category = homepage;
                  include($baseDIR . "blog.inc");
                  break;
              }
            ?>
          </div>
        </div>
        <!-- END: container -->
        <!-- page footer -->          
        <div id="pagebottom">
          <!-- CSMBC Copyright info goes here -->
          <!-- update with php to constantly have this year displayed -->
          <p class="footertext">
            Colorado School of Mines Broadcasting Club - Mines Internet Radio
            <br />
            http://radio.mines.edu -- Copyright &copy; 2005-<?php echo date('Y'); ?>
          </p>
        </div>
        <!-- END: page footer -->
      </div>
    </center>
  </body>
</html>
<?php
  //close db after page completes
  //tidying up after page
  include($baseDIR . "dbclose.inc");
?>
