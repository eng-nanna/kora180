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
    $bloggers = find_blogger_by_id($id);
    if ($bloggers['img']!="avatar.png")
        unlink('img/bloggers/'.DIRECTORY_SEPARATOR.$bloggers['img']); //delete it

    $result = delete_blogger($id);
    header("location: bloggers.php");
    exit();
}else{
    $bloggers = find_blogger_by_id($id);


}

$page_title = "حذف مقالة";
include ('../includes/admin_header.php');


?>


    <h1 class="pageTitle">
      <span>حذف مقالة</span>
    </h1>

<?php
echo display_errors($errors);
?>

    <div class="padding-1em">

        <a class="back-link" href="bloggers.php">&laquo; عودة للصفحة الرئيسية</a>

        <p>متأكد من ضرورة حذف هذه المقالة ؟</p>
        <p class="item"><?php echo htmlspecialchars($bloggers['title']); ?></p>


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
