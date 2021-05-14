<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Test_Controller extends CI_Controller {

    public function index() {

        $this->load->view('test');
    }
    public function hello(){
        echo "Hello World! Hello";
    }
    public function testViewAccount() {
        $data['account'] = $this->Test_Model->testGetAllAccount();
        $this->load->view("Test_View_Account",$data);
    }
    public function testForm(){
        $this->load->view('login.html');
    }
    public function testImage(){
        $this->load->view('testImage');
    }
    public function testBooks(){
        $this->load->view('Books.html');
    }

}
