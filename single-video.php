<?php
require_once('includes/initialize.php');
include ("includes/public_header.php");

$id = $_GET['id'] ?? 1;
$video = find_video_by_id($id);
?>

    <!-- Button trigger modal -->
    <main class="mt-5">
      <div class="container">

        <div class="row">
          <!-- MAIN AREA -->
          <div class="col-md-8">

            <section class="bg-white p-3">

              <article>
                <header class="mb-3">
                  <h2 class="font-weight-bold mb-2 h4">
                      <?php echo htmlspecialchars($video['video_title']); ?>
                  </h2>
                  <time class="text-muted small">
                      <?php
                      echo htmlspecialchars($video['video_date']);  ?>
                  </time>
                </header>

                <div class="text-center mb-3">
                    <video width="660" height="335" controls>
                        <source type="video/mp4" src="adminpanel/video/<?php echo htmlspecialchars(urlencode($video['video']));  ?>">
                        Sorry, your browser doesn't support the video element.
                    </video>
                </div>
              </article>

              <div class="panel-title panel-title--small">
                <h2>فيديوهات</h2>
              </div>

              <div class="p-3">
                <div class="row">
                <?php
                $video_set = find_all_videos(['limit' =>3] );
                while($video = mysqli_fetch_assoc($video_set)) {
                    ?>
                    <div class="col-md-4">
                        <div class="card border-0 news">
                            <div class="position-relative">
                                <a href="single-video.php?id=<?php echo htmlspecialchars(urlencode($video['video_id'])); ?>">
                                    <img class="card-img-top" src="adminpanel/video/thumbnail/if_play-circle.png" height="150px"
                                         alt="placeholder">
                                </a>
                            </div>
                            <div class="card-body">
                                <h4 class="card-title news__title">
                                    <a href="single-video.php?id=<?php echo htmlspecialchars(urlencode($video['video_id'])); ?>">
                                        <?php echo htmlspecialchars($video['video_title']); ?>
                                    </a>
                                </h4>
                                <time class="news__date"><?php
                                    echo htmlspecialchars($video['video_date']); ?></time>
                            </div>
                        </div> <!-- card-video -->
                    </div> <!-- col-md-4 -->
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