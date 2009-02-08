<?php
  /*** admin.php
    *  2009.02.01
    *  Daniel Patrick Williams - dwilliams@port8080.net
    *
    *  Controller Class for Mines Internet Radio
    *  Admin Interface to update MIR website & db
    *  Uses CodeIgnitor framework
    *
    *  - All form processing to be done by function containing form
    *    (i.e. login() processes login form)
    *  - Written for PHP 5
   ***/
  class Admin extends Controller {
  
    function __construct() {
      parent::Controller();
      // Load the libraries
      $this->load->library(array('form_validation', 'session'));
      // Load the Helpers
      $this->load->helper(array('form', 'url'));
      // Load the database
      $this->load->database();
      return;
    }
    
    // Called if no page is specified
    // - Redirect to login if not authenticated
    // - else redirect to profile editor
    function index() {
      // Check for user session information
      // if valid, proceed to edit_profile_user
      // otherwise, proceed to login
      if ( $this->session->userdata('user_name') && $this->session->userdata('user_id') ) {
        $this->edit_profile_user();
        return;
      }
      $this->login();
      return;
    }
    
    // Check information "login" to allow editing
    function login() {
      // Check for user session information
      // if valid, proceed to edit_profile_user
      // otherwise, proceed to login
      if ( $this->session->userdata('user_name') && $this->session->userdata('user_id') ) {
        // proceed to profile editor 
        $this->edit_profile_user();
        return;
      }
      if($this->form_validation->run('login') == TRUE) {
        // Load Users Models
        $this->load->model('users');
        // prep user info
        $uname = $this->input->post('uname');
        $pword = $this->input->post('pword');
        // check user in db
        $uid = $this->users->login_check($uname, $pword);
        if ( $uid == -1 ) {
          // set session data
          $this->session->set_userdata(array('user_data' => $uname, 'user_id' => $uid))
          // proceed to profile editor
          $this->edit_profile_user();
          return;
        }
      }
      $this->load->view('admin/login');
      return;
    }
    
    // Edit user's profile
    function edit_profile_user() {
      // Check for user session information
      if ( $this->session->userdata('user_name') && $this->session->userdata('user_id') ) {
        if ($this->form_validation->run('edit_user') == TRUE) {
          // Update DB with info
          // ---
        }
        // Load information from db
        $page_data['user_info'] = $this->users->get_user_info($this->session->userdata('user_id'));
        // Show page
        $this->load->view('page_start');
        $this->load->view('page_head');
        $this->load->view('page_body_start');
        // Content pane w/ editor
        $this->load->view('edit_profile_user', $page_data);
        $this->load->view('page_close');
        return;
      }
      $this->login();
      return;
    }
    
    // Manage/Add users of website
    function manage_users() {
      $this->index();
    }
    
    // Edit show's profile
    function edit_profile_show() {
      $this->index();
    }
    
    // Manage/Add radio shows
    function manage_shows() {
      $this->index();
    }
    
    // Edit blog posts (main website)
    function edit_post() {
      $this->index();
    }
    
    // Manage/Add blog posts
    function manage_posts() {
      $this->index();
    }
    
    // Edit poll's information
    function edit_poll() {
      $this->index();
    }
    
    // Manage/Add polls
    function manage_polls() {
      $this->index();
    }
  }

/* DPW */
/* END OF CODE */
