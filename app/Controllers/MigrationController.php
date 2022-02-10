<?php
 defined(' BASEPATH ') OR exit('No direct script access allowed');
 class MigrationController extends CI_Controller
 {
         public function index()
         {    
               echo "<title> Tutorial and Example </title>"; 
                 $this->load->library('migration'); // load migration library
                 if ($this->migration->current() === False)
                 {
                         show_error($this->migration->error_string()); /* if current version is not found, it returns an error message. */
                 }
                 else
                 { 
                     echo "<h2> Migration table has been created </h2>";
                 }
         }
 }
 ?> 