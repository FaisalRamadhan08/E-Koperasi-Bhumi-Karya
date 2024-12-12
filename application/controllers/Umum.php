<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Umum extends CI_Controller
{
   public function index()
   {
      $this->load->view('umum/home');
      // echo "Hello";
   }
   public function backHome()
   {
      $this->load->view('umum/home');
   }
}
