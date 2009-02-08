<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  /*** form_validation.php
    *  2009.02.01
    *  Daniel Patrick Williams - dwilliams@port8080.net
    *
    *  Form Validation config file
   ***/
  $config = array(
              'login' => array(
                           array(
                             'field' => 'uname',
                             'label' => 'Username',
                             'rules' => 'required'
                           ),
                           array(
                             'field' => 'pword',
                             'label' => 'Password',
                             'rules' => 'required'
                           ),
                         ),
              'users' => array(
                           array(
                             'field' => '',
                             'label' => '',
                             'rules' => ''
                           ),
                           array(
                             'field' => '',
                             'label' => '',
                             'rules' => ''
                           ),
                         )
            );

/* DPW */
/* END OF CODE */
