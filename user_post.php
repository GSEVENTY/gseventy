  <div class="cards">
      <?php
        $status = 'online';
        $sql = 'SELECT * FROM posts WHERE status = :st AND post_author = :pa ORDER BY post_id DESC';
        $stmt = $connection->prepare($sql);
        $stmt->execute(['st' => $status, 'pa' => $username]);
        $posts = $stmt->fetchAll();

        foreach ($posts as $post) {
            $post_id = $post->post_id;
            $post_title = $post->post_title;
            $post_content = $post->post_content;
            $post_author = $post->post_author;
            $post_date = $post->post_date;
            $external_link = $post->external_link;
            $post_image = $post->post_image;
            $image_credit = $post->image_credit;
            $post_category = $post->post_category_id;
        ?>

          <div class="card">
              <div class="card-writer">
                  <span><a href="writer-profile.php?username=<?php echo $post_author ?>"><?php echo $post_author ?></a></span>
                  <div>
                      <a href="delete_post.php?delete=<?php echo $post_id ?>">Delete</a>
                      <span><?php echo time_elapsed_string($post_date); ?></span>
                  </div>
              </div>
              <div class="card-content">
                  <?php
                    // Image only show in posts if image exist in db.
                    if (!$post_image == '') {
                        echo "<div class='card-img'>";
                        echo "<img src=' $post_image' />";
                        echo "<span>Image Credit: $image_credit</span>";
                        echo "</div>";
                    }
                    ?>
                  <div class="card-body">
                      <h1><?php echo $post_title ?></h1>
                      <p><?php echo $post_content ?></p>
                  </div>
              </div>
              <div class="card-footer">
                  <div class="card-vote">
                      <!-- <i class="far fa-thumbs-up"></i>
                    <span>20</span> -->
                      <?php
                        $sql = "SELECT * FROM categories WHERE cat_id = :ci";
                        $stmt = $connection->prepare($sql);
                        $stmt->execute(['ci' => $post_category]);
                        $cats = $stmt->fetchAll();

                        foreach ($cats as $cat) {
                            $cat_title = $cat->cat_title;
                        }
                        echo "<span>{$cat_title}</span>";
                        ?>
                  </div>
                  <div class="card-ext-link">
                      <td><a href="edit_post.php?source=edit_post&p_id=<?php echo $post_id ?>">Edit</a></td>
                      <a target="_blank" href="<?php echo $external_link ?>"><i class="external-link fas fa-external-link-alt"></i></a>
                  </div>
              </div>
          </div>
      <?php } ?>
  </div>