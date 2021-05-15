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
        <title>Tiệm Sách Stop Motion</title>
    </head>
    <style>
        .card-img-top {
            width: 100%;
            height: 30vh;
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
        <?php if($error!=''){ ?>
        <div class='containter' style="padding-top:80px">
            <div class="alert alert-danger" role="alert">
                <?php echo $error ?>
            </div>
        </div>
        
        <?php }?>
        <?php echo form_open_multipart('Account_Controller/do_update',array('class'=>'container','style'=>'padding-top:80px')) ?>
        <input type="hidden"  name="account_id" value="<?php echo $account->id ?>">
            <div class="row">
                
                <!-- ảnh của tài khoản -->
                <div class="col-3 bg-light">
                    <div class="card" >
                        <img class="card-img-top img-fluid" src="<?php echo base_url() . $account->image; ?>" alt="Card image">
                    </div>
                    <hr>
                    <input type="file" accept="image/*" class="form-control" name="image">
                </div>

                <!-- thông tin của tài khoản -->

                

                <div class="col-8 bg-light">


                    <div class='form-group row justify-content-end my-2 g'>
                        <label class='col-3 form-label my-2 text-right'>Tên đăng nhập</label>
                        <div class='col-8 '>
                            <input class="form-control" type="text" value="<?php echo $account->user_name ?>"  disabled="true">
                        </div>
                    </div>


                    <div class='form-group row justify-content-end my-2 '>
                        <label class='col-3  form-label my-2 text-right'>Tên đầy đủ</label>
                        <div class='col-8 '>
                            <input class="form-control" name="full_name" type="text" value="<?php echo $account->full_name ?>" placeholder="Chưa có tiêu đề" required="true" >
                        </div>
                    </div>



                    <div class='form-group row justify-content-end my-2 '>
                        <label class='col-3  form-label my-2 text-right'>Mật khẩu mới</label>
                        <div class='col-8 '>
                            <input class="form-control" name="pwd" type="password" value="" placeholder="password" required="true">
                        </div>
                    </div>



                    <div class='form-group row justify-content-end my-2 '>
                        <label class='col-3  form-label my-2 text-right'>Nhập lại mật khẩu mới</label>
                        <div class='col-8 '>
                            <input class="form-control" name="confirm_pwd" type="password" value="" placeholder="password" required="true" >
                        </div>
                    </div>


                    
                    
                    <hr>
                    
                    <div class='form-group row justify-content-end my-2 '>
                        <input type="submit" class="btn btn-outline-primary" value="Lưu" name='update'>
                    </div>
                    
                    <div class='form-group row justify-content-end my-2 '>
                        <a href='<?php echo base_url().'Account_Controller/logout'?>' class="btn btn-outline-secondary">Đăng xuất</a>
                    </div>
                    
                    
                </div>
                
                
                
            </div>



        <?php echo form_close() ?>
    </body>
</html>