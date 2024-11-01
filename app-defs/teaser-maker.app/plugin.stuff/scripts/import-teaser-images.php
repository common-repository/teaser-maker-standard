<?php

// *****************************************************************************
// TEASER-MAKER.APP / PLUGIN.STUFF / SCRIPTS / IMPORT-TEASER-IMAGES.PHP
// (C) 2014 Peter Newman. All Rights Reserved.
// *****************************************************************************

    namespace greatKiwi_byFernTec_teaserMaker_std_v0x1x114_datasetDef_teaserMaker ;

// =============================================================================
// import_teaser_images()
// =============================================================================

function import_teaser_images(
    $core_plugapp_dirs      ,
    $import_array           ,
    $loaded_datasets
    ) {

    // -------------------------------------------------------------------------
    // import_teaser_images(
    //      $core_plugapp_dirs      ,
    //      $import_array           ,
    //      $loaded_datasets
    //      )
    // - - - - - - - - - -
    // RETURNS
    //      On SUCCESS
    //          $teaser_image_urls_new_by_old ARRAY
    //
    //      On FAILURE
    //          $error_message STRING
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $import_array = Array(
    //
    //          [instance_data] => Array(
    //              [export_file_basename]  => teaser-sample-page-exported-7-jun-2014-at-09-44-16-gmt.dat
    //              [export_datetime_UTC]   => 1402134256
    //              )
    //
    //          [teaser_category_records] => Array(
    //
    //              [teaser_categories] => Array(
    //
    //                  [0] => Array(
    //                      [created_server_datetime_UTC]            => 1401260826
    //                      [last_modified_server_datetime_UTC]      => 1401948262
    //                      [key]                                    => 3f0318c7-fcd9-4694-9d2b-8d74610bec66-1401260826-168058-145
    //                      [parent_key]                             =>
    //                      [title]                                  => Teaser Sample Page
    //                      [description]                            => PHA+QWk+PC9wPg0K
    //                      [description_format]                     => none
    //                      [image_url]                              =>
    //                      [sequence_number]                        =>
    //                      [imports_export_file_basename]           =>
    //                      [imports_export_datetime_UTC]            =>
    //                      [imports_original_teaser_category_title] =>
    //                      [imports_import_file_basename]           =>
    //                      )
    //
    //                  )
    //
    //              [teasers] => Array(
    //
    //                  [0] => Array(
    //                      [created_server_datetime_UTC]       => 1396257849
    //                      [last_modified_server_datetime_UTC] => 1401931164
    //                      [key]                               => 53393439b8b82
    //                      [parent_key]                        => 3f0318c7-fcd9-4694-9d2b-8d74610bec66-1401260826-168058-145
    //                      [original_url]                      => http://www.rookiemag.com/2014/02/postcards-from-wonderland/
    //                      [original_title]                    => Postcards From Wonderland
    //                      [original_clipped_text]             => TXkgYG91c2UuLi4=
    //                      [text_format]                       => none
    //                      [original_media_url]                => http://static.rookiemag.com/2014/02/13927942057DbvL-700x466.jpeg
    //                      [sequence_number]                   => 10
    //                      )
    //
    //                  ...
    //
    //                  )
    //
    //              )
    //
    //          [teaser_images] => Array(
    //              [0] => Array(
    //                          [url]       => http://static.rookiemag.com/2014/02/13927942057DbvL-700x466.jpeg
    //                          [copy_type] => by-reference
    //                          )
    //              [1] => Array(
    //                          [url]       => http://static.rookiemag.com/2014/02/13912724721february2014background.jpg
    //                          [copy_type] => by-reference
    //                          )
    //              [2] => Array(
    //                          [url]       => http://www.mermaidchapel.com/wp-content/uploads/2014/03/birthofvenus.jpg
    //                          [copy_type] => by-reference
    //                          )
    //              )
    //
    //          )
    //
    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $import_array , '$import_array' ) ;

    // -------------------------------------------------------------------------
    // NOTE!
    // =====
    // 1.   All images whoose "copy_type" === "physical" - and thus, that
    //      are to be physically" copied to the destination site - are
    //      imported into the destination site's WordPress Media Library.
    //
    //      These images may have come from the following places (on the site
    //      the object being imported was exported from):-
    //          o   WordPress Media Library
    //          o   Some other directory(s) on the local server
    //          o   Some external server.
    //
    //      But we don't care.  We put them all into the destination server's
    //      WordPress Media Library.  As this is the best as far as:-
    //          o   Minimising file ownership and permission (etc) problems
    //              when saving the files to the destination site.
    //          o   Making it easy to manage (and delete) the imported images
    //              (via the WordPress Media Library admin screens)
    //
    // 2.   All images whoose "copy_type" === "by-reference" - are ignored.
    //      It's assumed that their "image_urls" - on both the "source" and
    //      "destination" sites - point to some external location that can be
    //      accessed by both sites.
    // -------------------------------------------------------------------------

    // =========================================================================
    // Init.
    // =========================================================================

    $ns = __NAMESPACE__ ;
    $fn = __FUNCTION__  ;

    // -------------------------------------------------------------------------

    $teaser_image_urls_new_by_old = array() ;

    // =========================================================================
    // Anything to to ?
    // =========================================================================

    if ( ! \array_key_exists( 'teaser_images' , $import_array ) ) {
        return $teaser_image_urls_new_by_old ;
    }

    // -------------------------------------------------------------------------

    if ( ! \is_array( $import_array['teaser_images'] ) ) {

        return <<<EOT
PROBLEM:&nbsp; Bad "teaser_images" (in import data - array expected)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // -------------------------------------------------------------------------

    if ( \count( $import_array['teaser_images'] ) < 1 ) {
        return $teaser_image_urls_new_by_old ;
    }

    // =========================================================================
    // GET the images currently in the DESTINATION SITE'S WordPress Media
    // Library...
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
    // WP Media Library Functions...
    // =========================================================================

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

    // -------------------------------------------------------------------------
    // wp_get_attachment_image_src( $attachment_id, $size, $icon )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Returns an array with the image attributes "url", "width" and "height",
    // of an image attachment file.
    //
    // Note: For just the image src, use the first element in the returned array.
    //
    //      $attachment_id
    //          (integer) (required) ID of the desired attachment.
    //          Default: None
    //
    //      $size
    //          (string/array) (optional) Size of the image shown for an image
    //          attachment: either a string keyword (thumbnail, medium, large or
    //          full) or a 2-item array representing width and height in pixels,
    //          e.g. array(32,32). As of Version 2.5, this parameter does not
    //          affect the size of media icons, which are always shown at their
    //          original size.
    //
    //          Default: thumbnail
    //
    //      $icon
    //          (bool) (optional) Use a media icon to represent the attachment.
    //          Default: false
    //
    // RETURN VALUE
    //      (array) An array containing:
    //
    //          [0] => url
    //          [1] => width
    //          [2] => height
    //          [3] => boolean: true if $url is a resized image, false if it is
    //                 the original.
    //
    //      or FALSE, if no image is available.
    //
    // CHANGE LOG
    //      Since: 2.5.0
    // -------------------------------------------------------------------------

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

    // =========================================================================
    // MAKE a list of the BASENAMES of the IMAGES in the WORDPRESS MEDIA
    // LIBRARY...
    // =========================================================================

    $wordpress_attachment_ids_by_attachment_basename = array() ;

    $wordpress_attachment_metadata_by_attachment_id = array() ;

    // -------------------------------------------------------------------------

    foreach ( $attachments as $this_attachment ) {

        // ---------------------------------------------------------------------

        $this_attachment_metadata =
            \wp_get_attachment_metadata( $this_attachment->ID ) ;
                //  Attachment meta field. FALSE on failure.

        // ---------------------------------------------------------------------

        if ( $this_attachment_metadata === FALSE ) {

            return <<<EOT
PROBLEM:&nbsp; "wp_get_attachment_metadata()" failure
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

        $this_basename = \basename( $this_attachment_metadata['file'] ) ;

        // ---------------------------------------------------------------------
        // NOTE!
        // =====
        // A given basename can appear in more than one attachment.
        // ---------------------------------------------------------------------

        if ( array_key_exists( $this_basename , $wordpress_attachment_ids_by_attachment_basename ) ) {

            $wordpress_attachment_ids_by_attachment_basename[ $this_basename ][] =
                $this_attachment->ID ;

        } else {

            $wordpress_attachment_ids_by_attachment_basename[ $this_basename ] =
                array(
                    $this_attachment->ID
                    ) ;

        }

        // ---------------------------------------------------------------------

        $wordpress_attachment_metadata_by_attachment_id[ $this_attachment->ID ] =
            $this_attachment_metadata
            ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // GET the UPLOADS ROOT DIRECTORY...
    // =========================================================================

    // -------------------------------------------------------------------------
    // wp_upload_dir( [ $yyyy_mm ] )
    // - - - - - - - - - - - - - - -
    // Returns an array of key => value pairs containing path information on the
    // currently configured uploads directory.
    //
    // Checks the 'upload_path' option, which should be from the web root
    // folder, and if it isn't empty it will be used. If it is empty, then the
    // path will be 'WP_CONTENT_DIR/uploads'. If the 'UPLOADS' constant is
    // defined, then it will override the 'upload_path' option and
    // 'WP_CONTENT_DIR/uploads' path.
    //
    // The upload URL path is set either by the 'upload_url_path' option or by
    // using the 'WP_CONTENT_URL' constant and appending '/uploads' to the path.
    //
    // If the 'uploads_use_yearmonth_folders' is set to true (checkbox if
    // checked in the administration settings panel), then the time will be
    // used. The format will be year first and then month.
    //
    // If the path couldn't be created, then an error will be returned with the
    // key 'error' containing the error message. The error suggests that the
    // parent directory is not writable by the server.
    //
    // On success, the returned array will have many indices:
    //
    //      o   path'       base directory and sub directory or full path to
    //                      upload directory.
    //
    //      o   'url'       base url and sub directory or absolute URL to upload
    //                      directory.
    //
    //      o   'subdir'    sub directory if uploads use year/month folders
    //                      option is on.
    //
    //      o   'basedir'   path without subdir.
    //
    //      o   'baseurl'   URL path without subdir.
    //
    //      o   'error'     set to false.
    //
    // PARAMETERS
    //
    //      $time
    //          (string) (optional) Time formatted in 'yyyy/mm'.
    //          Default: null
    //
    // EXAMPLE
    //
    //      $upload_dir = wp_upload_dir() ; // Array of key => value pairs
    //
    //      // $upload_dir now contains something like the following (if
    //      // successful):-
    //      //
    //      //      Array (
    //      //          [path]    => C:\path\to\wordpress\wp-content\uploads\2010\05
    //      //          [url]     => http://example.com/wp-content/uploads/2010/05
    //      //          [subdir]  => /2010/05
    //      //          [basedir] => C:\path\to\wordpress\wp-content\uploads
    //      //          [baseurl] => http://example.com/wp-content/uploads
    //      //          [error]   =>
    //      //          )
    //
    // IMPORTANT NOTE
    //
    // Note that using this function will create a subfolder in your Uploads
    // folder corresponding to the queried month (or current month, if no $time
    // argument is provided), if that folder is not already there. You don't
    // have to upload anything in order for this folder to be created.
    //
    // CHANGE LOG
    //      Since: 2.0.0
    // -------------------------------------------------------------------------

    $wp_uploads_dir = \wp_upload_dir() ;

    // -------------------------------------------------------------------------

    if (    \array_key_exists( 'error' , $wp_uploads_dir )
            &&
            $wp_uploads_dir['error'] !== FALSE
        ) {

        $msg = <<<EOT
PROBLEM:&nbsp; "wp_upload_dir()" failure getting WordPress uploads dir
</div style="padding-left:3em; font-style:monospace">{$wp_uploads_dir['error']}</div>
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        $msg = str_replace( "\n" , '' , $msg ) ;

        return $msg ;

    }

    // -------------------------------------------------------------------------

    $uploads_root_dirspec = \untrailingslashit( $wp_uploads_dir['basedir'] ) ;
    $uploads_root_url     = \untrailingslashit( $wp_uploads_dir['baseurl'] ) ;

    // =========================================================================
    // Build a list of the IMAGE RECORD INDICES that have ALREADY BEEN
    // IMPORTED...
    // =========================================================================

    $indices_of_already_imported_teaser_images = array() ;

    // -------------------------------------------------------------------------

    foreach ( $import_array['teaser_images'] as $this_teaser_image_index => $this_teaser_image ) {

        // ---------------------------------------------------------------------
        // NOTE!
        // =====
        // At this point, it's already been checked that each image has a
        // non-empty string URL and basename.
        // ---------------------------------------------------------------------

        // =====================================================================
        // Ignore all but the teaser images to be PHYSICALLY imported...
        // =====================================================================

        if ( $this_teaser_image['copy_type'] !== 'physical' ) {
            continue ;
        }

        // --------------------------------------------------------------------
        // NOTE!
        // =====
        // Here we have (eg):-
        //
        //      $this_teaser_image = array(
        //          [url]               => http://localhost/plugdev/wp-content/uploads/2014/05/teaser-postcards-from-wonderland.png
        //          [copy_type]         => physical
        //          [width]             => 842
        //          [height]            => 656
        //          [php_imagetype_xxx] => 3
        //          [mime_type]         => image/png
        //          [md5]               => b189026ddb09241db2c2728a448e4f7b
        //          [sha1]              => ca04b73bc84e8ded3ecfb561738927e600c435f4
        //          [filesize]          => 437065
        //          [binary_image_data] => XXX
        //          )
        //
        // ---------------------------------------------------------------------

        // =====================================================================
        // Get the teaser image basename...
        // =====================================================================

        $this_teaser_image_basename = \basename( $this_teaser_image['url'] ) ;

        // =====================================================================
        // If there's NO WordPress Media Libarary image with the same
        // basename as this teaser image, then the teaser CAN'T already have been
        // imported...
        // =====================================================================

        if ( ! array_key_exists(
                    $this_teaser_image_basename                           ,
                    $wordpress_attachment_ids_by_attachment_basename
                    )
            ) {
            continue ;
        }

        // =====================================================================
        // Loop over the existing WordPress Media Library images with the
        // same basename as the teaser image to be imported...
        // =====================================================================

        $attachment_ids_owned_by_attachment_basename =
            $wordpress_attachment_ids_by_attachment_basename[
                $this_teaser_image_basename
                ] ;

        // ---------------------------------------------------------------------

        foreach ( $attachment_ids_owned_by_attachment_basename as $this_attachment_basename => $this_attachment_id ) {

            // =================================================================
            // Get the WordPress Media Library image's filespec...
            // =================================================================

            $this_attachment_metadata =
                $wordpress_attachment_metadata_by_attachment_id[ $this_attachment_id ]
                ;

            // -----------------------------------------------------------------

            $this_attachment_image_filespec =
                $uploads_root_dirspec .
                '/' .
                $this_attachment_metadata['file']
                ;

            // =================================================================
            // Check that the attachment image file exists (as if not,
            // somethings wrong with our attachment image filespec calculation
            // code)...
            // =================================================================

            if ( ! \is_file( $this_attachment_image_filespec ) ) {

                $safe_relative_pathspec = \htmlentities( $this_attachment_metadata['file'] ) ;

                return <<<EOT
PROBLEM:&nbsp; Attachment image file not found ("{$safe_relative_pathspec}")
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            }

            // =================================================================
            // Compare:-
            //      o   This current WordPress Media Library image
            // with:-
            //      o   The teaser image to be imported.
            //
            // If they're the same, then this shop image has already been
            // imported.
            // =================================================================

            // -----------------------------------------------------------------
            // NOTE!
            // =====
            // Here we (should) have (eg):-
            //
            //      $this_teaser_image = array(
            //          [url]               => http://localhost/plugdev/wp-content/uploads/2014/05/teaser-postcards-from-wonderland.png
            //          [copy_type]         => physical
            //          [width]             => 842
            //          [height]            => 656
            //          [php_imagetype_xxx] => 3
            //          [mime_type]         => image/png
            //          [md5]               => b189026ddb09241db2c2728a448e4f7b
            //          [sha1]              => ca04b73bc84e8ded3ecfb561738927e600c435f4
            //          [filesize]          => 437065
            //          [binary_image_data] => XXX
            //          )
            //
            // -----------------------------------------------------------------

            // =================================================================
            // Skip this attachment image unless it's FILESIZE matches that
            // of the teaser image to be imported...
            // =================================================================

            // -------------------------------------------------------------------------
            // int filesize ( string $filename )
            // - - - - - - - - - - - - - - - - -
            // Gets the size for the given file.
            //
            //      filename
            //          Path to the file.
            //
            // Returns the size of the file in bytes, or FALSE (and generates an error
            // of level E_WARNING) in case of an error.
            //
            // Note:    Because PHP's integer type is signed and many platforms use
            //          32bit integers, some filesystem functions may return unexpected
            //          results for files which are larger than 2GB.
            //
            // (PHP 4, PHP 5)
            //
            // ERRORS/EXCEPTIONS
            //      Upon failure, an E_WARNING is emitted.
            //
            // Notes:   The results of this function are cached. See clearstatcache()
            //          for more details.
            //
            // Tip: As of PHP 5.0.0, this function can also be used with some URL
            //      wrappers. Refer to Supported Protocols and Wrappers to determine
            //      which wrappers support stat() family of functionality.
            // -------------------------------------------------------------------------

            $filesize = \filesize( $this_attachment_image_filespec ) ;

            // -------------------------------------------------------------------------

            if ( $filesize === FALSE ) {

                return <<<EOT
PROBLEM:&nbsp; "filesize()" failure (getting WordPress Media Library image file size)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            }

            // -------------------------------------------------------------------------

            if ( $filesize !== $this_teaser_image['filesize'] ) {
                continue ;
            }

            // =================================================================
            // Skip this attachment image unless it's MD5 checksum matches that
            // of the teaser image to be imported...
            // =================================================================

            // -------------------------------------------------------------------------
            // string md5_file ( string $filename [, bool $raw_output = false ] )
            // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
            // Calculates the MD5 hash of the file specified by the filename parameter
            // using the » RSA Data Security, Inc. MD5 Message-Digest Algorithm, and
            // returns that hash. The hash is a 32-character hexadecimal number.
            //
            //      filename
            //          The filename
            //
            //      raw_output
            //          When TRUE, returns the digest in raw binary format with a length
            //          of 16.
            //
            // Returns a string on success, FALSE otherwise.
            //
            // (PHP 4 >= 4.2.0, PHP 5)
            //
            // CHANGELOG
            //      Version     Description
            //      5.1.0       Changed the function to use the streams API. It means
            //                  that you can use it with wrappers, like
            //                  md5_file('http://example.com/..')
            //      5.0.0       Added the raw_output parameter
            // -------------------------------------------------------------------------

            $attachment_image_md5 = \md5_file( $this_attachment_image_filespec ) ;

            // -------------------------------------------------------------------------

            if ( $attachment_image_md5 === FALSE ) {

                return <<<EOT
PROBLEM:&nbsp; "md5_file()" failure (calculating WordPress Media Library image file checksum)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            }

            // -------------------------------------------------------------------------

            if ( $attachment_image_md5 !== $this_teaser_image['md5'] ) {
                continue ;
            }

            // =================================================================
            // Skip this attachment image unless it's SHA1 checksum matches
            // that of the teaser image to be imported...
            // =================================================================

            // -------------------------------------------------------------------------
            // string sha1_file ( string $filename [, bool $raw_output = false ] )
            // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
            // Calculates the sha1 hash of the file specified by filename using the »
            // US Secure Hash Algorithm 1, and returns that hash. The hash is a
            // 40-character hexadecimal number.
            //
            //      filename
            //          The filename of the file to hash.
            //
            //      raw_output
            //          When TRUE, returns the digest in raw binary format with a length
            //          of 20.
            //
            // Returns a string on success, FALSE otherwise.
            //
            // (PHP 4 >= 4.3.0, PHP 5)
            //
            // CHANGELOG
            //      Version     Description
            //      5.1.0       Changed the function to use the streams API. It means
            //                  that you can use it with wrappers, like
            //                  sha1_file('http://example.com/..')
            //      5.0.0       Added the raw_output parameter
            // -------------------------------------------------------------------------

            $attachment_image_sha1 = \sha1_file( $this_attachment_image_filespec ) ;

            // -------------------------------------------------------------------------

            if ( $attachment_image_sha1 === FALSE ) {

                return <<<EOT
PROBLEM:&nbsp; "sha1_file()" failure (calculating WordPress Media Library image file checksum)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            }

            // -------------------------------------------------------------------------

            if ( $attachment_image_sha1 !== $this_teaser_image['sha1'] ) {
                continue ;
            }

            // =================================================================
            // Skip this attachment image unless it's:-
            //      o   width
            //      o   height
            //      o   IMAGETYPE_XXX
            //      o   mime type
            //
            // matches that of the teaser image to be imported...
            //
            // ---
            //
            // NOTE that we're comparing the attachment image file's:-
            //      o   width, and;
            //      o   height,
            //
            // as described by the "getimagesize()" function (NOT as
            // described by the WordPress attachment "metadata").
            //
            // This eliminates the problems that would arise if the metadata
            // was out of step with the attachment image (for any reason).
            // =================================================================

            // -------------------------------------------------------------------------
            // array getimagesize ( string $filename [, array &$imageinfo ] )
            // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
            // The getimagesize() function will determine the size of any given image
            // file and return the dimensions along with the file type and a
            // height/width text string to be used inside a normal HTML IMG tag and the
            // correspondant HTTP content type.
            //
            // getimagesize() can also return some more information in imageinfo
            // parameter.
            //
            // Note:    Note that JPC and JP2 are capable of having components with
            //          different bit depths. In this case, the value for "bits" is the
            //          highest bit depth encountered. Also, JP2 files may contain
            //          multiple JPEG 2000 codestreams. In this case, getimagesize()
            //          returns the values for the first codestream it encounters in the
            //          root of the file.
            //
            // Note:    The information about icons are retrieved from the icon with the
            //          highest bitrate.
            //
            //      filename
            //          This parameter specifies the file you wish to retrieve
            //          information about. It can reference a local file or
            //          (configuration permitting) a remote file using one of the
            //          supported streams.
            //
            //      imageinfo
            //          This optional parameter allows you to extract some extended
            //          information from the image file. Currently, this will return the
            //          different JPG APP markers as an associative array. Some programs
            //          use these APP markers to embed text information in images. A
            //          very common one is to embed » IPTC information in the APP13
            //          marker. You can use the iptcparse() function to parse the binary
            //          APP13 marker into something readable.
            //
            // Returns an array with up to 7 elements. Not all image types will include
            // the channels and bits elements.
            //
            //      o   Index 0 and 1 contains respectively the width and the height of
            //          the image.
            //
            //          Note:   Some formats may contain no image or may contain
            //                  multiple images. In these cases, getimagesize() might
            //                  not be able to properly determine the image size.
            //                  getimagesize() will return zero for width and height in
            //                  these cases.
            //
            //      o   Index 2 is one of the IMAGETYPE_XXX constants indicating the
            //          type of the image.
            //
            //      o   Index 3 is a text string with the correct height="yyy"
            //          width="xxx" string that can be used directly in an IMG tag.
            //
            //      o   mime is the correspondant MIME type of the image. This
            //          information can be used to deliver images with the correct HTTP
            //          Content-type header
            //
            //      o   channels will be 3 for RGB pictures and 4 for CMYK pictures.
            //
            //      o   bits is the number of bits for each color.
            //
            // For some image types, the presence of channels and bits values can be a
            // bit confusing. As an example, GIF always uses 3 channels per pixel, but
            // the number of bits per pixel cannot be calculated for an animated GIF
            // with a global color table.
            //
            // On failure, FALSE is returned.
            //
            // ERRORS/EXCEPTIONS
            //      If accessing the filename image is impossible getimagesize() will
            //      generate an error of level E_WARNING. On read error, getimagesize()
            //      will generate an error of level E_NOTICE.
            //
            // (PHP 4, PHP 5)
            //
            // CHANGELOG
            //      Version     Description
            //      5.3.0       Added icon support.
            //      5.2.3       Read errors generated by this function downgraded to E_NOTICE from E_WARNING.
            //      4.3.2       Support for JPC, JP2, JPX, JB2, XBM, and WBMP became available.
            //      4.3.2       JPEG 2000 support was added for the imageinfo parameter.
            //      4.3.0       bits and channels are present for other image types, too.
            //      4.3.0       mime was added.
            //      4.3.0       Support for SWC and IFF was added.
            //      4.2.0       Support for TIFF was added.
            //      4.0.6       Support for BMP and PSD was added.
            //      4.0.5       URL support was added.
            // -------------------------------------------------------------------------

            $imagesize = \getimagesize( $this_attachment_image_filespec ) ;

            // -----------------------------------------------------------------

            if ( $imagesize === FALSE ) {

                return <<<EOT
PROBLEM:&nbsp; "getimagesize()" failure (getting WordPress Media Library image data)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            }

            // -----------------------------------------------------------------

            if (    $imagesize[0] !== $this_teaser_image['width']
                    ||
                    $imagesize[1] !== $this_teaser_image['height']
                    ||
                    $imagesize[2] !== $this_teaser_image['php_imagetype_xxx']
                    ||
                    $imagesize['mime'] !== $this_teaser_image['mime_type']
                ) {
                continue ;
            }

            // =================================================================
            // Check that the attachment metadata matches.
            //
            // NOTE!
            // =====
            // This is an "extra".  It's NOT needed by the "import teaser image"
            // function.
            //
            // But just out of interest we check if the (image):-
            //      o   width and;
            //      o   height
            //
            // in the METADATA are the same as they are in the attachment
            // image.
            // =================================================================

            if (    $this_attachment_metadata['width'] !== $imagesize[0]
                    ||
                    $this_attachment_metadata['height'] !== $imagesize[1]
                ) {

                return <<<EOT
PROBLEM:&nbsp; WordPress attachment metadata appears corrupt ("width" and/or "height" don't match those of the attachment image)
Attachment ID:&nbsp; {$this_attachment_id}
Attachment File:&nbsp; {$this_attachment_metadata['height']}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            }

            // =================================================================
            // If we get here, then this IMAGE is ALREADY IMPORTED...
            // =================================================================

            // -----------------------------------------------------------------
            // Update:-
            //      $indices_of_already_imported_teaser_images
            // -----------------------------------------------------------------

            $indices_of_already_imported_teaser_images[] = $this_teaser_image_index ;

            // -----------------------------------------------------------------
            // Update:-
            //      $teaser_image_urls_new_by_old
            // -----------------------------------------------------------------

            $attachment_url = \wp_get_attachment_url( $this_attachment_id ) ;
                                //  Returns a full URI for an attachment file or
                                //  false on failure.

            // -----------------------------------------------------------------

            if ( $attachment_url === FALSE ) {

                return <<<EOT
PROBLEM:&nbsp; "wp_get_attachment_url()" failure (getting WordPress Media Library image URL)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            }

            // -----------------------------------------------------------------

            $teaser_image_urls_new_by_old[ $this_teaser_image['url'] ] =
                $attachment_url
                ;

            // -----------------------------------------------------------------
            // No need to check any more of the WordPress Media Library
            // images with the same basename as the teaser image to be imported.
            // -----------------------------------------------------------------

            break ;

            // -----------------------------------------------------------------

        }

        // =====================================================================
        // Repeat with the next teaser image (if there is one)...
        // =====================================================================

    }

    // =========================================================================
    // IMPORT the IMAGEs to by PHYSICALLY IMPORTED - and that that HAVEN'T
    // yet been imported...
    // =========================================================================

    foreach ( $import_array['teaser_images'] as $this_teaser_image_index => $this_teaser_image ) {

        // ---------------------------------------------------------------------
        // NOTE!
        // =====
        // At this point, it's already been checked that each short image has a
        // non-empty string URL and basename.
        // ---------------------------------------------------------------------

        // =====================================================================
        // Ignore all but the teaser images to be PHYSICALLY imported...
        // =====================================================================

        if ( $this_teaser_image['copy_type'] !== 'physical' ) {
            continue ;
        }

        // --------------------------------------------------------------------
        // NOTE!
        // =====
        // Here we have (eg):-
        //
        //      $this_teaser_image = array(
        //          [url]               => http://localhost/plugdev/wp-content/uploads/2014/05/teaser-postcards-from-wonderland.png
        //          [copy_type]         => physical
        //          [width]             => 842
        //          [height]            => 656
        //          [php_imagetype_xxx] => 3
        //          [mime_type]         => image/png
        //          [md5]               => b189026ddb09241db2c2728a448e4f7b
        //          [sha1]              => ca04b73bc84e8ded3ecfb561738927e600c435f4
        //          [filesize]          => 437065
        //          [binary_image_data] => XXX
        //          )
        //
        // ---------------------------------------------------------------------

        // =====================================================================
        // Skip any teaser images that have already been imported...
        // =====================================================================

        if ( in_array(
                    $this_teaser_image_index                          ,
                    $indices_of_already_imported_teaser_images      ,
                    TRUE
                    )
            ) {
            continue ;
        }

        // =====================================================================
        // Save the teaser image to a temporary file...
        // =====================================================================

        // -------------------------------------------------------------------------
        // string tempnam ( string $dir , string $prefix )
        // - - - - - - - - - - - - - - - - - - - - - - - -
        // Creates a file with a unique filename, with access permission set to
        // 0600, in the specified directory. If the directory does not exist,
        // tempnam() may generate a file in the system's temporary directory, and
        // return the full path to that file, including its name.
        //
        //      dir
        //          The directory where the temporary filename will be created.
        //
        //      prefix
        //          The prefix of the generated temporary filename.
        //
        //          Note: Windows uses only the first three characters of prefix.
        //
        // Returns the new temporary filename (with path), or FALSE on failure.
        //
        // (PHP 4, PHP 5)
        //
        // CHANGELOG
        //      Version     Description
        //      4.0.6       Prior to PHP 4.0.6, the behaviour of the tempnam()
        //                  function was system dependent. On Windows the TMP
        //                  environment variable will override the dir parameter, on
        //                  Linux the TMPDIR environment variable has precedence,
        //                  while SVR4 will always use your dir parameter if the
        //                  directory it points to exists. Consult your system
        //                  documentation on the tempnam(3) function if in doubt.
        //
        //      4.0.3       This function's behavior changed in 4.0.3. The temporary
        //                  file is also created to avoid a race condition where the
        //                  file might appear in the filesystem between the time the
        //                  string was generated and before the script gets around
        //                  to creating the file. Note, that you need to remove the
        //                  file in case you need it no more, it is not done
        //                  automatically.
        // -------------------------------------------------------------------------

        // -------------------------------------------------------------------------
        // string sys_get_temp_dir ( void )
        // - - - - - - - - - - - - - - - -
        // Returns the path of the directory PHP stores temporary files in by
        // default.
        //
        // Returns the path of the temporary directory.
        //
        // (PHP 5 >= 5.2.1)
        //
        // USER CONTRIBUTED NOTES
        //      Anonymous
        //      6 years ago
        //      This function does not always add trailing slash. This behaviour is
        //      inconsistent across systems, so you have keep an eye on it.
        // -------------------------------------------------------------------------

        $teaser_image_temporary_filespec =
            \tempnam( \sys_get_temp_dir() , 'teaser-image' )
            ;

        // ---------------------------------------------------------------------

        if ( $teaser_image_temporary_filespec === FALSE ) {

            return <<<EOT
PROBLEM:&nbsp; "tmpnam()" failure (saving imported teaser image)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

        $number_bytes_written = \file_put_contents(
                                    $teaser_image_temporary_filespec          ,
                                    $this_teaser_image['binary_image_data']
                                    ) ;
                                    //  This function returns the number of
                                    //  bytes that were written to the file, or
                                    //  FALSE on failure.

        // ---------------------------------------------------------------------

        if ( $number_bytes_written === FALSE ) {

            return <<<EOT
PROBLEM:&nbsp; "file_put_contents()" failure (saving temporary imported teaser image)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

        if ( $number_bytes_written !== strlen( $this_teaser_image['binary_image_data'] ) ) {

            return <<<EOT
PROBLEM:&nbsp; Write failure (saving temporary imported teaser image)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;


        }

        // =====================================================================
        // ADD the IMPORTED IMAGE to the WordPress Media Library...
        // =====================================================================

        // -------------------------------------------------------------------------
        // (int/object) media_handle_sideload(
        //                      $file_array  = <none>   ,
        //                      $post_id     = <none>   ,
        //                      $desc        = NULL     ,
        //                      $post_data   = NULL
        //                      )
        // - - - - - - - - - - - - - - - - - - - - - - -
        // Handles a sideloaded file in the same way as an uploaded file is handled
        // by media_handle_upload().
        //
        //      $file_array
        //          (array) (required) Array similar to a $_FILES upload array.
        //          Default: None
        //
        //      $post_id
        //          (int) (required) The post ID the media is associated with.
        //          Default: None
        //
        //      $desc
        //          (string) (optional) Description of the sideloaded file.
        //          Default: null
        //
        //      $post_data
        //          (array) (optional) Allows you to overwrite some of the
        //          attachment.
        //          Default: null
        //
        // RETURN VALUE
        //      (int|object) The ID of the attachment or a WP_Error on failure.
        //
        //
        // CHANGE LOG
        //      Since: 2.6.0
        // -------------------------------------------------------------------------

        if ( ! \function_exists( 'media_handle_sideload' ) ) {
            require_once( ABSPATH . 'wp-admin/includes/image.php' ) ;
            require_once( ABSPATH . 'wp-admin/includes/file.php'  ) ;
            require_once( ABSPATH . 'wp-admin/includes/media.php' ) ;
        }

        // ---------------------------------------------------------------------

        $file_array = array(
                            'name'      =>  basename( $this_teaser_image['url'] )     ,
                            'type'      =>  $this_teaser_image['mime_type']           ,
                            'tmp_name'  =>  $teaser_image_temporary_filespec          ,
                            'error'     =>  0                                       ,
                            'size'      =>  $number_bytes_written
                            ) ;

        // ---------------------------------------------------------------------

        $post_id = 0 ;

        // ---------------------------------------------------------------------

        $new_attachment_id = \media_handle_sideload( $file_array , $post_id ) ;

        // ---------------------------------------------------------------------

    	if ( \is_wp_error( $new_attachment_id ) ) {

    		if ( \is_file( $teaser_image_temporary_filespec ) ) {

    		    @\unlink( $teaser_image_temporary_filespec ) ;
                    //  Returns TRUE on success or FALSE on failure.
                    //  An E_WARNING level error will be generated on failure.

            }

            return $new_attachment_id->get_error_message() ;

    	}

        // =====================================================================
        // Get rid of the temporary teaser image file (if necessary)...
        // =====================================================================

    	if ( \is_file( $teaser_image_temporary_filespec ) ) {

            // -----------------------------------------------------------------

            \ob_start() ;
        	    $ok = \unlink( $teaser_image_temporary_filespec ) ;
            $msg = \ob_get_clean() ;

            // -----------------------------------------------------------------

            if ( $ok !== TRUE ) {
                return $msg ;
            }

            // -----------------------------------------------------------------

        }

        // =====================================================================
        // Update:-
        //      $teaser_image_urls_new_by_old
        // =====================================================================

        $attachment_url = \wp_get_attachment_url( $new_attachment_id ) ;
                            //  Returns a full URI for an attachment file or
                            //  false on failure.

        // -----------------------------------------------------------------

        if ( $attachment_url === FALSE ) {

            return <<<EOT
PROBLEM:&nbsp; "wp_get_attachment_url()" failure (getting WordPress Media Library image URL)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // -----------------------------------------------------------------

        $teaser_image_urls_new_by_old[ $this_teaser_image['url'] ] =
            $attachment_url
            ;

        // =====================================================================
        // Repeat with the next teaser image (to be physically imported - if
        // there is one)...
        // =====================================================================

    }

    // =========================================================================
    // SUCCESS
    // =========================================================================

    return $teaser_image_urls_new_by_old ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// That's that!
// =============================================================================

