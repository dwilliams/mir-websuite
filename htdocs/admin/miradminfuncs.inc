<?php
  // This class contains funtions to update rss feeds for MIR

  // update / create function
  function updaterss($shortName) {
    // document base:
    $baseDIR = $_SERVER['DOCUMENT_ROOT'] . '/mir/';
    // get list of last 10 items in feed
    $feedQuery = "SELECT id, programid, title, shortname, description FROM rsslist WHERE shortname = '" . $shortName . "'";
    $feeddb = pg_query($feedQuery) or die('Death?');
    $feeddb = pg_fetch_array($feeddb, 0);

    //for testing
    //echo $feedQuery . '<br />' . $shortName . '<br />' . $feeddb . '<br />' . $feeddb['id'] . ', ' . $feeddb['programid'] . ', ' . $feeddb['title'] . ', ' . $feeddb['shortname'] . ', ' . $feeddb['description'];

    // create string for file contents
    $fileGuts = '';
    // write the xml declaration
    $fileGuts .= '<?xml version="1.0" encoding="utf-8"?>';
    // open rss tag and channel tag
    $fileGuts .= '<rss version="2.0"><channel>';
    // insert title of feed (from db)
    $fileGuts .= '<title>MIR - ' . $feeddb['title'] . '</title>';
    // insert link for MIR
    $fileGuts .= '<link>http://radio.mines.edu/</link>';
    // insert description (from db)
    $fileGuts .= '<description>' . $feeddb['desc'] . '</description>';
    // inserts language (make different languages later)
    $fileGuts .= '<language>' . 'en' . '</language>';
    
    // query for last 10 items and generate item list
    // (add in option for longer query later)
    $itemQuery = 'SELECT title, description, filename, filelen, date FROM rssitems WHERE feedid = ';
    if(isset($feeddb['id'])) {
      $itemQuery .= $feeddb['id'] . ' ORDER BY date ASC LIMIT 10';
    }
    else {
      $itemQuery .= '0 ORDER BY date ASC LIMIT 10';
    }
    $itemdb = pg_query($itemQuery) or die('');
    // list items using for loop
    $numItems = pg_num_rows($itemdb);
    for ($i = 0;$i < $numItems; $i++) {
      // get row for current item
      $currentItem = pg_fetch_array($itemdb, $i);
      // open item tag
      $fileGuts .= '<item>';
      // insert item title
      $fileGuts .= '<title>' . $currentItem['title'] . '</title>';
      // insert item link
      $fileGuts .= '<link>http://radio.mines.edu/programming/?id=' . $feeddb['programid'] . '</link>';
      // insert item description
      $fileGuts .= '<description>' . $currentItem['desc'] . '</descriptions>';
      // insert date for item
      // date(DATE_RFC822, $currentItem['date'])
      $fileGuts .= '<pubDate>' . date('D, d M Y H:i:s O', $currentItem['date']) . '</pubDate>';
      // insert file & guid information if not null
      if($currentItem['filename'] != NULL) {
        $fileGuts .= '<guid>http://radio.mines.edu/rssfiles/' . $feeddb['shortname'] . '/' . $currentItem['filename'] . '</guid>';
        $fileGuts .= '<enclosure url="http://radio.mines.edu/rssfiles/' . $feeddb['shortname'] . '/' . $currentItem['filename'] . '" length="' . $currentItem['filelen'] . '" type="audio/mpeg" />';
      }
      // just sets guid elsewise
      else {
        $fileGuts .= '<guid isPermaLink="false">' . $currentItem['title'] . '</guid>';
      }
      // close item tag
      $fileGuts .= '</item>';
    }
    
    // close channel and rss feed
    $fileGuts .= '</channel></rss>';
    
    // dump string to file
    $filename = $baseDIR . 'rssfiles/' . $feeddb['shortname'] . '.xml';
    if(!file_exists($filename) || is_writable($filename)) {
      if(!$fileHandle = fopen($filename, 'w')) {
        echo "Cain't open Fire";
      }
      if(fwrite($fileHandle, $fileGuts) === FALSE) {
        echo "Cain't write Fire";
      }
      fclose($fileHandle);
    }
    else {
      echo "Fire ain't writable";
    }
        
    // just going to echo to the screen for testing
    //echo $fileGuts;
  }
?>

