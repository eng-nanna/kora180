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
    $news = find_news_by_id($id);
    if ($news['img']!="avatar.png")
        unlink('img/news/'.DIRECTORY_SEPARATOR.$news['img']); //delete it

    $result = delete_news($id);
    header("location: news.php");
    exit();
}else{
    $news = find_news_by_id($id);


}

$page_title = "حذف خبر";
include ('../includes/admin_header.php');


?>


    <h1 class="pageTitle">
      <span>حذف خبر</span>
    </h1>

<?php
echo display_errors($errors);
?>

    <div class="padding-1em">

        <a class="back-link" href="news.php">&laquo; عودة للصفحة الرئيسية</a>

        <p>متأكد من ضرورة حذف هذا الخبر ؟</p>
        <p class="item"><?php echo htmlspecialchars($news['title']); ?></p>


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
