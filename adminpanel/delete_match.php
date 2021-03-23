<?php
require_once('../includes/initialize.php');
require_login();

if(!isset($_GET['id'])){
    header("location: index.php");
    exit();
}
$id = $_GET['id'];
$id= db_escape($db,$id);

if(is_post_request()) {
    $result = delete_match($id);
    header("location: matches.php");
    exit();
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

$page_title = "حذف أدمن";
include ('../includes/admin_header.php');


?>


    <h1 class="pageTitle">
      <span>حذف المباراة</span>
    </h1>

<?php
echo display_errors($errors);
?>

    <div class="padding-1em">

        <a class="back-link" href="matches.php">&laquo; عودة للصفحة الرئيسية</a>

        <p>متأكد من ضرورة حذف هذه المباراة ؟</p>
        <p class="item"><?php echo htmlspecialchars($team1['team_name']) ." VS ".htmlspecialchars($team2['team_name']); ?></p>


        <form class="addForm" action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
            <input class="button expanded" type="submit" name="submit" value="حذف">
        </form>
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
