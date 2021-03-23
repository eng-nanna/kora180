<?php
require_once('includes/initialize.php');
include ("includes/public_header.php");


$id = $_GET['id'] ?? 1;
$news = find_news_by_id($id);
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
                      <?php echo htmlspecialchars($news['title']); ?>
                  </h2>
                  <time class="text-muted small">
                      <?php echo htmlspecialchars($news['publish_date']); ?>
                  </time>
                </header>

                <div class="text-center mb-3">
                  <img class="responsive" src="adminpanel/img/news/<?php echo htmlspecialchars(urlencode($news['img'])); ?>" alt='placeholder image'>
                </div>
                <p><?php
                    echo htmlspecialchars($news['details']);
                    ?></p>
              </article>

              <div class="panel-title panel-title--small">
                <h2>مزيد من الاخبار</h2>
              </div>

              <div class="p-3">
                <div class="row">
<?php
$news_set = find_all_news(['limit' =>3] );
while($news = mysqli_fetch_assoc($news_set)) {
    ?>

    <div class="col-md-4">
        <div class="card border-0 news">
            <div class="position-relative">
                <a href="single-news.php?id=<?php echo htmlspecialchars(urlencode($news['news_id'])); ?>">
                    <img class="card-img-top" src="adminpanel/img/news/<?php echo htmlspecialchars(urlencode($news['img'])); ?>" height="250px" alt="placeholder">
                </a>
            </div>
            <div class="card-body">
                <h4 class="card-title news__title">
                    <a href="single-news.php?id=<?php echo htmlspecialchars(urlencode($news['news_id'])); ?>">
                        <?php echo htmlspecialchars($news['title']); ?>                   </a>
                </h4>
                <time class="news__date"><?php echo htmlspecialchars($news['publish_date']); ?></time>
                <p class="card-text"><?php
                    echo substr(htmlspecialchars($news['details']),0,120).".....";
                    ?></p>
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

          <!-- SIDEBAR -->
            <?php
            include ('includes/matches_tabs.php');
            ?>
        </div> <!-- .row -->

      </div>
      <!-- container -->
    </main>

<?php
include ("includes/public_footer.php");