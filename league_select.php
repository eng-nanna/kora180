<?php
/**
 * Created by PhpStorm.
 * User: eng-nanna
 * Date: 4/5/2018
 * Time: 11:40 AM
 */
require_once('includes/initialize.php');

$result = $_POST['selected'];
if ($result == ""){
    $matches_set = find_all_matches();
}else{
    $matches_set = find_all_matches(['league_id'=> $result]);
}
?>
<div class="p-3" id="DisplayDiv">
    <div class="row leagues-page">
        <?php while($match = mysqli_fetch_assoc($matches_set)) {
            $team1_set = find_all_teams(['team_id' => $match['team1']]);
            $team1 = mysqli_fetch_assoc($team1_set);
            $team2_set = find_all_teams(['team_id' => $match['team2']]);
            $team2 = mysqli_fetch_assoc($team2_set);
            ?>
            <div class="col-md-6">
                <article class="match-vs">
                    <div class="row no-gutters">
                        <div class="col-5">
                            <div class="media">
                                <div class="media-body">
                                    <div class="mt-0"> <?php echo htmlspecialchars($team1['team_name']); ?></div>
                                </div>
                                <img width="25"
                                     src="adminpanel/img/teams/<?php echo htmlspecialchars($team1['team_logo']); ?>"
                                     alt="Generic placeholder image">
                            </div>
                        </div>
                        <div class="col-2">
                            <span>:</span>
                        </div>
                        <div class="col-5">
                            <div class="media">
                                <div class="media-body">
                                    <div class="mt-0"><?php echo htmlspecialchars($team2['team_name']); ?></div>
                                </div>
                                <img width="25"
                                     src="adminpanel/img/teams/<?php echo htmlspecialchars($team2['team_logo']); ?>"
                                     alt="Generic placeholder image">
                            </div>
                        </div>
                        <div class="col-12 text-center match-live active">
                            <a href="#" target="_blank" class="btn btn-outline-success btn-sm mt-2 text-success">
                                <?php
                                echo htmlspecialchars($match['match_date']); ?>
                            </a>
                        </div>
                    </div>
                </article>
            </div>
            <?php
        }
        ?>

    </div> <!-- row -->
</div> <!-- p-3 -->
