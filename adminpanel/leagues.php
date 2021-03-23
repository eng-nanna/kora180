<?php
require_once('../includes/initialize.php');
require_login();

$page_title = "إضافة دوري";
$leagues_set = find_all_leagues();
include ('../includes/admin_header.php');

$valid_formats = array("jpg", "png", "gif", "bmp");
$min_file_dim = 50;
$max_file_dim = 250;
$path = "img/leagues/"; // Upload directory

if (is_post_request()){
    $league = [];
    $league['league_name'] = $_POST['league_name'] ?? '';
    $league['league_year'] = $_POST['league_year'] ?? '';

    if (empty($_FILES['files']['name'])){
        $league['league_logo'] = "league_logo.jpg";
        $result = insert_league($league);
        if($result === true){
            $new_id = mysqli_insert_id($db);
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
                    $result = insert_league($league);
                    if($result === true){
                        $new_id = mysqli_insert_id($db);
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
}else {
    $league = [];
    $league['league_name'] = '';
    $league['league_year'] = '';
}
?>


    <h1 class="pageTitle">
      <span>الدوريات</span>
      <a data-open="addAdmin" class="button">إضافة دوري</a>
    </h1>

<?php
echo display_errors($errors);
?>

    <div class="padding-1em">
      <table width="100%">
        <thead>
          <th>الدوري</th>
          <th>السنة</th>
          <th class="text-center">تعديل</th>
          <th class="text-center">حذف</th>
        </thead>
        <tbody>
        <?php while($league = mysqli_fetch_assoc($leagues_set)) { ?>
          <tr>
              <td><?php echo htmlspecialchars($league['league_name']); ?></td>
              <td><?php echo htmlspecialchars($league['league_year']); ?></td>
            <td class="text-center editRow"><a href="edit_league.php?id=<?php echo htmlspecialchars(urlencode($league['league_id'])); ?> "><i class="fas fa-edit"></i></a></td>
            <td class="text-center removeRow"><a href="delete_league.php?id=<?php echo htmlspecialchars(urlencode($league['league_id'])); ?> "><i class="fas fa-trash-alt"></i></a></td>
          </tr>
        <?php }
        mysqli_free_result($leagues_set);?>
        </tbody>
      </table>
    </div>

    <div class="reveal" data-animation-out="fade-out" id="addAdmin" data-reveal>
      <h3 class="">
        <span>إضافة دوري</span>
      </h3>
      <form class="addForm" action="<?php $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
        <label for="addName">اسم الدوري:</label>
        <input type="text" id="addName" name="league_name" value="" placeholder="اسم الدوري">

        <label for="password">سنة الدوري:</label>
            <?php
            $current_year = date('Y');
            $earliest_year = 1900;
            print '<select name="league_year">';
            foreach (range($current_year, $earliest_year) as $x) {
                print '<option value="'.$x.'"'.($x === $current_year ? ' selected="selected"' : '').'>'.$x.'</option>';
            }
            ?>
        </select>
          <input type="file" name="files" id="file" class="inputfile" />
          <label for="file">أضف لوجو الدوري</label>
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
