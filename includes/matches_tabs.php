<!-- SIDEBAR -->
<div class="col-md-4">
    <aside>
        <div class="panel-title">
            <h2>مباريات</h2>
        </div>

        <!-- Match TABS -->
        <section class="matches-panel bg-white">
            <div class="nav nav-pills nav-justified" id="matches" role="tablist" aria-orientation="vertical">
                <a class="nav-item nav-link active" id="yesterday-tab" data-toggle="pill" href="#yesterday" role="tab" aria-controls="v-pills-home"
                   aria-selected="true">
                    امس
                </a>
                <a class="nav-item nav-link" id="today-tab" data-toggle="pill" href="#today" role="tab" aria-controls="today" aria-selected="false">
                    اليوم
                </a>
                <a class="nav-item nav-link" id="tomorrow-tab" data-toggle="pill" href="#tomorrow" role="tab" aria-controls="tomorrow" aria-selected="false">
                    غدا
                </a>
            </div>

            <div class="tab-content" id="matchesContent">
                <div class="tab-pane fade show active" id="yesterday" role="tabpanel" aria-labelledby="yesterday-tab">
                    <section class="league">
                        <?php
                        $current = date("Y");
                        $leagues_set = find_all_leagues(['year'=>$current]);
                        while($league = mysqli_fetch_assoc($leagues_set)) {
                            $yesterday = date('Y-m-d',strtotime("-1 days"));
                            $matches_set = find_all_matches(['league_id'=> $league['league_id'],'time'=>$yesterday]);
                            $count = mysqli_num_rows($matches_set);
                            if ($count>0) {
                                ?>

                                <header>
                                    <h3 class="m-0"><?php echo htmlspecialchars($league['league_name']); ?></h3>
                                    <span><?php echo $count; ?> مباريات</span>
                                </header>

                                <div class="match-container">
                                    <?php
                                    while($match = mysqli_fetch_assoc($matches_set)) {
                                        $team1_set = find_all_teams(['team_id'=> $match['team1']]);
                                        $team1 = mysqli_fetch_assoc($team1_set);
                                        $team2_set = find_all_teams(['team_id'=> $match['team2']]);
                                        $team2 = mysqli_fetch_assoc($team2_set);
                                        ?>
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
                                                    <?php
                                                    $score_set = find_all_score(['match_id' => $match['match_id']]);
                                                    $score = mysqli_fetch_assoc($score_set);
                                                    ?>
                                                    <span><?php echo htmlspecialchars($score['team1']); ?></span>
                                                    <span>:</span>
                                                    <span><?php echo htmlspecialchars($score['team1']); ?></span>
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
                                                <div class="col-12 text-center active">
                                    <span class="btn btn-outline-danger btn-sm mt-2 text-danger"> <?php
                                        echo "توقيت المباراة ". htmlspecialchars($match['match_time']); ?> </span>
                                                </div>
                                            </div>
                                        </article>
                                        <?php
                                    }
                                    ?>

                                </div>
                                <!-- match-container -->
                                <?php
                            }
                        }
                        ?>
                    </section>
                    <!-- league -->
                </div>

                <div class="tab-pane fade" id="today" role="tabpanel" aria-labelledby="today-tab">
                    <section class="league">
                        <?php
                        $current = date("Y");
                        $leagues_set = find_all_leagues(['year'=>$current]);
                        while($league = mysqli_fetch_assoc($leagues_set)) {
                            $today = date('Y-m-d');
                            $matches_set = find_all_matches(['league_id' => $league['league_id'], 'time' => $today]);
                            $count = mysqli_num_rows($matches_set);
                            if ($count > 0) {
                                ?>

                                <header>
                                    <h3 class="m-0"><?php echo htmlspecialchars($league['league_name']); ?></h3>
                                    <span><?php echo $count; ?> مباريات</span>
                                </header>

                                <div class="match-container">
                                    <?php
                                    while($match = mysqli_fetch_assoc($matches_set)) {
                                        $team1_set = find_all_teams(['team_id' => $match['team1']]);
                                        $team1 = mysqli_fetch_assoc($team1_set);
                                        $team2_set = find_all_teams(['team_id' => $match['team2']]);
                                        $team2 = mysqli_fetch_assoc($team2_set);
                                        ?>
                                        <article class="match-vs">
                                            <div class="row no-gutters">
                                                <div class="col-5">
                                                    <a href="#">
                                                        <div class="media">
                                                            <div class="media-body">
                                                                <div class="mt-0"> <?php echo htmlspecialchars($team1['team_name']); ?></div>
                                                            </div>
                                                            <img width="25"
                                                                 src="adminpanel/img/teams/<?php echo htmlspecialchars($team1['team_logo']); ?>"
                                                                 alt="Generic placeholder image">
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="col-2">
                                                    <?php
                                                    $score_set = find_all_score(['match_id' => $match['match_id']]);
                                                    $score = mysqli_fetch_assoc($score_set);
                                                    $row_count = mysqli_num_rows($score_set);
                                                    if ($row_count != 0) {
                                                        ?>
                                                        <span><?php echo htmlspecialchars($score['team1']); ?></span>
                                                        <span>:</span>
                                                        <span><?php echo htmlspecialchars($score['team1']); ?></span>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                                <div class="col-5">
                                                    <a href="#">
                                                        <div class="media">
                                                            <div class="media-body">
                                                                <div class="mt-0"><?php echo htmlspecialchars($team2['team_name']); ?></div>
                                                            </div>
                                                            <img width="25"
                                                                 src="adminpanel/img/teams/<?php echo htmlspecialchars($team2['team_logo']); ?>"
                                                                 alt="Generic placeholder image">
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="col-12 text-center match-live active">
                                                    <?php
                                                    $combined = strtotime($match['match_time']);
                                                    $end_date = date("H:i:s", strtotime('+120 minutes', $combined));
                                                    $current_date = date('H:i:s');
                                                    if ($current_date < $match['match_time']) {
                                                        ?>
                                                        <span class="btn btn-outline-danger btn-sm mt-2 text-danger"> <?php
                                                            echo "توقيت المباراة " . htmlspecialchars($match['match_time']); ?> </span>
                                                        <?php
                                                    }elseif(($current_date >= $match['match_time']) && ($current_date <= $end_date)) {
                                                        ?>

                                                        <a href="<?php echo htmlspecialchars($match['match_url']);?>" target="_blank" class="btn btn-outline-danger btn-sm mt-2 text-danger">
                  <span>
                    <i class="fas fa-tv"></i>
                  </span>
                                                                                                                  مباشر - شاهد الآن
                                                        </a>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </article>
                                        <?php
                                    }
                                    ?>

                                </div>
                                <!-- match-container -->
                                <?php
                            }
                        }
                        ?>

                    </section>
                    <!-- league -->
                </div>

                <div class="tab-pane fade" id="tomorrow" role="tabpanel" aria-labelledby="tomorrow-tab">
                    <section class="league">
                        <?php
                        $current = date("Y");
                        $leagues_set = find_all_leagues(['year'=>$current]);
                        while($league = mysqli_fetch_assoc($leagues_set)) {
                            $tomorrow = date('Y-m-d',strtotime("+1 days"));
                            $matches_set = find_all_matches(['league_id'=> $league['league_id'],'time'=>$tomorrow]);
                            $count = mysqli_num_rows($matches_set);
                            if ($count>0) {
                                ?>

                                <header>
                                    <h3 class="m-0"><?php echo htmlspecialchars($league['league_name']); ?></h3>
                                    <span><?php echo $count; ?> مباريات</span>
                                </header>

                                <div class="match-container">
                                    <?php
                                    while($match = mysqli_fetch_assoc($matches_set)) {
                                        $team1_set = find_all_teams(['team_id'=> $match['team1']]);
                                        $team1 = mysqli_fetch_assoc($team1_set);
                                        $team2_set = find_all_teams(['team_id'=> $match['team2']]);
                                        $team2 = mysqli_fetch_assoc($team2_set);
                                        ?>
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
                                                    <?php
                                                    $score_set = find_all_score(['match_id' => $match['match_id']]);
                                                    $score = mysqli_fetch_assoc($score_set);
                                                    ?>
                                                    <span><?php echo htmlspecialchars($score['team1']); ?></span>
                                                    <span>:</span>
                                                    <span><?php echo htmlspecialchars($score['team1']); ?></span>
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
                                                <div class="col-12 text-center active">
                                    <span class="btn btn-outline-danger btn-sm mt-2 text-danger"> <?php
                                        echo "توقيت المباراة ". htmlspecialchars($match['match_time']); ?> </span>
                                                </div>
                                            </div>
                                        </article>
                                        <?php
                                    }
                                    ?>

                                </div>
                                <!-- match-container -->
                                <?php
                            }
                        }
                        ?>
                    </section>
                    <!-- matches-panel -->

    </aside>
</div> <!-- col-4 -->