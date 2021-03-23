<?php
require_once('../includes/initialize.php');
require_login();

$page_title = "إضافة مقالة";
$blogger_set = find_all_bloggers();
include ('../includes/admin_header.php');

$valid_formats = array("jpg", "png", "gif", "zip", "bmp");
$min_file_dim = 200;
$max_file_dim = 550;
$path = "img/bloggers/"; // Upload directory

if (is_post_request()){
    $bloggers = [];
    $bloggers['title'] = $_POST['title'] ?? '';
    $bloggers['publish_date'] = date('Y-m-d');
    $bloggers['content'] = $_POST['content'] ?? '';
    if (empty($_FILES['files']['name'])){
        $bloggers['img'] = "avatar.png";
        $result = insert_blogger($bloggers);
        if($result === true){
            $new_id = mysqli_insert_id($db);
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
                $message = "يجب أن لا يقل حجم الصورة عن 200 بيكسل";
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
                    $result = insert_blogger($bloggers);
                    if($result === true){
                        $new_id = mysqli_insert_id($db);
                        header("location: bloggers.php");
                        exit();
                    }else{
                        $errors = $result;
                    }
                }
                else {
                    // Failure
                    $message = "حاول مرة أخرى";
                    echo "<script type='text/javascript'>alert('$message');</script>";
                }
            }
        }
    }

}else {
    $bloggers = [];
    $bloggers['title'] = '';
    $bloggers['publish_date'] = '';
    $bloggers['img'] = '';
    $bloggers['content'] = '';
}
?>


    <h1 class="pageTitle">
      <span>آراء حرة</span>
      <a data-open="addAdmin" class="button">إضافة مقالة</a>
    </h1>

<?php
echo display_errors($errors);
?>

    <div class="padding-1em">
      <table width="100%">
        <thead>
          <th>عنوان المقالة</th>
          <th>تاريخ النشر</th>
          <th class="text-center">تعديل</th>
          <th class="text-center">حذف</th>
        </thead>
        <tbody>
        <?php while($bloggers = mysqli_fetch_assoc($blogger_set)) { ?>
          <tr>
              <td><?php echo htmlspecialchars($bloggers['title']); ?></td>
              <td><?php echo htmlspecialchars($bloggers['publish_date']); ?></td>
            <td class="text-center editRow"><a href="edit_blog.php?id=<?php echo htmlspecialchars(urlencode($bloggers['blogger_id'])); ?> "><i class="fas fa-edit"></i></a></td>
            <td class="text-center removeRow"><a href="delete_blog.php?id=<?php echo htmlspecialchars(urlencode($bloggers['blogger_id'])); ?> "><i class="fas fa-trash-alt"></i></a></td>
          </tr>
        <?php }
        mysqli_free_result($blogger_set);?>
        </tbody>
      </table>
    </div>

    <div class="reveal" data-animation-out="fade-out" id="addAdmin" data-reveal>
      <h3 class="">
        <span>إضافة مقالة</span>
      </h3>
      <form class="addForm" action="<?php $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
        <label for="addName">عنوان المقالة:</label>
        <input type="text" id="addName" name="title" value="" placeholder="عنوان المقالة">
        <label for="content">محتوى المقالة:</label>
        <textarea id="content" name="content" rows="10" cols="20" placeholder="المقالة"></textarea>
        <input type="file" name="files" id="file" class="inputfile" />
        <label for="file">أضف صورة المقالة</label>

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
