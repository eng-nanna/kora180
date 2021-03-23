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
    $match = [];
    $match['id'] = $id ?? '';
    $match['league_id'] = $_POST['league_id'] ?? '';
    $match['team1'] = $_POST['team1'] ?? '';
    $match['team2'] = $_POST['team2'] ?? '';
    $match['match_date'] = $_POST['match_date'] ?? '';
    $match['match_time'] = $_POST['match_time'] ?? '';
    $match['match_url'] = $_POST['match_url'] ?? '';

    $result = update_match($match);
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

$page_title = "تعديل المباراة";
include ('../includes/admin_header.php');


?>


    <h1 class="pageTitle">
      <span>تعديل المباراة</span>
    </h1>

<?php
echo display_errors($errors);
?>

    <div class="padding-1em">

        <a class="back-link" href="matches.php">&laquo; عودة للصفحة الرئيسية</a>

        <form class="addForm" action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
            <label for="league_id">الدوري:</label>
            <select name="league_id">
                <?php
                $league_set = find_all_leagues();
                while($league = mysqli_fetch_assoc($league_set)){
                    print '<option value="'.htmlspecialchars($league['league_id']).'"'.(htmlspecialchars($league['league_id']) === $match['league_id'] ? ' selected="selected"' : '').'>'.htmlspecialchars($league['league_name']).'</option>';
                }
                ?>
            </select>
            <label for="team1">الفريق الأول:</label>
            <select name="team1">
                <?php
                $team_set = find_all_teams();
                while($team1 = mysqli_fetch_assoc($team_set)){
                    print '<option value="'.htmlspecialchars($team1['team_id']).'"'.(htmlspecialchars($team1['team_id']) === $match['team1'] ? ' selected="selected"' : '').'>'.htmlspecialchars($team1['team_name']).'</option>';
                }
                ?>
            </select>
            <label for="team2">الفريق الثاني:</label>
            <select name="team2">
                <?php
                $team_set = find_all_teams();
                while($team2 = mysqli_fetch_assoc($team_set)){
                    print '<option value="'.htmlspecialchars($team2['team_id']).'"'.(htmlspecialchars($team2['team_id']) === $match['team2'] ? ' selected="selected"' : '').'>'.htmlspecialchars($team2['team_name']).'</option>';
                }
                ?>
            </select>
            <label for="match_date">تاريخ المباراة:</label>
            <input type="text" id="match_date" name="match_date" value="<?php echo $match['match_date']; ?>">
            <label for="match_time">توقيت المباراة:</label>
            <input type="text" id="match_time" name="match_time" value="<?php echo $match['match_time']; ?>">
            <label for="addName">رابط المشاهدة:</label>
            <input type="text" id="addName" name="match_url" value="<?php echo $match['match_url']; ?>" placeholder="رابط المشاهدة">

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


<script src="js/jquery.js"></script>
<script src="js/jquery.datetimepicker.full.js"></script>
<script>
    /*jslint browser:true*/
    /*global jQuery, document*/

    jQuery(document).ready(function () {
        'use strict';

        jQuery('#match_date').datetimepicker({
            lang:'ch',
            timepicker:false,
            format:'Y-m-d',
            formatDate:'Y-m-d'
        });

        jQuery('#match_time').datetimepicker({
            datepicker:false,
            format:'H:i',
            step:5
        });
    });
</script>
</body>
</html>
