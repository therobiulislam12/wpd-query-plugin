<div class="wrap">
    <h1 class="heading-title">Customize Post</h1>
    <hr class="wp-header-end" />

    <h2 class="screen-reader-text">Filter posts list</h2>

    <div class="tablenav top">
        <form action="" method="get">
            <input type="hidden" name="page" value="wpd_posts_query">
            <div class="alignleft actions">
                <label class="screen-reader-text" for="cat">Filter by category</label>
                <?php
                    $selected_category = isset( $_GET['wpd_category'] ) ? $_GET['wpd_category'] : '-1';
                ?>
                <select name="wpd_category" id="cat" class="postform">
                <option value="-1" <?php selected( '-1', $selected_category ); ?> >All Categories</option>
                    <?php foreach($terms as $term): ?> 
                        <option value="<?php echo esc_attr($term->term_id); ?>" <?php selected( $term->term_id, $selected_category ); ?>>
                        <?php echo $term->name; ?>
                    </option>
                    <?php endforeach; ?>
                </select>
                <input type="submit" name="wpd_filter_action" id="post-query-submit" class="button" value="Filter" />
            </div>

            <div class="alignleft actions">
                <label class="screen-reader-text" for="cat">Filter by Author</label>

                <?php
                     $selected_author = isset( $_GET['wpd_author'] ) ? $_GET['wpd_author'] : '-1';
                ?>

                <select name="wpd_author" id="author" class="postform">
                    <option value="-1" <?php selected( '-1', $selected_author ); ?> >All Authors</option>
                    <?php foreach($authors as $author): ?> 
                        <option value="<?php echo esc_attr($author->ID); ?>" <?php selected( $author->ID, $selected_author ); ?>>
                        <?php echo $author->display_name; ?>
                    </option>
                    <?php endforeach; ?>
                </select>

                <input type="submit" name="wpd_author_action" id="post-query-submit" class="button" value="Filter" />
            </div>

            <div class="tablenav-pages one-page">
                <span class="displaying-num">
                    <?php
                        echo 'Total ' . $post_count->publish . ' posts'
                    ?>
                </span>
                <span class="pagination-links">
                    <span class="tablenav-pages-navspan button disabled" aria-hidden="true">«</span>
                    <span class="tablenav-pages-navspan button disabled" aria-hidden="true">‹</span>
                    <span class="paging-input">
                        <label for="current-page-selector" class="screen-reader-text">Current Page</label>
                        <input class="current-page" id="current-page-selector" type="text" name="paged" value="1" size="1" aria-describedby="table-paging">
                        <span class="tablenav-paging-text"> of <span class="total-pages">1</span></span>
                    </span>
                    <span class="tablenav-pages-navspan button disabled" aria-hidden="true">›</span>
                    <span class="tablenav-pages-navspan button disabled" aria-hidden="true">»</span>
                </span>
            </div>

            <br class="clear">
        </form>
    </div>


    <table class="wp-list-table widefat fixed striped table-view-list posts">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Categories</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($posts as $post) : 
                $author = get_user_by('id', $post->post_author);
                $author = $author->data->display_name;

                $formatted_date = get_the_date($date_format, $post->ID);
                $formatted_time = get_the_time($time_format, $post->ID);

                $categories = get_the_category($post->ID);
                $category_names = [];

                foreach($categories as $category) {
                    $category_names[] = $category->name;
                }
                $category_list = implode(', ', $category_names);

                ?>
                <tr>
                    <td><?php echo $post->ID ?></td>
                    <td style="color:#183ad6; cursor:pointer">
                        <strong><span class="row-title"><?php echo $post->post_title ?></span></strong>
                    </td>
                    <td><?php echo $author; ?></td>
                    <td><?php echo $category_list  ?></td>
                    <td class="date column-date" data-colname="Date">Published<br><?php echo $formatted_date . ' at ' . $formatted_time; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>

        <tfoot>  
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Categories</th>
                <th>Date</th>
            </tr>
        </tfoot>
    </table>
</div>
