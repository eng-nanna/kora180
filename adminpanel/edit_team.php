<?php
require_once('../includes/initialize.php');
require_login();

if(!isset($_GET['id'])){
    header("location: index.php");
    exit();
}
$id = $_GET['id'];
$id= db_escape($db,$id);

$valid_formats = array("jpg", "png", "gif", "bmp");
$min_file_dim = 50;
$max_file_dim = 250;
$path = "img/teams/"; // Upload directory

if (is_post_request()){
    $team = [];
    $team['id'] = $id ?? '';
    $team['team_name'] = $_POST['team_name'] ?? '';

    if (empty($_FILES['files']['name'])){
        $sql = "SELECT * FROM teams WHERE team_id = '$id' ";
        $result = mysqli_query($db,$sql);
        confirm_result_set($result);
        $teams_set = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        $team['team_logo'] = $teams_set['team_logo'];
        $result = update_team($team);
        if($result === true){
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
                    $result = update_team($team);
                    if($result === true){
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
}else{
    $sql = "SELECT * FROM teams WHERE team_id = '$id' ";
    $result = mysqli_query($db,$sql);
    confirm_result_set($result);
    $team = mysqli_fetch_assoc($result);
    mysqli_free_result($result);


}

$page_title = "تعديل الفريق";
include ('../includes/admin_header.php');


?>


    <h1 class="pageTitle">
      <span>تعديل الفريق</span>
    </h1>

<?php
echo display_errors($errors);
?>

    <div class="padding-1em">

        <a class="back-link" href="teams.php">&laquo; عودة للصفحة الرئيسية</a>

        <form class="addForm" action="<?php $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
            <label for="addName">اسم الفريق:</label>
            <input type="text" id="addName" name="team_name" value="<?php echo $team['team_name']; ?>" >

            <input type="file" name="files" id="file" class="inputfile" />
            <label for="file">تغيير لوجو الفريق</label>

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
