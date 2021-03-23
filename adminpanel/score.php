<?php
require_once('../includes/initialize.php');
require_login();

if(!isset($_GET['id'])){
    header("location: index.php");
    exit();
}
$id = $_GET['id'];
$id= db_escape($db,$id);

if (is_post_request()){
    $score = [];
    $score['match_id'] = $id ?? '';
    $score['team1'] = $_POST['team1'] ?? '';
    $score['team2'] = $_POST['team2'] ?? '';

    $result = insert_score($score);
    if($result === true){
        header("location: matches.php");
        exit();
    }else{
        $errors = $result;
    }
}else{
    $sql = "SELECT * FROM matches WHERE match_id = '$id' ";
    $result = mysqli_query($db,$sql);
    confirm_result_set($result);
    $match = mysqli_fetch_assoc($result);
    $team1_set = find_all_teams(['team_id'=> $match['team1']]);
    $team1 = mysqli_fetch_assoc($team1_set);
    $team2_set = find_all_teams(['team_id'=> $match['team2']]);
    $team2 = mysqli_fetch_assoc($team2_set);
    mysqli_free_result($result);
}

$page_title = "إضافة نتيجة المباراة";
include ('../includes/admin_header.php');


?>


    <h1 class="pageTitle">
      <span>إضافة نتيجة المباراة</span>
    </h1>

<?php
echo display_errors($errors);
?>

    <div class="padding-1em">

        <a class="back-link" href="matches.php">&laquo; عودة للصفحة الرئيسية</a>

        <form class="addForm" action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
            <label for="addName"><?php echo "نتيجة ". $team1['team_name'] ?></label>
            <input type="text" id="addName" name="team1" value="" >
            <label for="addName"><?php echo "نتيجة ". $team2['team_name'] ?></label>
            <input type="text" id="addName" name="team2" value="" >
            <input class="button expanded" type="submit" name="submit" value="إضافة النتيجة">
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
