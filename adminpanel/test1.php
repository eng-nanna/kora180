<?php
/**
 * Created by PhpStorm.
 * User: eng-nanna
 * Date: 3/18/2018
 * Time: 8:10 PM
 */
require_once('../includes/initialize.php');
require_login();

$result = $_POST['selected'];
if ($result == "all"){
    $matches_set = find_all_matches();
}else{
    $matches_set = find_all_matches(['league_id'=> $result]);
}
?>

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
            <td class="text-center editRow"><a href="score.php?id=<?php echo htmlspecialchars(urlencode($match['match_id'])); ?> "><i class="fab fa-periscope"></i></a></td>
            <td class="text-center editRow"><a href="edit_match.php?id=<?php echo htmlspecialchars(urlencode($match['match_id'])); ?> "><i class="fas fa-edit"></i></a></td>
            <td class="text-center removeRow"><a href="delete_match.php?id=<?php echo htmlspecialchars(urlencode($match['match_id'])); ?> "><i class="fas fa-trash-alt"></i></a></td>
        </tr>
    <?php }
    mysqli_free_result($matches_set);?>
    </tbody>
</table>
</div>