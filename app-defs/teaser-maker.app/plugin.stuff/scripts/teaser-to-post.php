<?php

// *****************************************************************************
// TEASER-MAKER.APP / PLUGIN.STUFF / SCRIPTS / TEASER-TO-POST.PHP
// (C) 2014 Peter Newman. All Rights Reserved.
// *****************************************************************************

    namespace greatKiwi_byFernTec_teaserMaker_std_v0x1x114_teaserMaker ;

// =============================================================================
// teaser_to_post()
// =============================================================================

function teaser_to_post(
    $caller_app_slash_plugins_global_namespace      ,
    $dataset_manager_home_page_title                ,
    $caller_plugins_includes_dir                    ,
    $all_application_dataset_definitions            ,
    $dataset_slug                                   ,
    $question_front_end
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_teaserMaker\teaser_to_post(
    //      $caller_app_slash_plugins_global_namespace      ,
    //      $dataset_manager_home_page_title                ,
    //      $caller_plugins_includes_dir                    ,
    //      $all_application_dataset_definitions            ,
    //      $dataset_slug                                   ,
    //      $question_front_end
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Displays the (WordPress) post editing page for the post belonging to
    // the specified teaser (creating that post first, if it doesn't already
    // exist).
    //
    // The teaser whose post is required is that specified by:-
    //      $_GET['record_key']
    //
    // NOTE!
    // =====
    // Actually, this routine returns some HTML that's either:-
    //
    //      o   An error message string (if an error occurs), or;
    //
    //      o   Some Javascript that redirects to the required post
    //          editing page.
    //
    // RETURNS:
    //      $page_html STRING
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $_GET = Array(
    //                  [page]          => teaserMaker
    //                  [action]        => custom
    //                  [action_slug]   => post-teaser
    //                  [application]   => teaser-maker
    //                  [dataset_slug]  => teasers
    //                  [record_key]    => 5310417c6e7cd
    //                  )
    //
    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $_GET ) ;

    // =========================================================================
    // Get the PAGE CONTENT PROPER...
    // =========================================================================

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_teaserMaker\teaser_to_post_proper(
    //      $caller_app_slash_plugins_global_namespace      ,
    //      $dataset_manager_home_page_title                ,
    //      $caller_plugins_includes_dir                    ,
    //      $all_application_dataset_definitions            ,
    //      $dataset_slug                                   ,
    //      $question_front_end
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // RETURNS
    //      ARRAY(
    //          $plugin_title       STRING      ,
    //          $main_page_content  STRING      ,
    //          $support_javascript STRING
    //          )
    //
    // NOTE!
    // =====
    // The $main_page_content returned may be the page requested proper.  Or it
    // may be just an error message.
    // -------------------------------------------------------------------------

    list(   $teaser_title           ,
            $teaser_summary         ,
            $main_page_content      ,
            $support_javascript
            ) = teaser_to_post_proper(
                    $caller_app_slash_plugins_global_namespace      ,
                    $dataset_manager_home_page_title                ,
                    $caller_plugins_includes_dir                    ,
                    $all_application_dataset_definitions            ,
                    $dataset_slug                                   ,
                    $question_front_end
                    ) ;

    // =========================================================================
    // DISPLAY the PAGE...
    // =========================================================================

    $page_title = 'Post Teaser' ;

    $page_header = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\get_page_header(
                        $page_title                     ,
                        $caller_plugins_includes_dir    ,
                        $question_front_end
                        ) ;

    // -------------------------------------------------------------------------

    return <<<EOT
<div style="width:98%">
    {$page_header}
    <div style="background-color:#D6ECF6; padding:0.33em 1em">
        <h3 style="margin:0"><span style="color:#333333">Teaser:</span>&nbsp; {$teaser_title}</h3>
        {$teaser_summary}
    </div>
    <div style="height:1.5em"></div>
    {$main_page_content}
</div>
{$support_javascript}
<br />
<br />
EOT;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// teaser_to_post_proper()
// =============================================================================

function teaser_to_post_proper(
    $caller_app_slash_plugins_global_namespace      ,
    $dataset_manager_home_page_title                ,
    $caller_plugins_includes_dir                    ,
    $all_application_dataset_definitions            ,
    $dataset_slug                                   ,
    $question_front_end
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_teaserMaker\teaser_to_post_proper(
    //      $caller_app_slash_plugins_global_namespace      ,
    //      $dataset_manager_home_page_title                ,
    //      $caller_plugins_includes_dir                    ,
    //      $all_application_dataset_definitions            ,
    //      $dataset_slug                                   ,
    //      $question_front_end
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // RETURNS
    //      ARRAY(
    //          $plugin_title       STRING      ,
    //          $plugin_summary     STRING      ,
    //          $main_page_content  STRING      ,
    //          $support_javascript STRING
    //          )
    //
    // NOTE!
    // =====
    // The $main_page_content returned may be the page requested proper.  Or it
    // may be just an error message.
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $_GET = Array(
    //                  [page]          => teaserMaker
    //                  [action]        => custom
    //                  [action_slug]   => post-teaser
    //                  [application]   => teaser-maker
    //                  [dataset_slug]  => teasers
    //                  [record_key]    => 5310417c6e7cd
    //                  )
    //
    // NOTE!
    // =====
    // Of the above $_GET variables, only:-
    //      o   "page",
    //      o   "application", and;
    //      o   "dataset_slug"
    //
    // have been verified.
    // -------------------------------------------------------------------------

//\greatKiwi_standardDatasetManager\pr( $_GET ) ;

    // =========================================================================
    // DEFAULT the OUTPUT VARIABLES...
    // =========================================================================

    $teaser_title       = '&lt;Unknown&gt;' ;
    $teaser_summary     = '' ;
    $main_page_content  = '' ;
    $support_javascript = '' ;

    // =========================================================================
    // ERROR CHECKING...
    // =========================================================================

    // -------------------------------------------------------------------------
    // $_POST ?
    // -------------------------------------------------------------------------

//\greatKiwi_standardDatasetManager\pr( $_POST ) ;

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $_POST ) ;

//  if (    count( $_POST ) === 1
//          &&
//          isset( $_POST['submit'] )
//          &&
//          $_POST['submit'] === 'Export'
//      ) {
//      $list_or_export = 'export' ;
//
//  } else {
//      $list_or_export = 'list' ;
//
//  }

    // -------------------------------------------------------------------------
    // $dataset_slug = $_GET['dataset_slug'] = plugins ?
    // -------------------------------------------------------------------------

    if ( $_GET['dataset_slug'] !== 'teasers' ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Bad "dataset_slug" (1)
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_teaserMaker\\teaser_to_post_proper()
EOT;

        return array(
                    $teaser_title           ,
                    $teaser_summary         ,
                    nl2br( $msg )           ,
                    $support_javascript
                    ) ;

    }

    // -------------------------------------------------------------------------

    if ( $dataset_slug !== 'teasers' ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Bad "dataset_slug" (2)
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_teaserMaker\\teaser_to_post_proper()
EOT;

        return array(
                    $teaser_title           ,
                    $teaser_summary         ,
                    nl2br( $msg )           ,
                    $support_javascript
                    ) ;

    }

    // -------------------------------------------------------------------------
    // record_key ?
    // -------------------------------------------------------------------------

    if ( ! isset( $_GET['record_key'] ) ) {

        $msg = <<<EOT
PROBLEM:&nbsp; No "record_key"
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_teaserMaker\\teaser_to_post_proper()
EOT;

        return array(
                    $teaser_title           ,
                    $teaser_summary         ,
                    nl2br( $msg )           ,
                    $support_javascript
                    ) ;

    }

    // -------------------------------------------------------------------------

    if (    ! is_string( $_GET['record_key'] )
            ||
            trim( $_GET['record_key'] ) === ''
            ||
            strlen( $_GET['record_key'] ) > 32
            ||
            ! ctype_alnum( $_GET['record_key'] )
        ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Bad "record_key" (1 to 32 character alphanumeric string expected)
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_teaserMaker\\teaser_to_post_proper()
EOT;

        return array(
                    $teaser_title           ,
                    $teaser_summary         ,
                    nl2br( $msg )           ,
                    $support_javascript
                    ) ;

    }

    // =========================================================================
    // LOAD the PLUGINS (from ARRAY STORAGE)...
    // =========================================================================

    require_once( $caller_plugins_includes_dir . '/array-storage.php' ) ;

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_arrayStorage\load_numerically_indexed(
    //      $dataset_name                       ,
    //      $question_die_on_error = FALSE
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Loads and returns the specified PHP numerically indexed array.
    //
    // RETURNS
    //      o   On SUCCESS
    //          - - - - -
    //          ARRAY $array
    //          A possibly empty PHP numerically indexed ARRAY.
    //
    //      o   On FAILURE
    //          - - - - -
    //          $error_message STRING
    // -------------------------------------------------------------------------

    $question_die_on_error = TRUE ;

    $teaser_records = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_arrayStorage\load_numerically_indexed(
                            $dataset_slug               ,
                            $question_die_on_error
                            ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $teaser_records ) ) {

        return array(
                    $teaser_title               ,
                    $teaser_summary             ,
                    nl2br( $teaser_records )    ,
                    $support_javascript
                    ) ;

    }

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $teaser_records = Array(
    //
    //          [0] => Array(
    //                      [created_server_micro_datetime_UTC]         => 1392000580.5055
    //                      [last_modified_server_micro_datetime_UTC]   => 1392095033
    //                      [key]                                       => 52f83e447b74b
    //                      [slug]                                      => terwtert
    //                      [title]                                     => erwtwretw
    //                      [camelName]                                 => werter
    //                      [description]                               => wertr
    //                      [version]                                   => wertwe
    //                      )
    //
    //          [1] => Array(
    //                      [created_server_micro_datetime_UTC]         => 1392006683.3767
    //                      [last_modified_server_micro_datetime_UTC]   => 1392006683
    //                      [key]                                       => 52f8561b5c068
    //                      [slug]                                      => fghsfghfg
    //                      [title]                                     =>
    //                      [camelName]                                 =>
    //                      [description]                               =>
    //                      [version]                                   => sfhfgshg
    //                      )
    //
    //          )
    //
    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $teaser_records ) ;

    // =========================================================================
    // Get the specified dataset's DATASET MANAGER DATASET DEFINITION...
    // =========================================================================

    $selected_datasets_dmdd = $all_application_dataset_definitions[ $dataset_slug ] ;
        //  dmdd = Dataset Manager Dataset Definition

    // =========================================================================
    // GET the DATASET's TITLE...
    // =========================================================================

    // -------------------------------------------------------------------------
    // \greatKiwi_standardDatasetManager\get_dataset_title(
    //      $selected_datasets_dmdd     ,
    //      $dataset_slug
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - -
    // RETURNS
    //      o   On SUCCESS!
    //          - - - - - -
    //          $dataset_title STRING
    //
    //      o   On FAILURE!
    //          - - - - - -
    //          array( $error_message STRING )
    // -------------------------------------------------------------------------

    $dataset_title = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\get_dataset_title(
                        $selected_datasets_dmdd     ,
                        $dataset_slug
                        ) ;

    // -------------------------------------------------------------------------

    if ( is_array( $dataset_title ) ) {

        return array(
                    $teaser_title                   ,
                    $teaser_summary                 ,
                    nl2br( $dataset_title[0] )      ,
                    $support_javascript
                    ) ;

    }

    // =========================================================================
    // GET/CHECK the dataset records KEY FIELD SLUG...
    // =========================================================================

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\get_dataset_key_field_slug(
    //      $all_application_dataset_definitions    ,
    //      $dataset_slug
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Returns the dataset's (array storage) key field slug.
    //
    // RETURNS
    //      o   $array_storage_key_field_slug STRING on SUCCESS
    //      o   array( $error_message STRING ) on FAILURE
    // -------------------------------------------------------------------------

    $key_field_slug = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\get_dataset_key_field_slug(
                        $all_application_dataset_definitions    ,
                        $dataset_slug
                        ) ;

    // -------------------------------------------------------------------------

    if ( is_array( $key_field_slug ) ) {

        return array(
                    $teaser_title                   ,
                    $teaser_summary                 ,
                    nl2br( $key_field_slug[0] )     ,
                    $support_javascript
                    ) ;

    }

    // =========================================================================
    // GET the DATASET's RECORD INDICES BY KEY...
    // =========================================================================

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\get_dataset_record_indices_by_key(
    //      $dataset_title      ,
    //      $dataset_records    ,
    //      $key_field_slug
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // RETURNS:-
    //      o   (array) $record_indices_by_key on SUCCESS
    //      o   (string) $error_message on FAILURE
    // -------------------------------------------------------------------------

    $record_indices_by_key = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\get_dataset_record_indices_by_key(
                                $dataset_title      ,
                                $teaser_records     ,
                                $key_field_slug
                                ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $record_indices_by_key ) ) {

        return array(
                    $teaser_title                       ,
                    $teaser_summary                     ,
                    nl2br( $record_indices_by_key )     ,
                    $support_javascript
                    ) ;

    }

    // =========================================================================
    // GET the SPECIFIED TEASER's DETAILS...
    // =========================================================================

    if ( ! array_key_exists(
                $_GET['record_key']         ,
                $record_indices_by_key
                )
        ) {

        // ---------------------------------------------------------------------

        $msg = <<<EOT
PROBLEM:&nbsp; Bad "record_key" (no such teaser)
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_teaserMaker\\teaser_to_post_proper()
EOT;

        return array(
                    $teaser_title           ,
                    $teaser_summary         ,
                    nl2br( $msg )           ,
                    $support_javascript
                    ) ;

        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------

    $teaser_details = $teaser_records[
                            $record_indices_by_key[ $_GET['record_key'] ]
                            ] ;

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $teaser_details = Array(
    //          [created_server_datetime_UTC]       => 1393662310
    //          [last_modified_server_datetime_UTC] => 1393662381
    //          [key]                               => 53119966a9a2e
    //          [original_url]                      => http://nz2.php.net/file_upload
    //          [original_title]                    => Handling file uploads
    //          [original_clipped_text]             => "xxx"
    //          [original_media_url]                =>
    //          [post_id]                           => 0
    //          )
    //
    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $teaser_details ) ;

    // =========================================================================
    // Does the TEASER'S POST ALREADY EXIST ?
    //
    // If so, OPEN IT'S EDITING SCREEN (in a new window/tab)...
    // =========================================================================

    if (    trim( $teaser_details['post_id'] ) !== ''
            &&
            \ctype_digit( (string) $teaser_details['post_id'] )
            &&
            $teaser_details['post_id'] > 0
        ) {

        // -------------------------------------------------------------------------
        // get_edit_post_link( $id, $context )
        // - - - - - - - - - - - - - - - - - -
        // Returns edit post url as string value, provided the current user has the
        // 'edit_post' capability. To retrieve a URL without checking user
        // capabilities use admin_url() instead.
        //
        // Can be used within the WordPress loop or outside of it. Can be used with
        // pages, posts, attachments, and revisions.
        //
        //      id
        //          (integer) (optional) The post ID
        //
        //          Default: None
        //
        //      context
        //          (string) (optional) How to write ampersands. Defaults to
        //          'display' which will encode as '&amp;'. Passing any other string
        //          (including an empty string), will encode ampersands as '&'.
        //
        //          Default: 'display'
        //
        // RETURNS
        //      admin_url() (string)
        //          admin_url() to edit the post or post_type.
        //
        // CHANGELOG
        //      Since: 2.3.0
        // -------------------------------------------------------------------------

        $context = '' ;

        // ---------------------------------------------------------------------

        $url = \get_edit_post_link(
                    $teaser_details['post_id']      ,
                    $context
                    ) ;

        // ---------------------------------------------------------------------

        $main_page_content = <<<EOT
<script type="text/javascript">
    location.href = '{$url}' ;
</script>
EOT;

        // ---------------------------------------------------------------------

        return array(
                    $teaser_title           ,
                    $teaser_summary         ,
                    $main_page_content      ,
                    $support_javascript
                    ) ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // GET the TEASER TITLE...
    // =========================================================================

    if (    isset( $teaser_details['original_title'] )
            &&
            is_string( $teaser_details['original_title'] )
            &&
            trim( $teaser_details['original_title'] ) !== ''
        ) {

        $teaser_title = $teaser_details['original_title'] ;

//  } elseif (  isset( $teaser_details['slug'] )
//              &&
//              is_string( $teaser_details['slug'] )
//              &&
//              trim( $teaser_details['slug'] ) !== ''
//      ) {
//
//      $teaser_title = to_title( $teaser_details['slug'] ) ;

    }

    // =========================================================================
    // Create the TEASER SUMMARY...
    // =========================================================================

    $teaser_summary = '' ;

    // -------------------------------------------------------------------------

    $teaser_summary .= <<<EOT
<tr>
    <td align="right">created</td>
    <td>:&nbsp;&nbsp;</td>
    <td><b>{$teaser_details['created_server_datetime_UTC']}</b></td>
</tr>\n
EOT;

    // -------------------------------------------------------------------------

    $teaser_summary .= <<<EOT
<tr>
    <td align="right">last&nbsp;modified</td>
    <td>:&nbsp;&nbsp;</td>
    <td><b>{$teaser_details['last_modified_server_datetime_UTC']}</b></td>
</tr>\n
EOT;

    // -------------------------------------------------------------------------

    $teaser_summary .= <<<EOT
<tr>
    <td align="right">url</td>
    <td>:&nbsp;&nbsp;</td>
    <td><b>{$teaser_details['original_url']}</b></td>
</tr>\n
EOT;

    // -------------------------------------------------------------------------

    $teaser_summary .= <<<EOT
<tr>
    <td align="right">clipping</td>
    <td>:&nbsp;&nbsp;</td>
    <td><pre style="margin:0; background-color:#F0F8FF; padding:0.33em 1em">{$teaser_details['original_clipped_text']}</pre></td>
</tr>\n
EOT;

    // -------------------------------------------------------------------------

    $teaser_summary .= <<<EOT
<tr>
    <td align="right">media&nbsp;url</td>
    <td>:&nbsp;&nbsp;</td>
    <td><b>{$teaser_details['original_media_url']}</b></td>
</tr>\n
EOT;

    // -------------------------------------------------------------------------

    $teaser_summary .= <<<EOT
<tr>
    <td align="right">post&nbsp;ID</td>
    <td>:&nbsp;&nbsp;</td>
    <td><b>{$teaser_details['post_id']}</b></td>
</tr>\n
EOT;

    // -------------------------------------------------------------------------

    $teaser_summary = <<<EOT
<div style="padding-left:3em">
    <table border="0" cellpadding="0" cellspacing="0">
        {$teaser_summary}
    </table>
</div>
EOT;

    // =========================================================================
    // CREATE a NEW POST for the teaser...
    // =========================================================================

    // -------------------------------------------------------------------------
    // wp_insert_post( $post, $wp_error )
    // - - - - - - - - - - - - - - - - -
    // This function inserts posts (and pages) in the database. It sanitizes
    // variables, does some checks, fills in missing variables like date/time,
    // etc. It takes an array as its argument and returns the post ID of the
    // created post (or 0 if there is an error).
    //
    //      $post
    //          (array) (required) An array representing the elements that make
    //          up a post. There is a one-to-one relationship between these
    //          elements and the names of columns in the wp_posts table in the
    //          database.
    //
    //          Default: None
    //
    //          IMPORTANT: Setting a value for $post['ID'] WILL NOT create a
    //          post with that ID number. Setting this value will cause the
    //          function to update the post with that ID number with the other
    //          values specified in $post. In short, to insert a new post,
    //          $post['ID'] must be blank or not set at all.
    //
    //          The contents of the post array can depend on how much (or
    //          little) you want to trust the defaults. Here is a list with a
    //          short description of all the keys you can set for a post:
    //
    //              $post = array(
    //
    //                  'ID'                    => [ <post id> ]
    //                      // Are you updating an existing post?
    //
    //                  'post_content'          => [ <string> ]
    //                      // The full text of the post.
    //
    //                  'post_name'             => [ <string> ]
    //                      // The name (slug) for your post
    //
    //                  'post_title'            => [ <string> ]
    //                      // The title of your post.
    //
    //                  'post_status'           => [ 'draft' | 'publish' |
    //                                               'pending'| 'future' |
    //                                               'private' | custom
    //                                               registered status ]
    //                      // Default 'draft'.
    //
    //                  'post_type'             => [ 'post' | 'page' | 'link' |
    //                                               'nav_menu_item' | custom
    //                                               post type ]
    //                      // Default 'post'.
    //
    //                  'post_author'           => [ <user ID> ]
    //                      // The user ID number of the author. Default is the
    //                      // current user ID.
    //
    //                  'ping_status'           => [ 'closed' | 'open' ]
    //                      // Pingbacks or trackbacks allowed. Default is the
    //                      // option 'default_ping_status'.
    //
    //                  'post_parent'           => [ <post ID> ]
    //                      // Sets the parent of the new post, if any. Default
    //                      // 0.
    //
    //                  'menu_order'            => [ <order> ]
    //                      // If new post is a page, sets the order in which it
    //                      // should appear in supported menus. Default 0.
    //
    //                  'to_ping'               =>
    //                      // Space or carriage return-separated list of URLs
    //                      // to ping. Default empty string.
    //
    //                  'pinged'                =>
    //                      // Space or carriage return-separated list of URLs
    //                      // that have been pinged. Default empty string.
    //
    //                  'post_password'         => [ <string> ]
    //                      // Password for post, if any. Default empty string.
    //
    //                  'guid'                  =>
    //                      // Skip this and let Wordpress handle it, usually.
    //
    //                  'post_content_filtered' =>
    //                      // Skip this and let Wordpress handle it, usually.
    //
    //                  'post_excerpt'          => [ <string> ]
    //                      // For all your post excerpt needs.
    //
    //                  'post_date'             => [ Y-m-d H:i:s ]
    //                      // The time post was made.
    //
    //                  'post_date_gmt'         => [ Y-m-d H:i:s ]
    //                      // The time post was made, in GMT.
    //
    //                  'comment_status'        => [ 'closed' | 'open' ]
    //                      // Default is the option 'default_comment_status',
    //                      // or 'closed'.
    //
    //                  'post_category'         => [ array(<category id>, ...) ]
    //                      // Default empty.
    //
    //                  'tags_input'            => [ '<tag>, <tag>, ...' | array ]
    //                      // Default empty.
    //
    //                  'tax_input'             => [ array( <taxonomy> => <array
    //                                               | string> ) ]
    //                      // For custom taxonomies. Default empty.
    //
    //                  'page_template'         => [ <string> ]
    //                      // Default empty.
    //
    //                  )
    //
    //          NOTES
    //
    //              'post_status':  If providing a post_status of 'future' you
    //                              must specify the post_date in order for
    //                              WordPress to know when to publish your post.
    //                              See also Post Status Transitions.
    //
    //              'post_category':    Equivalent to calling
    //                                  wp_set_post_categories().
    //
    //              'tags_input':   Equivalent to calling wp_set_post_tags().
    //
    //              'tax_input':    Equivalent to calling wp_set_post_terms()
    //                              for each custom taxonomy in the array. If
    //                              the current user doesn't have the capability
    //                              to work a taxonomy, the you must use
    //                              wp_set_object_terms() instead.
    //
    //              'page_template':    If post_type is 'page', will attempt to
    //                                  set the page template. On failure, the
    //                                  function will return either a WP_Error
    //                                  or 0, and stop before the final actions
    //                                  are called. Otherwise, equivalent to
    //                                  calling update_post_meta() with a key of
    //                                  '_wp_page_template'.
    //
    //      $wp_error
    //          (bool) (optional) Allow return of WP_Error object on failure
    //
    //          Default: false
    //
    // RETURNS
    //      The ID of the post if the post is successfully added to the
    //      database. On failure, it returns 0 if $wp_error is set to false, or
    //      a WP_Error object if $wp_error is set to true.
    //
    // SECURITY
    //      wp_insert_post() passes data through sanitize_post(), which itself
    //      handles all necessary sanitization and validation (kses, etc.).
    //
    //      As such, you don't need to worry about that.
    //
    //      You may wish, however, to remove HTML, JavaScript, and PHP tags from
    //      the post_title and any other fields. Surprisingly, WordPress does
    //      not do this automatically. This can be easily done by using the
    //      wp_strip_all_tags() function (as of 2.9) and is especially useful
    //      when building front-end post submission forms.  Eg:-
    //
    //      // Create post object
    //          $my_post = array(
    //              'post_title'    => wp_strip_all_tags( $_POST['post_title'] ),
    //              'post_content'  => $_POST['post_content'],
    //              'post_status'   => 'publish',
    //              'post_author'   => 1,
    //              'post_category' => array( 8,39 )
    //              )
    //
    // CHANGE LOG
    //      Since: 1.0
    //
    // RELATED
    //      wp_update_post(), wp_delete_post(), wp_publish_post(),
    //      wp_delete_attachment(), wp_get_attachment_url(),
    //      wp_insert_attachment(), wp_insert_post_data()
    // -------------------------------------------------------------------------

    $post_content = $teaser_details['original_clipped_text'] ;

    $post_title   = $teaser_details['original_title'] ;

    // -------------------------------------------------------------------------

    $post_data = array(
                'post_content'      => $post_content        ,
                'post_title'        => $post_title          ,
                'post_status'       => 'draft'              ,
                'post_type'         => 'post'               ,
                'post_parent'       => 0                    ,
                'post_excerpt'      => $post_content        ,
                'post_category'     => array()
                ) ;

    // -------------------------------------------------------------------------

    $wp_error = FALSE ;

    // -------------------------------------------------------------------------

    $post_id = wp_insert_post( $post_data, $wp_error ) ;
                    // Returns the ID of the post if the post is successfully
                    // added to the database. On failure, it returns 0 if
                    // $wp_error is set to false, or a WP_Error object if
                    // $wp_error is set to true.

    // -------------------------------------------------------------------------

    if ( $post_id === 0 ) {

        $msg = <<<EOT
PROBLEM:&nbsp; "wp_insert_post()" failure (creating post for teaser)
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_teaserMaker\\teaser_to_post_proper()
EOT;

        return array(
                    $teaser_title           ,
                    $teaser_summary         ,
                    nl2br( $msg )           ,
                    $support_javascript
                    ) ;

    }

    // =========================================================================
    // SAVE the teaser's POST ID...
    // =========================================================================

    $teaser_details['post_id'] = $post_id ;

    // -------------------------------------------------------------------------

    $teaser_records[ $record_indices_by_key[ $_GET['record_key'] ] ] =
        $teaser_details
        ;

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_arrayStorage\save_numerically_indexed(
    //      $dataset_name                       ,
    //      $array_to_save                      ,
    //      $question_die_on_error = FALSE
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - -
    // Saves the specified numerically-indexed PHP array.
    //
    // RETURNS
    //      o   On SUCCESS
    //          - - - - -
    //          TRUE
    //
    //      o   On FAILURE
    //          - - - - -
    //          $error message STRING
    // -------------------------------------------------------------------------

    $question_die_on_error = FALSE ;

    // -------------------------------------------------------------------------

    $result = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_arrayStorage\save_numerically_indexed(
                    $dataset_slug               ,
                    $teaser_records             ,
                    $question_die_on_error
                    ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $result ) ) {

        return array(
                    $teaser_title           ,
                    $teaser_summary         ,
                    nl2br( $result )        ,
                    $support_javascript
                    ) ;

    }

    // =========================================================================
    // OPEN the new post's EDITING SCREEN (in a new window/tab)...
    // =========================================================================

    if (    trim( $teaser_details['post_id'] ) !== ''
            &&
            \ctype_digit( (string) $teaser_details['post_id'] )
            &&
            $teaser_details['post_id'] > 0
        ) {

        // -------------------------------------------------------------------------
        // get_edit_post_link( $id, $context )
        // - - - - - - - - - - - - - - - - - -
        // Returns edit post url as string value, provided the current user has the
        // 'edit_post' capability. To retrieve a URL without checking user
        // capabilities use admin_url() instead.
        //
        // Can be used within the WordPress loop or outside of it. Can be used with
        // pages, posts, attachments, and revisions.
        //
        //      id
        //          (integer) (optional) The post ID
        //
        //          Default: None
        //
        //      context
        //          (string) (optional) How to write ampersands. Defaults to
        //          'display' which will encode as '&amp;'. Passing any other string
        //          (including an empty string), will encode ampersands as '&'.
        //
        //          Default: 'display'
        //
        // RETURNS
        //      admin_url() (string)
        //          admin_url() to edit the post or post_type.
        //
        // CHANGELOG
        //      Since: 2.3.0
        // -------------------------------------------------------------------------

        $context = '' ;

        // ---------------------------------------------------------------------

        $url = \get_edit_post_link(
                    $teaser_details['post_id']      ,
                    $context
                    ) ;

        // ---------------------------------------------------------------------

        $main_page_content = <<<EOT
<script type="text/javascript">
    location.href = '{$url}' ;
</script>
EOT;

        // ---------------------------------------------------------------------

        return array(
                    $teaser_title           ,
                    $teaser_summary         ,
                    $main_page_content      ,
                    $support_javascript
                    ) ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // That's that!
    // =========================================================================

}

//  FROM TWENTY-TWELVE
//  (with image = Featured Image)
//  =============================

/*
<article id="post-128" class="post-128 post type-post status-publish format-standard hentry category-uncategorized instock">
	<header class="entry-header">
				<div class="entry-thumbnail">
			<img width="225" height="225" src="http://localhost/plugdev/wp-content/uploads/2013/09/orange-jacket.jpeg" class="attachment-post-thumbnail wp-post-image" alt="Orange Jacket" />		</div>

				<h1 class="entry-title">
			<a href="http://localhost/plugdev/?p=128" rel="bookmark">Handling file uploads</a>
		</h1>

		<div class="entry-meta">
			<span class="date"><a href="http://localhost/plugdev/?p=128" title="Permalink to Handling file uploads" rel="bookmark"><time class="entry-date" datetime="2014-03-03T12:17:50+00:00">March 3, 2014</time></a></span><span class="categories-links"><a href="http://localhost/plugdev/?cat=1" title="View all posts in Uncategorized" rel="category">Uncategorized</a></span><span class="author vcard"><a class="url fn n" href="http://localhost/plugdev/?author=1" title="View all posts by petern" rel="author">petern</a></span>			<span class="edit-link"><a class="post-edit-link" href="http://localhost/plugdev/wp-admin/post.php?post=128&amp;action=edit" title="Edit Post">Edit</a></span>		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

		<div class="entry-content">
		<p>The official (multi-page) tutorial, on the PHP site.</p>
<p>Table of Contents<br />
==========<br />
o    POST method uploads<br />
o    Error Messages Explained<br />
o    Common Pitfalls<br />
o    Uploading multiple files<br />
o    PUT method support</p>
			</div><!-- .entry-content -->

	<footer class="entry-meta">

			</footer><!-- .entry-meta -->
</article><!-- #post -->
*/


//  FROM MERMAID CHAPEL
//  ===================

/*
	<div class="post-178 post type-post status-draft format-standard hentry category-film" id="post-178">
			<h2><span style="font-size:115%">&#8220;She was a poet on a street corner trying to recite to a crowd pulling at her clothes.&#8221;</span></h2>

			<div class="entry">
				<p style="text-align: center;"><a href="http://www.mermaidchapel.com/wp-content/uploads/2014/03/marilynfragments.jpg"><img class="alignnone size-full wp-image-189" alt="marilynfragments" src="http://www.mermaidchapel.com/wp-content/uploads/2014/03/marilynfragments.jpg" width="500" height="661" /></a></p>
<p style="text-align: center;">Marilyn Monroe wrote poemlike texts or fragments on loose-leaf paper and in notebooks. One such entry was as follows:</p>
<p style="text-align: center;"><em>Oh damn I wish that I were</em><br />
<em> dead-absolutely nonexistent-</em><br />
<em> gone away from here-from</em><br />
<em> everywhere. But how would I <del datetime="2014-03-02T01:47:37+00:00">do it</del></em><br />
<em> There is always bridges-the Brooklyn</em><br />
<em> bridge<del datetime="2014-03-02T01:47:37+00:00">-no not the Brooklyn Bridge<br />
because</del> But I love that bridge (everything is beautiful from there</em><br />
<em> and the air is so clean) walking it seems</em><br />
<em> peaceful <del datetime="2014-03-02T01:47:37+00:00">there</del> even with all those</em><br />
<em> cars going crazy underneath. So</em><br />
<em> it would have to be some other bridge</em><br />
<em> an ugly one with no view-except</em><br />
<em> I <del datetime="2014-03-02T01:47:37+00:00">particularly</del> like in particular all bridges-there&#8217;s some-</em><br />
<em> thing about them and besides <del datetime="2014-03-02T01:47:37+00:00">these</del> I&#8217;ve</em><br />
<em> never seen an ugly bridge.</em></p>
<p style="text-align: center;">&#8220;To have survived, she would have had to be either more cynical or even further from reality than she was. Instead, she was a poet on a street corner trying to recite to a crowd pulling at her clothes.&#8221; &#8211; <strong>Arthur Miller</strong></p>


				<p class="postmetadata alt">
					<small>
						This entry was posted
												on Monday, March 3rd, 2014 at 12:55 am						and is filed under <a href="http://www.mermaidchapel.com/category/film/" title="View all posts in Film" rel="category tag">Film</a>.
						You can follow any responses to this entry through the <a href='http://www.mermaidchapel.com/?p=178/feed/'>RSS 2.0</a> feed.

													Both comments and pings are currently closed.

						<a class="post-edit-link" href="http://www.mermaidchapel.com/wp-admin/post.php?post=178&amp;action=edit">Edit this entry</a>.
					</small>
				</p>

			</div>
		</div>
*/


















// -----------------------------------------------------------------------------
// -----------------------------------------------------------------------------
// -----------------------------------------------------------------------------
// -----------------------------------------------------------------------------

    // =========================================================================
    // SKIP the teasers that AREN'T to be exported...
    // =========================================================================

/*
    if ( $teaser_details['slug'] === 'teaser_exporter' ) {

        $msg = <<<EOT
<br />
<b>Sorry, but this teaser CAN'T be EXPORTED (it's a Plugin Maker internal teaser)</b>
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_teaserMaker\\teaser_to_post_proper()

<a href="javascript:history.back()" style="text-decoration:none"><b>OK</b></a>
EOT;

        return array(
                    $teaser_title           ,
                    $teaser_summary         ,
                    nl2br( $msg )           ,
                    $support_javascript
                    ) ;

    }
*/

    // =========================================================================
    // Create the PLUGIN BASENAME...
    // =========================================================================

    // -------------------------------------------------------------------------
    // NOTE!
    // =====
    // The "teaser basename" provides:-
    //      o   The teaser directory's basename, and;
    //      o   The main teaser file's name (excluding the ".php" extension).
    //
    // We include the teaser version in this basename - so that we can
    // install different versions of the teaser (for comparison purposes,
    // for example).
    // -------------------------------------------------------------------------

/*
    $teaser_basename = trim( $teaser_details['slug'] ) ;

    // -------------------------------------------------------------------------

    $teaser_basename = str_replace( '_' , '-' , $teaser_basename ) ;

    // -------------------------------------------------------------------------

    if (    isset( $teaser_details['version'] )
            &&
            is_string( $teaser_details['version'] )
            &&
            trim( $teaser_details['version'] ) !== ''
        ) {

        // ---------------------------------------------------------------------

        if ( strlen( $teaser_details['version'] ) > 64 ) {

            $msg = <<<EOT
PROBLEM:&nbsp; Plugin "version" too long (1 to 64 characters expected)
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_teaserMaker\\teaser_to_post_proper()
EOT;

            return array(
                        $teaser_title           ,
                        $teaser_summary         ,
                        nl2br( $msg )           ,
                        $support_javascript
                        ) ;

        }

        // ---------------------------------------------------------------------

        $teaser_version = trim( $teaser_details['version'] ) ;

        // ---------------------------------------------------------------------

//      $teaser_version = str_replace( '.' , '-' , $teaser_version ) ;

        // ---------------------------------------------------------------------

        $teaser_basename .= '-v' . $teaser_version ;

        // ---------------------------------------------------------------------

    }
*/

    // =========================================================================
    // CHECK the PLUGIN BASENAME...
    // =========================================================================

/*
    if (    $list_or_export === 'export'
            &&
            $teaser_basename === ''
        ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Empty teaser basename (please give the teaser a "slug" - and optionally a "version" too)
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_teaserMaker\\teaser_to_post_proper()
EOT;

        return array(
                    $teaser_title           ,
                    $teaser_summary         ,
                    nl2br( $msg )           ,
                    $support_javascript
                    ) ;

    }

    // =========================================================================
    // LOAD the PLUGIN MAKER CORE DIRS...
    // =========================================================================

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_appsAPI\get_core_plugapp_dirs(
    //      $path_in_plugin         ,
    //      $app_handle = NULL
    //      )
    // - - - - - - - - - - - - - - - - - -
    // Returns the dirspecs of the main dirs used in a given app.  Ie:-
    //
    //      array(
    //          'plugin_root_dir'                   =>  "xxx"   ,
    //          'plugins_includes_dir'              =>  "xxx"   ,
    //          'plugins_app_defs_dir'              =>  "xxx"   ,
    //          'dataset_manager_includes_dir'      =>  "xxx"   ,   //  (1)
    //          'apps_dot_app_dir'                  =>  "xxx"   ,   //  (2)
    //          'apps_plugin_stuff_dir'             =>  "xxx"   ,   //  (3)
    //          )
    //
    //      (1) This is where most of the "Dataset Manager" includes files
    //          are stored.
    //
    //      (2) If $app_handle === NULL, the returned $apps_dot_app_dir
    //          is NULL too.
    //
    //      (3) If $app_handle === NULL, the returned $apps_plugin_stuff_dir
    //          is NULL too.
    //
    // ---
    //
    // $path_in_plugin should be a file, directory or link path in the
    // plugin (or "app") from which this function is called.  Typically,
    // one uses __FILE__ for this purpose.  Eg:-
    //
    //      \greatKiwi_appsAPI\get_single_app_defs_root_dir( __FILE__ ) ;
    //
    // ---
    //
    // $app_handle should be either:-
    //
    //      o   A single "app slug" - eg; "research-assistant" - as a
    //          STRING.  For which the returned dirspec might be (eg):-
    //
    //              /home/joe/.../plugins/some-plugin/app-defs/research-assistant.app
    //
    // Or:-
    //
    //      o   An array of (nested) app slugs.  Eg:-
    //
    //              array(
    //                  'some-app'          ,
    //                  'child-app'         ,
    //                  'grandchild-app'
    //                  [...]
    //                  )
    //
    //          For which the returned dirspec might be (eg):-
    //
    //              /home/joe/.../plugins/some-plugin/app-defs/some-app.app/child-app.app/grandchild-app.app
    //
    // Exits with an error message if the directory can't be returned (eg;
    // doesn't exist).
    //
    // NOTE!
    // -----
    // These "apps" and "datasets" (etc) are typically defined in a directory
    // tree structure like (eg):-
    //
    //      /plugins/this-plugin/
    //      +-- app-defs/
    //      |   +-- some-app.app/
    //      |   |   +-- child-app.app/
    //      |   |       +-- grandchild-app.app
    //      |   |           +-- etc...
    //      |   +-- another-app.app/
    //      |       +-- ...
    //      +-- includes/
    //      +-- js/
    //      +-- admin/
    //      +-- remote/
    //      +-- ...etc...
    //      +-- this-plugin.php
    //      +-- ...etc...
    //
    // -------------------------------------------------------------------------

    $path_in_plugin = dirname( __FILE__ ) ;

    $plugin_slug_dashed = str_replace( '_' , '-' , $plugin_details['slug'] ) ;

    $app_handle = $plugin_slug_dashed ;

    // -------------------------------------------------------------------------

    $plugin_maker_core_dirs = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_appsAPI\get_core_plugapp_dirs(
                                    $path_in_plugin     ,
                                    $app_handle
                                    ) ;

//\greatKiwi_standardDatasetManager\pr( $plugin_maker_core_dirs ) ;

    // =========================================================================
    // LOAD the PLUGIN MAKER DIRECTORY TREE...
    // =========================================================================

    // -------------------------------------------------------------------------
    // \greatKiwi_dirsFiles\load_directory_tree(
    //      $root_dir
    //      )
    // - - - - - - - - - - -
    // Loads the specified directory tree.
    //
    // RETURNS
    //      o   On SUCCESS!
    //          - - - - - -
    //          An ARRAY like (eg):-
    //
    //      o   On FAILURE!
    //          - - - - - -
    //          $error_message STRING
    // -------------------------------------------------------------------------

    $tree = \greatKiwi_dirsFiles\load_directory_tree(
                $plugin_maker_core_dirs['plugin_root_dir']
                ) ;

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $tree = Array(
    //          [dirs] => Array(
    //              [/opt/lampp/htdocs/plugdev/wp-content/plugins/research-assistant/admin] => Array(
    //                  [dirs] => Array(
    //                      [/opt/lampp/htdocs/plugdev/wp-content/plugins/research-assistant/admin/_old_] => Array(
    //                          [dirs]  => Array()
    //                          [files] => Array(
    //                              [0] => manage-candidate-pages.php
    //                              [1] => manage-dataset.php
    //                              [2] => manage-projects.php
    //                              [3] => manage-reference-urls.php
    //                              )
    //                          [other] => Array(
    //                              [0] => .
    //                              [1] => ..
    //                              )
    //                          )
    //                      )
    //                  [files] => Array(
    //                      [0] => common.bak
    //                      [1] => common.php
    //                      [2] => home.bak
    //                      [3] => home.php
    //                      )
    //                  [other] => Array(
    //                      [0] => .
    //                      [1] => ..
    //                      )
    //                  )
    //              ...
    //              [/opt/lampp/htdocs/plugdev/wp-content/plugins/research-assistant/app-defs] => Array(
    //                  [dirs] => Array(
    //                      [/opt/lampp/htdocs/plugdev/wp-content/plugins/research-assistant/app-defs/basepress-logger.app] => Array(
    //                          [dirs] => Array(
    //                              [/opt/lampp/htdocs/plugdev/wp-content/plugins/research-assistant/app-defs/basepress-logger.app/plugin.stuff] => Array(
    //                                  [dirs]  => Array()
    //                                  [files] => Array(
    //                                      [0] => api-functions.bak
    //                                      [1] => api-functions.php
    //                                      [2] => basepress-logger.bak
    //                                      [3] => basepress-logger.php
    //                                      [4] => basepress-logger-proper.bak
    //                                      [5] => basepress-logger-proper.php
    //                                      [6] => test.bak
    //                                      [7] => test.php
    //                                      )
    //                                  [other] => Array(
    //                                      [0] => .
    //                                      [1] => ..
    //                                      )
    //                                  )
    //                              )
    //                          [files] => Array(
    //                              [0] => app-data.bak
    //                              [1] => app-data.php
    //                              [2] => global-log-messages.dd.bak
    //                              [3] => global-log-messages.dd.php
    //                              [4] => logs.dd.bak
    //                              [5] => logs.dd.php
    //                              [6] => messages.dd.bak
    //                              [7] => messages.dd.php
    //                              )
    //                          [other] => Array(
    //                              [0] => .
    //                              [1] => ..
    //                              )
    //                          )
    //                      ...
    //                      [/opt/lampp/htdocs/plugdev/wp-content/plugins/research-assistant/app-defs/plugin-exporter.app] => Array(
    //                          [dirs] => Array(
    //                              [/opt/lampp/htdocs/plugdev/wp-content/plugins/research-assistant/app-defs/plugin-exporter.app/plugin.stuff] => Array(
    //                                  [dirs] => Array(
    //                                      [/opt/lampp/htdocs/plugdev/wp-content/plugins/research-assistant/app-defs/plugin-exporter.app/plugin.stuff/scripts] => Array(
    //                                          [dirs] => Array()
    //                                          [files] => Array(
    //                                              [0] => select-export-dirs-files.bak
    //                                              [1] => select-export-dirs-files.php
    //                                              )
    //                                          [other] => Array(
    //                                              [0] => .
    //                                              [1] => ..
    //                                              )
    //                                          )
    //                                      )
    //                                  [files] => Array(
    //                                      [0] => plugin-exporter.bak
    //                                      [1] => plugin-exporter.php
    //                                      [2] => plugin-exporter-proper.bak
    //                                      [3] => plugin-exporter-proper.php
    //                                      )
    //                                  [other] => Array(
    //                                      [0] => .
    //                                      [1] => ..
    //                                      )
    //                                  )
    //                              )
    //                          [files] => Array(
    //                              [0] => app-data.bak
    //                              [1] => app-data.php
    //                              [2] => files-tree.view.bak
    //                              [3] => files-tree.view.php
    //                              [4] => files-tree-view.resources.php
    //                              [5] => plugin-components.dd.bak
    //                              [6] => plugin-components.dd.php
    //                              [7] => plugins.dd.bak
    //                              [8] => plugins.dd.php
    //                              )
    //                          [other] => Array(
    //                              [0] => .
    //                              [1] => ..
    //                              )
    //                          )
    //                      )
    //                  [files] => Array()
    //                  [other] => Array(
    //                      [0] => .
    //                      [1] => ..
    //                      )
    //                  )
    //              )
    //          [files] => Array(
    //              [0] => apps-api.bak
    //              [1] => apps-api.php
    //              [2] => common.bak
    //              [3] => common-for-plugin.bak
    //              [4] => common-for-plugin.php
    //              [5] => common-global.bak
    //              [6] => common-global.php
    //              [7] => common.php
    //              [8] => research-assistant.bak
    //              [9] => research-assistant.php
    //              )
    //          [other] => Array(
    //              [0] => .
    //              [1] => ..
    //              )
    //          )
    //
    // -------------------------------------------------------------------------

//\greatKiwi_standardDatasetManager\pr( $tree ) ;

    // =========================================================================
    // REMOVE every APP from the APP-DEFS directory that's not the selected
    // PLUGIN...
    // =========================================================================

    $selected_plugins_app_def_dirspec =
        $plugin_maker_core_dirs['plugins_app_defs_dir'] .
        '/' .
        $plugin_slug_dashed . '.app'
        ;

    // -------------------------------------------------------------------------

    if ( ! is_dir( $selected_plugins_app_def_dirspec ) ) {

        // ---------------------------------------------------------------------

        $msg = <<<EOT
PROBLEM:&nbsp; Can't find selected plugin's "application definition" directory
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_teaserMaker\\teaser_to_post_proper()
EOT;

        return array(
                    $teaser_title           ,
                    $teaser_summary         ,
                    $msg                    ,
                    $support_javascript
                    ) ;

        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------

    if ( ! is_dir( $plugin_maker_core_dirs['plugins_app_defs_dir'] ) ) {

        // ---------------------------------------------------------------------

        $msg = <<<EOT
PROBLEM:&nbsp; Can't find Plugin Maker's "app_defs" directory
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_teaserMaker\\teaser_to_post_proper()
EOT;

        return array(
                    $teaser_title           ,
                    $teaser_summary         ,
                    $msg                    ,
                    $support_javascript
                    ) ;

        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------

    foreach ( $tree['dirs'] as $this_top_dirspec => $this_top_dir_details ) {

        // ---------------------------------------------------------------------

        if ( $this_top_dirspec === $plugin_maker_core_dirs['plugins_app_defs_dir'] ) {

            // -----------------------------------------------------------------

            foreach ( $this_top_dir_details['dirs'] as $this_app_def_dirspec => $this_app_def_details ) {

                if ( $this_app_def_dirspec !== $selected_plugins_app_def_dirspec ) {
                    unset( $tree['dirs'][ $this_top_dirspec ]['dirs'][ $this_app_def_dirspec ] ) ;
                }

            }

            // -----------------------------------------------------------------

        }

        // ---------------------------------------------------------------------

    }

//\greatKiwi_standardDatasetManager\pr( $tree ) ;

    // =========================================================================
    // Get the MAIN PLUGIN FILE's details...
    //
    // NOTE!
    // -----
    // The main plugin file is special because:-
    //
    //      o   It gets relocated from the (input) plugin's ".app" dir, to
    //          the output plugin's root dir, and;
    //
    //      o   We set some of the parameters in the file's WordPress Plugin
    //          Header (from the relevant plugin record fields).
    // =========================================================================

    $main_plugin_files_from_filespec =  $selected_plugins_app_def_dirspec .
                                        '/plugin.stuff/' .
                                        $plugin_slug_dashed . '.php'
                                        ;

    // =========================================================================
    // Get READY to EXPORT...
    // =========================================================================

    if ( $list_or_export === 'export' ) {

        // ---------------------------------------------------------------------

        require_once( dirname( __FILE__ ) . '/export-support.php' ) ;

        // -------------------------------------------------------------------------
        // get_empty_export_dir(
        //      $plugin_details             ,
        //      $plugin_basename            ,
        //      $plugin_maker_core_dirs
        //      )
        // - - - - - - - - - - - - - - - - -
        // Returns the pathspec of the directory we're going to export the plugin
        // to.  That directory will also be:-
        //      o   Created if it DOESN'T exist.
        //      o   Emptied if it DOES exist.
        //
        // RETURNS
        //      o   On SUCCESS!
        //          - - - - - -
        //          $plugin_export_directory_dirspec STRING
        //
        //      o   On FAILURE!
        //          - - - - - -
        //          ARRAY( $error_message STRING )
        // -------------------------------------------------------------------------

        $plugin_export_directory_dirspec = get_empty_export_dir(
                                                $plugin_details             ,
                                                $plugin_basename            ,
                                                $plugin_maker_core_dirs
                                                ) ;

        // ---------------------------------------------------------------------

        if ( is_array( $plugin_export_directory_dirspec ) ) {

            return array(
                        $teaser_title                           ,
                        $teaser_summary                         ,
                        $plugin_export_directory_dirspec[0]     ,
                        $support_javascript
                        ) ;

        }

//\greatKiwi_standardDatasetManager\pr( $plugin_export_directory_dirspec ) ;

        // ---------------------------------------------------------------------

        require_once( $caller_plugins_includes_dir . '/copy-directory-tree.php' ) ;
            //  In case "process_sub_tree()" requires it.

        // ---------------------------------------------------------------------

    } else {

        // ---------------------------------------------------------------------

        $plugin_export_directory_dirspec = NULL ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // Create the TREE LISTING (= MAIN PAGE CONTENT)...
    // =========================================================================

    $tree_root_dirspec = $plugin_maker_core_dirs['plugin_root_dir'] ;

    $listing = <<<EOT
<div>
    <span style="font-size:120%; font-weight:bold; color:#CC0000">{$tree_root_dirspec}/</span>
     &nbsp;&nbsp;&nbsp;&nbsp;
     <span style="font-size:150%">&larr;<span style="position:relative; top:0.5em; left:-0.33em">&darr;</span></span><span
        style="position:relative; left:-0.5em">dir/tree to export FROM</span>
     &nbsp;&nbsp;&nbsp;&nbsp;
     <a href="javascript:history.back()" style="text-decoration:none"><b>Back</b></a>
</div>
EOT;

    $tree_root_relative_sub_tree_dirspec = '' ;

    $level = 1 ;

    // -------------------------------------------------------------------------

    $result = process_sub_tree(
                    $tree                                   ,
                    $tree_root_dirspec                      ,
                    $tree_root_relative_sub_tree_dirspec    ,
                    $list_or_export                         ,
                    $level                                  ,
                    $listing                                ,
                    $plugin_export_directory_dirspec        ,
                    $plugin_slug_dashed                     ,
                    $main_plugin_files_from_filespec        ,
                    $plugin_details
                    ) ;

    // -------------------------------------------------------------------------

    if ( $list_or_export === 'list' ) {

        // ---------------------------------------------------------------------
        // LIST
        // ---------------------------------------------------------------------

        $main_page_content = <<<EOT
<div style="width:98%">
    {$listing}
    <form   method="post"
            action=""
            style="margin-top:2em; background-color:#F0F0F0; padding:0.2em 3em; text-align:left"
            >
        <input  type="submit"
                name="submit"
                value="Export"
                />
    </form>
</div>\n
EOT;

        // -------------------------------------------------------------------------
        // float disk_free_space ( string $directory )
        // - - - - - - - - - - - - - - - - - - - - - -
        // Given a string containing a directory, this function will return the
        // number of bytes available on the corresponding filesystem or disk
        // partition.
        //
        //      directory
        //          A directory of the filesystem or disk partition.
        //
        //          Note:   Given a file name instead of a directory, the behaviour
        //                  of the function is unspecified and may differ between
        //                  operating systems and PHP versions.
        //
        // Returns the number of available bytes as a float or FALSE on failure.
        //
        // (PHP 4 >= 4.1.0, PHP 5)
        // -------------------------------------------------------------------------

        $disk_free_space = disk_free_space( WP_PLUGIN_DIR ) ;

        $disk_free_space = number_format( $disk_free_space ) ;

        $main_page_content .= <<<EOT
<script type="text/javascript">
    document.getElementById( 'disk-free-space' ).innerHTML = '{$disk_free_space} bytes' ;
</script>
EOT;

        // ---------------------------------------------------------------------

    } else {

        // ---------------------------------------------------------------------
        // EXPORT
        // ---------------------------------------------------------------------

        $main_page_content = <<<EOT
<div style="width:98%">
    Plugin exported OK<br />
    <a href="">OK</a>
</div>
EOT;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // Get the SUPPORT JAVASCRIPT (if any is required)...
    // =========================================================================

    $support_javascript = '' ;
*/

/*
// =============================================================================
// process_sub_tree()
// =============================================================================

function process_sub_tree(
    $sub_tree                               ,
    $sub_tree_root_dirspec                  ,
    $tree_root_relative_sub_tree_dirspec    ,
    $list_or_export                         ,
    $level                                  ,
    &$listing                               ,
    $output_plugin_root_dirspec             ,
    $plugin_slug_dashed                     ,
    $main_plugin_files_from_filespec        ,
    $plugin_details
    ) {

    // -------------------------------------------------------------------------
    // process_sub_tree(
    //      $sub_tree                               ,
    //      $sub_tree_root_dirspec                  ,
    //      $tree_root_relative_sub_tree_dirspec    ,
    //      $list_or_export                         ,
    //      $level                                  ,
    //      &$listing                               ,
    //      $output_plugin_root_dirspec             ,
    //      $plugin_slug_dashed                     ,
    //      $main_plugin_files_from_filespec        ,
    //      $plugin_details
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - -
    // Copy or lists the specified sub-tree (of the:-
    //      Plugin Maker
    // plugin root directory).
    //
    // RETURNS
    //      o   On SUCCESS!
    //          - - - - - -
    //          TRUE
    //
    //      o   On FAILURE!
    //          - - - - - -
    //          $error_message STRING
    // -------------------------------------------------------------------------

    // =========================================================================
    // Init.
    // =========================================================================

    $indent = $level * 4 ;

    // -------------------------------------------------------------------------

    $ignore_case_TRUE  = TRUE  ;
    $ignore_case_FALSE = FALSE ;

    // -------------------------------------------------------------------------

    $tree_root_relative_dirspecs_whoose_content_to_toggle = array(
        'includes/Zebra_Form-master'        ,
        'js/date-picker-v5'                 ,
        'js/dhtmlxGrid'                     ,
        'js/x'
        ) ;

    // -------------------------------------------------------------------------

    $tree_root_relative_dirspecs_to_copy_as_is =
        $tree_root_relative_dirspecs_whoose_content_to_toggle
        ;

    // -------------------------------------------------------------------------

    $fg_copy   = '#333333' ;
    $fg_normal = '#000000' ;

    // -------------------------------------------------------------------------

    $question_recurse = NULL ;

    // =========================================================================
    // Toggle this dir's content ?
    // =========================================================================

    if ( in_array(  $tree_root_relative_sub_tree_dirspec                        ,
                    $tree_root_relative_dirspecs_whoose_content_to_toggle       ,
                    TRUE
                    )
        ) {

        if ( $list_or_export === 'list' ) {

            $listing .= <<<EOT
<div style="padding-left:{$indent}em">...</div>\n
EOT;

        }

        return ;

    }

    // =========================================================================
    // DIRS...
    // =========================================================================

    foreach ( $sub_tree['dirs'] as $sub_dir_dirspec => $sub_dir_content ) {

        // ---------------------------------------------------------------------

        $sub_dir_basename = basename( $sub_dir_dirspec ) ;

        // ---------------------------------------------------------------------

        if ( $sub_dir_basename === '_old_' ) {
            continue ;
        }
            //  Skip "_old_" directories...

        // ---------------------------------------------------------------------

        if ( substr( $sub_dir_basename , -4 ) === '.app' ) {
            $question_selected_plugins_app_dir = TRUE ;

        } else {
            $question_selected_plugins_app_dir = FALSE ;

        }

        // ---------------------------------------------------------------------

        if ( $list_or_export === 'list' ) {

            // -----------------------------------------------------------------
            // LIST
            // -----------------------------------------------------------------

            question_blank_line( $listing ) ;

            // -----------------------------------------------------------------

            if ( $question_selected_plugins_app_dir ) {
                $listing .= <<<EOT
<div style="background-color:#F0F0F0">\n
EOT;
            }

            // -----------------------------------------------------------------

            $listing .= <<<EOT
<div style="padding-left:{$indent}em"><strong>{$sub_dir_basename}</strong></div>\n
EOT;

            // -----------------------------------------------------------------

            $question_recurse = TRUE ;

            // -----------------------------------------------------------------

        } else {

            // -----------------------------------------------------------------
            // EXPORT
            // -----------------------------------------------------------------

            if ( $tree_root_relative_sub_tree_dirspec === '' ) {

                $this_tree_root_relative_sub_tree_dirspec =
                    $sub_dir_basename
                    ;

            } else {

                $this_tree_root_relative_sub_tree_dirspec =
                    $tree_root_relative_sub_tree_dirspec .
                    '/' .
                    $sub_dir_basename
                    ;

            }

            // -----------------------------------------------------------------

            if ( $tree_root_relative_sub_tree_dirspec === '' ) {

                $output_dirspec =   $output_plugin_root_dirspec .
                                    '/' .
                                    $sub_dir_basename
                                    ;

            } else {

                $output_dirspec =   $output_plugin_root_dirspec .
                                    '/' .
                                    $tree_root_relative_sub_tree_dirspec .
                                    '/' .
                                    $sub_dir_basename
                                    ;

            }

            // -----------------------------------------------------------------

            if ( in_array(  $this_tree_root_relative_sub_tree_dirspec       ,
                            $tree_root_relative_dirspecs_to_copy_as_is      ,
                            TRUE
                            )
                ) {

                // -------------------------------------------------------------
                // COPY COMPLETE DIRECTORY TREE...
                // -------------------------------------------------------------

                // -------------------------------------------------------------------------
                // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_directoryOperations\copy_directory_tree(
                //      $from_dirspec                   ,
                //      $to_dirspec                     ,
                //      $question_strict = TRUE         ,
                //      $question_overwrite = FALSE     ,
                //      $levels = 0                     ,
                //      $current_level = 0
                //      )
                // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
                // Copies the specified directory tree.
                //
                // In other words (by default), copies the specified directory and all of
                // it's descendants.
                //
                // ---
                //
                // $question_strict:-
                //      o   TRUE means that NONE of the destination dirs and files may
                //          already exist.
                //      o   FALSE means that it's OK if any of the destination dirs and
                //          files already exist.  If the destination item that already
                //          exists is a FILE, then $question_overwrite describes how
                //          this should be handled.
                //
                // ---
                //
                // $question_overwrite:-
                //      (Only used if $question_strict is FALSE.)
                //      o   TRUE means that if a destination file already exists, then
                //          it MAY be overwritten.
                //      o   FALSE means that if a destination file already exists, then
                //          it may NOT be overwritten.  (Instead, the copy ends at this
                //          point - the existing file being a FATAL error.)
                //
                // ---
                //
                // $levels:-
                //      o   If $levels is 0, then we copy ALL of the destination
                //          directory's decendants (no matter ho deeply nested they are).
                //      o   If $levels is 1, then we copy only the DESTINATION
                //          DIRECTORY itself (but NONE of it's descendants).
                //      o   If $levels is 2, then we copy the destination directory and
                //          it's children (but NOT it's grandchildren, etc).
                //      o   And so on...
                //
                // ---
                //
                // $current_level:-
                //      o   The level that we've nested down to (and are currently at).
                //
                // ---
                //
                // RETURNS
                //      o   On SUCCESS!
                //          - - - - - -
                //          TRUE
                //
                //      o   On FAILURE!
                //          - - - - - -
                //          $error_message STRING
                // -------------------------------------------------------------------------

                $question_strict    = TRUE  ;
                $question_overwrite = FALSE ;
                $levels             = 0     ;
                $current_level      = 0     ;

                // -------------------------------------------------------------

                $result = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_directoryOperations\copy_directory_tree(
                                $sub_dir_dirspec        ,
                                $output_dirspec         ,
                                $question_strict        ,
                                $question_overwrite     ,
                                $levels                 ,
                                $current_level
                                ) ;

//              echo '<br /><br />COPYING:&nbsp; ' , $sub_dir_dirspec , ' to:-<br />&nbsp;&nbsp;&nbsp;&nbsp;<b>' , $output_dirspec , '</b>' ;
//              $result = TRUE ;

                // -------------------------------------------------------------

                if ( is_string( $result ) ) {
                    return $result ;
                }

                // -------------------------------------------------------------

                $question_recurse = FALSE ;

                // -------------------------------------------------------------

            } else {

                // -------------------------------------------------------------
                // CREATE THIS OUTPUT DIRECTORY (THEN RECURSE)...
                // -------------------------------------------------------------

                // -------------------------------------------------------------------------
                // bool mkdir ( string $pathname [, int $mode = 0777 [, bool $recursive = false [, resource $context ]]] )
                // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
                // Attempts to create the directory specified by pathname.
                //
                //      pathname
                //          The directory path.
                //
                //      mode
                //          The mode is 0777 by default, which means the widest possible
                //          access. For more information on modes, read the details on the
                //          chmod() page.
                //
                //          Note:
                //
                //          mode is ignored on Windows.
                //
                //          Note that you probably want to specify the mode as an octal
                //          number, which means it should have a leading zero. The mode is
                //          also modified by the current umask, which you can change using
                //          umask().
                //
                //      recursive
                //          Allows the creation of nested directories specified in the
                //          pathname.
                //
                //      context
                //          Note: Context support was added with PHP 5.0.0. For a
                //          description of contexts, refer to Streams.
                //
                // Returns TRUE on success or FALSE on failure.
                //
                // (PHP 4, PHP 5)
                //
                // CHANGELOG
                //      Version     Description
                //      -------     -------------------------------------------------------
                //      5.0.0       The recursive parameter was added
                //
                //      5.0.0       As of PHP 5.0.0 mkdir() can also be used with some URL
                //                  wrappers. Refer to Supported Protocols and Wrappers for
                //                  a listing of which wrappers support mkdir()
                //
                //      4.2.0       The mode parameter became optional.
                // -------------------------------------------------------------------------

                $mode      = 0755  ;    //  Standard Web/WordPress Directory permissions
                $recursive = FALSE ;

                // -------------------------------------------------------------

                $ok = mkdir(
                            $output_dirspec     ,
                            $mode               ,
                            $recursive
                            ) ;

//              echo '<br /><br />Creating:&nbsp; ' , $sub_dir_dirspec , ' as:-<br />&nbsp;&nbsp;&nbsp;&nbsp;<b>' , $output_dirspec , '</b>' ;
//              $ok = TRUE ;

                // -------------------------------------------------------------

                if ( $ok !== TRUE ) {

                    return <<<EOT
PROBLEM:&nbsp; "mkdir()" failure creating sub-directory in output plugin
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_teaserMaker\\process_sub_tree()
EOT;

                }

                // -------------------------------------------------------------

                $question_recurse = TRUE ;

                // -------------------------------------------------------------

            }

            // -----------------------------------------------------------------

        }

        // ---------------------------------------------------------------------
        // RECURSE ?
        // ---------------------------------------------------------------------

        if ( $question_recurse ) {

            // -----------------------------------------------------------------

            if ( $tree_root_relative_sub_tree_dirspec === '' ) {

                $new_tree_root_relative_sub_tree_dirspec =
                    $sub_dir_basename
                    ;

            } else {

                $new_tree_root_relative_sub_tree_dirspec =
                    $tree_root_relative_sub_tree_dirspec . '/' . $sub_dir_basename
                    ;

            }

            // -----------------------------------------------------------------

            process_sub_tree(
                $sub_dir_content                            ,
                $sub_dir_dirspec                            ,
                $new_tree_root_relative_sub_tree_dirspec    ,
                $list_or_export                             ,
                $level + 1                                  ,
                $listing                                    ,
                $output_plugin_root_dirspec                 ,
                $plugin_slug_dashed                         ,
                $main_plugin_files_from_filespec            ,
                $plugin_details
                ) ;

            // -----------------------------------------------------------------

        }

        // ---------------------------------------------------------------------

        if (    $list_or_export === 'list'
                &&
                $question_selected_plugins_app_dir
            ) {
            $listing .= <<<EOT
</div>\n
EOT;
        }

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // FILES...
    // =========================================================================

    if (    count( $sub_tree['dirs'] ) > 0
            &&
            count( $sub_tree['files'] ) > 0
        ) {
        question_blank_line( $listing ) ;
    }

    // -------------------------------------------------------------------------

    foreach ( $sub_tree['files'] as $file_index => $file_basename ) {

        // ---------------------------------------------------------------------
        // Skip this file ?
        // ---------------------------------------------------------------------

        if ( question_skip_file(
                $sub_tree_root_dirspec                  ,
                $tree_root_relative_sub_tree_dirspec    ,
                $file_basename
                )
            ) {
            continue ;
        }

        // ---------------------------------------------------------------------
        // Init $actions...
        // ---------------------------------------------------------------------

        $actions = '' ;

        // ---------------------------------------------------------------------
        // Copy this file ?
        // ---------------------------------------------------------------------

        if ( question_copy_file(
                $sub_tree_root_dirspec                  ,
                $tree_root_relative_sub_tree_dirspec    ,
                $file_basename
                )
            ) {
            $fg = $fg_copy ;

        } else {
            $fg = $fg_normal ;

        }

        // ---------------------------------------------------------------------

        if ( $list_or_export === 'list' ) {

            // -----------------------------------------------------------------
            // LIST
            // -----------------------------------------------------------------

            $listing .= <<<EOT
<div style="padding-left:{$indent}em; font-style:italic; color:{$fg}">{$file_basename}</div>\n
EOT;

            // -----------------------------------------------------------------

        } else {

            // -----------------------------------------------------------------
            // EXPORT
            // -----------------------------------------------------------------

//          require_once( dirname( __FILE__ ) . '/export-support.php' ) ;

            // -------------------------------------------------------------------------
            // copy_file(
            //      $from_filespec                      ,
            //      $to_filespec                        ,
            //      $main_plugin_files_from_filespec    ,
            //      $plugin_camel_name                  ,
            //      $plugin_version
            //      )
            // - - - - - - - - - - - - - - - - - - - - -
            // Copies the FROM file to the TO filespec (doing any file-specific
            // processing that might be required) in the process.
            //
            // The file-specific processing is:-
            //
            //      o   NAMESPACE NAME FIXING
            //          ---------------------
            //          If the FROM file is a PHP file, then we adjust the
            //          namespace names of any namespaces that require this.
            //
            //          The namespace names that are adjusted are those that contain
            //          the following strings:-
            //          #   "_teaserMaker_std_"
            //          #   "_pluginVerion_"
            //
            //          Eg.  If:-
            //              --  $plugin_camel_name = "basepressLogger"
            //              --  $plugin_version    = "0.1"
            //
            //          then:-
            //              greatKiwi_byFernTec_teaserMaker_std_v0x1x114_arrayStorage
            //
            //          would become:-
            //              greatKiwi_byFernTec_basepressLogger_v0x1_arrayStorage
            //
            //      o   PLUGIN FILE HEADER FIELD FIXING
            //          -------------------------------
            //          If the FROM file is the main plugin file (that is to be
            //          copied to the new plugin's root directory), the we set
            //          (some of) the fields in the WordPress plugin header as
            //          required.
            //
            //          NOTE!  The WordPress plugin header is (for example):-
            //
            //              /*
            //                  Plugin Name: Plugin Exporter
            //                  Plugin URI: http://ferntechnology.com/
            //                  Description: Create stand-alone version of a Plugin Maker created plugin
            //                  Author: Fern Technology
            //                  Version: 0.1
            //                  Author URI: http://ferntechnology.com/
            //                  Text Domain: plugin-exporter
            //                  Domain Path: /lang
            //              */
            //
            // RETURNS
            //      o   On SUCCESS!
            //          - - - - - -
            //          TRUE
            //
            //      o   On FAILURE!
            //          - - - - - -
            //          $error_message STRING
            // -------------------------------------------------------------------------

/*
            $from_filespec =    $sub_tree_root_dirspec .
                                '/' .
                                $file_basename
                                ;

            // -----------------------------------------------------------------

            $to_filespec =  get_destination_filespec(
                                $from_filespec                          ,
                                $output_plugin_root_dirspec             ,
                                $tree_root_relative_sub_tree_dirspec    ,
                                $file_basename                          ,
                                $plugin_slug_dashed                     ,
                                $main_plugin_files_from_filespec
                                ) ;
            // -----------------------------------------------------------------

            $ok = copy_file(
                        $from_filespec                      ,
                        $to_filespec                        ,
                        $main_plugin_files_from_filespec    ,
                        $plugin_details
                        ) ;


//          echo '<br />Copying: ' , $to_filespec ;
//          $ok = TRUE ;

            // -----------------------------------------------------------------

            if ( $ok !== TRUE ) {
                return $ok ;
            }

            // -----------------------------------------------------------------

        }

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// question_skip_file()
// =============================================================================

function question_skip_file(
    $sub_tree_root_dirspec                  ,
    $tree_root_relative_sub_tree_dirspec    ,
    $file_basename
    ) {

    // -------------------------------------------------------------------------
    // Init...
    // -------------------------------------------------------------------------

    $ignore_case_TRUE  = TRUE  ;
//  $ignore_case_FALSE = FALSE ;

    // -------------------------------------------------------------------------
    // Skip ".bak" files...
    // -------------------------------------------------------------------------

    if ( \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\ends_with( $file_basename , '.bak' , $ignore_case_TRUE ) ) {
        return TRUE ;
    }

    // -------------------------------------------------------------------------
    // Skip all files in the Plugin Plant root directory, except:-
    //      o   "apps-api.php"
    //      o   "test-debug.php"
    // -------------------------------------------------------------------------

    $allowed_root_dir_file_basenames = array(
        'apps-api.php'      ,
        'test-debug.php'
        ) ;

    // -------------------------------------------------------------------------

    if (    $tree_root_relative_sub_tree_dirspec === ''
            &&
            ! in_array( $file_basename , $allowed_root_dir_file_basenames , TRUE )
        ) {
        return TRUE ;
    }

    // -------------------------------------------------------------------------
    // Keep all the rest...
    // -------------------------------------------------------------------------

    return FALSE ;

    // -------------------------------------------------------------------------
    // That's that!
    // -------------------------------------------------------------------------

}

// =============================================================================
// question_copy_file()
// =============================================================================

function question_copy_file(
    $sub_tree_root_dirspec                  ,
    $tree_root_relative_sub_tree_dirspec    ,
    $file_basename
    ) {

    // -------------------------------------------------------------------------
    // Copy all but the skipped files...
    // -------------------------------------------------------------------------

    return ! question_skip_file(
                $sub_tree_root_dirspec                  ,
                $tree_root_relative_sub_tree_dirspec    ,
                $file_basename
                ) ;

    // -------------------------------------------------------------------------
    // That's that!
    // -------------------------------------------------------------------------

}

// =============================================================================
// get_destination_filespec()
// =============================================================================

function get_destination_filespec(
    $source_filespec                        ,
    $output_plugin_root_dirspec             ,
    $tree_root_relative_sub_tree_dirspec    ,
    $file_basename                          ,
    $plugin_slug_dashed                     ,
    $main_plugin_files_from_filespec
    ) {

    // =========================================================================
    // Check for the files to be relocated...
    // =========================================================================

    // -------------------------------------------------------------------------
    // main plugin file
    //
    // Relocate from:-
    //      .../plugins/plugin-plant/app-defs/<plugin-basename-dashed>/plugin.stuff/
    //
    // to:-
    //      output plugin's root directory
    // -------------------------------------------------------------------------

    if ( $source_filespec === $main_plugin_files_from_filespec ) {

        return  $output_plugin_root_dirspec .
                '/' .
                $file_basename
                ;

    }

    // =========================================================================
    // Normal (non-relocated) files...
    // =========================================================================

    if ( $tree_root_relative_sub_tree_dirspec === '' ) {

        return  $output_plugin_root_dirspec .
                '/' .
                $file_basename
                ;

    } else {

        return  $output_plugin_root_dirspec .
                '/' .
                $tree_root_relative_sub_tree_dirspec .
                '/' .
                $file_basename
                ;

    }

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// question_blank_line()
// =============================================================================

function question_blank_line(
    &$listing
    ) {

    // -------------------------------------------------------------------------

    if ( $listing !== '' ) {

        $listing .= <<<EOT
<div style="height:0.33em"></div>
EOT;

    }

    // -------------------------------------------------------------------------

}
*/

// =============================================================================
// That's that!
// =============================================================================

