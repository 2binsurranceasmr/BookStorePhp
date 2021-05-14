<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    </head>
    <style>
        .card-img-top {
            width: 100%;
            height: 30vh;
            object-fit: contain;
        }
        img {
            width: 100%;
            height:50vh;
            object-fit: contain;
        }



    </style>
    <body>
        <!-- Grey with black text -->
        <nav class="navbar navbar-expand-md navbar-light bg-light fixed-top">

            <!-- First nav left -->
            <div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="<?php echo base_url() ?>"><strong>Home</strong></a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="<?php echo base_url().'Book_Controller/books' ?>">Trang chủ</a>
                    </li>
                    <?php if($role=='ADMIN'){ ?>
                    <li class="nav-item active">
                        <a class="nav-link" href="<?php echo base_url() . 'Book_Controller/addBook' ?>">Thêm sản phẩm</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="<?php echo base_url() . 'Shipping_Controller/ships' ?>">Giao hàng</a>
                    </li>
                    <?php }?>
                </ul>
            </div>
            <!-- Second nav right -->
            <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
                <ul class="navbar-nav ml-auto">
                    <li>
                        <form class="form-inline" action="<?php echo base_url() . 'Book_Controller/search' ?> " method='post'>
                            <input class="form-control mr-sm-2" type="text" placeholder="Tìm kiếm" name='book_title'>
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name='search' value='search'>
                                <span class="fas fa-search"></span>
                            </button>
                        </form>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                            <span class="fas fa-user-cog"></span>
                        </a>
                        <?php if($role=='USER'){?>
                        <div class="dropdown-menu dropdown-menu-right float-right" style="position:absolute">
                            <a class="dropdown-item" href="<?php echo base_url() . 'Account_Controller/accountDetails' ?>">Thông tin tài khoản</a>
                            <a class="dropdown-item" href="<?php echo base_url() . 'Cartitem_Controller/viewHistory' ?>">Lịch sử giao dịch</a>
                            <a class="dropdown-item" href="<?php echo base_url() . 'Cartitem_Controller/viewShoppingCart' ?>">Giỏ hàng</a>
                            <a class="dropdown-item" href="<?php echo base_url() . 'Account_Controller/logout' ?>">Đăng xuất</a>
                        </div>
                        <?php } ?>
                        <?php if($role=='ADMIN'){?>
                        <div class="dropdown-menu dropdown-menu-right float-right" style="position:absolute">
                            <a class="dropdown-item" href="<?php echo base_url() . 'Account_Controller/accountDetails' ?>">Quản lý tài khoản</a>
                            <a class="dropdown-item" href="<?php echo base_url() . 'Account_Controller/logout' ?>">Đăng xuất</a>
                        </div>
                        <?php } ?>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="container" style="margin-top:80px">
            <?php if(isset($error)&&$error!='') { ?>
            <div class="alert alert-success">
                    <?php echo $error ?>
            </div>
            <?php } ?>
            <div class="row">
                <div class="col-4  p-1 m-1">
                    <img src="<?php echo base_url() . $book->image ?>"/>
                </div>
                <div class="col-7 p-1 m-1">
                    <h1><?php echo $book->title ?></h1>
                    <p>Tác giả: <?php echo $author ?></p>
                    <p><span style="font-size: 2rem; color: #3366ff"><?php echo $book->price ?> <b><u>Đ</u></b></span></p>
                    <div style="border-bottom: 1px black solid">
                        <p><?php echo $book->description ?> </p> <br><br>
                    </div>


                    <!-- Cho vào giỏ  -->
                    <br>
                    <?php
                    echo form_open('Cartitem_Controller/add/' . $book->id, array('style' => 'border-bottom:1px black solid'));
                    ?>
                    <div class="container">
                        <div class="row">

                            <!-- số lượng  -->

                            <div class="form-group col-4 p-1 m-1 d-flex align-items-center" >
                                <?php
                                echo form_input(array(
                                    'name' => 'quantity',
                                    
                                    'class' => 'form-group'
                                ));
                                ?>
                            </div>


                            <!-- thêm  -->

                            <div class="form-group col-3 p-1 m-1 d-flex align-items-center" >
                                <?php
                                echo form_input(array(
                                    'type' => 'submit',
                                    'name' => 'add',
                                    'value' => 'Thêm vào giỏ',
                                    
                                    'class' => 'form-group btn btn-outline-primary'
                                ));
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                    echo form_close();
                    ?>
                    <a href='<?php echo base_url().'Cartitem_Controller/viewShoppingCart' ?>' class="form-group btn btn-outline-primary">Xem giỏ hàng</a>
                    <a href='<?php echo base_url().'Book_Controller/books' ?>' class="form-group btn btn-outline-secondary">Tiếp tục mua sắm</a>
                </div>
            </div>
        </div>


    </body>
</html>