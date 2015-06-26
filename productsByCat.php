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
        <script src="lightbox/js/lightbox.min.js" type="text/javascript"></script>

        <link href="lightbox/css/lightbox.css" rel="stylesheet" type="text/css"/>

        <style type="text/css">
            #product-list {
                margin: 15px 0 0 0; 
                padding: 0; 
                list-style: none;
            }

            #product-list li {
                float: left; 
                margin: 0 0px 15px 15px; 
                border: 1px dashed #CCCCCC; 
                padding: 10px; 
                width: 310px;
            }
        </style>

        <script type="text/javascript">
            function putProID(masp) {
                $("#txtMaSP").val(masp);
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
        require_once '/helper/CartProcessing.php';

        // đặt hàng

        if (isset($_POST['txtMaSP'])) {
            $masp = $_POST['txtMaSP'];
            $solg = 1;
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
                            Danh sách sản phẩm
                            <!-- InstanceEndEditable -->
                        </div>
                    </div>
                    <div id="right-body">
                        <!-- InstanceBeginEditable name="main-body" -->
                        <?php
                        require_once 'helper/Utils.php';
                        require_once 'entities/Product.php';

                        if (!isset($_GET["catId"])) {
                            //echo "Không có tham số danh mục.";
                            Utils::RedirectTo("index.php");
                        } else {
                            $p_catId = $_GET["catId"];
                            $list = Product::loadProductsByCatId($p_catId);

                            $n = count($list);
                            if ($n == 0) {
                                echo "Không có sản phẩm.";
                            } else {
                                ?>
                                <form id="form1" name="form1" method="post" action="">               
                                    <input type="hidden" id="txtMaSP" name="txtMaSP" />
                                </form>

                                <ul id="product-list">
                                    <?php
                                    for ($i = 0; $i < $n; $i++) {
                                        //echo $list[$i]->getProName() . "<br/>";
                                        ?>
                                        <li>
                                            <a href="imgs/sp/<?php echo $list[$i]->getProID(); ?>/main.jpg" data-lightbox="lightbox-<?php echo $i; ?>"><img width="200" height="150" src="imgs/sp/<?php echo $list[$i]->getProID(); ?>/main_thumbs.jpg" title="<?php echo $list[$i]->getProName(); ?>" /></a>
                                            <br />
                                            <br />
                                            <span class="bold13orange"><?php echo $list[$i]->getProName(); ?></span>
                                            <br />
                                            Giá: <span class="bold11red"><?php echo number_format($list[$i]->getPrice()); ?></span>
                                            <br />
                                            Số lượng: <?php echo $list[$i]->getQuantity(); ?>
                                            <br />
                                            <br />
                                            <span style="height: 26px; display: block"><?php echo $list[$i]->getTinyDes(); ?></span>
                                            <br />
                                            <table cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td><a href="details.php?proId=<?php echo $list[$i]->getProID(); ?>" class="Detail">Chi tiết</a></td>
                                                    <td style="padding-left: 4px">
                                                        <?php
                                                        if (Context::isLogged()) {
                                                            ?>
                                                            <a href="#" class="Detail" onclick="putProID(<?php echo $list[$i]->getProID(); ?>);">Đặt hàng</a>
                                                            <?php
                                                        } else {
                                                            echo "&nbsp;";
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                            </table>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                </ul>
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
