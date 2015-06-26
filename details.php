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
        require_once '/helper/CartProcessing.php';

        // đặt hàng

        if (isset($_POST["btnDatHang"])) {
            $masp = $_GET['proId'];
            $solg = $_POST["txtSoLuong"];
            CartProcessing::addItem($masp, $solg);
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
                            Chi tiết sản phẩm
                            <!-- InstanceEndEditable -->
                        </div>
                    </div>
                    <div id="right-body">
                        <!-- InstanceBeginEditable name="main-body" -->
<?php
require_once 'helper/Utils.php';
require_once 'entities/Product.php';

if (!isset($_GET["proId"])) {
    Utils::RedirectTo("index.php");
} else {
    $p_proId = $_GET["proId"];
    $p = Product::loadProductByProId($p_proId);

    if (!isset($p)) {
        echo "Không có sản phẩm này.";
    } else {
        ?>

                                <table cellpadding="5" cellspacing="0">
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td><img width="400" height="300" src="imgs/sp/<?php echo $p->getProId(); ?>/main.jpg"/></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td><span class="bold13orange"><?php echo $p->getProName(); ?></span></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td><span class="bold11red"><?php echo number_format($p->getPrice()); ?></span></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td><span><?php echo $p->getFullDes(); ?></span></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>
        <?php
        if (Context::isLogged()) {
            ?>
                                                <form id="frmAddToCart" name="frmAddToCart" method="post" action="">
                                                    Số lượng đặt: <input type="text" id="txtSoLuong" name="txtSoLuong" style="width: 45px"/>
                                                    <input type="submit" id="btnDatHang" name="btnDatHang" class="blueButton" value="Đặt hàng" />
                                                </form>
            <?php
        } else {
            echo "&nbsp;";
        }
        ?>
                                        </td>
                                    </tr>
                                </table>

        <?php
    }
}
?>
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
