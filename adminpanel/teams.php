<?php
require_once('../includes/initialize.php');
require_login();

$page_title = "إضافة فريق";
$team_set = find_all_teams();
include ('../includes/admin_header.php');

$valid_formats = array("jpg", "png", "gif", "bmp");
$min_file_dim = 50;
$max_file_dim = 250;
$path = "img/teams/"; // Upload directory


if (is_post_request()){
    $team = [];
    $team['team_name'] = $_POST['team_name'] ?? '';

    if (empty($_FILES['files']['name'])){
        $team['team_logo'] = "logo.jpg";
        $result = insert_team($team);
        if($result === true){
            $new_id = mysqli_insert_id($db);
            header("location: teams.php");
            exit();
        }else{
            $errors = $result;
        }
    }else{
        $team['team_logo'] = $_FILES['files']['name'];
        if ($_FILES['files']['error'] == 0) {
            list($width,$height) = getimagesize($_FILES["files"]["tmp_name"]);
            if ($height < $min_file_dim || $width < $min_file_dim) {
                $message = "يجب أن لا يقل حجم الصورة عن 50 بيكسل";
                echo "<script type='text/javascript'>alert('$message');</script>";
            }elseif ($height > $max_file_dim || $width > $max_file_dim) {
                $message = "يجب أن لا يزيد حجم الصورة عن 250 بيكسل";
                echo "<script type='text/javascript'>alert('$message');</script>";
            }
            elseif( ! in_array(pathinfo($team['team_logo'], PATHINFO_EXTENSION), $valid_formats) ){
                $message = "امتداد الصورة غير مناسب";
                echo "<script type='text/javascript'>alert('$message');</script>";
            }
            else{ // No error found! Move uploaded files
                if(move_uploaded_file($_FILES["files"]["tmp_name"], $path.$team['team_logo'])) {
                    $result = insert_team($team);
                    if($result === true){
                        $new_id = mysqli_insert_id($db);
                        header("location: teams.php");
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
    $team = [];
    $team['team_name'] = '';
}
?>


    <h1 class="pageTitle">
      <span>الفرق</span>
      <a data-open="addAdmin" class="button">إضافة فريق</a>
    </h1>

<?php
echo display_errors($errors);
?>

    <div class="padding-1em">
      <table width="100%">
        <thead>
          <th>اسم الفريق</th>
          <th class="text-center">تعديل</th>
          <th class="text-center">حذف</th>
        </thead>
        <tbody>
        <?php while($team = mysqli_fetch_assoc($team_set)) { ?>
          <tr>
              <td><?php echo htmlspecialchars($team['team_name']); ?></td>
            <td class="text-center editRow"><a href="edit_team.php?id=<?php echo htmlspecialchars(urlencode($team['team_id'])); ?> "><i class="fas fa-edit"></i></a></td>
            <td class="text-center removeRow"><a href="delete_team.php?id=<?php echo htmlspecialchars(urlencode($team['team_id'])); ?> "><i class="fas fa-trash-alt"></i></a></td>
          </tr>
        <?php }
        mysqli_free_result($team_set);?>
        </tbody>
      </table>
    </div>

    <div class="reveal" data-animation-out="fade-out" id="addAdmin" data-reveal>
      <h3 class="">
        <span>إضافة فريق</span>
      </h3>
      <form class="addForm" action="<?php $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
        <label for="addName">اسم الفريق:</label>
        <input type="text" id="addName" name="team_name" value="" placeholder="اسم الفريق">

          <input type="file" name="files" id="file" class="inputfile" />
          <label for="file">أضف لوجو الفريق</label>

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
