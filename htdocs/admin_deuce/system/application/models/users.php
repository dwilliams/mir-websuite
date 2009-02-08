<?php
  /*** users.php
    *  2009.02.01
    *  Daniel Patrick Williams - dwilliams@port8080.net
    *
    *  Model Class for users at Mines Internet Radio
    *  Access the users and users_data tables from the database
    *  Written for CodeIgnitor framework
    *
    *  - Load db before loading model in controller
    *  - Written for PHP 5
   ***/
  class Users extends Model {
    
    var $user = array('id' => '',
                      'username' => '',
                      'password' => '',
                      'email' => '',
                      'level' => '');
    var $data = array('id' => '',
                      'userid' => '',
                      'aim' => '',
                      'url' => '',
                      'description' => '',
                      'displayname' => '',
                      'hidden' => '',
                      'firstname' => '',
                      'lastname' => '');
    
    function __construct() {
      parent::Model();
    }

    // Function to check user in database for login
    // - If successful, returns uid, else returns -1 (int)
    function login_check($uname = '', $pword = '') {
      // Check for proper data
      if ( ! isset($uname) || ! isset($pword) ) {
        return -1;
      }
      // Spin hash
      $phash = md5($uname) . sha1($pword) . sha1($uname . md5($pword));
      // Query the good old db
      $this->db->select('id')->from('users')->where('username', $uname)->where('password', $phash);
      $query = $this->db->get();
      if ($query->num_rows() == 1) {
        return $query->result()->id;
      }
      return -1;
    }
    
    // Function to get a users's information via user_id
    // - If successful, return queried array of userdata:
    // - Else, returns -1 (int)
    function get_info_user($user_id = -1) {
      // Check for user_id
      if ( $user_id == -1 ) {
        return -1;
      }
      // Query the good old db
      $this->db->select('users.username, users.email, users.level', 'users_data.aim', 'users_data.url', 'users_data.displayname', 'users_data.firstname', 'users_data.lastname', 'users_data.description', 'users_data.hidden');
      $this->db->from('users');
      $this->db->join('users_data', 'users_data.userid = users.id');
      $this->db->where('id', $user_id);
      $query = $this->db->get();
      if ( $query->num_rows() == 1 ) {
        return $query->result();
      }
      return -1;
    }
  }

/* DPW */
/* END OF CODE */
