<?php
require_once('../includes/initialize.php');
require_login();

$page_title = "إضافة أدمن";
$admins_set = find_all_admins();
include ('../includes/admin_header.php');

if (is_post_request()){
    $admin = [];
    $admin['username'] = $_POST['username'] ?? '';
    $admin['password'] = $_POST['password'] ?? '';

    $result = insert_admin($admin);
    if($result === true){
        $new_id = mysqli_insert_id($db);
        header("location: home.php");
        exit();
    }else{
        $errors = $result;
    }
}else {
    $admin = [];
    $admin['username'] = '';
    $admin['password'] = '';
}
?>


    <h1 class="pageTitle">
      <span>الأدمن</span>
      <a data-open="addAdmin" class="button">إضافة أدمن</a>
    </h1>

<?php
echo display_errors($errors);
?>

    <div class="padding-1em">
      <table width="100%">
        <thead>
          <th>اسم المستخدم</th>
          <th class="text-center">تعديل</th>
          <th class="text-center">حذف</th>
        </thead>
        <tbody>
        <?php while($admin = mysqli_fetch_assoc($admins_set)) { ?>
          <tr>
            <td><?php echo htmlspecialchars($admin['username']); ?></td>
            <td class="text-center editRow"><a href="edit_admin.php?id=<?php echo htmlspecialchars(urlencode($admin['admin_id'])); ?> "><i class="fas fa-edit"></i></a></td>
            <td class="text-center removeRow"><a href="delete_admin.php?id=<?php echo htmlspecialchars(urlencode($admin['admin_id'])); ?> "><i class="fas fa-trash-alt"></i></a></td>
          </tr>
        <?php }
        mysqli_free_result($admins_set);?>
        </tbody>
      </table>
    </div>

    <div class="reveal" data-animation-out="fade-out" id="addAdmin" data-reveal>
      <h3 class="">
        <span>إضافة أدمن</span>
      </h3>
      <form class="addForm" action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
        <label for="addName">اسم المستخدم:</label>
        <input type="text" id="addName" name="username" value="" placeholder="اسم المستخدم">
        <label for="password">كلمة المرور:</label>
        <input type="password" id="password" name="password" value="" placeholder="كلمة المرور">
        <input class="button expanded" type="submit" name="submit" value="إضافة">
      </form>
      <button class="close-button" data-close aria-label="Close reveal" type="button">
        <span aria-hidden="true">&times;</span>
      </button>
    </div><!-- reveal -->

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
