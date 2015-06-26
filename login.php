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

        <style type="text/css">
            #tableDangNhap {
                width: 90%;
                margin: 0 auto;
                margin-top: 15px;
            }
        </style>

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
        require_once '/helper/Utils.php';

        // Login

        require_once 'entities/User.php';

        if (isset($_POST["btnDangNhap"])) {

            $uid = $_POST["txtTenDN"];
            $pwd = $_POST["txtMK"];

            $u = new User(-1, $uid, $pwd, '', '', time(), 0);
            $loginRet = $u->login();

            if ($loginRet) {
                $_SESSION["IsLogin"] = 1; // đã đăng nhập
                $_SESSION["CurrentUser"] = (array) $u;

                $remember = isset($_POST["chkGhiNho"]) ? true : false;
                
                if ($remember) {
                    $expire = time() + 15 * 24 * 60 * 60;
                    setcookie("UserName", $uid, $expire);
                }

                $url = 'index.php';
                if (isset($_GET["retUrl"])) {
                    $url = $_GET["retUrl"];
                }

                Utils::RedirectTo($url);
            } else {
                
            }
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
                            Đăng nhập
                            <!-- InstanceEndEditable -->
                        </div>
                    </div>
                    <div id="right-body">
                        <!-- InstanceBeginEditable name="main-body" -->

                        <form id="frmLogin" name="frmLogin" method="post" action="">
                            <table id="tableDangNhap" cellpadding="2" cellspacing="0">
                                <tr>
                                    <td class="title" colspan="4">Thông tin đăng nhập</td>
                                </tr>
                                <tr>
                                    <td width="15px">&nbsp;</td>
                                    <td width="120px">&nbsp;</td>
                                    <td width="200px">&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td width="15px">&nbsp;</td>
                                    <td width="120px">Tên đăng nhập:</td>
                                    <td width="200px">
                                        <input type="text" name="txtTenDN" id="txtTenDN" />
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>Mật khẩu:</td>
                                    <td><input type="password" name="txtMK" id="txtMK" />

                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>
                                        <input name="chkGhiNho" type="checkbox" id="chkGhiNho" value="checked" />Ghi nhớ                                
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>
                                        <input name="btnDangNhap" type="submit" class="blueButton" id="btnDangNhap" value="Đăng nhập" />
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td colspan="3">
                                        <span style="color: red"></span>
                                    </td>
                                </tr>
                            </table>
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
