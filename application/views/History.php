<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Tiệm sách Stop-motion</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
        <style>
            body {
                background: #eecda3;
                background: -webkit-linear-gradient(to right, #4cbfec, #ecb1e7);
                background: linear-gradient(to right,  #4cbfec, #ecb1e7);
                min-height: 100vh;
            }
            .jumbotron {
                padding-top: 10px !important;
                padding-bottom: 10px !important;
            }
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
        <div class="container" style="padding-top:80px">
            <div class="row">
                <div class="col">
                    <div class="jumbotron">
                        <h2>Lịch sử giao dịch</h2>
                    </div>
                    <div class="table-responsive bg-light p-5 rounded">
                        <table class="table table-light table-striped rounded">
                            <thead class="thead-dark">
                                <tr>
                                    <th></th>
                                    <th>Tiêu đề</th>
                                    <th>Số lượng</th>
                                    <th>Ngày thêm vào giỏ</th>
                                    <th>Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($cartitems as $cart) {
                                    ?>
                                    <tr>
                                        <td> <img width='70px' height="70px" src="<?php echo base_url() . $cart->image ?>" </td>
                                        <td> <?php echo $cart->title ?> </td>
                                        <td> <?php echo $cart->quantity ?> </td>
                                        <td> <?php echo $cart->order_date ?> </td>
                                        <td> 
                                            <?php
                                            if ($cart->status == 0) {
                                                echo '<strong style="color:red;text-align:center">Chưa giao hàng</strong>';
                                            } else {
                                                echo'<strong style="color:green;text-align:center">Đã giao hàng</strong>';
                                            }
                                            ?> 
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                        <a href="javascript:history.back()" type="button" style="float:right;" class="btn btn-outline-primary rounded-pill py-2">Trở về</a>

                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
