<?php
  /*** edit_profile_user.php
    *  2009.02.01
    *  Daniel Patrick Williams - dwilliams@port8080.net
    *
    *  Views (parts) of MIR's admin interface
   ***/
  // Incoming Variables:
  // - $id
  // - $username
  // - $email
  // - $level
  // - $firstname
  // - $lastname
  // - $displayname
  // - $url
  // - $aim
  // - $description
  // - $hidden
  // --- Variables ---
  $disabled = '';
  
  // Content pane (aka body)
  echo '<div id="page_main"><h2>Edit Profile:</h2>';
  echo form_open('admin/edit_profile_user', '', array('userid' => $id));
  echo '<table cellspacing=15><tr><td valign="top">';
  echo form_fieldset('<b>Name</b>');
  echo '<br />Username:<br />';
  echo form_input(array('name' => 'username',
                        'size' => '66',
                        'value' => $username,
                        'disabled' => 'disabled'));
  echo '<br />Role:<br />';
  if ($level < 4) {
    $disabled = 'disabled="disabled"';
  }
  echo form_dropdown('level', array('8' => 'Administrator',
                                    '4' => 'Director',
                                    '2' => 'Disc Jockey'
                                    '1' => 'Disabled'), $level, $disabled);
  echo '<br />First Name:<br />';
  echo form_input(array('name' => 'firstname',
                        'size' => '66',
                        'value' => $firstname));
  echo '<br />Last Name:<br />';
  echo form_input(array('name' => 'lastname',
                        'size' => '66',
                        'value' => $lastname));
  echo '<br />Display Name:<br />';
  echo form_input(array('name' => 'displayname',
                        'size' => '66',
                        'value' => $displayname));
  echo form_fieldset_close();
  echo '</td><td valign="top">';
  echo form_fieldset('<b>Contact Information</b>');
  echo '<br />Email:<br />';
  echo form_input(array('name' => 'email',
                        'size' => '66',
                        'value' => $email));
  echo '<br />Personal Website:<br />';
  echo form_input(array('name' => 'url',
                        'size' => '66',
                        'value' => $url));
  echo '<br />AIM Username:<br />';
  echo form_input(array('name' => 'aim',
                        'size' => '66',
                        'value' => $aim));
  echo form_fieldset_close();
  echo '</td></tr><tr><td valign="bottom">';
  echo form_fieldset('<b>About You</b>');
  echo '<br />Share a little personal information for your profile.<br />';
  echo form_textarea(array('name' => 'description',
                           'rows' => '6',
                           'cols' => '64',
                           'value' => $description));
  echo form_fieldset_close();
  echo '</td><td valign="top">';
  echo form_fieldset('<b>Update Password</b>');
  echo '<br />';
  echo 'To change your password, use both boxes and type in your new';
  echo '<br />password.  Otherwise, leave both boxes blank.<br />';
  // Put password error here if need be
  echo '<br />New Password:<br />';
  echo form_password(array('name' => 'newpassword1',
                           'size' => '66'));
  echo '<br />Type if again:<br />';
  echo form_password(array('name' => 'newpassword2',
                           'size' => '66'));
  echo form_fieldset_close();
  echo '</td></tr><tr><td colspan=2 align="right" valign="center">';
  echo form_submit(array('name' => 'submit',
                         'value' => 'update'));
  echo '</td></tr></table>';
  echo form_close();
  // End content pane
  echo '</div>';

/* DPW */
/* END OF CODE */
