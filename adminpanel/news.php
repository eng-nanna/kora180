<?php
require_once('../includes/initialize.php');
require_login();

$page_title = "إضافة خبر";
$news_set = find_all_news();
include ('../includes/admin_header.php');

$valid_formats = array("jpg", "png", "gif", "zip", "bmp");
$min_file_dim = 200;
$max_file_dim = 550;
$path = "img/news/"; // Upload directory

if (is_post_request()){
    $news = [];
    $news['title'] = $_POST['title'] ?? '';
    $news['publish_date'] = date('Y-m-d');
    $news['details'] = $_POST['details'] ?? '';
    if (empty($_FILES['files']['name'])){
        $news['img'] = "avatar.png";
        $result = insert_news($news);
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
                    $result = insert_news($news);
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
}else {
    $news = [];
    $news['title'] = '';
    $news['publish_date'] = '';
    $news['img'] = '';
    $news['details'] = '';
}
?>


    <h1 class="pageTitle">
      <span>الأخبار</span>
      <a data-open="addAdmin" class="button">إضافة خبر</a>
    </h1>

<?php
echo display_errors($errors);
?>

    <div class="padding-1em">
      <table width="100%">
        <thead>
          <th>عنوان الخبر</th>
          <th>تاريخ النشر</th>
          <th class="text-center">تعديل</th>
          <th class="text-center">حذف</th>
        </thead>
        <tbody>
        <?php while($news = mysqli_fetch_assoc($news_set)) { ?>
          <tr>
              <td><?php echo htmlspecialchars($news['title']); ?></td>
              <td><?php echo htmlspecialchars($news['publish_date']); ?></td>
            <td class="text-center editRow"><a href="edit_news.php?id=<?php echo htmlspecialchars(urlencode($news['news_id'])); ?> "><i class="fas fa-edit"></i></a></td>
            <td class="text-center removeRow"><a href="delete_news.php?id=<?php echo htmlspecialchars(urlencode($news['news_id'])); ?> "><i class="fas fa-trash-alt"></i></a></td>
          </tr>
        <?php }
        mysqli_free_result($news_set);?>
        </tbody>
      </table>
    </div>

    <div class="reveal" data-animation-out="fade-out" id="addAdmin" data-reveal>
      <h3 class="">
        <span>إضافة خبر</span>
      </h3>
      <form class="addForm" action="<?php $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
        <label for="addName">عنوان الخبر:</label>
        <input type="text" id="addName" name="title" value="" placeholder="عنوان الخبر">
        <label for="content">محتوى الخبر:</label>
        <textarea id="content" name="details" rows="10" cols="20" placeholder="تفاصيل الخبر"></textarea>
        <input type="file" name="files" id="file" class="inputfile" />
        <label for="file">أضف صورة الخبر</label>

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
