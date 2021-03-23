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
    $sql = "SELECT * FROM teams WHERE team_id = '$id' ";
    $result = mysqli_query($db,$sql);
    confirm_result_set($result);
    $team = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    unlink('img/teams/'.DIRECTORY_SEPARATOR.$team['team_logo']); //delete it

    $results = delete_team($id);
    header("location: teams.php");
    exit();
}else{
    $sql = "SELECT * FROM teams WHERE team_id = '$id' ";
    $result = mysqli_query($db,$sql);
    confirm_result_set($result);
    $team = mysqli_fetch_assoc($result);
    mysqli_free_result($result);


}

$page_title = "حذف فريق";
include ('../includes/admin_header.php');


?>


    <h1 class="pageTitle">
      <span>حذف فريق</span>
    </h1>

<?php
echo display_errors($errors);
?>

    <div class="padding-1em">

        <a class="back-link" href="teams.php">&laquo; عودة للصفحة الرئيسية</a>

        <p>متأكد من ضرورة حذف هذا الفريق ؟</p>
        <p class="item"><?php echo htmlspecialchars($team['team_name']); ?></p>


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
