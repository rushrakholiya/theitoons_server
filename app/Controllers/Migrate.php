<?php
 
namespace App\Controllers;

class Migrate extends \CodeIgniter\Controller
{
    public function index()
    {
        $migrate = \Config\Services::migrations();
        

        try {
            $migrate->latest();
            echo "Done";            
        } catch (\Throwable $e) {
            echo "Not Done";// Do something with the error here...
        }


        $seeder = \Config\Database::seeder();
        try {
           $seeder->call('SiteDetailSeeder');
           echo "Done";  
         } catch (\Exception $e) {

             $this->showError($e);
         }
    }
}