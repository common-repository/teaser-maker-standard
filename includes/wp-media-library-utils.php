<?php

// *****************************************************************************
// INCLUDES / WP-MEDIA-LIBRARY-UTILS.PHP
// (C) 2014 Peter Newman. All Rights Reserved.
// *****************************************************************************

    namespace greatKiwi_byFernTec_teaserMaker_std_v0x1x114_wpMediaLibraryUtils ;

// =============================================================================
// get_smallest_as_big_as()
// =============================================================================

function get_smallest_as_big_as(
    $target_media_library_image_url     ,
    $min_width                          ,
    $min_height
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_wpMediaLibraryUtils\
    // get_smallest_as_big_as(
    //      $target_media_library_image_url     ,
    //      $min_width                          ,
    //      $min_height
    //      )
    // - - - - - - - - - - - - - - - - - - - - -
    // Given the URL of a full-size image file in the WP Media Library,
    // returns the URL of the resized variant of that image that's at least
    // as big as requested.
    //
    // NOTES!
    // ======
    // 1.   If $min_width = 0, then we don't care how wide the output image
    //      is; only that it's at least $min_height high.
    //
    // 2.   If $min_height = 0, then we don't care how high the output image
    //      is; only that it's at least $min_width wide.
    //
    // 3.   $min_width and $min_height CAN'T BOTH be 0 though.  One or both
    //      must be 1+.
    //
    // RETURNS:-
    //      o   On SUCCESS
    //              $smaller_image_url STRING
    //
    //      o   On FAILURE
    //              ARRAY( $error_message STRING )
    // -------------------------------------------------------------------------

    // =========================================================================
    // Init.
    // =========================================================================

    $ns = __NAMESPACE__ ;
    $fn = __FUNCTION__  ;

    // =========================================================================
    // ERROR CHECKING...
    // =========================================================================

    // -------------------------------------------------------------------------
    // $target_media_library_image_url ?
    // -------------------------------------------------------------------------

    if (    ! is_string( $target_media_library_image_url )
            ||
            trim( $target_media_library_image_url ) === ''
        ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Bad "target_media_library_image_url" (non-empty string expected)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return array( $msg ) ;

    }

    // -------------------------------------------------------------------------
    // $min_width ?
    // -------------------------------------------------------------------------

    if (    trim( $min_width ) === ''
            ||
            ! \ctype_digit( (string) $min_width )
        ) {

        $safe_min_width = htmlentities( $min_width ) ;

        $msg = <<<EOT
PROBLEM:&nbsp; Bad "min_width" ("{$safe_min_width}" - must be 0+)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return array( $msg ) ;

    }

    // -------------------------------------------------------------------------
    // $min_height ?
    // -------------------------------------------------------------------------

    if (    trim( $min_height ) === ''
            ||
            ! \ctype_digit( (string) $min_height )
        ) {

        $safe_min_height = htmlentities( $min_height ) ;

        $msg = <<<EOT
PROBLEM:&nbsp; Bad "min_height" ("{$safe_min_height}" - must be 0+)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return array( $msg ) ;

    }

    // -------------------------------------------------------------------------
    // $min_width / $min_height ?
    // -------------------------------------------------------------------------

    if ( $min_width == 0 && $min_height == 0 ) {

        $safe_min_width  = htmlentities( $min_width  ) ;
        $safe_min_height = htmlentities( $min_height ) ;

        $msg = <<<EOT
PROBLEM:&nbsp; Bad "min_width" ("{$safe_min_width}") and "min_height" ("{$safe_min_height}") (one or both must be non-zero)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return array( $msg ) ;

    }

    // =========================================================================
    // GET the WordPress Media Library DATA used by this function (which we
    // cache in memory for speed)...
    // =========================================================================

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_wpMediaLibraryUtils\
    // get_smallest_as_big_as_data()
    // - - - - - - - - - - - - - - -
    // Gets and caches the IMAGE attachments in the WordPress Media Library.
    //
    // RETURNS:-
    //      o   On SUCCESS
    //              ARRAY(
    //                  $attachments                    ,
    //                  $attachment_indices_by_url
    //                  )
    //
    //      o   On FAILURE
    //              $error_message STRING
    // -------------------------------------------------------------------------

    $result = get_smallest_as_big_as_data() ;

    // -------------------------------------------------------------------------

    if ( is_string( $result ) ) {
        return array( $result ) ;
    }

    // -------------------------------------------------------------------------

    list(
        $attachments                    ,
        $attachment_indices_by_url
        ) = $result ;

    // =========================================================================
    // IMAGE in MEDIA LIBRARY ?
    //
    // If NOT, return the requested image...
    // =========================================================================

    if ( ! array_key_exists(
                $target_media_library_image_url     ,
                $attachment_indices_by_url
                )
        ) {
        return $target_media_library_image_url ;
    }

    // =========================================================================
    // This is the ATTACHMENT pointed to be the target image URL...
    // =========================================================================

    $target_attachment_obj =
        $attachments[
            $attachment_indices_by_url[ $target_media_library_image_url ]
            ] ;

    // =========================================================================
    // GET the attachment's OTHER IMAGE SIZES...
    // =========================================================================

    // -------------------------------------------------------------------------
    // wp_get_attachment_metadata( $attachment_id, $unfiltered )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Retrieve attachment meta field for attachment ID.
    //
    //      $attachment_id
    //          (integer) (required) Attachment ID
    //          Default: None
    //
    //      $unfiltered
    //          (boolean) (optional) If true, filters are not run.
    //          Default: false
    //
    // RETURN VALUES
    //
    //      (array|boolean)
    //          Attachment meta field. False on failure.
    //
    //      The fields are:
    //
    //          width       (integer)   The width of the attachment
    //          height      (integer)   The height of the attachment
    //          file        (string)    The file path relative to
    //                                  `wp-content/uploads/`
    //          sizes       (array)     Keys are size slugs, each value is an
    //                                  array containing 'file', 'width',
    //                                  'height', and 'mime-type'
    //          image_meta  (array)
    //
    // EXAMPLE
    //
    //      Array(
    //          [width]     => 2400
    //          [height]    => 1559
    //          [file]      => 2011/12/press_image.jpg
    //          [sizes]     => Array(
    //                              [thumbnail] => Array(
    //                                                  [file]      => press_image-150x150.jpg
    //                                                  [width]     => 150
    //                                                  [height]    => 150
    //                                                  [mime-type] => image/jpeg
    //                                                  )
    //                              [medium] => Array(
    //                                                  [file]      => press_image-4-300x194.jpg
    //                                                  [width]     => 300
    //                                                  [height]    => 194
    //                                                  [mime-type] => image/jpeg
    //                                                  )
    //                              [large] => Array(
    //                                                  [file]      => press_image-1024x665.jpg
    //                                                  [width]     => 1024
    //                                                  [height]    => 665
    //                                                  [mime-type] => image/jpeg
    //                                                  )
    //                              [post-thumbnail] => Array(
    //                                                      [file]      => press_image-624x405.jpg
    //                                                      [width]     => 624
    //                                                      [height]    => 405
    //                                                      [mime-type] => image/jpeg
    //                                                      )
    //                              )
    //          [image_meta] => Array(
    //                              [aperture]          => 5
    //                              [credit]            =>
    //                              [camera]            => Canon EOS-1Ds Mark III
    //                              [caption]           =>
    //                              [created_timestamp] => 1323190643
    //                              [copyright]         =>
    //                              [focal_length]      => 35
    //                              [iso]               => 800
    //                              [shutter_speed]     => 0.016666666666667
    //                              [title]             =>
    //                              )
    //          )
    //
    // CHANGE LOG
    //      Since: 2.1.0
    // -------------------------------------------------------------------------

    $target_attachment_metadata =
        \wp_get_attachment_metadata(
            $target_attachment_obj->ID
            ) ;

    // -------------------------------------------------------------------------

    if ( $target_attachment_metadata === FALSE ) {
        return $target_media_library_image_url ;
    }

    // =========================================================================
    // ANY OTHER SIZES ?
    // =========================================================================

    if (    ! array_key_exists( 'sizes' , $target_attachment_metadata )
            ||
            ! is_array( $target_attachment_metadata['sizes'] )
            ||
            count( $target_attachment_metadata['sizes'] ) < 1
        ) {
        return $target_media_library_image_url ;
    }

    // =========================================================================
    // Find the SMALLEST OTHER SIZE that's at least as big as requested.
    // =========================================================================

    // -------------------------------------------------------------------------
    // NOTE!
    // =====
    // We assume that no matter what the image size, the width and height are
    // always proportional (in the same aspect ratio).  So when comparing
    // image sizes, we only need compare the width OR the height - but never
    // both.
    // -------------------------------------------------------------------------

    $smallest_other_size_url    = ''          ;
    $smallest_other_size_width  = PHP_INT_MAX ;
    $smallest_other_size_height = PHP_INT_MAX ;

    // -------------------------------------------------------------------------

    foreach ( $target_attachment_metadata['sizes'] as $size_name => $size_details ) {

        // ---------------------------------------------------------------------

        if (    $size_details['width'] < $min_width
                ||
                $size_details['height'] < $min_height
            ) {
            continue ;
                //  Too small
        }

        // ---------------------------------------------------------------------

        $size_url = \trailingslashit( \dirname( $target_media_library_image_url ) ) . $size_details['file'] ;

        // ---------------------------------------------------------------------

        if ( $smallest_other_size_url === '' ) {

            $smallest_other_size_url    = $size_url               ;
            $smallest_other_size_width  = $size_details['width']  ;
            $smallest_other_size_height = $size_details['height'] ;

        } else {

            if ( $size_details['width'] < $smallest_other_size_width ) {

                $smallest_other_size_url    = $size_url               ;
                $smallest_other_size_width  = $size_details['width']  ;
                $smallest_other_size_height = $size_details['height'] ;

            }

        }

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // DONE!
    // =========================================================================

    if ( $smallest_other_size_url === '' ) {
        return $target_media_library_image_url ;
    }

    // -------------------------------------------------------------------------

    return $smallest_other_size_url ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// get_smallest_as_big_as_data()
// =============================================================================

function get_smallest_as_big_as_data() {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_wpMediaLibraryUtils\
    // get_smallest_as_big_as_data()
    // - - - - - - - - - - - - - - -
    // Gets and caches the IMAGE attachments in the WordPress Media Library.
    //
    // RETURNS:-
    //      o   On SUCCESS
    //              ARRAY(
    //                  $attachments                    ,
    //                  $attachment_indices_by_url
    //                  )
    //
    //      o   On FAILURE
    //              $error_message STRING
    // -------------------------------------------------------------------------

    // =========================================================================
    // Already CACHED ?
    // =========================================================================

    $global_cache_variable_name =
        'greatKiwi_byFernTec_teaserMaker_std_v0x1x114_smallestAsBigAsData'
        ;

    // -------------------------------------------------------------------------

    if ( array_key_exists( $global_cache_variable_name , $GLOBALS ) ) {
        return $GLOBALS[ $global_cache_variable_name ] ;
    }

    // =========================================================================
    // GET the IMAGES in the WordPress Media Library...
    // =========================================================================

    // -------------------------------------------------------------------------
    // $posts_array = get_posts( $args )
    // - - - - - - - - - - - - - - - - -
    // The most appropriate use for get_posts is to create an array of posts
    // based on a set of parameters. It retrieves a list of latest posts or
    // posts matching this criteria. get_posts can also be used to create
    // Multiple Loops, though a more direct reference to WP_Query using new
    // WP_Query is preferred in this case.
    //
    // The parameters of get_posts are similar to those of get_pages but is
    // implemented quite differently, and should be used in appropriate
    // scenarios. get_posts uses WP_Query, whereas get_pages queries the
    // database more directly. Each have parameters that reflect this difference
    // in implementation.
    //
    // query_posts also uses WP_Query, but is not recommended because it
    // directly alters the main loop by changing the variables of the global
    // variable $wp_query. get_posts, on the other hand, simply references a new
    // WP_Query object, and therefore does not affect or alter the main loop.
    //
    // If you would like to alter the main query before it is executed, you can
    // hook into it using pre_get_posts. If you would just like to call an array
    // of posts based on a small and simple set of parameters within a page,
    // then get_posts is your best option.
    //
    // DEFAULT USAGE
    //
    //      $args = array(
    //                  'posts_per_page'   => 5             ,
    //                  'offset'           => 0             ,
    //                  'category'         => ''            ,
    //                  'orderby'          => 'post_date'   ,
    //                  'order'            => 'DESC'        ,
    //                  'include'          => ''            ,
    //                  'exclude'          => ''            ,
    //                  'meta_key'         => ''            ,
    //                  'meta_value'       => ''            ,
    //                  'post_type'        => 'post'        ,
    //                  'post_mime_type'   => ''            ,
    //                  'post_parent'      => ''            ,
    //                  'post_status'      => 'publish'     ,
    //                  'suppress_filters' => TRUE
    //                  )
    //
    // Note: 'numberposts' and 'posts_per_page' can be used interchangeably.
    //
    // PARAMETERS
    //
    //      For full parameters list see WP_Query.
    //
    //      See also get_pages() for example parameter usage.
    //
    //      get_posts() makes use of the WP_Query class to fetch posts. See the
    //      parameters section of the WP_Query documentation for a list of
    //      parameters that this function accepts.
    //
    //      Note:   get_posts uses 'suppress_filters' => true as default, while
    //              query_posts() applies filters by default, this can be
    //              confusing when using query-modifying plugins, like WPML.
    //              Also note that even if 'suppress_filters' is true, any
    //              filters attached to pre_get_posts are still applied—only
    //              filters attached on 'posts_*' or 'comment_feed_*' are
    //              suppressed.
    //
    //      Note:   The category parameter needs to be the ID of the category,
    //              and not the category name.
    //
    //      Note:   The category parameter can be a comma separated list of
    //              categories, as the get_posts() function passes the
    //              'category' parameter directly into WP_Query as 'cat'.
    //
    //      'orderby'
    //          (string) (optional) Sort retrieved posts by parameter.
    //
    //          Default: 'date'
    //
    //              'none'           -  No order (available with Version 2.8).
    //
    //              'ID'             -  Order by post id. Note the
    //                                  capitalization.
    //
    //              'author'         -  Order by author.
    //
    //              'title'          -  Order by title.
    //
    //              'date'           -  Order by date.
    //
    //              'modified'       -  Order by last modified date.
    //
    //              'parent'         -  Order by post/page parent id.
    //
    //              'rand'           -  Random order.
    //
    //              'comment_count'  -  Order by number of comments (available
    //                                  with Version 2.9).
    //
    //              'menu_order'     -  Order by Page Order. Used most often for
    //                                  Pages (Order field in the Edit Page
    //                                  Attributes box) and for Attachments (the
    //                                  integer fields in the Insert / Upload
    //                                  Media Gallery dialog), but could be used
    //                                  for any post type with distinct
    //                                  'menu_order' values (they all default to
    //                                  0).
    //
    //              'meta_value'     -  Note that a 'meta_key=keyname' must also
    //                                  be present in the query. Note also that
    //                                  the sorting will be alphabetical which
    //                                  is fine for strings (i.e. words), but
    //                                  can be unexpected for numbers (e.g. 1,
    //                                  3, 34, 4, 56, 6, etc, rather than 1, 3,
    //                                  4, 6, 34, 56 as you might naturally
    //                                  expect).
    //
    //              'meta_value_num' -  Order by numeric meta value (available
    //                                  with Version 2.8). Also note that a
    //                                  'meta_key=keyname' must also be present
    //                                  in the query. This value allows for
    //                                  numerical sorting as noted above in
    //                                  'meta_value'.
    //
    //              'post__in'       -  Matches same order you passed in via the
    //                                  'include' parameter.
    //
    //          Note:   get_pages() uses the parameter 'sort_column' instead of
    //                  'orderby'. Also, get_pages() requires that 'post_' be
    //                  prepended to these values: 'author, date, modified,
    //                  parent, title, excerpt, content'.
    //
    //      'post_mime_type'
    //          (string or array) (Optional) List of mime types or comma
    //          separated string of mime types.
    //
    //          Default: None
    //
    // RETURN VALUE
    //
    //      (array) List of WP_Post objects.
    //
    //      Unlike get_pages(), get_posts() will return private pages in the
    //      appropriate context (i.e., for an administrator). (See: Andreas
    //      Kirsch, WordPress Hacking II, January 24, 2009-- accessed
    //      2012-11-09.)
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // DEFAULT POST TYPES
    // ==================
    // There are five post types that are readily available to users or
    // internally used by the WordPress installation by default :
    //
    //      Post            (Post Type: 'post')
    //      Page            (Post Type: 'page')
    //      Attachment      (Post Type: 'attachment')
    //      Revision        (Post Type: 'revision')
    //      Navigation menu (Post Type: 'nav_menu_item')
    //
    // ATTACHMENT is a special post that holds information about a file uploaded
    // through the WordPress media upload system, such as its description and
    // name. For images, this is also linked to metadata information, stored in
    // the wp_postmeta table, about the size of the images, the thumbnails
    // generated from the images, the location of the image files, the HTML alt
    // text, and even information obtained from EXIF data embedded in the
    // images.
    // -------------------------------------------------------------------------

    $args = array(
                'post_type'        => 'attachment'  ,
                'posts_per_page'   => -1            ,       //  All
                'orderby'          => 'none'        ,
                'post_mime_type'   => array(
                                            'image/gif'     ,
                                            'image/jpeg'    ,
                                            'image/png'
                                            )
                ) ;

    // -------------------------------------------------------------------------

    $attachments = \get_posts( $args ) ;

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $attachments = Array(
    //
    //          [0] => WP_Post Object(
    //                      [ID]                    => 158
    //                      [post_author]           => 1
    //                      [post_date]             => 2014-05-09 17:04:06
    //                      [post_date_gmt]         => 2014-05-09 05:04:06
    //                      [post_content]          =>
    //                      [post_title]            => teaser-postcards-from-wonderland
    //                      [post_excerpt]          =>
    //                      [post_status]           => inherit
    //                      [comment_status]        => closed
    //                      [ping_status]           => open
    //                      [post_password]         =>
    //                      [post_name]             => teaser-postcards-from-wonderland
    //                      [to_ping]               =>
    //                      [pinged]                =>
    //                      [post_modified]         => 2014-05-09 17:04:06
    //                      [post_modified_gmt]     => 2014-05-09 05:04:06
    //                      [post_content_filtered] =>
    //                      [post_parent]           => 0
    //                      [guid]                  => http://localhost/plugdev/wp-content/uploads/2014/05/teaser-postcards-from-wonderland.png
    //                      [menu_order]            => 0
    //                      [post_type]             => attachment
    //                      [post_mime_type]        => image/png
    //                      [comment_count]         => 0
    //                      [filter]                => raw
    //                      [format_content]        =>
    //                      )
    //
    //          ...
    //
    //          )
    //
    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $attachments , '$attachments' ) ;

    // =========================================================================
    // INDEX the Media Library images by URL...
    // =========================================================================

    $attachment_indices_by_url = array() ;

    // -------------------------------------------------------------------------

    foreach ( $attachments as $this_attachment_index => $this_attachment_obj ) {

        // -------------------------------------------------------------------------
        // wp_get_attachment_url( $id )
        // - - - - - - - - - - - - - -
        // Returns a full URI for an attachment file or false on failure.
        //
        //      $id
        //          (integer) (required) The ID of the desired attachment
        //          Default: None
        //
        // RETURN VALUE
        //
        //      (string/boolean)
        //          Returns URI to uploaded attachment or "false" on failure.
        //
        //
        // Notes    You can change the output of this function through the wp get
        //          attachment url filter.
        //
        //          If you want a URI for the attachment page, not the attachment
        //          file itself, you can use get_attachment_link.
        //
        // CHANGE LOG
        //      Since: 2.1.0
        // -------------------------------------------------------------------------

        $attachment_url = \wp_get_attachment_url( $this_attachment_obj->ID ) ;

        // ---------------------------------------------------------------------

        if ( $attachment_url === FALSE ) {
            continue ;
                //  Skip this attachment ???
        }

        // ---------------------------------------------------------------------

        $attachment_indices_by_url[ $attachment_url ] = $this_attachment_index ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // DONE!
    // =========================================================================

    $GLOBALS[ $global_cache_variable_name ] =
        array(
            $attachments                    ,
            $attachment_indices_by_url
            ) ;

    // -------------------------------------------------------------------------

    return $GLOBALS[ $global_cache_variable_name ] ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// That's that!
// =============================================================================

