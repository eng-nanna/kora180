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
$path = "img/bloggers/"; // Upload directory

if (is_post_request()){
    $bloggers = [];
    $bloggers['id'] = $id ?? '';
    $bloggers['title'] = $_POST['title'] ?? '';
    $bloggers['content'] = $_POST['content'] ?? '';
    if (empty($_FILES['files']['name'])){
        $sql = "SELECT * FROM blogger WHERE blogger_id = '$id' ";
        $result = mysqli_query($db,$sql);
        confirm_result_set($result);
        $bloggers_set = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        $bloggers['img'] = $bloggers_set['img'];
        $result = update_blogger($bloggers);
        if($result === true){
            header("location: bloggers.php");
            exit();
        }else{
            $errors = $result;
        }
    }else{
        $bloggers['img'] = $_FILES['files']['name'];
        if ($_FILES['files']['error'] == 0) {
            list($width,$height) = getimagesize($_FILES["files"]["tmp_name"]);
            if ($height < $min_file_dim || $width < $min_file_dim) {
                $message = "يجب أن لا قل حجم الصورة عن 200 بيكسل";
                echo "<script type='text/javascript'>alert('$message');</script>";
            }elseif ($height > $max_file_dim || $width > $max_file_dim) {
                $message = "يجب أن لا يزيد حجم الصورة عن 550 بيكسل";
                echo "<script type='text/javascript'>alert('$message');</script>";
            }
            elseif( ! in_array(pathinfo($bloggers['img'], PATHINFO_EXTENSION), $valid_formats) ){
                $message = "امتداد الصورة غير مناسب";
                echo "<script type='text/javascript'>alert('$message');</script>";
            }
            else{ // No error found! Move uploaded files
                if(move_uploaded_file($_FILES["files"]["tmp_name"], $path.$bloggers['img'])) {
                    $result = update_blogger($bloggers);
                    if($result === true){
                        header("location: bloggers.php");
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
    $sql = "SELECT * FROM blogger WHERE blogger_id = '$id' ";
    $result = mysqli_query($db,$sql);
    confirm_result_set($result);
    $bloggers = mysqli_fetch_assoc($result);
    mysqli_free_result($result);


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

        <a class="back-link" href="bloggers.php">&laquo; عودة للصفحة الرئيسية</a>

        <form class="addForm" action="<?php $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
            <label for="addName">عنوان الخبر:</label>
            <input type="text" id="addName" name="title" value="<?php echo $bloggers['title']; ?>" >
            <label for="password">محتوى الخبر:</label>
            <textarea id="content" name="content" rows="10" cols="20" placeholder="تفاصيل الخبر"><?php echo $bloggers['content']; ?></textarea>
            <img src="img/bloggers/<?php echo $bloggers['img']; ?>"<br>
            <input type="file" name="files" id="file" class="inputfile" />
            <label for="file">تغيير صورة المقالة</label>
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
