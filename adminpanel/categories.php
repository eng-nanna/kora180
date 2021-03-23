<?php
require_once('../includes/initialize.php');
require_login();

$page_title = "إضافة تصنيف";
$categ_set = find_all_categories();
include ('../includes/admin_header.php');

if (is_post_request()){
    $categ = [];
    $categ['category'] = $_POST['category'] ?? '';

    $result = insert_category($categ);
    if($result === true){
        $new_id = mysqli_insert_id($db);
        header("location: categories.php");
        exit();
    }else{
        $errors = $result;
    }
}else {
    $categ = [];
    $categ['category'] = '';
}
?>


    <h1 class="pageTitle">
      <span>التصنيفات</span>
      <a data-open="addAdmin" class="button">إضافة تصنيف</a>
    </h1>

<?php
echo display_errors($errors);
?>

    <div class="padding-1em">
      <table width="100%">
        <thead>
          <th>التصنيف</th>
          <th class="text-center">تعديل</th>
          <th class="text-center">حذف</th>
        </thead>
        <tbody>
        <?php while($categ = mysqli_fetch_assoc($categ_set)) { ?>
          <tr>
              <td><?php echo htmlspecialchars($categ['category']); ?></td>
            <td class="text-center editRow"><a href="edit_category.php?id=<?php echo htmlspecialchars(urlencode($categ['category_id'])); ?> "><i class="fas fa-edit"></i></a></td>
            <td class="text-center removeRow"><a href="delete_category.php?id=<?php echo htmlspecialchars(urlencode($categ['category_id'])); ?> "><i class="fas fa-trash-alt"></i></a></td>
          </tr>
        <?php }
        mysqli_free_result($categ_set);?>
        </tbody>
      </table>
    </div>

    <div class="reveal" data-animation-out="fade-out" id="addAdmin" data-reveal>
      <h3 class="">
        <span>إضافة تصنيف</span>
      </h3>
      <form class="addForm" action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
        <label for="addName">التصنيف:</label>
        <input type="text" id="addName" name="category" value="" placeholder="التصنيف">
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
