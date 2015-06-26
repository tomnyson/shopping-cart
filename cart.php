<?php
session_start();

if (!isset($_SESSION["IsLogin"])) {
    $_SESSION["IsLogin"] = 0; // chưa đăng nhập
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="Templates/frontend.dwt.php" codeOutsideHTMLIsLocked="false" -->
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Quản lý bán hàng</title>
        <link href="font-awesome-4.2.0/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        <!-- InstanceBeginEditable name="head" -->
        <script src="lightbox/js/jquery-1.11.0.min.js" type="text/javascript"></script>
        <style type="text/css">
            #cart {
                border-collapse: collapse;
                border: solid 1px #3366CC;
            }

            #cart td.header {
                background-color: #003399;
                color: #CCCCFF;
                font-weight: bold;
            }

            #cart td {
                color: #003399;
            }
        </style>

        <script type="text/javascript">
            function putProID(cmd, masp) {
                $("#hCmd").val(cmd);
                $("#hProId").val(masp);

                document.form1.submit();
            }
        </script>

        <!-- InstanceEndEditable -->
        <link rel="stylesheet" type="text/css" href="styles/site.css"/>
        <link rel="stylesheet" type="text/css" href="styles/link.css"/>
        <link rel="stylesheet" type="text/css" href="styles/frontend-layout.css"/>
    </head>

    <body>
        <?php
        if (!isset($_SESSION['Cart'])) {
            $_SESSION['Cart'] = array();
        }
        ?>
        <!-- InstanceBeginEditable name="PHP_Init" -->

        <?php
        require_once '/helper/Context.php';
        require_once '/helper/Utils.php';

        if (!Context::isLogged()) {
            Utils::RedirectTo('login.php?retUrl=cart.php');
        }

        require_once '/helper/CartProcessing.php';

        // cập nhật giỏ hàng (xoá/sửa)

        if (isset($_POST['hCmd'])) {
            $cmd = $_POST['hCmd']; // X/S
            $masp = $_POST['hProId'];

            if ($cmd == 'X') {
                CartProcessing::removeItem($masp);
            } else if ($cmd == 'S') {
                //$sl = $_POST["sl_".$masp];
                $sl = $_POST["sl_$masp"];
                CartProcessing::updateItem($masp, $sl);
            }
        }

        // lập hoá đơn

        require_once '/entities/Order.php';
        require_once '/entities/OrderDetail.php';
        require_once '/entities/Product.php';

        if (isset($_POST['btnLapHD'])) {
            $date = time();
            $user = $_SESSION['CurrentUser']['id'];

            $total = 0;
            foreach ($_SESSION['Cart'] as $masp => $solg) {
                $p = Product::loadProductByProId($masp);
                $amount = $p->getPrice() * $solg;
                $total += $amount;
            }

            $o = new Order(-1, $date, $user, $total);
            $o->add();

            // thêm nhiều dòng chi tiết hoá đơn

            foreach ($_SESSION['Cart'] as $masp => $solg) {
                $p = Product::loadProductByProId($masp);

                $amount = $p->getPrice() * $solg;
                $detail = new OrderDetail(-1, $o->getOrderID(), $masp, $solg, $p->getPrice(), $amount);
                $detail->add();
            }

            // huỷ giỏ hàng

            unset($_SESSION['Cart']);

            // nạp lại trang hiện tại

            $query = $_SERVER['PHP_SELF'];
            $path = pathinfo($query);
            $url = $path['basename'];
            Utils::RedirectTo($url);
        }
        ?>

        <!-- InstanceEndEditable -->
        <div id="main">
            <div id="header">
                WEBSITE BÁN HÀNG ..
            </div>
            <div id="commandContainer">
                <div id="navigation">
                    <ul>
                        <li><a href="#" class="nav">Trang chủ</a></li>
                        <li><a href="#" class="nav">Sản phẩm</a></li>
                        <li><a href="#" class="nav">Liên hệ</a></li>
                        <li><a href="#" class="nav">Thông tin</a></li>
                    </ul>
                </div>
                <div id="userCommand">

                    <?php
                    require_once '/helper/Context.php';
                    require_once '/helper/CartProcessing.php';

                    if (!Context::isLogged()) {
                        ?>
                        <a href="login.php" class="cmd">Đăng nhập</a>
                        | 
                        <a href="register.php" class="cmd">Đăng ký</a>
                        <?php
                    } else {
                        ?>
                        <a href="cart.php" class="cmd"><i class="fa fa-shopping-cart fa-lg"></i> (<b><?php echo CartProcessing::countQuantity(); ?></b> sản phẩm)</a>
                        | 
                        <a href="profile.php" class="cmd">Hi, <?php echo $_SESSION["CurrentUser"]["name"]; ?>!</a>
                        | 
                        <a href="logout.php" class="cmd">Thoát</a>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div id="body">
                <div id="left">
                    <div id="left-header">
                        <div id="left-header-left">
                        </div>
                        <div id="left-header-main">
                            Danh mục
                        </div>
                    </div>
                    <div id="left-body">
                        <?php
                        require_once 'entities/Category.php';

                        $categories = Category::loadAll();
                        for ($i = 0, $n = count($categories); $i < $n; $i++) {
                            $name = $categories[$i]->getCatName();
                            $id = $categories[$i]->getCatId();
                            ?>
                            <a href="productsByCat.php?catId=<?php echo $id; ?>" class="Menu"><?php echo $name; ?></a><br />
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div id="right">
                    <div id="right-header">
                        <div id="right-header-left">
                        </div>
                        <div id="right-header-main">
                            <!-- InstanceBeginEditable name="main-title" -->
                            Giỏ hàng
                            <!-- InstanceEndEditable -->
                        </div>
                    </div>
                    <div id="right-body">
                        <!-- InstanceBeginEditable name="main-body" -->

                        <form id="form1" name="form1" method="post" action="">
                            <input type="hidden" id="hCmd" name="hCmd" />
                            <input type="hidden" id="hProId" name="hProId" />

                            <div class="title" style="margin-left: 30px; margin-right: 30px">
                                Giỏ hàng
                            </div>
                            <div style="margin: 10px 0  0 25px;">
                                <span id="total" class="bold13orange">Tổng tiền: 1000000</span>
                            </div>
                            <div style="padding: 20px 20px 20px 30px">
                                <table id="cart" width="100%" border="1" cellspacing="0" cellpadding="4">
                                    <tr>
                                        <td class="header" width="200px">Sản phẩm</td>
                                        <td class="header" width="120px">Giá</td>
                                        <td class="header" width="90px">Số lượng</td>
                                        <td class="header" width="120px">Thành tiền</td>
                                        <td class="header">&nbsp;</td>
                                        <td class="header">&nbsp;</td>
                                    </tr>
                                    <?php
                                    require_once '/entities/Product.php';

                                    $total = 0;
                                    foreach ($_SESSION['Cart'] as $masp => $solg) {
                                        $p = Product::loadProductByProId($masp);
                                        ?>
                                        <tr>
                                            <td><?php echo $p->getProName(); ?></td>
                                            <td><?php echo number_format($p->getPrice()); ?></td>
                                            <td><input type="text" id="sl_<?php echo $masp; ?>" name="sl_<?php echo $masp; ?>" style="width: 60px" value="<?php echo $solg; ?>" /></td>
                                            <td><?php echo number_format($p->getPrice() * $solg); ?></td>
                                            <td align="center"><img src="imgs/delete-icon.png" title="Xoá" style="cursor: pointer" onclick="putProID('X', <?php echo $masp; ?>);" /></td>
                                            <td align="center"><img src="imgs/Actions-document-save-icon.png" title="Cập nhật" style="cursor: pointer" onclick="putProID('S', <?php echo $masp; ?>);" /></td>
                                        </tr>
                                        <?php
                                        $total += $p->getPrice() * $solg;
                                    }
                                    ?>
                                </table>
                                <script type="text/javascript">
                                    $("#total").html("Tổng tiền: <?php echo number_format($total); ?>");
                                </script>

                            </div>
                            <div style="padding-left: 30px">
                                <a href="index.php" class="blueLink">Về trang chủ</a>
                                <input type="submit" id="btnLapHD" name="btnLapHD" value="Lập hoá đơn" class="blueButton" />
                            </div>
                        </form>
                        <!-- InstanceEndEditable -->
                    </div>
                </div>
            </div>

            <div style="clear: both"></div>

            <div id="footer">
                <div>
                    Copyright @ 12CK3 2014
                </div>
                <div>
                    Liên hệ: ltweb1-12ck3@fit.hcmus.edu.vn
                </div>
            </div>
        </div>
    </body>
    <!-- InstanceEnd --></html>
