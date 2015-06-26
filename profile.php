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

        <link href="jquery-ui-1.11.2.custom/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
        <script src="jquery-ui-1.11.2.custom/external/jquery/jquery.js" type="text/javascript"></script>
        <script src="jquery-ui-1.11.2.custom/jquery-ui.min.js" type="text/javascript"></script>

        <script type="text/javascript">
            $(function() {
                $("#txtNgaySinh").datepicker(
                        {
                            dateFormat: "d/m/yy"
                        }
                );
            }
            );
        </script>

        <style type="text/css">
            #tableDangKy {
                width: 90%;
                margin: 0 auto;
                margin-top: 15px;
            }

            div.ui-datepicker {
                font-size: 10pt;
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
        require_once '/helper/Context.php';
        require_once '/helper/Utils.php';
        require_once '/entities/User.php';

        if (!Context::isLogged()) {
            Utils::RedirectTo('login.php?retUrl=profile.php');
        }

        // đổi mật khẩu

        if (isset($_POST["btnDoiMK"])) {
            $old_pwd = $_POST['txtMKCu'];
            $new_pwd = $_POST['txtMKMoi'];
            $username = $_SESSION['CurrentUser']['username'];

            $n = User::changePassword($username, $old_pwd, $new_pwd);

            if ($n > 0) {
                echo "<script type='text/javascript'>alert('Đổi MK thành công.');</script>";
            } else {
                echo "<script type='text/javascript'>alert('Đổi MK KHÔNG thành công.');</script>";
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
                            Thông tin cá nhân
                            <!-- InstanceEndEditable -->
                        </div>
                    </div>
                    <div id="right-body">
                        <!-- InstanceBeginEditable name="main-body" -->
                        <form action="" method="post" id="frm">
                            <table id="tableDangKy" cellpadding="2" cellspacing="0">
                                <tr>
                                    <td colspan="4" class="title">Đổi mật khẩu</td>
                                </tr>
                                <tr>
                                    <td width="15px"></td>
                                    <td width="120px"></td>
                                    <td width="200px"></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>Tên đăng nhập:</td>
                                    <td><strong><?php echo $_SESSION["CurrentUser"]["username"]; ?></strong>

                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>Mật khẩu cũ:</td>
                                    <td><input type="password" id="txtMKCu" name="txtMKCu" /></td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>Mật khẩu mới:</td>
                                    <td><input type="password" id="txtMKMoi" name="txtMKMoi" /></td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>Nhập lại:</td>
                                    <td><input type="password" id="txtNLMK" name="txtNLMK" /></td>
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
                                    <td><input name="btnDoiMK" type="submit" class="blueButton" id="btnDoiMK" value="Cập nhật" /></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="title">Cập nhật thông tin cá nhân</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>Họ tên:</td>
                                    <td>
                                        <input type="text" id="txtHoTen" name="txtHoTen" value="<?php echo $_SESSION["CurrentUser"]["name"]; ?>" />
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>Email:</td>
                                    <td>
                                        <input type="text" id="txtEmail" name="txtEmail" value="<?php echo $_SESSION["CurrentUser"]["email"]; ?>" />
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>Ngày sinh:</td>
                                    <td>
                                        <input type="text" id="txtNgaySinh" name="txtNgaySinh" value="<?php echo date('j/n/Y', $_SESSION["CurrentUser"]["dob"]); ?>" />
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
                                    <td><input name="btnCapNhat" type="submit" class="blueButton" id="btnCapNhat" value="Cập nhật" /></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td colspan="3">&nbsp;

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
