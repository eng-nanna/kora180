<?php
require_once('../includes/initialize.php');
require_login();

if(!isset($_GET['id'])){
    header("location: index.php");
    exit();
}
$id = $_GET['id'];
$id= db_escape($db,$id);

$valid_formats = array("mp4");
$file_size_max = 160000000;
$path = "video/"; // Upload directory


if (is_post_request()){
    $video = [];
    $video['id'] = $id ?? '';
    $video['category_id'] = $_POST ['category'] ?? '';
    $video['video_title'] = $_POST['title'] ?? '';
    if (empty($_FILES['files']['name'])){
        $video_set = find_video_by_id($id);
        $video['video'] = $video_set['video'];
        $result = update_video($news);
        if($result === true){
            $new_id = mysqli_insert_id($db);
            header("location: videos.php");
            exit();
        }else{
            $errors = $result;
        }
    }else{
        $video['video'] = $_FILES['files']['name'];
        if ($_FILES['files']['error'] == 0) {
            if ($_FILES["files"]["size"] > $file_size_max){
                $message = "يجب أن لا يزيد حجم الفيديو عن 20 ميجابايت";
                echo "<script type='text/javascript'>alert('$message');</script>";
            }
            elseif( ! in_array(pathinfo($video['video'], PATHINFO_EXTENSION), $valid_formats) ){
                $message = "يرجى اختيار فيديو بصيغة mp4";
                echo "<script type='text/javascript'>alert('$message');</script>";
            }
            else{ // No error found! Move uploaded files
                $ffmpeg = "../../ffmpeg/bin/ffmpeg";
                $videoFile = $_FILES["files"]["tmp_name"];
                $size = "250x250";
                $thumb = "video/thumbnail/". pathinfo($video['video'], PATHINFO_FILENAME);

                for($num = 1; $num <= 1; $num++)
                {
                    $interval = $num * 3;
                    shell_exec("$ffmpeg -i $videoFile -an -ss $interval -s $size $thumb.jpg");
                }
                if(move_uploaded_file($_FILES["files"]["tmp_name"], $path.$video['video'])) {
                    $result = update_video($video);
                    if($result === true){
                        $new_id = mysqli_insert_id($db);
                        header("location: videos.php");
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
    $video_set = find_video_by_id($id);

}

$page_title = "تعديل الخبر";
include ('../includes/admin_header.php');


?>


    <h1 class="pageTitle">
      <span>تعديل الفيديو</span>
    </h1>

<?php
echo display_errors($errors);
?>

    <div class="padding-1em">

        <a class="back-link" href="videos.php">&laquo; عودة للصفحة الرئيسية</a>

        <form class="addForm" action="<?php $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
            <label for="addName">عنوان الفيديو:</label>
            <input type="text" id="addName" name="title" value="<?php echo $video_set['video_title']; ?>" >
            <label for="category">التصنيف:</label>
            <select name="category">
                <?php
                $categ_set = find_all_categories();
                while($categ = mysqli_fetch_assoc($categ_set)){
                    print '<option value="'.htmlspecialchars($categ['category_id']).'"'.(htmlspecialchars($categ['category_id']) === $video_set['category_id'] ? ' selected="selected"' : '').'>'.htmlspecialchars($categ['category']).'</option>';
                }
                ?>
            <input type="file" name="files" id="file" class="inputfile" />
            <label for="file">تغيير الفيديو</label>
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
