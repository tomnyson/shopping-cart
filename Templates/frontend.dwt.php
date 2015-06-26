<?php
session_start();

if (!isset($_SESSION["IsLogin"])) {
    $_SESSION["IsLogin"] = 0; // chưa đăng nhập
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Quản lý bán hàng</title>
        <link href="../font-awesome-4.2.0/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        <!-- TemplateBeginEditable name="head" -->
        <!-- TemplateEndEditable -->
        <link rel="stylesheet" type="text/css" href="../styles/site.css"/>
        <link rel="stylesheet" type="text/css" href="../styles/link.css"/>
        <link rel="stylesheet" type="text/css" href="../styles/frontend-layout.css"/>
    </head>

    <body>
    	<?php
			if (!isset($_SESSION['Cart'])) {
				$_SESSION['Cart'] = array();
			}
		?>
        <!-- TemplateBeginEditable name="PHP_Init" -->
        <!-- TemplateEndEditable -->
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
                        <a href="../login.php" class="cmd">Đăng nhập</a>
                        | 
                        <a href="../register.php" class="cmd">Đăng ký</a>
    <?php
} else {
    ?>
                        <a href="../cart.php" class="cmd"><i class="fa fa-shopping-cart fa-lg"></i> (<b><?php echo CartProcessing::countQuantity(); ?></b> sản phẩm)</a>
                        | 
                        <a href="../profile.php" class="cmd">Hi, <?php echo $_SESSION["CurrentUser"]["name"]; ?>!</a>
                        | 
                        <a href="../logout.php" class="cmd">Thoát</a>
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
require_once '../entities/Category.php';

$categories = Category::loadAll();
for ($i = 0, $n = count($categories); $i < $n; $i++) {
    $name = $categories[$i]->getCatName();
    $id = $categories[$i]->getCatId();
    ?>
                            <a href="../productsByCat.php?catId=<?php echo $id; ?>" class="Menu"><?php echo $name; ?></a><br />
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
                            <!-- TemplateBeginEditable name="main-title" -->
                            <!-- TemplateEndEditable -->
                        </div>
                    </div>
                    <div id="right-body">
                        <!-- TemplateBeginEditable name="main-body" -->
                        <!-- TemplateEndEditable -->
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
</html>
