<?php
include 'include/connect_db.php';
include 'include/session.php';

// เพิ่มสินค้าลงตะกร้า
// ถ้ามีการส่งค่าของปุ่ม เพิ่มลงตะกร้าที่หน้า index.php มา ให้เข้าเงื่อนไขด้านล่าง
if (isset($_POST["add_cart"])) {

    // ถ้ามีการส่งค่าหรือกำหนดค่าของ Array [cart] แล้วให้เข้าเงื่อนไขด้านล่างอีกครั้ง
    if (isset($_SESSION["cart"])) {

        // ใช้ ฟังก์ชั่น array_column โดยกำหนดให้ $order_array_id นั้นเท่่า key ที่ชื่อ order_id ใน array $_SESSION cart
        $order_array_id = array_column($_SESSION["cart"], "order_id");

        // เขียนเงื่อนไขตรวจสอบว่า ถ้าไม่มี รหัสสินค้า หรือ ไม่มีการกดเพิ่มสินค้าลงตะกร้า อยู่ใน Array ของ $order_array_id
        if (!in_array($_GET["id"], $order_array_id)) {

            // ใช้ฟังก์ชั่น count ในการนับจำนวน array
            $count = count($_SESSION["cart"]);

            // กำหนดตัวแปรและสร้าง Array โดยให้ใน array มีค่าของ id(รหัสสินค้า) และ จำนวนที่ซื้อ
            $order_array = array(
                'order_id' => $_GET['id'],
                'order_name' => $_POST['name'],
                'order_code' => $_POST['code'],
                'order_quantity' => $_POST['quantity'],
                'order_price' => $_POST['price'],
                'order_img' => $_POST['img'],
            );

            //ให้ทำการเก็บ Array $order_array ไว้ในตัวแปร $_SESSION ด้านล่างโดยจะอยู่ในอาเรย์ช่องที่ระบบ
            // ทำการนับได้ว่ามีการเพิ่มสินค้าเข้ามาในตะกร้าเป็นชิ้นที่เท่าไหร่
            // $_SESSION["cart"][$count] = $order_array;
            $_SESSION["cart"][$_GET['id']] = $order_array;

            $addorder = "SELECT * FROM product WHERE product_id = {$_GET['id']}";
            $addquery = mysqli_query($conn, $addorder);
            $add = mysqli_fetch_array($addquery);
            echo '<script>alert("คุณเพิ่ม ' . $add['product_name'] . '(' . $add['product_code'] . ') ลงตะกร้าสินค้า");window.location="index.php";</script>';
            // echo '<div class="alert alert-info text-center">คุณเพิ่ม ' . $add['product_name'] . '(' . $add['product_code'] . ') ลงตะกร้าสินค้า</div>';
            // หากทำการกดเพิ่มสินค้าชิ้นเดิมที่ถูกเพิ่มเข้าตะกร้าแล้วให้เข้าเงื่อนไขด้านล่าง
        } else {

            $url = '127.0.0.1/shopoo/index.php';

            // if (!file_exists($url)) {
            echo '<script>window.location="index.php";</script>';

            // }
        }
    } else {

        // กำหนดตัวแปรและสร้าง Array โดยให้ใน array มีค่าของ id และ จำนวนที่ซื้อ
        $order_array = array(
            'order_id' => $_GET['id'],
            'order_name' => $_POST['name'],
            'order_code' => $_POST['code'],
            'order_quantity' => $_POST['quantity'],
            'order_price' => $_POST['price'],
            'order_img' => $_POST['img'],
        );

        //
        $_SESSION['cart'][$_GET['id']] = $order_array;
    }
}

// ลบสินค้า
// ปุ่มลบสินค้า
if (isset($_GET['action'])) {
    if ($_GET["action"] == "delete") {
        foreach ($_SESSION["cart"] as $key => $value) {
            if ($value["order_id"] == $_GET["order_id"]) {

                $delete = "SELECT * FROM product WHERE product_id = {$_GET['order_id']}";
                $delquery = mysqli_query($conn, $delete);
                $del = mysqli_fetch_array($delquery);
                // ลบ Array ของสินค้าชิ้นนั้น
                unset($_SESSION["cart"][$key]);
                echo '<script>alert("สินค้า ' . $del['product_code'] . ' : ' . $del['product_name'] . ' ถูกลบจากตะกร้าสินค้า");window.location="cart.php";</script>';
            }
        }
    }
}
// echo $_SESSION['cart'][$value]['order_quantity'] = 1000;
// ปุ่มแก้ไขข้อมูลจำนวนที่สินค้าที่เลือก
if (!empty($_POST['confirm'])) {

    // echo "test";
    // เช็คค่าของจำนวนสินค้าว่ามีการส่งมาหรือไม่
    if (!empty($_POST['quantity'])) {

        $confirm_quan = $_POST['quantity'];

        foreach ($_POST['product_id'] as $key => $value) {
            # code...

            // แทนค่าโดยการ อิง index key ของ Array
            $_SESSION['cart'][$value]['order_quantity'] = $_POST['quantity'][$key];
            // $_SESSION['cart'][4]['order_quantity'] = $_POST['quantity'][$key];
            // print_r($_SESSION['cart'][$key]['order_quantity']);
            // echo $value;
        }
    }
}

