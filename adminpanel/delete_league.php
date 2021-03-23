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
    $sql = "SELECT * FROM leagues WHERE league_id = '$id' ";
    $result = mysqli_query($db,$sql);
    confirm_result_set($result);
    $league = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    unlink('img/leagues/'.DIRECTORY_SEPARATOR.$league['league_logo']); //delete it

    $results = delete_league($id);
    header("location: leagues.php");
    exit();
}else{
    $sql = "SELECT * FROM leagues WHERE league_id = '$id' ";
    $result = mysqli_query($db,$sql);
    confirm_result_set($result);
    $league = mysqli_fetch_assoc($result);
    mysqli_free_result($result);


}

$page_title = "حذف دوري";
include ('../includes/admin_header.php');


?>


    <h1 class="pageTitle">
      <span>حذف دوري</span>
    </h1>

<?php
echo display_errors($errors);
?>

    <div class="padding-1em">

        <a class="back-link" href="leagues.php">&laquo; عودة للصفحة الرئيسية</a>

        <p>متأكد من ضرورة حذف هذا الدوري ؟</p>
        <p class="item"><?php echo htmlspecialchars($league['league_name']); ?></p>


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
