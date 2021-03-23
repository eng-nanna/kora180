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

            <!-- news section -->
            <section class="home-news bg-white">

              <div class="panel-title">
                <h2>الأخبار</h2>
                <a href="news.php" class="panel__more">
                  <i class="fas fa-plus"></i>
                </a>
              </div>
                <?php
                $news_set = find_all_news(['limit' =>2] );
                while($news = mysqli_fetch_assoc($news_set)) {
                    ?>

                    <article class="news">
                        <div class="row no-gutters">
                            <div class="col-md-6">
                                <!--<a href="single-news.php?id=<?php /*echo htmlspecialchars(urlencode($news['news_id'])); */?>"
                                   style="background-image: url(adminpanel/img/news/<?php /*echo htmlspecialchars(urlencode($news['img'])); */?>); background-size: contain"
                                   class="news__image"></a>-->
                                <a href="single-news.php?id=<?php echo htmlspecialchars(urlencode($news['news_id'])); ?>">
                                    <img class="card-img-top" src="adminpanel/img/news/<?php echo htmlspecialchars(urlencode($news['img'])); ?>" height="250px"
                                         alt="placeholder">
                                </a>
                            </div> <!-- news image -->
                            <div class="col-md-6 px-3">
                                <time class="news__date">
                                    <i class="far fa-calendar-alt"></i>
                                    <?php echo htmlspecialchars($news['publish_date']); ?>
                                </time>
                                <h3 class="news__title">
                                    <a href="#">
                                        <?php echo htmlspecialchars($news['title']); ?>
                                    </a>
                                </h3>
                                <p>
                                    <?php
                                    echo substr(htmlspecialchars($news['details']),0,120).".....";
                                    ?>
                                </p>
                                <a href="single-news.php?id=<?php echo htmlspecialchars(urlencode($news['news_id'])); ?>" class="btn btn-outline-dark">التفاصيل</a>
                            </div> <!-- .col-6 -->
                        </div> <!-- .row -->
                    </article> <!-- news -->
                    <?php
                }
                    ?>
              <!-- news -->

            </section>
            <!-- End News -->

            <!-- Start Videos Section -->
            <section class="home-videos bg-white">

              <div class="panel-title">
                <h2>فيديو</h2>
                <a href="video.php" class="panel__more">
                  <i class="fas fa-plus"></i>
                </a>
              </div>

              <div class="row">
                <?php
                $video_set = find_all_videos(['limit' =>2] );
                while($video = mysqli_fetch_assoc($video_set)) {
                    ?>
                    <div class="col-md-6">
                        <a href="single-video.php?id=<?php echo htmlspecialchars(urlencode($video['video_id'])); ?>">
                            <div class="card border-0">
                                <div class="position-relative">
                                    <img class="card-img-top" src="adminpanel/video/thumbnail/if_play-circle.png" height="170px"
                                         alt="placeholder">
                                </div>
                                <div class="card-body">
                                    <h4 class="card-title news__title"><?php echo htmlspecialchars($video['video_title']); ?></h4>
                                    <p class="card-text">
                                        <time class="news__date"><?php
                                            echo htmlspecialchars($video['video_date']); ?></time>
                                    </p>
                                </div>
                            </div> <!-- card-video -->
                        </a>
                    </div> <!-- col-md-6 -->
                    <?php
                }
                    ?>

              </div> <!-- row -->
            </section>

          </div>
          <!-- col-8 -->

            <?php
            include ('includes/matches_tabs.php');
            ?>
        </div> <!-- .row -->

      </div>
      <!-- container -->
    </main>

<?php
include ("includes/public_footer.php");