// ปุ่มเคลียสินค้าในตะกร้าทั้งหมด
if (!empty($_POST['clear'])) {

    unset($_SESSION['cart']);
    echo '<div class="alert alert-warning mb-0 text-center">คุณลบสินค้าในตะกร้าทั้งหมดแล้ว <a href="index.php" >กลับไปเลือกสินค้า</a></div>';
}
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


    <!-- Navigation -->
    <?php

    include 'include/nav-bar.php';

    ?>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php

                // เทส เช็คอาเรย์ของค่าที่ส่งมากับปุ่ม
                // echo "<pre>";
                // print_r($_POST);
                // echo "</pre>";
                // echo "<pre>";
                // print_r($_SESSION);
                // echo "</pre>";
                ?>
                <div class="table-responsive">
                    <form action="cart.php" method="POST" id="cal-order">
                        <table class="table table-inverse" width="100%">
                            <thead class="thead-inverse">
                                <tr>
                                    <th>ลำดับที่</th>
                                    <th>รหัสสินค้า</th>
                                    <th>ชื่อสินค้า</th>
                                    <th>จำนวนที่สั่งซื้อ</th>
                                    <th>ราคาต่อชิ้น</th>
                                    <th>ราคารวม</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($_SESSION['cart'])) {

                                    $total = 0;

                                    // กำหนดตัวแปรสำหรับแสดงลำดับที่ของที่อยู่ในตะกร้า
                                    $i = 1;

                                    // กำหนดตัวแปรสำหรับชื่อของฟิลด์ จำนวนที่สั่งซื้อของสินค้า
                                    // $x = 0;
                                    foreach ($_SESSION['cart'] as $key => $value) {
                                        # code...

                                        $listorder = "SELECT * FROM product WHERE product_id = {$value['order_id']}";
                                        $query1 = mysqli_query($conn, $listorder);
                                        $list = mysqli_fetch_array($query1);

                                        echo '<tr>';
                                        echo '<td scope="row" ">' . $i . '</td>';
                                        echo '<td>' . $value['order_code'] . '</td>';
                                        echo '<td class="w-auto">' . $value['order_name'] . '</td>';
                                        echo '<td width="200px"><input type="text" class="form-control quan" name="quantity[]" value="' . $value['order_quantity'] . '" id="quantity"></td>';
                                        // Input field แบบ hidden เพื่อส่งค่า product_id
                                        echo '<input type="text" class="form-control col-4" name="product_id[]" value="' . $value['order_id'] . '" id="" hidden> ';
                                        echo '<td class="w-auto" >' . number_format($list['product_price'],) . '</td>';
                                        $amount = $value['order_quantity'] * $list['product_price'];
                                        echo '<td class="w-auto"><input type="text" class="form-control" id="amount" value=' . number_format($amount,) . ' readonly ></td>';
                                        echo '<td class="w-auto"><a class="btn btn-danger" href="cart.php?action=delete&order_id=' . $value['order_id'] . '"><i class="fa fa-trash" aria-hidden="true"></i> ลบ</a></td>';
                                        echo '</tr>';
                                        $i++;
                                        $total += $amount;
                                    }
                                    // echo '<tfoot>';
                                    echo '<tr>';
                                    echo '<th colspan="5" class="text-center w-auto"><h4>รวมทั้งหมด</h4></th>';

                                    echo '<th colspan="2" class="w-auto"> <h4>' . number_format($total,) . '</h4></th>';
                                    echo '</tr>';
                                    // echo '</tfoot>';
                                }
                                ?>
                            </tbody>
                        </table>
                        <button class="btn btn-danger float-right mr-5" name="clear" type="submit" value="clear"><i class="fa fa-trash" aria-hidden="true"></i> เคลียตะกร้า</button>
                        <button class="btn btn-info float-right mr-1" name="confirm" type="submit" value="confirm"><i class="fa fa-calculator" aria-hidden="true"></i> คำนวณราคา</button>
                    </form>
                    <!-- <a class="btn btn-dark" href="index.php"><i class="fa fa-backward" aria-hidden="true"></i> กลับไปเลือกสินค้า</a> -->
                </div>
            </div>
        </div>
    </div>


    <!-- footer -->
    <?php include 'include/footer.php'; ?>