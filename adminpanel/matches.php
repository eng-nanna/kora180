<?php
require_once('../includes/initialize.php');
require_login();

$page_title = "إضافة مباراة";
$matches_set = find_all_matches($options=[]);
include ('../includes/admin_header.php');

if (isset($_POST['submit'])){
    $match = [];
    $match['league_id'] = $_POST ['league_id'] ??'';
    $match['team1'] = $_POST ['team1'] ??'';
    $match['team2'] = $_POST ['team2'] ??'';
    $match['match_date'] = $_POST ['match_date'] ??'';
    $match['match_time'] = $_POST ['match_time'] ??'';
    $match['match_url'] = $_POST ['match_url'] ??'';

    $result = insert_match($match);
    if($result === true){
        $new_id = mysqli_insert_id($db);
        header("location: matches.php");
        exit();
    }else{
        $errors = $result;
    }
}else {
    $match = [];
    $match['league_id'] = '';
    $match['team1'] = '';
    $match['team2'] = '';
    $match['match_date'] = '';
    $match['match_time'] = '';
    $match['match_url'] = '';
}
?>


    <h1 class="pageTitle">
      <span>المباريات</span>
      <a data-open="addAdmin" class="button">إضافة مباراة</a>
    </h1>

<?php
echo display_errors($errors);
?>


<div class="padding-1em">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div id="div1">
        اختر الدوري<select name="leagues" id="leagues" onchange="fetch_select(this.value);">
                <option value="all">جميع الدوريات</option>
                    <?php
                    $league_set = find_all_leagues();
                    while($league = mysqli_fetch_assoc($league_set)){
                        ?>
                        <option value="<?php echo htmlspecialchars($league['league_id']);?>"><?php echo htmlspecialchars($league['league_name'])." - ". htmlspecialchars($league['league_year']);?></option>
                        <?php
                    }
                    ?>
                </select>

        </select>
        </div>
    </form>

    <table width="100%" id="DisplayDiv">
        <thead>
          <th>الفرق</th>
          <th>توقيت المباراة</th>
          <th>تاريخ المباراة</th>
          <th>النتيجة</th>
          <th class="text-center">إضافة النتيجة</th>
          <th class="text-center">تعديل</th>
          <th class="text-center">حذف</th>
        </thead>
        <tbody>
        <?php while($match = mysqli_fetch_assoc($matches_set)) {
            $team1_set = find_all_teams(['team_id'=> $match['team1']]);
            $team1 = mysqli_fetch_assoc($team1_set);
            $team2_set = find_all_teams(['team_id'=> $match['team2']]);
            $team2 = mysqli_fetch_assoc($team2_set);
            ?>
          <tr>
              <td><?php echo htmlspecialchars($team1['team_name']) ." VS ".htmlspecialchars($team2['team_name']); ?></td>
              <td><?php echo htmlspecialchars($match['match_time']); ?></td>
              <td><?php echo htmlspecialchars($match['match_date']); ?></td>
              <?php
              $score_set = find_all_score(['match_id' => $match['match_id']]);
              $row_count = mysqli_num_rows($score_set);
              if ($row_count == 0) {
                  ?>
                  <td><?php echo "لا توجد نتيجة بعد"; ?></td>
                  <?php
              }else{
                  $score = mysqli_fetch_assoc($score_set);
                  ?>
                  <td><?php echo htmlspecialchars($score['team1']) ." VS ".htmlspecialchars($score['team2']); ?> </td>
              <?php
              }
              ?>
              <td class="text-center editRow"><a <?php
                  $combined = strtotime("$match[match_date] $match[match_time]");
                  $end_date = date("Y-m-d H:i:s", strtotime('+120 minutes', $combined));
                  $current_date = date('Y-m-d H:i:s');
                  if ($end_date > $current_date){
                      echo "class=\"isDisabled\" ";
                  }
            ?>
                           href="score.php?id=<?php echo htmlspecialchars(urlencode($match['match_id'])); ?> "><i class="fab fa-periscope"></i></a></td>
              <td class="text-center editRow"><a href="edit_match.php?id=<?php echo htmlspecialchars(urlencode($match['match_id'])); ?> "><i class="fas fa-edit"></i></a></td>
            <td class="text-center removeRow"><a href="delete_match.php?id=<?php echo htmlspecialchars(urlencode($match['match_id'])); ?> "><i class="fas fa-trash-alt"></i></a></td>
          </tr>
        <?php }
        mysqli_free_result($matches_set);?>
        </tbody>
      </table>
    </div>

    <div class="reveal" data-animation-out="fade-out" id="addAdmin" data-reveal>
      <h3 class="">
        <span>إضافة مباراة</span>
      </h3>
      <form class="addForm" action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
          <label for="league_id">الدوري:</label>
          <select name="league_id">
              <?php
              $league_set = find_all_leagues();
              while($league = mysqli_fetch_assoc($league_set)){
                  ?>
                  <option value="<?php echo htmlspecialchars($league['league_id']);?>"><?php echo htmlspecialchars($league['league_name'])." - ". htmlspecialchars($league['league_year']);?></option>
                  <?php
              }
              ?>
          </select>
          <label for="team1">الفريق الأول:</label>
          <select name="team1">
              <?php
              $team_set = find_all_teams();
              while($team1 = mysqli_fetch_assoc($team_set)){
                  ?>
                  <option value="<?php echo htmlspecialchars($team1['team_id']);?>"><?php echo htmlspecialchars($team1['team_name']);?></option>
                  <?php
              }
              ?>
          </select>
          <label for="team2">الفريق الثاني:</label>
          <select name="team2">
              <?php
              $team_set = find_all_teams();
              while($team2 = mysqli_fetch_assoc($team_set)){
                  ?>
                  <option value="<?php echo htmlspecialchars($team2['team_id']);?>"><?php echo htmlspecialchars($team2['team_name']);?></option>
                  <?php
              }
              ?>
          </select>
          <label for="match_date">تاريخ المباراة:</label>
          <input type="text" id="match_date" name="match_date" value="">
          <label for="match_time">توقيت المباراة:</label>
          <input type="text" id="match_time" name="match_time" value="">
        <label for="addName">رابط المشاهدة:</label>
        <input type="text" id="addName" name="match_url" value="" placeholder="رابط المشاهدة">

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

<script>
    function fetch_select(val)
    {
        $.ajax({
            type: 'post',
            url: 'test1.php',
            data: {
                selected:val
            },
            success: function (response) {
                document.getElementById("DisplayDiv").innerHTML=response;
            }
        });
    }
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
