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
    $categ = [];
    $categ['id'] = $id ?? '';
    $categ['category'] = $_POST['category'] ?? '';


    $result = update_category($categ);
    if($result === true){
        header("location: categories.php");
        exit();
    }else{
        $errors = $result;
    }
}else{
    $sql = "SELECT * FROM categories WHERE category_id = '$id' ";
    $result = mysqli_query($db,$sql);
    confirm_result_set($result);
    $categ = mysqli_fetch_assoc($result);
    mysqli_free_result($result);


}

$page_title = "تعديل التصنيف";
include ('../includes/admin_header.php');


?>


    <h1 class="pageTitle">
      <span>تعديل التصنيف</span>
    </h1>

<?php
echo display_errors($errors);
?>

    <div class="padding-1em">

        <a class="back-link" href="categories.php">&laquo; عودة للصفحة الرئيسية</a>

        <form class="addForm" action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
            <label for="addName">التصنيف:</label>
            <input type="text" id="addName" name="category" value="<?php echo $categ['category']; ?>" >
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
