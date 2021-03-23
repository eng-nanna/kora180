<?php
require_once('../includes/initialize.php');
require_login();

if(!isset($_GET['id'])){
    header("location: index.php");
    exit();
}
$id = $_GET['id'];
$id= db_escape($db,$id);

if(is_post_request()) {
    $result = delete_category($id);
    header("location: categories.php");
    exit();
}else{
    $sql = "SELECT * FROM categories WHERE category_id = '$id' ";
    $result = mysqli_query($db,$sql);
    confirm_result_set($result);
    $categ = mysqli_fetch_assoc($result);
    mysqli_free_result($result);


}

$page_title = "حذف تصنيف";
include ('../includes/admin_header.php');


?>


    <h1 class="pageTitle">
      <span>حذف تصنيف</span>
    </h1>

<?php
echo display_errors($errors);
?>

    <div class="padding-1em">

        <a class="back-link" href="categories.php">&laquo; عودة للصفحة الرئيسية</a>

        <p>متأكد من ضرورة حذف هذا التصنيف ؟</p>
        <p class="item"><?php echo htmlspecialchars($categ['category']); ?></p>


        <form class="addForm" action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
            <input class="button expanded" type="submit" name="submit" value="حذف">
        </form>
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
