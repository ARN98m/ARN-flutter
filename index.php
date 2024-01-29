<?php
ob_start();

//هذه صفحة التسجيل
session_start();

//متغيير عنوان الصفحة      
$PageTitle = 'Login';

//هذا المتغيرر لي يبين بلي هذي الصفحة مفيهاش navbar
$noNavbar = '';

//تحفضلي التسجيل باه كي ندير ريلود لصفحة متدخلينش لل صفحة التسجيل مرة وخداخر
if (isset($_SESSION['admin'])) {
  Header('Location: homePage.php'); //Redirect To Dashboard Page
}

//الملف لي فيه قاع الملفات المستدعات
include 'init.php';
//Check if User Coming From HTTP Post Request (التاكد ان الشخص دخل لصفحة بااسم المستخدم  والباسورد)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $admin = $_POST['user'];
  $password = $_POST['pass'];
  $hashedPass = sha1($password);



  $row =  getAllFrom(
    "admin_id,admin_name,admin_password",
    "admins",
    "admin_name=? AND admin_password= ?",
    $admin . "," . $hashedPass,
    "",
    "",
    "",
    1
  );

  $count = checkCount(
    "admin_id,admin_name,admin_password",
    "admins",
    "admin_name=? AND admin_password= ?",
    $admin . "," . $hashedPass,
  );

  if ($count > 0) {
    $_SESSION['admin'] = $admin; 
    $_SESSION['ID'] = $row['admin_id']; 
    header('location: homePage.php'); 
    exit();
  }
}
?>


<form class='login' action="<?php echo $_SERVER['PHP_SELF'] ?>" method='POST'>

  <img class="logo" src="layout/images/logo.png" alt="">
  <h4 class='text-center'>Admin Login</h4>
  <input class='form-control' type="text" name="user" placeholder='الاسم' autocomplete='off'>
  <input class='form-control' type="password" name="pass" placeholder='الرقم السري' autocomplete='new-password'>
  <input class='btn  submit' type="submit" value='Login' />
</form>


<?php
include  $tpl . 'footer.php';

ob_end_flush();
?>