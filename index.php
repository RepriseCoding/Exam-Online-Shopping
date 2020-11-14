<?php
include 'include/connect_db.php';
include 'include/session.php';

?>
<!doctype html>
<html lang="en">

<head>
    <title>หน้าแรก</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="node_modules\bootstrap\dist\css\bootstrap.min.css">
    <!-- Font awesome CSS -->
    <link rel="stylesheet" href="node_modules\font-awesome\css\font-awesome.min.css">
    <!-- Main CSS for Customize website -->
    <link rel="stylesheet" href="css\style.css">
</head>

<body>

    <header>
        <div class="card text-white bg-primary">
            <div class="card-body text-center">
                <h1 class="card-title">Welcome</h1>
            </div>

        </div>
    </header>

    <!-- Navigation bar -->
    <?php include 'include/nav-bar.php'; ?>
    <div class="container">
        <div class="row justify-content-left">
            <?php

            // ตรวจสอบว่ามีการส่งค่าของปุ่ม search มาหรือไม่
            if (!empty($_POST['search'])) {

                $where = $_POST['search_name'];
                $price = $_POST['price_range'];



                //ถ้าผู้ใช้ไม่ได้กรอกอะไรเลยในช่อง search name และ ไม่ได้เลือกช่วงราคา
                if (empty($_POST['search_name']) && empty($_POST['price_range'])) {

                    $search = "SELECT * FROM product WHERE product_name LIKE '%{$where}%' ORDER BY product_id DESC";
                    $searchquery = mysqli_query($conn, $search);
                    $countsearch = mysqli_num_rows($searchquery);

                    while ($rowsearch = mysqli_fetch_array($searchquery)) {
                        // echo $_POST['price_range'];
                        echo '<div class="col-10 col-md-3 p-2">';
                        echo '<div class="card" id="product_card">';
                        echo '<form action="cart.php?action=order&id=' . $rowsearch['product_id'] . '" method="post" id="product-card">';
                        echo '<div class="product-img-frame">';
                        echo '<img class="card-img-top mt-3" src="' . $rowsearch['product_img'] . '" alt="รูปภาพสินค้า">';
                        echo '</div>';
                        echo '<div class="card-body">';
                        echo '<h4 class="card-title">' . $rowsearch['product_name'] . '</h4>';
                        echo '<input type="text" class="form-control" name="name" id="name" value="' . $rowsearch['product_name'] . '" hidden>';
                        echo '<input type="text" class="form-control" name="code" id="code" value="' . $rowsearch['product_code'] . '" hidden>';
                        echo '<input type="text" class="form-control" name="quantity" id="quantity" value="1" hidden>';
                        echo '<input type="text" class="form-control" name="price" id="price" value="' . $rowsearch['product_price'] . '" hidden>';
                        echo '<input type="text" class="form-control" name="img" id="img" value="' . $rowsearch['product_img'] . '" hidden>';
                        echo '<span class="card-text">ราคา : ' . number_format($rowsearch['product_price'],) . ' บาท</span>';
                        echo '<button class="btn btn-success mt-4 pull-right" type="submit" name="add_cart" id="cart-but"><i class="fa fa-cart-plus" aria-hidden="true"></i> เพิ่มลงตะกร้า</button>';
                        echo '</div>';
                        echo '</form>';
                        echo '</div>';
                        echo '</div>';
                    }
                }
                // หากมีการพิมพ์์ชื่อสินค้าแต่ไม่ได้เลือกช่วงราคา
                elseif (!empty($_POST['search_name']) && empty($_POST['price_range'])) {

                    $search = "SELECT * FROM product WHERE product_name LIKE '%{$where}%' ORDER BY product_id DESC";
                    $searchquery = mysqli_query($conn, $search);
                    $countsearch = mysqli_num_rows($searchquery);

                    // เขียนเงื่อนไขเช็คว่า ชื่อสินค้าถูกหรือใกล้เคียงหรือไม่ (หมายถึงพบเรคอร์ดในตารางหรือเปล่า)
                    if ($countsearch > 0) {

                        while ($rowsearch = mysqli_fetch_array($searchquery)) {
                            // echo $_POST['price_range'];
                            echo '<div class="col-10 col-md-3 p-2">';
                            echo '<div class="card" id="product_card">';
                            echo '<form action="cart.php?action=order&id=' . $rowsearch['product_id'] . '" method="post" id="product-card">';
                            echo '<div class="product-img-frame">';
                            echo '<img class="card-img-top mt-3" src="' . $rowsearch['product_img'] . '" alt="รูปภาพสินค้า">';
                            echo '</div>';
                            echo '<div class="card-body">';
                            echo '<h4 class="card-title">' . $rowsearch['product_name'] . '</h4>';
                            echo '<input type="text" class="form-control" name="name" id="name" value="' . $rowsearch['product_name'] . '" hidden>';
                            echo '<input type="text" class="form-control" name="code" id="code" value="' . $rowsearch['product_code'] . '" hidden>';
                            echo '<input type="text" class="form-control" name="quantity" id="quantity" value="1" hidden>';
                            echo '<input type="text" class="form-control" name="price" id="price" value="' . $rowsearch['product_price'] . '" hidden>';
                            echo '<input type="text" class="form-control" name="img" id="img" value="' . $rowsearch['product_img'] . '" hidden>';
                            echo '<span class="card-text">ราคา : ' . number_format($rowsearch['product_price'],) . ' บาท</span>';
                            echo '<button class="btn btn-success mt-4 pull-right" type="submit" name="add_cart" id="cart-but"><i class="fa fa-cart-plus" aria-hidden="true"></i> เพิ่มลงตะกร้า</button>';
                            echo '</div>';
                            echo '</form>';
                            echo '</div>';
                            echo '</div>';
                        }
                    }
                    // หากชื่อสินค้าไม่ตรงหรือไม่ใกล้เคียง (ไม่พบเรคอร์ดในตาราง)
                    else {
                        // ให้แสดงผลเป็น class.alert
                        echo '<div class="alert alert-danger text-center" style="width:100%;">ไม่พบสินค้าที่ต้องการค้นหา <a href="index.php" >ลองค้นหาอีกครั้ง</a></div>';
                    }
                }
                // หากมีการเลือกช่วงราคา แต่ไม่ได้พิมพ์ชื่อสินค้า
                elseif (!empty($_POST['price_range']) && empty($_POST['search_name'])) {

                    $search = "SELECT * FROM product WHERE product_price {$price} ORDER BY product_id DESC";
                    $searchquery = mysqli_query($conn, $search);
                    $countsearch = mysqli_num_rows($searchquery);


                    while ($rowsearch = mysqli_fetch_array($searchquery)) {

                        // echo $_POST['price_range'];
                        echo '<div class="col-10 col-md-3 p-2">';
                        echo '<div class="card" id="product_card">';
                        echo '<form action="cart.php?action=order&id=' . $rowsearch['product_id'] . '" method="post" id="product-card">';
                        echo '<div class="product-img-frame">';
                        echo '<img class="card-img-top mt-3" src="' . $rowsearch['product_img'] . '" alt="รูปภาพสินค้า">';
                        echo '</div>';
                        echo '<div class="card-body">';
                        echo '<h4 class="card-title">' . $rowsearch['product_name'] . '</h4>';
                        echo '<input type="text" class="form-control" name="name" id="name" value="' . $rowsearch['product_name'] . '" hidden>';
                        echo '<input type="text" class="form-control" name="code" id="code" value="' . $rowsearch['product_code'] . '" hidden>';
                        echo '<input type="text" class="form-control" name="quantity" id="quantity" value="1" hidden>';
                        echo '<input type="text" class="form-control" name="price" id="price" value="' . $rowsearch['product_price'] . '" hidden>';
                        echo '<input type="text" class="form-control" name="img" id="img" value="' . $rowsearch['product_img'] . '" hidden>';
                        echo '<span class="card-text">ราคา : ' . number_format($rowsearch['product_price'],) . ' บาท</span>';
                        echo '<button class="btn btn-success mt-4 pull-right" type="submit" name="add_cart" id="cart-but"><i class="fa fa-cart-plus" aria-hidden="true"></i> เพิ่มลงตะกร้า</button>';
                        echo '</div>';
                        echo '</form>';
                        echo '</div>';
                        echo '</div>';
                    }
                }
                // หากมีการเลือกช่วงราคา และพิมพ์ชื่อสินค้า
                elseif (!empty($_POST['price_range']) && !empty($_POST['search_name'])) {

                    $search = "SELECT * FROM product WHERE product_name LIKE '%{$where}%' AND product_price {$price} ORDER BY product_id DESC";
                    $searchquery = mysqli_query($conn, $search);
                    $countsearch = mysqli_num_rows($searchquery);

                    // เขียนเงื่อนไขเช็คว่า ชื่อสินค้าถูกหรือใกล้เคียงหรือไม่ (หมายถึงพบเรคอร์ดในตารางหรือเปล่า)
                    if ($countsearch > 0) {
                        while ($rowsearch = mysqli_fetch_array($searchquery)) {

                            echo $_POST['price_range'];
                            echo '<div class="col-10 col-md-3 p-2">';
                            echo '<div class="card" id="product_card">';
                            echo '<form action="cart.php?action=order&id=' . $rowsearch['product_id'] . '" method="post" id="product-card">';
                            echo '<div class="product-img-frame">';
                            echo '<img class="card-img-top mt-3" src="' . $rowsearch['product_img'] . '" alt="รูปภาพสินค้า">';
                            echo '</div>';
                            echo '<div class="card-body">';
                            echo '<h4 class="card-title">' . $rowsearch['product_name'] . '</h4>';
                            echo '<input type="text" class="form-control" name="name" id="name" value="' . $rowsearch['product_name'] . '" hidden>';
                            echo '<input type="text" class="form-control" name="code" id="code" value="' . $rowsearch['product_code'] . '" hidden>';
                            echo '<input type="text" class="form-control" name="quantity" id="quantity" value="1" hidden>';
                            echo '<input type="text" class="form-control" name="price" id="price" value="' . $rowsearch['product_price'] . '" hidden>';
                            echo '<input type="text" class="form-control" name="img" id="img" value="' . $rowsearch['product_img'] . '" hidden>';
                            echo '<span class="card-text">ราคา : ' . number_format($rowsearch['product_price'],) . ' บาท</span>';
                            echo '<button class="btn btn-success mt-4 pull-right" type="submit" name="add_cart" id="cart-but"><i class="fa fa-cart-plus" aria-hidden="true"></i> เพิ่มลงตะกร้า</button>';
                            echo '</div>';
                            echo '</form>';
                            echo '</div>';
                            echo '</div>';
                        }
                    }
                    // หากชื่อสินค้าไม่ตรงหรือไม่ใกล้เคียง (ไม่พบเรคอร์ดในตาราง)
                    else {
                        // ให้แสดงผลเป็น class.alert
                        echo '<div class="alert alert-danger text-center" style="width:100%;">ไม่พบสินค้าที่ต้องการค้นหา <a href="index.php" >ลองค้นหาอีกครั้ง</a></div>';
                    }
                }


                // ไม่ได้มี แอคชั่นใดๆเกิดขึ้นกับปุ่ม search ให้แสดงข้อมูลตามปกติ
            } else {

                $listproduct = "SELECT * FROM product ORDER BY product_id DESC";
                $query1 = mysqli_query($conn, $listproduct);

                while ($list = mysqli_fetch_array($query1)) {
                    echo '<div class="col-10 col-md-3 p-2">';
                    echo '<div class="card " id="product_card">';
                    echo '<form action="cart.php?action=order&id=' . $list['product_id'] . '" method="post" id="product-card">';
                    echo '<div class="product-img-frame">';
                    echo '<img class="card-img-top mt-1" src="' . $list['product_img'] . '" alt="รูปภาพสินค้า">';
                    echo '</div>';
                    echo '<div class="card-body">';
                    echo '<h4 class="card-title">' . $list['product_name'] . '</h4>';
                    echo '<input type="text" class="form-control" name="name" id="name" value="' . $list['product_name'] . '" hidden>';
                    echo '<input type="text" class="form-control" name="code" id="code" value="' . $list['product_code'] . '" hidden>';
                    echo '<input type="text" class="form-control" name="quantity" id="quantity" value="1" hidden>';
                    echo '<input type="text" class="form-control" name="price" id="price" value="' . $list['product_price'] . '" hidden>';
                    echo '<input type="text" class="form-control" name="img" id="img" value="' . $list['product_img'] . '" hidden>';
                    echo '<span class="card-text">ราคา : ' . number_format($list['product_price'],) . ' บาท</span>';
                    echo '<button class="btn btn-success mt-4 pull-right" type="submit" name="add_cart" id="cart-but"><i class="fa fa-cart-plus" aria-hidden="true"></i> เพิ่มลงตะกร้า</button>';
                    echo '</div>';
                    echo '</form>';
                    echo '</div>';
                    echo '</div>';
                }
            }

            ?>

        </div>
    </div>


    <!-- footer -->
    <?php include 'include/footer.php'; ?>