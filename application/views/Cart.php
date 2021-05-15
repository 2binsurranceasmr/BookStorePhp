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
        <title>Tiệm Sách Stop Motion</title>
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
                    <li class="nav-item active">
                        <a class="nav-link" href="<?php echo base_url() . 'Shipping_Controller/statistic' ?>">Thống kê</a>
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
            <?php if(isset($error)&&$error!=''){?>
            <div class="alert alert-danger">
                    <?php echo $error ?>
                </div> 
            <?php } ?>
            <div class="jumbotron">
                <h2>Thông tin giỏ hàng</h2>
            </div>
            <table class="table table-light table-striped rounded">
                <thead class="thead-dark">
                    <tr>
                        <th></th>
                        <th>Tiêu đề</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                        <th>Ngày thêm vào giỏ</th>
                        <th>Xóa</th>
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
                            <td> <?php echo $cart->price ?> </td>
                            <td> <?php echo $cart->order_date ?> </td>
                            <td>
                                <a name ="delete" href="<?php echo base_url() . 'Cartitem_Controller/delete/' . $cart->id ?>" class="btn btn-danger" role="button"><i class="far fa-trash-alt"></i></a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>

            <!-- Thanh toán -->
            <div class="row bg-white">

                <!-- Căn lề -->
                <div class='col-1'>
                </div>

                <!-- form thanh toán -->
                <div class="col-5 p-3 m-3">
                    <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Phương thức thanh toán</div>

                    <?php echo form_open('Shipping_Controller/add'); ?>
                    <div class="form-group">
                        <span style="font-size: 125%;"><label><i class="fa fa-user"></i> Tên chủ tài khoản</label></span>
                        <?php
                        echo form_input(array(
                            'type' => 'text',
                            'name' => 'card_owner',
                            'class' => 'form_group',
                            
                            'placeholder' => 'Nguyễn Cửa Hàng'
                        ));
                        ?>
                    </div>
                    <div class="form-group">
                        <span style="font-size: 125%;"><label><i class="fa fa-credit-card"></i> Số tài khoản</label></span>
                        <?php
                        echo form_input(array(
                            'type' => 'number',
                            'name' => 'card_number',
                            'class' => 'form_group',
                            'value' => $account->card_number,
                            'placeholder' => '0000000'
                        ));
                        ?>
                    </div>
                    <div class="form-group">
                        <span style="font-size: 125%;"><label><i class="fa fa-address-card-o"></i> Địa chỉ giao hàng</label></span>
                        <?php
                        echo form_input(array(
                            'type' => 'text',
                            'name' => 'address',
                            'class' => 'form_group',
                            'required' => 'true',
                            'value' => $account->address,
                            'placeholder' => 'D302 Cơ sở chính'
                        ));
                        ?>
                    </div>
                    <div class="form-group">
                        <span style="font-size: 125%;"><label><i class="fa fa-institution"></i> Thành phố</label></span>
                        
                        <?php
                        echo form_input(array(
                            'type' => 'text',
                            'name' => 'city',
                            'class' => 'form_group',
                            'required' => 'true',
                            'value' => $account->city,
                            'placeholder' => 'Hồ Chí Minh'
                        ));
                        ?>
                    </div>
                    <div class="form-group">
                        <span style="font-size: 125%;"><label><i class="fa fa-phone"></i> Số điện thoại liên lạc</label></span>
                        
                        <?php
                        echo form_input(array(
                            'type' => 'number',
                            'name' => 'number_phone',
                            'class' => 'form_group',
                           'required' => 'true',
                            'value' => $account->number_phone,
                            'placeholder' => '888'
                        ));
                        ?>
                    </div>
                    
                    <div class="form-group">
                        
                        <?php
                        echo form_input(array(
                            'type' => 'submit',
                            'name' => 'pay',
                            'class' => 'btn btn-primary btn-block',
                            'value' => 'Thanh toán'
                        ));
                        ?>
                    </div>
                    
                    <?php echo form_close() ?>
                </div>



                <div class="col-4 p-3 m-3">
                    <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Tổng tiền</div>
                    <ul class="list-unstyled mb-4">
                        <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Giá tiền sản phẩm </strong><strong><span><?php echo $price?></span>₫</strong></li>
                        <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Phí vận chuyển</strong><strong><span>0</span>₫</strong></li>
                        <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Tổng cộng</strong>
                            <h5 class="font-weight-bold"><strong><span><?php echo $total_price?></span>₫</strong></h5>
                        </li>
                    </ul>

                </div>
            </div>
        </div>
    </body>
</html>
