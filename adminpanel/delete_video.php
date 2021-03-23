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
    $sql = "SELECT * FROM videos WHERE video_id = '$id' ";
    $result = mysqli_query($db,$sql);
    confirm_result_set($result);
    $video_set = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    $thumb = pathinfo($video_set['video'], PATHINFO_FILENAME).".jpg";
    unlink('video/'.DIRECTORY_SEPARATOR.$video_set['video']); //delete it
    unlink('video/thumbnail/'.DIRECTORY_SEPARATOR.$thumb); //delete it

    $results = delete_video($id);
    header("location: videos.php");
    exit();
}else{
    $sql = "SELECT * FROM videos WHERE video_id = '$id' ";
    $result = mysqli_query($db,$sql);
    confirm_result_set($result);
    $video_set = mysqli_fetch_assoc($result);
    mysqli_free_result($result);


}

$page_title = "حذف فيديو";
include ('../includes/admin_header.php');


?>


    <h1 class="pageTitle">
      <span>حذف فيديو</span>
    </h1>

<?php
echo display_errors($errors);
?>

    <div class="padding-1em">

        <a class="back-link" href="videos.php">&laquo; عودة للصفحة الرئيسية</a>

        <p>متأكد من ضرورة حذف هذا الفيديو ؟</p>
        <p class="item"><?php echo htmlspecialchars($video_set['video_title']); ?></p>


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
