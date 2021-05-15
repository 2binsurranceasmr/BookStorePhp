<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<!-- The video -->
<!DOCTYPE HTML>
<html>
    <head>
        <title>Tiệm Sách Stop Motion</title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <!-- Popper JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <style>
            /* Style the video: 100% width and height to cover the entire window */
            #myVideo {
                position: fixed;
                right: 0;
                bottom: 0;
                /*                 min-width: 100%;
                                 min-height: 100%;*/
                width: 100%;
                height: 100%;
            }


            .container {
                position: fixed;
                width:  100%;
                height: 100%;
                top: 0;
                left:0;
            }
            .center{
                position: absolute;
                top: 35%;
                left: 71%;
            }
            .content{
                position: relative;
                width: 100%;
                height: 100%;
                left: 0;
                top: 0;
            }
            /* Style the button */

            .btn{
                margin-right: 10px;
                color:#129FEA;
                background: transparent;
            }
            .btn:hover{
                opacity: 80%;
            }
        </style>
    <video autoplay muted loop id="myVideo">
        <source src="<?php echo base_url() ?>pop-up-book2.mp4" type="video/mp4">
    </video>
</head>
<body>
    <div class="container">
        <div class="center">
            <h3 style="color:purple">Tiệm sách Stop Motion</h3>
            <a href="<?php echo base_url() ?>Account_Controller/login" id="myBtn" class="btn btn-primary btn-lg">Đăng nhập</a>
            <a href="<?php echo base_url() ?>Book_Controller/visit" id="myBtn" class="btn btn-primary btn-lg">Vào cửa hàng</a>
        </div>
    </div>
</body>
</html>