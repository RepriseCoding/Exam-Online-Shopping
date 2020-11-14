<nav class="navbar navbar-expand-sm navbar-dark bg-dark mt-0 mb-3" id="topnav">
    <a class="navbar-brand" href="#">TestShop</a>
    <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation"></button>
    <div class="collapse navbar-collapse" id="collapsibleNavId">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item active">
                <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <?php
                if (!empty($_SESSION['cart'])) {
                    $count = count($_SESSION["cart"]);
                    echo '<a class="nav-link text-danger" href="cart.php"><i class="fa fa-cart-plus" aria-hidden="true"></i> ' . $count . ' สินค้าในตะกร้า</a>';
                } else {
                    echo '<a class="nav-link" href="cart.php"><i class="fa fa-cart-plus" aria-hidden="true"></i> ตะกร้าสินค้า</a>';
                }
                ?>
            </li>
            <!-- <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
                <div class="dropdown-menu" aria-labelledby="dropdownId">
                    <a class="dropdown-item" href="#">Action 1</a>
                    <a class="dropdown-item" href="#">Action 2</a>
                </div>
            </li> -->
        </ul>
        <form action="index.php?search" method="POST" class="form-inline my-2 my-lg-0">
            <div class="form-group mr-2">
                <label for=""></label>
                <select class="custom-select" name="price_range" id="">
                    <option value="" selected>เลือกช่วงราคา</option>
                    <option value="<= 1000">ไม่เกิน 1,000</option>
                    <option value="<= 5000">ไม่เกิน 5,000</option>
                    <option value="<= 10000">ไม่เกิน 10,000</option>
                    <option value=">= 10000"> 10,000 ขึ้นไป</option>
                </select>
            </div>
            <input class="form-control mr-sm-2" type="text" name="search_name" placeholder="ค้นหาชื่อสินค้าที่นี่">
            <button class="btn btn-success my-2 my-sm-0" type="submit" value="search" name="search">ค้นหา</button>
        </form>
    </div>
</nav>