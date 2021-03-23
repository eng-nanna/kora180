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

            <section class="bg-white">

              <div class="panel-title">
                <h2>فيديوهات</h2>
              </div>

              <div class="p-3">
                <div class="row">
                    <?php
                    $num_rec_per_page=9;
                    if (isset($_GET["page"])){
                        $page  = $_GET["page"];
                    }else{
                        $page=1;
                    }
                    $start_from = ($page-1) * $num_rec_per_page;
                    $video_set = find_all_videos(['start' =>$start_from,'step'=> $num_rec_per_page] );
                    while($video = mysqli_fetch_assoc($video_set)) {
                    ?>
                  <div class="col-md-4">
                    <div class="card border-0 news">
                      <div class="position-relative">
                        <a href="single-video.php?id=<?php echo htmlspecialchars(urlencode($video['video_id'])); ?>">
                          <img class="card-img-top" src="adminpanel/video/thumbnail/if_play-circle.png" height="150px" alt="placeholder">
                        </a>
                      </div>
                      <div class="card-body">
                        <h4 class="card-title news__title">
                          <a href="single-video.php?id=<?php echo htmlspecialchars(urlencode($video['video_id'])); ?>">
                              <?php echo htmlspecialchars($video['video_title']); ?>
                          </a>
                        </h4>
                        <time class="news__date"><?php
                            echo htmlspecialchars($video['video_date']);  ?></time>
                      </div>
                    </div> <!-- card-video -->
                  </div> <!-- col-md-4 -->
                        <?php
                    }
                    ?>


                  <div class="col-12">
                    <div class="pagination-container d-flex justify-content-center">
                      <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <?php
                            $video_set = find_all_videos(['start' =>$start_from,'step'=> $num_rec_per_page] );
                            $total_records = mysqli_num_rows($video_set);  //count number of records
                            $total_pages = ceil($total_records / $num_rec_per_page);
                            if ($total_pages>1) {
                                ?>
                                <li class="page-item">
                                    <a class="page-link"
                                       href="video.php?page=<?php echo htmlspecialchars(urlencode("1")); ?>"
                                       aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>
                                <?php
                                for ($i = 1; $i <= $total_pages; $i++) {
                                    ?>
                                    <li class="page-item">
                                        <a class="page-link"
                                           href="video.php?page=<?php echo htmlspecialchars(urlencode($i)); ?>"><?php echo $i; ?></a>
                                    </li>
                                    <?php
                                }
                                ?>
                                <li class="page-item">
                                    <a class="page-link"
                                       href="video.php?page=<?php echo htmlspecialchars(urlencode($total_pages)); ?>"
                                       aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </li>
                                <?php
                            }
                                ?>
                        </ul>
                      </nav>
                    </div>
                  </div>

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