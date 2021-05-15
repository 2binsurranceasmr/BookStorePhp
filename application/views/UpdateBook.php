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
                        <a class="nav-link" href="<?php echo base_url() . 'Book_Controller/books' ?>">Trang chủ</a>
                    </li>
                    <?php if ($role == 'ADMIN') { ?>
                        <li class="nav-item active">
                            <a class="nav-link" href="<?php echo base_url() . 'Book_Controller/addBook' ?>">Thêm sản phẩm</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="<?php echo base_url() . 'Shipping_Controller/ships' ?>">Giao hàng</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="<?php echo base_url() . 'Shipping_Controller/statistic' ?>">Thống kê</a>
                        </li>

                    <?php } ?>
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
                        <?php if ($role == 'USER') { ?>
                            <div class="dropdown-menu dropdown-menu-right float-right" style="position:absolute">
                                <a class="dropdown-item" href="<?php echo base_url() . 'Account_Controller/accountDetails' ?>">Thông tin tài khoản</a>
                                <a class="dropdown-item" href="<?php echo base_url() . 'Cartitem_Controller/viewHistory' ?>">Lịch sử giao dịch</a>
                                <a class="dropdown-item" href="<?php echo base_url() . 'Cartitem_Controller/viewShoppingCart' ?>">Giỏ hàng</a>
                                <a class="dropdown-item" href="<?php echo base_url() . 'Account_Controller/logout' ?>">Đăng xuất</a>
                            </div>
                        <?php } ?>
                        <?php if ($role == 'ADMIN') { ?>
                            <div class="dropdown-menu dropdown-menu-right float-right" style="position:absolute">
                                <a class="dropdown-item" href="<?php echo base_url() . 'Account_Controller/accountDetails' ?>">Quản lý tài khoản</a>
                                <a class="dropdown-item" href="<?php echo base_url() . 'Account_Controller/logout' ?>">Đăng xuất</a>
                            </div>
                        <?php } ?>
                    </li>
                </ul>
            </div>
        </nav>
        <?php if (isset($error) && $error != '') { ?>
            <div class="alert alert-danger container" style="padding-top:80px">
                <?php echo $error ?>
            </div> 
        <?php } ?>
        <?php echo form_open_multipart('Book_Controller/do_update', array('class' => 'container', 'style' => 'padding-top:80px')) ?>
        <input type="hidden"  name="book_id" value="<?php echo $book['id'] ?>">
        <div class="row">
            <!-- ảnh của sách -->
            <div class="col-3 bg-light">
                <div class="card" >
                    <img class="card-img-top img-fluid" src="<?php echo base_url() . $book['image']; ?>" alt="Card image">
                </div>
                <hr>
                <input type="file" accept="image/*" class="form-control" name="image">
            </div>

            <!-- thông tin của sách -->



            <div class="col-8 bg-light">

                <div class='form-group row justify-content-end my-2 '>
                    <label class='col-3  form-label my-2 text-right'>Tiêu đề</label>
                    <div class='col-8 '>
                        <input class="form-control" name="title" type="text" value="<?php echo $book['title'] ?>" placeholder="Chưa có tiêu đề" >
                    </div>
                </div>


                <div class='form-group row justify-content-end my-2 g'>
                    <label class='col-3 form-label my-2 text-right'>Tác giả</label>
                    <div class='col-8  my-2'>
                        <span><?php echo $book['author'] ?></span>
                        <span><strong>Chỉnh sửa: </strong></span> 
                        <select name='author_id'>
                            <?php foreach ($authors as $author) { ?>
                                <option value='<?php echo $author->id ?>'> <?php echo $author->full_name ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>



                <div class='form-group row justify-content-end my-2 '>
                    <label class='col-3  form-label my-2 text-right'>Giá</label>
                    <div class='col-8 '>
                        <input class="form-control" name="price" type="text" value="<?php echo $book['price'] ?>" placeholder="200000" >
                    </div>
                </div>



                <div class='form-group row justify-content-end my-2 '>
                    <label class='col-3  form-label my-2 text-right'>Thể loại</label>
                    <div class='col-8 my-2'>
                        <span><?php echo $book['category'] ?></span>
                        <span><strong>Chỉnh sửa: </strong></span> 
                        <select name='category_id'>
                            <?php foreach ($categories as $category) { ?>
                                <option value='<?php echo $category->id ?>'> <?php echo $category->name ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>


                <div class='form-group row justify-content-end my-2'>
                    <label class='col-3 form-label my-2 text-right'>Năm phát hành</label>
                    <div class='col-8 '>
                        <input class="form-control" name="publish_year" type="text" value="<?php echo $book['publish_year'] ?>" placeholder="1995" >
                    </div>
                </div>



                <div class='form-group row justify-content-end my-2'>
                    <label class='col-3 form-label my-2 text-right'>Mô tả</label>
                    <div class='col-8 '>
                        <textarea rows="5" class="form-control" name="description" type="text" placeholder="Hiện chưa có mô tả" ><?php echo $book['description'] ?></textarea>
                    </div>
                </div>


                <hr>

                <div class='form-group row justify-content-end my-2 '>
                    <input type="submit" class="btn btn-outline-primary" value="Lưu" name='edit'>
                </div>


            </div>



        </div>



        <?php echo form_close() ?>
    </body>
</html>