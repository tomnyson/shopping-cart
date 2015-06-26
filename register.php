<?php
	session_start();
	
	if(!isset($_SESSION["IsLogin"]))
	{
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
        <script type="text/javascript">
            function KTra() {
                var tenDN = $("#txtTenDN").val();
                if (tenDN.length === 0) {
                    alert("Chưa đủ thông tin.");
                    return false;
                }

                return true;
            }

            function changeCaptcha() {
                var captcha = document.getElementById("imgCaptcha");
                captcha.src = "cool-php-captcha-0.3.1/captcha.php?" + Math.random();
            }
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
        require_once '/helper/Utils.php';
        require_once '/entities/User.php';

        if (isset($_POST["btnDangKy"])) {
            $tendn = $_POST["txtTenDN"];
            $mk = $_POST["txtMK"];
            $hoTen = $_POST["txtHoTen"];
            $email = $_POST["txtEmail"];

            $ngaySinh = $_POST["txtNgaySinh"]; // 28/11/2014
            $dob = strtotime(str_replace('/', '-', $ngaySinh)); //d-m-Y
            //$ngaySinh = time();

            $u = new User(-1, $tendn, $mk, $hoTen, $email, $dob, 0);
            $u->insert();

            Utils::RedirectTo("board.php?id=1");
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
                            Đăng ký thành viên
                            <!-- InstanceEndEditable -->
                        </div>
                    </div>
                    <div id="right-body">
                        <!-- InstanceBeginEditable name="main-body" -->
                        <form id="frmReg" name="frmReg" method="post" action="" onsubmit="return KTra();">
                            <table id="tableDangKy" cellpadding="2" cellspacing="0">
                                <tr>
                                    <td colspan="4" class="title">Thông tin đăng nhập</td>
                                </tr>
                                <tr>
                                    <td width="15px">&nbsp;</td>
                                    <td width="120px">&nbsp;</td>
                                    <td width="200px">&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>Tên đăng nhập:</td>
                                    <td><input type="text" name="txtTenDN" id="txtTenDN" /></td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>Mật khẩu:</td>
                                    <td><input type="password" name="txtMK" id="txtMK" /></td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>Nhập lại:</td>
                                    <td><input type="password" name="txtNLMK" id="txtNLMK" /></td>
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
                                    <td><img src="cool-php-captcha-0.3.1/captcha.php" id="imgCaptcha" style="cursor: pointer;" onclick="changeCaptcha()" /></td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>Mã xác nhận:</td>
                                    <td><input type="text" name="txtMaXacNhan" id="txtMaXacNhan" /></td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="title">Thông tin cá nhân</td>
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
                                    <td><input type="text" name="txtHoTen" id="txtHoTen" /></td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>Email:</td>
                                    <td><input type="text" name="txtEmail" id="txtEmail" /></td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>Ngày sinh:</td>
                                    <td><input type="text" name="txtNgaySinh" id="txtNgaySinh" /></td>
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
                                        <input name="btnDangKy" type="submit" class="blueButton" id="btnDangKy" value="Đăng ký" />
                                    </td>
                                    <td>&nbsp;</td>
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
