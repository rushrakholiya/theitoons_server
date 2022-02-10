<?php
 defined(' BASEPATH ') OR exit('No direct script access allowed');
 class MigrationController extends CI_Controller
 {
        public function index($version){
            $this->load->library("migration");

            if(!$this->migration->version($version)){
              show_error($this->migration->error_string());
            }   
            else
            { 
                 echo "<h2> Migration table has been created </h2>";
            }
        }
 }
 ?> 