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
$path = "img/leagues/"; // Upload directory

if (is_post_request()){
    $league = [];
    $league['id'] = $id ?? '';
    $league['league_name'] = $_POST['league_name'] ?? '';
    $league['league_year'] = $_POST['league_year'] ?? '';

    if (empty($_FILES['files']['name'])){
        $sql = "SELECT * FROM leagues WHERE league_id = '$id' ";
        $result = mysqli_query($db,$sql);
        confirm_result_set($result);
        $leagues_set = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        $league['league_logo'] = $leagues_set['league_logo'];
        $result = update_league($league);
        if($result === true){
            header("location: leagues.php");
            exit();
        }else{
            $errors = $result;
        }
    }else{
        $league['league_logo'] = $_FILES['files']['name'];
        if ($_FILES['files']['error'] == 0) {
            list($width,$height) = getimagesize($_FILES["files"]["tmp_name"]);
            if ($height < $min_file_dim || $width < $min_file_dim) {
                $message = "يجب أن لا قل حجم الصورة عن 50 بيكسل";
                echo "<script type='text/javascript'>alert('$message');</script>";
            }elseif ($height > $max_file_dim || $width > $max_file_dim) {
                $message = "يجب أن لا يزيد حجم الصورة عن 250 بيكسل";
                echo "<script type='text/javascript'>alert('$message');</script>";
            }
            elseif( ! in_array(pathinfo($league['league_logo'], PATHINFO_EXTENSION), $valid_formats) ){
                $message = "امتداد الصورة غير مناسب";
                echo "<script type='text/javascript'>alert('$message');</script>";
            }
            else{ // No error found! Move uploaded files
                if(move_uploaded_file($_FILES["files"]["tmp_name"], $path.$league['league_logo'])) {
                    $result = update_league($league);
                    if($result === true){
                        header("location: leagues.php");
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
    $sql = "SELECT * FROM leagues WHERE league_id = '$id' ";
    $result = mysqli_query($db,$sql);
    confirm_result_set($result);
    $league = mysqli_fetch_assoc($result);
    mysqli_free_result($result);


}

$page_title = "تعديل الدوري";
include ('../includes/admin_header.php');


?>


    <h1 class="pageTitle">
      <span>تعديل الدوري</span>
    </h1>

<?php
echo display_errors($errors);
?>

    <div class="padding-1em">

        <a class="back-link" href="leagues.php">&laquo; عودة للصفحة الرئيسية</a>

        <form class="addForm" action="<?php $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
            <label for="addName">اسم الدوري:</label>
            <input type="text" id="addName" name="league_name" value="<?php echo $league['league_name']; ?>" >
            <label for="password">سنة الدوري:</label>
            <?php
            $current_year = date('Y');
            $earliest_year = 1900;
            $selected_year = $league['league_year'];
            print '<select name="league_year">';
            foreach (range($current_year, $earliest_year) as $x) {
                print '<option value="'.$x.'"'.($x == $selected_year ? ' selected="selected"' : '').'>'.$x.'</option>';
            }
            ?>
            </select>
            <input type="file" name="files" id="file" class="inputfile" />
            <label for="file">أضف لوجو الدوري</label>
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
