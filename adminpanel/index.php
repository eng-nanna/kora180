<?php
require_once('../includes/initialize.php');

$errors = [];

if(is_post_request()) {

    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (is_blank($username)){
        $errors[] = "ادخل اسم المستخدم";
    }
    if (is_blank($password)){
        $errors[] = "ادخل كلمة المرور";
    }

    if (empty($errors)){
        $sql = "SELECT * FROM admins WHERE username = '$username' ";
        $result = mysqli_query($db,$sql);
        confirm_result_set($result);
        $admin = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        if ($admin){
            if (password_verify($password,$admin['password'])){
                log_in_admin($admin);
                header("location: home.php");
                exit();
            }else{
                //username found, but password does not match
                $errors[] = "كلمة المرور غير صحيحة";
            }
        }else{
            //no username found
            $errors[] = "المستخدم غير موجود";
        }
    }
}

?>
<!doctype html>
<html class="no-js" lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>كورة 180 | تسجيل دخول الأدمن</title>
  <link rel="stylesheet" href="css/app.css">
  <link rel="stylesheet" href="css/fonts/opensans_regular/stylesheet.css" />
  <link rel="stylesheet" href="css/fonts/opensans_bold/stylesheet.css" />
  <link rel="stylesheet" href="css/icons-style/font-awesome.min.css" />

  <link rel="stylesheet" href="css/style.css" />
    <style>
        .errors {
            display: inline-block;
            border: 2px solid blue;
            color: blue;
            padding: 1em;
            margin-bottom: 1em;
        }

        .errors ul {
            margin-bottom: 0;
            padding-left: 1em;
        }

    </style>
</head>
<body>

  <div class="row login-container">
    <div class="login-form">
      <div class="form-logo">
        <a href="#">
          <img src="img/kora.jpg" alt="logo" width="230">
        </a>
      </div><!-- form-logo -->
        <?php echo display_errors($errors); ?>
      <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
        <label> <i class="fa fa-user"></i> اسم المستخدم<input type="text" name="username" placeholder="اسم المستخدم"></label>
        <label><i class="fa fa-key"></i> كلمة المرور<input type="password" name="password" placeholder="كلمة المرور"></label>
        <input type="submit" class="success button expanded" value="دخول">
      </form>
    </div>
  </div>

  <script src="js/vendor.min.js"></script>
  <script src="js/app.js"></script>
  <script>
  $(document).foundation();
  </script>
</body>
</html>
