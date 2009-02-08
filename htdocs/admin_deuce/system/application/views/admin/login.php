<?php
  /*** login.php
    *  2009.02.01
    *  Daniel Patrick Williams - dwilliams@port8080.net
    *
    *  Views (parts) of MIR's admin interface
   ***/
  // Start the webpage XHTML 1.0 Strict compliant
  echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
  echo '<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">';
  // And a little comment love...
  echo '<!-- MIR Admin Interface     -->';
  echo '<!-- Mines Internet Radio    -->';
  echo '<!-- Daniel Patrick Williams -->';
  echo '<!-- dwilliams@port8080.net  -->';
  // Login page follows
  echo '<head><title>MIR Admin Interface Login</title>';
  echo '<link rel="stylesheet" type="text/css" href="' . base_url() . 'mir.css" />';
  echo '</head><body id="loginbody"><div id="container"><div id="pagetop">';
  echo '<h1>MIR Login</h1></div><center><div id="loginform">';
  echo validation_errors('<div style="color: #ff0000;">', '</div>'); // Bad Username or Password!
  // Use Form helper for the login
  // Update later to use Table helper
  echo form_open('admin/login', array('name' => 'login'));
  echo '<table style="width:95%;"><tr><td style="width:25%;">';
  echo 'Username:</td><td style="width:74%;">';
  echo form_input(array('name' => 'uname', 'id' => 'uname', 'style' => 'width: 100%'));
  echo '</td></tr><tr><td>Password:</td><td>';
  echo form_password(array('name' => 'pword', 'id' => 'pword', 'style' => 'width: 100%'));
  echo '</td></tr><tr><td></td><td>';
  echo form_submit(array('name' => 'submit', 'type' => 'submit', 'id' => 'submit', 'value' => 'Login'));
  echo '</td></tr></table>';
  echo form_close();
  echo '</div></center></div></body></html>';

/* DPW */
/* END OD CODE */
