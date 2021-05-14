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
        .card-body .btn{
            margin-left: 5% !important;
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

        <!-- Container -->
        <div class="container" style="margin-top:80px">



            <div class="row d-flex align-items-stretch">
                <div class="card-columns">
                    <?php
                    if ($results != null) {
                        foreach ($results as $book) {
                            ?>

                            <div class="card" >
                                <img class="card-img-top img-fluid" src="<?php echo base_url() . $book->image; ?>" alt="Card image">
                                <div class="card-body">
                                    <h4 class="card-title align-top d-inline-block text-truncate" style="max-width:15vw;width:15vw"><?php echo $book->title; ?></h4>
                                    <p class="card-text align-top d-inline-block text-truncate" style="max-width:15vw;width:15vw"><?php echo $book->description; ?></p>
                                    <?php 
                                    if($role=='USER')
                                        echo '<a href="' . base_url() . 'Book_Controller/bookDetails/' . $book->id . '"class="btn btn-outline-primary">Xem chi tiết</a>';
                                    if($role=='ADMIN'){
                                        echo '<a href="' . base_url() . 'Book_Controller/updateBook/' . $book->id . '"class="btn btn-outline-primary">Sửa</a>';
                                    }
                                          ?>  
                                </div>
                            </div>

                        <?php }
                    } ?>

                </div>

            </div>

            <!-- Pagination của CI -->
            <?php if (isset($links)) { ?>
                <?php echo $links ?>
            <?php } ?>



        </div>
    </body>
</html>
