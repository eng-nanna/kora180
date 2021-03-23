<?php
require_once('includes/initialize.php');
include ("includes/public_header.php");
?>

    <!-- Button trigger modal -->
    <main class="mt-5">
      <div class="container">

        <div class="row">
          <!-- MAIN AREA -->
          <div class="col-md-8">

            <section class="bg-white min-height">

              <div class="panel-title">
                <h2>جدول الدوري</h2>
              </div>

              <div class="league-select">
                <select name="leagues" class="custom-select leagues-select" id="leagues-select" onchange="fetch_select(this.value);">
                  <option value="" selected disabled>اختر جدول الدوري</option>
                    <?php
                    $league_set = find_all_leagues();
                    while($league = mysqli_fetch_assoc($league_set)){
                        $matches_set = find_all_matches(['league_id'=> $result, 'limit'=>8]);
                        ?>
                        <option value="<?php echo htmlspecialchars($league['league_id']);?>"><?php echo htmlspecialchars($league['league_name'])." - ". htmlspecialchars($league['league_year']);?></option>
                        <?php
                    }
                    ?>
                </select>
              </div>

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
            </section>

          </div> <!-- col-8 -->

            <?php
            include ('includes/matches_tabs.php');
            ?>
        </div> <!-- .row -->

      </div>
        <!-- container -->
    </main>

<?php
include ("includes/public_footer.php");
?>

<script>
    function fetch_select(val)
    {
        $.ajax({
            type: 'post',
            url: 'league_select.php',
            data: {
        selected:val
            },
            success: function (response) {
        document.getElementById("DisplayDiv").innerHTML=response;
    }
        });
    }
</script>