<!--moo cows are yummy...-->
<?php
  // pull userdata from db
  $userQuery = "SELECT users.id, users.username, users.email, users.level, users_data.firstname, users_data.lastname, users_data.displayname, users_data.url, users_data.aim, users_data.description, users_data.hidden FROM users, users_data WHERE users.id = users_data.userid AND users.username = '" . $_SESSION['username'] . "'";
  $userData = pg_query($userQuery) or die('Query failed: ' . pg_last_error());
  $userLevel = pg_fetch_result($userData, 0, 'level');
?>
<h1>Edit Profile:</h1>
<form method="post" action="<?php echo $baseURL; ?>/admin/formproc.php">
<input type="hidden" name="formtype" value="editprofile">
<input type="hidden" name="userid" value="<?php echo pg_fetch_result($userData, 0, 'id'); ?>">
<table cellspacing=15>
<tr><td valign="top">
<fieldset>
<legend><B>Name</B></legend>
	<BR />Username:<BR />
	<input type="text" size="66" name="username" value="
<?php
  echo pg_fetch_result($userData, 0, 'username') . '" ';
?>
  disabled="disabled"><BR />
	Role:<BR />
	<select name="level"
<?php
  if(pg_fetch_result($userData, 0, 'level') < 4)
	{
	  echo ' disabled="disabled"';
	}
?>
	>
		<option value="8"<?php if($userLevel == 8) { echo ' selected'; } ?>>Administrator</option> <!-- level 10 -->
		<option value="4"<?php if($userLevel == 4) { echo ' selected'; } ?>>Director</option> <!-- level 7 -->
		<option value="2"<?php if($userLevel == 2) { echo ' selected'; } ?>>DJ</option> <!-- level 5 -->
		<option value="1"<?php if($userLevel == 1) { echo ' selected'; } ?>>&mdash; No role for this station &mdash;</option> <!-- level 1 -->
	</select>
	<div style=""><!-- checkbox on right of column --></div>
	<BR>
	First Name:<BR>
	<input type="text" size="66" name="firstname" value="<?php echo pg_fetch_result($userData, 0, 'firstname'); ?>"><BR>
	Last Name:<BR>
	<input type="text" size="66" name="lastname" value="<?php echo pg_fetch_result($userData, 0, 'lastname'); ?>"><BR>
	Display Name:<BR>
	<input type="text" size="66" name="displayname" value="<?php echo pg_fetch_result($userData, 0, 'displayname'); ?>"><BR>
</fieldset>
</td>
<td valign="top">
<fieldset>
<legend><B>Contact Info</B></legend>
	<BR>E-mail:<BR>
	<input type="text" size="66" name="email" value="<?php echo pg_fetch_result($userData, 0, 'email'); ?>"><BR>
	Personal Website:<BR>
	<input type="text" size="66" name="url" value="<?php echo pg_fetch_result($userData, 0, 'url'); ?>"><BR>
	AIM Username:<BR>
	<input type="text" size="66" name="aim" value="<?php echo pg_fetch_result($userData, 0, 'aim'); ?>"><BR>
</fieldset>
</td></tr>
<tr><td valign="bottom">
<fieldset>
<legend><B>About You</B></legend>
	<BR>Share a little personal information for your profile.<BR>
	<textarea name="description" rows="6" cols="64"><?php echo pg_fetch_result($userData, 0, 'description'); ?></textarea><BR>
</fieldset>
</td>
<td valign="top">
<fieldset>
<legend><B>Update Password</B></legend>
	<BR>To change your password, use both boxes and type in your new<BR>password.  Otherwise, leave both boxes blank.<BR>
	<?php if($_REQUEST['dud'] == "passwd") { echo '<br /><div style="error">Passwords DO NOT Match!</div>'; } ?>
	<br />New Password:<BR>
	<input type="password" size="66" name="newpassword1"><BR>
	Type It Again:<BR>
	<input type="password" size="66" name="newpassword2"><BR>
</fieldset>
</td></tr>
<tr><td colspan=2 align="right" valign="center">
	<input type="submit" value="Update">
</td></tr>
</form>
