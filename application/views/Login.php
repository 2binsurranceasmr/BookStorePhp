<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<html>
    <head>
        <title>Tiệm Sách Stop Motion</title>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <!-- Popper JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <style>
            input{
                width: 100%;
                padding: 12px 20px;
                margin: 8px 0;
                display: inline-block;
                border: 1px solid #ccc;
                border-radius: 4px;
                box-sizing: border-box;
            }
            input:focus {
                outline: none !important;
                border:1px solid #409ad5;
                box-shadow: 0 0 5px #409ad5;
            }
            .form-group {
                margin-bottom: 5px!important;
            }

        </style>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                </div>
                <div class="col-lg-5">
                    <img src="http://localhost/BookStorePhpVersion2/logo.jpg" width="50" height="50"/>
                    <h1>Đăng nhập</h1>
                    
                    <?php 
                        if (isset($error) && $error!=''){
                            echo '<div class="alert alert-danger" role="alert">';
                            echo $error;
                            echo '</div>';
                        }
                        if (isset($success)){
                            echo '<div class="alert alert-success" role="alert">';
                            echo $success;
                            echo '</div>';
                        }
                    ?>
                    
                    <?php
                    echo form_open('Account_Controller/confirmLogin');
                    ?>

                    <!-- username  -->

                    <div class="form-group">
                        <?php
                        echo form_input(array(
                            'type' => 'text',
                            'name' => 'username',
                            'placeholder' => 'Tên đăng nhập',
                            'required' => 'true',
                            'class' => 'form-group'
                        ));
                        ?>
                    </div>


                    <!-- password  -->


                    <div class="form-group">
                        <?php
                        echo form_input(array(
                            'type' => 'password',
                            'name' => 'pwd',
                            'placeholder' => 'Nhập mật khẩu',
                            'required' => 'true',
                            'class' => 'form-group'
                        ));
                        ?>
                    </div>
                    
                    <!-- nút  -->
                    
                    <div class="row">
                        <div class="col-6">
                            <?php
                            echo form_input(array(
                                'type' => 'submit',
                                'name' => 'login',
                                'class' => 'btn btn-primary btn-block',
                                'value' => 'Đăng nhập'
                            ));
                            ?>
                        </div>
                        <a href="<?php echo base_url().'Account_Controller/forgot'?>" style="margin-top:3%">Quên mật khẩu</a>
                        <a href="<?php echo base_url().'Account_Controller/register'?>" style="margin-top:3%; margin-left:5%">Đăng ký</a>
                    </div>


                    <?php
                    echo form_close();
                    ?>



                </div>
                <div class="col-lg-4">
                </div>
            </div>
        </div>
    </body>
</html>
