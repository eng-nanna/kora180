<?php
require_once('includes/initialize.php');
include ("includes/public_header.php");


$id = $_GET['id'] ?? 1;
$blogger = find_blogger_by_id($id);
?>

<!-- Button trigger modal -->
    <div id="fb-root" xmlns="http://www.w3.org/1999/html"></div>
    <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.12';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>

    <main class="mt-5">
      <div class="container">

        <div class="row">
          <!-- MAIN AREA -->
          <div class="col-md-8">

            <section class="bg-white p-3">

              <p>
                <header class="mb-3">
                  <h2 class="font-weight-bold mb-2 h4">
                      <?php echo htmlspecialchars($blogger['title']); ?>
                  </h2>
                  <time class="text-muted small">
                      <?php echo htmlspecialchars($blogger['publish_date']); ?>
                  </time>
                </header>

                <div class="text-center mb-3">
                  <img class="responsive" src="adminpanel/img/bloggers/<?php echo htmlspecialchars(urlencode($blogger['img'])); ?>" alt='placeholder image'>
                </div>
                <p><?php
                    echo htmlspecialchars($blogger['content']);
                    ?></p>
                  <p>
                  <div class="fb-share-button" data-href="http://imanage.esy.es/kora180/single-article.php?id?id=<?php echo htmlspecialchars(urlencode($id)); ?>" data-layout="button_count" data-size="small" data-mobile-iframe="true"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Flocalhost%2Fkora180%2Fsingle-article.php%3Fid%3D1&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Share</a></div>
                  <div class="fb-like" data-href="http://imanage.esy.es/kora180/single-article.php?id=<?php echo htmlspecialchars(urlencode($id)); ?>" data-layout="button_count" data-action="like" data-size="small" data-show-faces="true"></div>
                  </p>
                  <p>
                  <div class="fb-comments" data-href="http://imanage.esy.es/kora180/single-article.php?id=<?php echo htmlspecialchars(urlencode($id)); ?>" data-numposts="10"></div>
                  </p>
              </article>

              <div class="panel-title panel-title--small">
                <h2>مزيد من الآراء</h2>
              </div>

              <div class="p-3">
                <div class="row">
<?php
$blogger_set = find_all_bloggers(['limit' =>3] );
while($blogger = mysqli_fetch_assoc($blogger_set)) {
    ?>

    <div class="col-md-4">
        <div class="card border-0 news">
            <div class="position-relative">
                <a href="single-news.php?id=<?php echo htmlspecialchars(urlencode($blogger['blogger_id'])); ?>">
                    <img class="card-img-top" src="adminpanel/img/bloggers/<?php echo htmlspecialchars(urlencode($blogger['img'])); ?>" height="250px" alt="placeholder">
                </a>
            </div>
            <div class="card-body">
                <h4 class="card-title news__title">
                    <a href="single-article.php?id=<?php echo htmlspecialchars(urlencode($blogger['blogger_id'])); ?>">
                        <?php echo htmlspecialchars($blogger['title']); ?>                   </a>
                </h4>
                <time class="news__date"><?php echo htmlspecialchars($blogger['publish_date']); ?></time>
                <p class="card-text"><?php
                    echo substr(htmlspecialchars($blogger['content']),0,120).".....";
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