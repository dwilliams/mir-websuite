<?php
  /*** page_close.php
    *  2009.02.01
    *  Daniel Patrick Williams - dwilliams@port8080.net
    *
    *  Views (parts) of MIR's admin interface
   ***/
  // Close body and html page
  echo '<div id="page_banner_bottom">';
  echo '<div class="banner_text_copyright">';
  echo 'Mines Internet Radio &copy; ' . date('Y') . ' - All Rights Reserved';
  echo '<br />';
  echo '<a href="' . site_url('main/home') . '">Home</a> - <a href="' . site_url('admin') . '">Admin</a>';
  echo '</div></div></div></body></html>';

/* DPW */
/* END OD CODE */
