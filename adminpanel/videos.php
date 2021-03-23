<?php
require_once('../includes/initialize.php');
require_login();

$page_title = "إضافة فيديو";
$video_set = find_all_videos($options=[]);
include ('../includes/admin_header.php');

$valid_formats = array("mp4");
$file_size_max = 160000000;
$path = "video/"; // Upload directory

if (isset($_POST['submit'])){
    $video = [];
    $video['category_id'] = $_POST ['category'] ?? '';
    $video['video_title'] = $_POST['title'] ?? '';
    $video['video_date'] = date("Y-m-d h:i:s");

    if (empty($_FILES['files']['name'])){
        $video['video'] = "";
        $result = insert_video($video);
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
                $ffmpeg = "C:\\ffmpeg\\bin\\ffmpeg";
                $videoFile = $_FILES["files"]["tmp_name"];
                $size = "250x250";
                $thumb = "video/thumbnail/". pathinfo($video['video'], PATHINFO_FILENAME);

                for($num = 1; $num <= 1; $num++)
                {
                    $interval = $num * 3;
                    shell_exec("$ffmpeg -i $videoFile -an -ss $interval -s $size $thumb.jpg");
                    echo "Thumbnail Created! - $num.jpg<br />";
                }
                if(move_uploaded_file($_FILES["files"]["tmp_name"], $path.$video['video'])) {
                    $result = insert_video($video);
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
}else {
    $video = [];
    $video['category_id'] = '';
    $video['video_title'] = '';
    $video['video'] = '';
}
?>


    <h1 class="pageTitle">
      <span>الفيديوهات</span>
      <a data-open="addAdmin" class="button">إضافة فيديو</a>
    </h1>

<?php
echo display_errors($errors);
?>


<div class="padding-1em">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        اختر التصنيف<select onchange="fetch_select(this.value);">

            <option value="all">جميع التصنيفات</option>
            <?php
            $categ_set = find_all_categories();
            while($categ = mysqli_fetch_assoc($categ_set)){
                ?>
                <option value="<?php echo htmlspecialchars($categ['category_id']);?>"><?php echo htmlspecialchars($categ['category']);?></option>
                <?php
            }
            ?>
        </select>
    </form>

    <table width="100%" id="DisplayDiv">
        <thead>
          <th>عنوان الفيديو</th>
          <th class="text-center">تعديل</th>
          <th class="text-center">حذف</th>
        </thead>
        <tbody>
        <?php while($video = mysqli_fetch_assoc($video_set)) { ?>
          <tr>
              <td><?php echo htmlspecialchars($video['video_title']); ?></td>
            <td class="text-center editRow"><a href="edit_video.php?id=<?php echo htmlspecialchars(urlencode($video['video_id'])); ?> "><i class="fas fa-edit"></i></a></td>
            <td class="text-center removeRow"><a href="delete_video.php?id=<?php echo htmlspecialchars(urlencode($video['video_id'])); ?> "><i class="fas fa-trash-alt"></i></a></td>
          </tr>
        <?php }
        mysqli_free_result($video_set);?>
        </tbody>
      </table>
    </div>

    <div class="reveal" data-animation-out="fade-out" id="addAdmin" data-reveal>
      <h3 class="">
        <span>إضافة فيديو</span>
      </h3>
      <form class="addForm" action="<?php $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
        <label for="addName">عنوان الفيديو:</label>
        <input type="text" id="addName" name="title" value="" placeholder="عنوان الفيديو">
        <label for="category">التصنيف:</label>
          <select name="category">
              <?php
              $categ_set = find_all_categories();
              while($categ = mysqli_fetch_assoc($categ_set)){
                  ?>
                  <option value="<?php echo htmlspecialchars($categ['category_id']);?>"><?php echo htmlspecialchars($categ['category']);?></option>
                  <?php
              }
              ?>
          </select>
          <input type="file" name="files" id="file" class="inputfile" />
          <label for="file">تحميل الفيديو</label>
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

<script>
    function fetch_select(val)
    {
        $.ajax({
            type: 'post',
            url: 'test.php',
            data: {
                selected:val
            },
            success: function (response) {
                document.getElementById("DisplayDiv").innerHTML=response;
            }
        });
    }
</script>
</body>
</html>
