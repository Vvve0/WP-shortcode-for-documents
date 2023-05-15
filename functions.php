function custom_attachments_shortcode($atts) {
    ob_start();

    // only for document type attatchments
    $atts = shortcode_atts(array(
        'keyword' => '',
    ), $atts);

    $query_args = array(
        'post_type'      => 'attachment',
        'post_mime_type' => 'application/pdf',
        'post_status'    => 'inherit',
        'posts_per_page' => -1,
        'orderby'        => 'title',
        'order'          => 'ASC',
        's'              => $atts['keyword'], 
    );

    $query = new WP_Query($query_args);

    if ($query->have_posts()) {
        echo '<div class="custom-attachments-wrapper">'; 
        while ($query->have_posts()) {
            $query->the_post();
            echo '<div class="custom-attachments-item">';
            echo '<a class="custom-attachments-link" href="' . wp_get_attachment_url(get_the_ID()) . '">';
            echo '<h3 class="custom-attachments-title">' . get_the_title() . '</h3>';
            echo '</a>';
            echo '</div>';
        }
        echo '</div>';
    }

	wp_reset_postdata();
wp_reset_query();

    return ob_get_clean();
}
add_shortcode('custom_attachments', 'custom_attachments_shortcode');
