<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Upload_Model extends CI_Model {

    Public function __construct() {

        parent::__construct();
    }

    public function do_upload_image($input_name='image',$type = 'UPLOAD') {
        
        if($type=='BOOK'){
            $path='./images/book';
        }
        if($type=='USER'){
            $path='./images/user';
        }
        
        if($type=='UPLOAD'){
            $path='./uploads/';
        }
        
        $config['upload_path'] = $path;
        $config['allowed_types'] = 'jpg|png';
        $config['max_size'] = 60000;
        $config['max_width'] = 60000;
        $config['max_height'] = 60000;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload($input_name)) {

            return null;
            
        } else {
            return array('upload_data' => $this->upload->data());

        }
    }

}
