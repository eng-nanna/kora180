<?php
require_once('../includes/initialize.php');
require_login();

if(!isset($_GET['id'])){
    header("location: index.php");
    exit();
}
$id = $_GET['id'];
$id= db_escape($db,$id);

$valid_formats = array("jpg", "png", "gif", "zip", "bmp");
$min_file_dim = 200;
$max_file_dim = 550;
$path = "img/news/"; // Upload directory

if (is_post_request()){
    $news = [];
    $news['id'] = $id ?? '';
    $news['title'] = $_POST['title'] ?? '';
    $news['details'] = $_POST['details'] ?? '';
    if (empty($_FILES['files']['name'])){
        $news_set = find_news_by_id($id);
        $news['img'] = $news_set['img'];
        $result = update_news($news);
        if($result === true){
            $new_id = mysqli_insert_id($db);
            header("location: news.php");
            exit();
        }else{
            $errors = $result;
        }
    }else{
        $news['img'] = $_FILES['files']['name'];
        if ($_FILES['files']['error'] == 0) {
            list($width,$height) = getimagesize($_FILES["files"]["tmp_name"]);
            if ($height < $min_file_dim || $width < $min_file_dim) {
                $message = "يجب أن لا يقل حجم الصورة عن 200 بيكسل";
                echo "<script type='text/javascript'>alert('$message');</script>";
            }elseif ($height > $max_file_dim || $width > $max_file_dim) {
                $message = "يجب أن لا يزيد حجم الصورة عن 550 بيكسل";
                echo "<script type='text/javascript'>alert('$message');</script>";
            }
            elseif( ! in_array(pathinfo($news['img'], PATHINFO_EXTENSION), $valid_formats) ){
                $message = "امتداد الصورة غير مناسب";
                echo "<script type='text/javascript'>alert('$message');</script>";
            }
            else{ // No error found! Move uploaded files
                if(move_uploaded_file($_FILES["files"]["tmp_name"], $path.$news['img'])) {
                    $result = update_news($news);
                    if($result === true){
                        $new_id = mysqli_insert_id($db);
                        header("location: news.php");
                        exit();
                    }else{
                        $errors = $result;
                    }
                }
                else {
                    // Failure
                    $message = "Try again";
                    echo "<script type='text/javascript'>alert('$message');</script>";
                }
            }
        }
    }
}else{
    $news = find_news_by_id($id);


}

$page_title = "تعديل الخبر";
include ('../includes/admin_header.php');


?>


    <h1 class="pageTitle">
      <span>تعديل الخبر</span>
    </h1>

<?php
echo display_errors($errors);
?>

    <div class="padding-1em">

        <a class="back-link" href="news.php">&laquo; عودة للصفحة الرئيسية</a>

        <form class="addForm" action="<?php $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
            <label for="addName">عنوان الخبر:</label>
            <input type="text" id="addName" name="title" value="<?php echo $news['title']; ?>" >
            <label for="password">محتوى الخبر:</label>
            <textarea id="content" name="details" rows="10" cols="20" placeholder="تفاصيل الخبر"><?php echo $news['details']; ?></textarea>
            <img src="img/news/<?php echo $news['img']; ?>"<br>
            <input type="file" name="files" id="file" class="inputfile" />
            <label for="file">تغيير صورة الخبر</label>
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
