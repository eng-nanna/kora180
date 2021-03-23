<?php
require_once('../includes/initialize.php');
require_login();

if(!isset($_GET['id'])){
    header("location: index.php");
    exit();
}
$id = $_GET['id'];
$id= db_escape($db,$id);

if (is_post_request()){
    $admin = [];
    $admin['id'] = $id ?? '';
    $admin['username'] = $_POST['username'] ?? '';
    $admin['password'] = $_POST['password'] ?? '';

    $result = update_admin($admin);
    if($result === true){
        header("location: home.php");
        exit();
    }else{
        $errors = $result;
    }
}else{
    $sql = "SELECT * FROM admins WHERE admin_id = '$id' ";
    $result = mysqli_query($db,$sql);
    confirm_result_set($result);
    $admin = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
}

$page_title = "تعديل أدمن";
include ('../includes/admin_header.php');


?>


    <h1 class="pageTitle">
      <span>تعديل الأدمن</span>
    </h1>

<?php
echo display_errors($errors);
?>

    <div class="padding-1em">

        <a class="back-link" href="home.php">&laquo; عودة للصفحة الرئيسية</a>

        <form class="addForm" action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
            <label for="addName">اسم المستخدم:</label>
            <input type="text" id="addName" name="username" value="<?php echo $admin['username']; ?>">
            <label for="password">كلمة المرور:</label>
            <input type="password" id="password" name="password" value="">
            <input class="button expanded" type="submit" name="submit" value="تعديل">
        </form>
      </table>
    </div>

  </div> <!--moduleContainer -->
  <!-- ==== End Modules Contaner ==== -->


</div>

<script src="js/vendor.min.js"></script>
<script src="js/app.js"></script>
<script>
$(document).foundation();
</script>
</body>
</html>
