<?php

// *****************************************************************************
// TEASER-MAKER.APP / PLUGIN.STUFF / SCRIPTS / IMPORT-SUBMISSION-HANDLER.PHP
// (C) 2014 Peter Newman. All Rights Reserved.
// *****************************************************************************

    namespace greatKiwi_byFernTec_teaserMaker_std_v0x1x114_datasetDef_teaserMaker ;

// =============================================================================
// handle_form_submission()
// =============================================================================

function handle_form_submission(
    $core_plugapp_dirs
    ) {

    // -------------------------------------------------------------------------
    // handle_form_submission(
    //      $core_plugapp_dirs
    //      )
    // - - - - - - - - - - - -
    // Handles the:-
    //      "select_teaser_category_export_to_import"
    // form submission.
    //
    // Echos any success or error output required.
    //
    // RETURNS
    //      Nothing
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //          $_GET = array()
    //
    //          $_POST = array()
    //
    //          $_FILES = array(
    //              [teaser_category_export_file_to_import] => Array(
    //                  [name]     => sample-teaser-page-exported-28-may-2014-at-03-11-23-gmt.dat
    //                  [type]     => application/x-ns-proxy-autoconfig
    //                  [tmp_name] => /tmp/php9J7yD1
    //                  [error]    => 0
    //                  [size]     => 5068
    //                  )
    //              )
    //
    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $_GET , '$_GET' ) ;
//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $_POST , '$_POST' ) ;
//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $_FILES , '$_FILES' ) ;

    // =========================================================================
    // Init.
    // =========================================================================

    $ns = __NAMESPACE__ ;
    $fn = __FUNCTION__ ;

    // =========================================================================
    // ERROR CHECKING (1)
    // =========================================================================

    // -------------------------------------------------------------------------
    // $_GET / $_POST ?
    // -------------------------------------------------------------------------

    if (    count( $_GET ) > 0
            ||
            count( $_POST ) > 0
        ) {

        //  Ignore the call !!!

        return ;

    }

    // -------------------------------------------------------------------------
    // $_FILES ?
    // -------------------------------------------------------------------------

    if ( count( $_FILES ) > 1 ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Too many files
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        echo nl2br( $msg ) ;

        return ;

    }

    // -------------------------------------------------------------------------
    // teaser_category_export_file_to_import ?
    // -------------------------------------------------------------------------

    $file_field_name = 'teaser_category_export_file_to_import' ;

    // -------------------------------------------------------------------------

    if ( ! array_key_exists( $file_field_name , $_FILES ) ) {

        $msg = <<<EOT
PROBLEM:&nbsp; No "{$file_field_name}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        echo nl2br( $msg ) ;

        return ;

    }

    // -------------------------------------------------------------------------

    if ( ! is_array( $_FILES[ $file_field_name ] ) ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Bad "{$file_field_name}" (array expected)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        echo nl2br( $msg ) ;

        return ;

    }

    // -------------------------------------------------------------------------
    // error ?
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // NOTE!
    // =====
    // The "error" codes are:-
    //
    //      UPLOAD_ERR_OK
    //          Value: 0; There is no error, the file uploaded with success.
    //
    //      UPLOAD_ERR_INI_SIZE
    //          Value: 1; The uploaded file exceeds the upload_max_filesize
    //          directive in php.ini.
    //
    //      UPLOAD_ERR_FORM_SIZE
    //          Value: 2; The uploaded file exceeds the MAX_FILE_SIZE directive
    //          that was specified in the HTML form.
    //
    //      UPLOAD_ERR_PARTIAL
    //          Value: 3; The uploaded file was only partially uploaded.
    //
    //      UPLOAD_ERR_NO_FILE
    //          Value: 4; No file was uploaded.
    //
    //      UPLOAD_ERR_NO_TMP_DIR
    //          Value: 6; Missing a temporary folder. Introduced in PHP 4.3.10
    //          and PHP 5.0.3.
    //
    //      UPLOAD_ERR_CANT_WRITE
    //          Value: 7; Failed to write file to disk. Introduced in PHP 5.1.0.
    //
    //      UPLOAD_ERR_EXTENSION
    //          Value: 8; A PHP extension stopped the file upload. PHP does not
    //          provide a way to ascertain which extension caused the file
    //          upload to stop; examining the list of loaded extensions with
    //          phpinfo() may help. Introduced in PHP 5.2.0.
    //
    // Note:  These became PHP constants in PHP 4.3.0.
    // -------------------------------------------------------------------------

    if ( $_FILES[ $file_field_name ]['error'] === 4 ) {

        $msg = <<<EOT
<br />
Please select a Teaser Category export file to upload/import...
EOT;

        echo nl2br( $msg ) ;

        return ;

    }

    // -------------------------------------------------------------------------

    if ( $_FILES[ $file_field_name ]['error'] !== 0 ) {

        $msg = <<<EOT
PROBLEM:&nbsp; File upload failure ({$_FILES[ $file_field_name ]['error']})
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        echo nl2br( $msg ) ;

        return ;

    }

    // -------------------------------------------------------------------------
    // size ?
    // tmp_name ?
    //
    // NOTE!
    // =====
    // If no file is selected for upload in your form, PHP will return
    // $_FILES['userfile']['size'] as 0, and $_FILES['userfile']['tmp_name'] as
    // none.
    // -------------------------------------------------------------------------

    if (    $_FILES[ $file_field_name ]['size'] === 0
            ||
            $_FILES[ $file_field_name ]['tmp_name'] === ''
        ) {

        $msg = <<<EOT
<br />
Please select a Teaser Category export file to upload/import...
EOT;

        echo nl2br( $msg ) ;

        return ;

    }

    // =========================================================================
    // Get the PHP temporary (uploads) dir and upload filespec...
    // =========================================================================

    $php_temp_filespec = $_FILES[ $file_field_name ]['tmp_name'] ;

    // -------------------------------------------------------------------------

    if ( $php_temp_filespec === '' ) {

        $msg = <<<EOT
<br />
Sorry, but we can't find the uploaded file
EOT;

        echo nl2br( $msg ) ;

        return ;

    }

    // =========================================================================
    // LOAD the FILE CONTENT...
    // =========================================================================

    $uploaded_file_content = file_get_contents( $php_temp_filespec ) ;
                                //  The function returns the read data or FALSE
                                //  on failure.

    // -------------------------------------------------------------------------

    if ( $uploaded_file_content === FALSE ) {

        $msg = <<<EOT
PROBLEM:&nbsp; File read failure
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        echo nl2br( $msg ) ;

        return ;

    }

    // =========================================================================
    // Is the file content a BASE 64 ENCODED string ?
    // =========================================================================

    require_once( $core_plugapp_dirs['plugins_includes_dir'] . '/string-utils.php' ) ;

    // -------------------------------------------------------------------------

    if ( ! \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\ctype_base64( $uploaded_file_content ) ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Bad upload file data (contains unexpected characters)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        echo nl2br( $msg ) ;

        return ;

    }

    // =========================================================================
    // Base64 DECODE the uploaded file content...
    // =========================================================================

    // -------------------------------------------------------------------------
    // string base64_decode ( string $data [, bool $strict = false ] )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Decodes a base64 encoded data.
    //
    //      data
    //          The encoded data.
    //
    //      strict
    //          Returns FALSE if input contains character from outside the
    //          base64 alphabet.
    //
    // Returns the original data or FALSE on failure. The returned data may be
    // binary.
    //
    // (PHP 4, PHP 5)
    //
    // CHANGELOG
    //      Version     Description
    //      5.2.0       strict added
    // -------------------------------------------------------------------------

    $strict = TRUE ;

    // -------------------------------------------------------------------------

    $uploaded_file_content = \base64_decode( $uploaded_file_content , $strict ) ;

    // -------------------------------------------------------------------------

    if ( $uploaded_file_content === FALSE ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Bad upload file data (contains invalid characters)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        echo nl2br( $msg ) ;

        return ;

    }

    // =========================================================================
    // UNSERIALISE the BASE64 DECODED file content...
    // =========================================================================

    // -------------------------------------------------------------------------
    // mixed unserialize ( string $str )
    // - - - - - - - - - - - - - - - - -
    // unserialize() takes a single serialized variable and converts it back
    // into a PHP value.
    //
    //      str
    //          The serialized string.
    //
    //          If the variable being unserialized is an object, after
    //          successfully reconstructing the object PHP will automatically
    //          attempt to call the __wakeup() member function (if it exists).
    //
    //          Note: unserialize_callback_func directive
    //
    //          It's possible to set a callback-function which will be called,
    //          if an undefined class should be instantiated during
    //          unserializing. (to prevent getting an incomplete object
    //          "__PHP_Incomplete_Class".) Use your php.ini, ini_set() or
    //          .htaccess to define 'unserialize_callback_func'. Everytime an
    //          undefined class should be instantiated, it'll be called. To
    //          disable this feature just empty this setting.
    //
    // The converted value is returned, and can be a boolean, integer, float,
    // string, array or object.
    //
    // In case the passed string is not unserializeable, FALSE is returned and
    // E_NOTICE is issued.
    //
    // (PHP 4, PHP 5)
    //
    // CHANGELOG
    //      Version     Description
    //      4.2.0       The directive unserialize_callback_func became
    //                  available.
    // -------------------------------------------------------------------------

    $import_array = @\unserialize( $uploaded_file_content ) ;

    // -------------------------------------------------------------------------

    if ( $import_array === FALSE ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Bad upload file data (not unserialisable)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        echo nl2br( $msg ) ;

        return ;

    }

    // -------------------------------------------------------------------------

    if ( ! is_array( $import_array ) ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Bad upload file data (array expected)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        echo nl2br( $msg ) ;

        return ;

    }

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $import_array = Array(
    //
    //          [instance_data] => Array(
    //              [export_file_basename] => sample-teaser-page-exported-28-may-2014-at-03-11-23-gmt.dat
    //              [export_datetime_UTC]  => 1401246683
    //              )
    //
    //          [teaser_category_records] => Array(
    //
    //              [teaser_categories] => Array(
    //                  [0] => Array(
    //                      [created_server_datetime_UTC]            => 1401260826
    //                      [last_modified_server_datetime_UTC]      => 1401260826
    //                      [key]                                    => 3f0318c7-fcd9-4694-9d2b-8d74610bec66-1401260826-168058-145
    //                      [parent_key]                             =>
    //                      [title]                                  => Sample Teaser Page
    //                      [description]                            => PHA+QW4gZuPC9wPg0K
    //                      [description_format]                     => none
    //                      [image_url]                              =>
    //                      [sequence_number]                        =>
    //                      [imports_export_file_basename]           =>
    //                      [imports_export_datetime_UTC]            =>
    //                      [imports_original_teaser_category_title] =>
    //                      [imports_import_file_basename]           =>
    //                      )
    //                  )
    //
    //              [teasers] => Array(
    //                  [0] => Array(
    //                      [created_server_datetime_UTC]       => 1396257849
    //                      [last_modified_server_datetime_UTC] => 1401092342
    //                      [key]                               => 53393439b8b82
    //                      [parent_key]                        => 5382f8db5d0c1
    //                      [original_url]                      => http://www.rookiemag.com/2014/02/postcards-from-wonderland/
    //                      [original_title]                    => Postcards From Wonderland
    //                      [original_clipped_text]             => TXkgYmVzdiaG91c2UuLi4=
    //                      [text_format]                       => none
    //                      [original_media_url]                => http://static.rookiemag.com/2014/02/13927942057DbvL-700x466.jpeg
    //                      [sequence_number]                   => 10
    //                      )
    //                  ...
    //                  )
    //
    //              )
    //
    //          [teaser_images] => Array(
    //              [0] => Array(
    //                          [url]       => http://static.rookiemag.com/2014/02/13927942057DbvL-700x466.jpeg
    //                          [copy_type] => by-reference
    //                          )
    //              ...
    //              )
    //
    //          )
    //
    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $import_array , '$import_array' ) ;

    // =========================================================================
    // ERROR CHECKING (2)
    // =========================================================================

    // -------------------------------------------------------------------------
    // instance_data ?
    // -------------------------------------------------------------------------

    if ( ! array_key_exists( 'instance_data' , $import_array ) ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Bad import file (no "instance_data")
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        echo nl2br( $msg ) ;

        return ;

    }

    // -------------------------------------------------------------------------

    if ( ! is_array( $import_array['instance_data'] ) ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Bad import file "instance_data" (array expected)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        echo nl2br( $msg ) ;

        return ;

    }

    // -------------------------------------------------------------------------
    // teaser_category_records ?
    // -------------------------------------------------------------------------

    if ( ! array_key_exists( 'teaser_category_records' , $import_array ) ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Bad import file (no "teaser_category_records")
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        echo nl2br( $msg ) ;

        return ;

    }

    // -------------------------------------------------------------------------

    if ( ! is_array( $import_array['teaser_category_records'] ) ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Bad import file "teaser_category_records" (array expected)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        echo nl2br( $msg ) ;

        return ;

    }

    // -------------------------------------------------------------------------
    // teaser_images ?
    // -------------------------------------------------------------------------

    if (    array_key_exists( 'teaser_images' , $import_array )
            &&
            ! is_array( $import_array['teaser_images'] )
        ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Bad "teaser_images" (in import data - array expected)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        echo nl2br( $msg ) ;

        return ;

    }

    // -------------------------------------------------------------------------

    $allowed_copy_types = array(
        'physical'          ,
        'by-reference'
        ) ;

    // -------------------------------------------------------------------------

    $physical_copy_type_field_slugs = array(
        'width'                 ,
        'height'                ,
        'php_imagetype_xxx'     ,
        'mime_type'             ,
        'md5'                   ,
        'sha1'                  ,
        'filesize'              ,
        'binary_image_data'
        ) ;

    // -------------------------------------------------------------------------

    foreach ( $import_array['teaser_images'] as $this_teaser_image_index => $this_teaser_image ) {

        // ---------------------------------------------------------------------

        $teaser_image_number = $this_teaser_image_index + 1 ;

        // ---------------------------------------------------------------------
        // url ?
        // ---------------------------------------------------------------------

        if ( ! array_key_exists( 'url' , $this_teaser_image ) ) {

            $msg = <<<EOT
PROBLEM:&nbsp; Bad teaser image# {$teaser_image_number} (no "url" field)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            echo nl2br( $msg ) ;

            return ;

        }

        // ---------------------------------------------------------------------

        if (    ! is_string( $this_teaser_image['url'] )
                ||
                trim( $this_teaser_image['url'] ) === ''
            ) {

            $msg = <<<EOT
PROBLEM:&nbsp; Bad teaser image# {$teaser_image_number} "url" (non-empty string expected)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            echo nl2br( $msg ) ;

            return ;

        }

        // ---------------------------------------------------------------------

        $basename = basename( $this_teaser_image['url'] ) ;
                        //  Returns the base name of the given path.

        // ---------------------------------------------------------------------

        if ( trim( $basename ) === '' ) {

            $msg = <<<EOT
PROBLEM:&nbsp; Bad teaser image# {$teaser_image_number} "url" (has no "basename" component)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            echo nl2br( $msg ) ;

            return ;

        }

        // ---------------------------------------------------------------------
        // copy_type ?
        // ---------------------------------------------------------------------

        if ( ! array_key_exists( 'copy_type' , $this_teaser_image ) ) {

            $msg = <<<EOT
PROBLEM:&nbsp; Bad teaser image# {$teaser_image_number} (no "copy_type" field)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            echo nl2br( $msg ) ;

            return ;

        }

        // ---------------------------------------------------------------------

        if ( ! in_array( $this_teaser_image['copy_type'] , $allowed_copy_types , TRUE ) ) {

            $safe_copy_type = htmlentities( $this_teaser_image['copy_type'] ) ;

            $msg = <<<EOT
PROBLEM:&nbsp; Unrecognised/unsupported {$teaser_image_number} "copy_type" ("{$safe_copy_type}")
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            echo nl2br( $msg ) ;

            return ;

        }

        // ---------------------------------------------------------------------
        // copy+type = "physical"
        // ---------------------------------------------------------------------

        if ( $this_teaser_image['copy_type'] === 'physical' ) {

            // -----------------------------------------------------------------
            // "physical" copy type teaser image fields.  Ie:-
            //      o   'width'
            //      o   'height'
            //      o   'php_imagetype_xxx'
            //      o   'mime_type'
            //      o   'md5'
            //      o   'sha1'
            //      o   'filesize'
            //      o   'binary_image_data'
            // -----------------------------------------------------------------

            foreach ( $physical_copy_type_field_slugs as $this_field_slug ) {

                // -------------------------------------------------------------

                if ( ! array_key_exists( $this_field_slug , $this_teaser_image ) ) {

                    $msg = <<<EOT
PROBLEM:&nbsp; Bad teaser image# {$teaser_image_number} (no "{$this_field_slug}" field)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

                    echo nl2br( $msg ) ;

                    return ;

                }

                // -------------------------------------------------------------

            }

            // -----------------------------------------------------------------
            // filesize vs. strlen( binary_image_data )
            // -----------------------------------------------------------------

            if ( $this_teaser_image['filesize'] !== strlen( $this_teaser_image['binary_image_data'] ) ) {

                $msg = <<<EOT
PROBLEM:&nbsp; Bad teaser image# {$teaser_image_number} ("filesize" / "binary_image_data (length) mismatch)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

                echo nl2br( $msg ) ;

                return ;

            }

            // -----------------------------------------------------------------

        }

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // LOAD the application's DATASET DEFINITIONS - and INITIALISE ARRAY
    // STORAGE...
    // =========================================================================

    require_once( $core_plugapp_dirs['dataset_manager_includes_dir'] . '/common.php' ) ;

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
    // load_dataset_definitions_and_initialise_array_storage(
    //      $core_plugapp_dirs                      ,
    //      $target_apps_apps_dir_relative_path     ,
    //      $question_front_end
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // $target_apps_apps_dir_relative_path is like (eg):-
    //      o   "teaser-maker"
    //      o   "basepress-users/reporting-module"
    //      o   etc.
    //
    // RETURNS
    //      o   On SUCCESS
    //              ARRAY(
    //                  $app_defs_directory_tree                        ,
    //                  $applications_dataset_and_view_definitions_etc  ,
    //                  $all_application_dataset_definitions
    //                  )
    //
    //      o   On FAILURE
    //              $error_message STRING
    // -------------------------------------------------------------------------

    $target_apps_apps_dir_relative_path = 'teaser-maker' ;
    $question_front_end                 = FALSE ;

    // -------------------------------------------------------------------------

    $result =
        \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\load_dataset_definitions_and_initialise_array_storage(
            $core_plugapp_dirs                      ,
            $target_apps_apps_dir_relative_path     ,
            $question_front_end
            ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $result ) ) {
        echo nl2br( $result ) ;
        return ;
    }

    // -------------------------------------------------------------------------

    list(
        $app_defs_directory_tree                        ,
        $applications_dataset_and_view_definitions_etc  ,
        $all_application_dataset_definitions
        ) = $result ;

    // =========================================================================
    // LOAD the application's DATASETS...
    // =========================================================================

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
    // load_applications_datasets(
    //      $all_application_dataset_definitions    ,
    //      $core_plugapp_dirs                      ,
    //      &$loaded_datasets = array()
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - -
    // Makes sure that (on return):-
    //      $loaded_datasets
    // contains the title, records, key field slug and record indices by key
    // of all the datasets defined in:-
    //      $all_application_dataset_definitions
    //
    // In other words:-
    //
    //      o   Those datasets already in both:-
    //              $all_application_dataset_definitions, and;
    //              $loaded_datasets
    //          are ignored (their existing data is left as is).
    //
    // But:-
    //
    //      o   Those datasets in:-
    //              $all_application_dataset_definitions
    //          but not yet in:-
    //              $loaded_datasets
    //          are added to:-
    //              $loaded_datasets
    //
    // NOTE!
    // =====
    // The input $loaded_datasets must be either:-
    //      o   The empty array, or;
    //      o   An array like:-
    //              $loaded_datasets = array(
    //                  '<this_dataset_slug>'   => array(
    //                      'title'                     =>  "xxx"           ,
    //                      'records'                   =>  array(...)      ,
    //                      'key_field_slug'            =>  "yyy"           ,
    //                      'record_indices_by_key'     =>  array(...)
    //                      )
    //                  ...
    //                  )
    //
    // RETURNS
    //      o   On SUCCESS
    //              TRUE
    //
    //      o   On FAILURE
    //              $error_message STRING
    // -------------------------------------------------------------------------

    $loaded_datasets = array() ;

    // -------------------------------------------------------------------------

    $result = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\load_applications_datasets(
                    $all_application_dataset_definitions    ,
                    $core_plugapp_dirs                      ,
                    $loaded_datasets
                    ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $result ) ) {
        return nl2br( $result ) ;
    }

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $loaded_datasets = Array(
    //
    //          [teaser_categories] => Array(
    //
    //              [title]                 => Teaser Categories
    //
    //              [records]               => Array(
    //                  [0] => Array(
    //                      [created_server_datetime_UTC]            => 1401260826
    //                      [last_modified_server_datetime_UTC]      => 1401260826
    //                      [key]                                    => 3f0318c7-fcd9-4694-9d2b-8d74610bec66-1401260826-168058-145
    //                      [parent_key]                             =>
    //                      [title]                                  => Sample Teaser Page
    //                      [description]                            => PHA+QW4gZuPC9wPg0K
    //                      [description_format]                     => none
    //                      [image_url]                              =>
    //                      [sequence_number]                        =>
    //                      [imports_export_file_basename]           =>
    //                      [imports_export_datetime_UTC]            =>
    //                      [imports_original_teaser_category_title] =>
    //                      [imports_import_file_basename]           =>
    //                      )
    //                  ...
    //                  )
    //
    //              [key_field_slug]        => key
    //
    //              [record_indices_by_key] => Array(
    //                  [53365e603cdab] => 0
    //                  [53365e77656c4] => 1
    //                  ...
    //                  [5382f8db5d0c1] => 7
    //                  )
    //
    //              )
    //
    //          [teaser_layouts] => Array(
    //
    //              [title]                 => Teaser Layouts
    //
    //              [records]               => Array(
    //                  [0] => Array(
    //                      [created_server_datetime_UTC]       => 1398761346
    //                      [last_modified_server_datetime_UTC] => 1398761376
    //                      [key]                               => 535f6782aa913
    //                      [title]                             => "P and H Tags - Floated Image" - for "Iconic One"
    //                      [slug]                              => p-and-h-tags-floated-image-copy-1
    //                      [container_html]                    => WyoqVEVB2Rpdj4=
    //                      [title_html]                        => PGRpdiBPC9kaXY+
    //                      [text_html]                         => PGRpdiBjRpdj4=
    //                      [image_html]                        => PGRpdiBkaXY+
    //                      [read_more_html]                    => PGRpdi9kaXY+
    //                      [date_html]                         => PGRpdiBj9kaXY+
    //                      [spacer_html]                       =>
    //                      [description]                       =>
    //                      [image_url]                         =>
    //                      )
    //                  ...
    //                  )
    //
    //              [key_field_slug]        => key
    //
    //              [record_indices_by_key] => Array(
    //                  [535f6782aa913] => 0
    //                  )
    //
    //              )
    //
    //          [teaser_scripts] => Array(
    //
    //              [title]                 => Teaser Scripts
    //
    //              [records]               => Array(
    //                  [0] => Array(
    //                      [created_server_datetime_UTC]       => 1398761346
    //                      [last_modified_server_datetime_UTC] => 1398761456
    //                      [key]                               => 535f6782aa9a0
    //                      [layout_key]                        => 535f6782aa913
    //                      [title]                             => "P and H Tags - Floated Image" - for "Iconic One"
    //                      [slug]                              => p-and-h-tags-floated-image-copy-1-scripts
    //                      [container_js]                      =>
    //                      [title_js]                          =>
    //                      [text_js]                           =>
    //                      [image_js]                          =>
    //                      [read_more_js]                      =>
    //                      [date_js]                           =>
    //                      [spacer_js]                         =>
    //                      [description]                       =>
    //                      [image_url]                         =>
    //                      )
    //                  ...
    //                  )
    //
    //              [key_field_slug]        => key
    //
    //              [record_indices_by_key] => Array(
    //                  [535f6782aa9a0] => 0
    //                  )
    //
    //              )
    //
    //          [teasers] => Array(
    //
    //              [title]                 => Teasers
    //
    //              [records]               => Array(
    //                  [0] => Array(
    //                      [created_server_datetime_UTC]       => 1396257849
    //                      [last_modified_server_datetime_UTC] => 1401092342
    //                      [key]                               => 53393439b8b82
    //                      [parent_key]                        => 5382f8db5d0c1
    //                      [original_url]                      => http://www.rookiemag.com/2014/02/postcards-from-wonderland/
    //                      [original_title]                    => Postcards From Wonderland
    //                      [original_clipped_text]             => TXkgY1c2UuLi4=
    //                      [text_format]                       => none
    //                      [original_media_url]                => http://static.rookiemag.com/2014/02/13927942057DbvL-700x466.jpeg
    //                      [sequence_number]                   => 10
    //                      )
    //                  ...
    //                  )
    //
    //              [key_field_slug]        => key
    //
    //              [record_indices_by_key] => Array(
    //                  [53393439b8b82] => 0
    //                  ...
    //                  )
    //
    //              )
    //
    //          [teaser_settings] => Array(
    //
    //              [title]                 => Teaser Settings
    //
    //              [records]               => Array(
    //                  [0] => Array(
    //                      [created_server_datetime_UTC]       => 1397021148
    //                      [last_modified_server_datetime_UTC] => 1399513570
    //                      [key]                               => 5344d9dc6dfb1
    //                      [selected_layout_slug]              => custom
    //                      [custom_layout_key]                 => 535f6782aa913
    //                      [custom_style_key]                  => 535f6782aa95b
    //                      [custom_scripts_key]                => 535f6782aa9a0
    //                      )
    //                  ...
    //                  )
    //
    //              [key_field_slug]        => key
    //
    //              [record_indices_by_key] => Array(
    //                  [5344d9dc6dfb1] => 0
    //                  )
    //
    //              )
    //
    //          [teaser_styles] => Array(
    //
    //              [title]                 => Teaser Styles
    //
    //              [records]               => Array(
    //                  [0] => Array(
    //                      [created_server_datetime_UTC]       => 1398761346
    //                      [last_modified_server_datetime_UTC] => 1398761433
    //                      [key]                               => 535f6782aa95b
    //                      [layout_key]                        => 535f6782aa913
    //                      [title]                             => "P and H Tags - Floated Image" - for "Iconic One"
    //                      [slug]                              => p-and-h-tags-floated-image-copy-1-styles
    //                      [container_css]                     => RElWLDsNCn0=
    //                      [title_css]                         => RElWLaWw0KfQ==
    //                      [text_css]                          => RElWLLjVlbTsNCn0=
    //                      [image_css]                         => RElWLw0KfQ==
    //                      [read_more_css]                     => RElWMDsNCn0=
    //                      [date_css]                          => RElWLDQp9
    //                      [spacer_css]                        =>
    //                      [description]                       =>
    //                      [image_url]                         =>
    //                      )
    //                  ...
    //                  )
    //
    //              [key_field_slug]        => key
    //
    //              [record_indices_by_key] => Array(
    //                  [535f6782aa95b] => 0
    //                  )
    //
    //              )
    //
    //          )
    //
    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $loaded_datasets ) ;

    // =========================================================================
    // Make sure that the selected import file hasn't already been
    // imported...
    // =========================================================================

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $import_array = Array(
    //
    //          [instance_data] => Array(
    //              [export_file_basename] => sample-teaser-page-exported-28-may-2014-at-03-11-23-gmt.dat
    //              [export_datetime_UTC]  => 1401246683
    //              )
    //
    //          ...
    //
    //          )
    //
    //      $loaded_datasets = Array(
    //
    //          [teaser_categories] => Array(
    //              [title]                 => Teaser Categories
    //              [records]               => Array(
    //                  [0] => Array(
    //                      [created_server_datetime_UTC]            => 1401260826
    //                      [last_modified_server_datetime_UTC]      => 1401260826
    //                      [key]                                    => 3f0318c7-fcd9-4694-9d2b-8d74610bec66-1401260826-168058-145
    //                      [parent_key]                             =>
    //                      [title]                                  => Sample Teaser Page
    //                      [description]                            => PHA+QW4gZuPC9wPg0K
    //                      [description_format]                     => none
    //                      [image_url]                              =>
    //                      [sequence_number]                        =>
    //                      [imports_export_file_basename]           =>
    //                      [imports_export_datetime_UTC]            =>
    //                      [imports_original_teaser_category_title] =>
    //                      [imports_import_file_basename]           =>
    //                      )
    //                  ...
    //                  )
    //              [key_field_slug]        => key
    //              [record_indices_by_key] => Array(
    //                  [53365e603cdab] => 0
    //                  [53365e77656c4] => 1
    //                  ...
    //                  [5382f8db5d0c1] => 7
    //                  )
    //
    //              )
    //
    //          ...
    //
    //          )
    //
    // -------------------------------------------------------------------------

    foreach ( $loaded_datasets['teaser_categories']['records'] as $this_teaser_category ) {

        // ---------------------------------------------------------------------

        if (    array_key_exists( 'imports_import_file_basename' , $this_teaser_category )
                &&
                $this_teaser_category['imports_import_file_basename']
                ===
                $_FILES[ $file_field_name ]['name']
            ) {

            $msg = <<<EOT
<br />
<pre>
<span style="font-size:200%">&raquo;</span> <b style="font-size:125%">{$this_teaser_category['imports_import_file_basename']}</b>
</pre>
Sorry, but this Teaser Category has ALREADY been IMPORTED
EOT;

            echo $msg ;

            return ;

        }

        // ---------------------------------------------------------------------

        if (    array_key_exists( 'imports_export_file_basename' , $this_teaser_category )
                &&
                $this_teaser_category['imports_export_file_basename']
                ===
                $import_array['instance_data']['export_file_basename']
                &&
                array_key_exists( 'imports_export_datetime_UTC' , $this_teaser_category )
                &&
                $this_teaser_category['imports_export_datetime_UTC']
                ===
                $import_array['instance_data']['export_datetime_UTC']
            ) {

            $msg = <<<EOT
<br />
<pre>
<span style="font-size:200%">&raquo;</span> <b style="font-size:125%">{$this_teaser_category['imports_import_file_basename']}</b>
</pre>
Sorry, but this Teaser Category has ALREADY been IMPORTED
EOT;

            echo $msg ;

            return ;

        }

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // Support Routines...
    // =========================================================================

    require_once( $core_plugapp_dirs['dataset_manager_includes_dir'] . '/record-key-support.php' ) ;

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
    // get_unique_record_key_for_dataset(
    //      $record_indices_by_key
    //      )
    // - - - - - - - - - - - - - - - - -
    // RETURNS
    //      o   On SUCCESS
    //              $record_key STRING
    //
    //      o   On FAILURE
    //              ARRAY( $error_message STRING )
    // -------------------------------------------------------------------------

    // =========================================================================
    // ADD the TEASER CATEGORY...
    // =========================================================================

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $import_array = Array(
    //
    //          [instance_data] => Array(
    //              [export_file_basename] => sample-teaser-page-exported-28-may-2014-at-03-11-23-gmt.dat
    //              [export_datetime_UTC]  => 1401246683
    //              )
    //
    //          [teaser_category_records] => Array(
    //
    //              [teaser_categories] => Array(
    //                  [0] => Array(
    //                      [created_server_datetime_UTC]            => 1401260826
    //                      [last_modified_server_datetime_UTC]      => 1401260826
    //                      [key]                                    => 3f0318c7-fcd9-4694-9d2b-8d74610bec66-1401260826-168058-145
    //                      [parent_key]                             =>
    //                      [title]                                  => Sample Teaser Page
    //                      [description]                            => PHA+QW4gZuPC9wPg0K
    //                      [description_format]                     => none
    //                      [image_url]                              =>
    //                      [sequence_number]                        =>
    //                      [imports_export_file_basename]           =>
    //                      [imports_export_datetime_UTC]            =>
    //                      [imports_original_teaser_category_title] =>
    //                      [imports_import_file_basename]           =>
    //                      )
    //                  )
    //
    //              ...
    //
    //              )
    //
    //          ...
    //
    //          )
    //
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // New Teaser Category = Imported Teaser Category (with a few fields
    // added/changed)...
    // -------------------------------------------------------------------------

    $imported_teaser_category = $import_array['teaser_category_records']['teaser_categories'][0] ;

    $new_teaser_category = $imported_teaser_category ;

    // ========
    // TODO !!!
    // ========
    // We should CHECK ALL THE IMPORTED FIELDS (just as we'd do if we were
    // getting them from a $_POST (or whatever) form submission)

    // -------------------------------------------------------------------------
    // Set new teaser category's:-
    //      'created_server_datetime_UTC'
    //      'last_modified_server_datetime_UTC'
    //
    // fields...
    // -------------------------------------------------------------------------

    $time = time() ;

    $new_teaser_category['created_server_datetime_UTC']       = $time ;
    $new_teaser_category['last_modified_server_datetime_UTC'] = $time ;

    // -------------------------------------------------------------------------
    // Set new teaser category's "key" field...
    // -------------------------------------------------------------------------

    $imported_teaser_category_key =
        $imported_teaser_category[
            $loaded_datasets['teaser_categories']['key_field_slug']
            ] ;

    // -------------------------------------------------------------------------

    $new_teaser_category_key =
        \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\get_unique_record_key_for_dataset(
            $loaded_datasets['teaser_categories']['record_indices_by_key']
            ) ;

    // -------------------------------------------------------------------------

    if ( is_array( $new_teaser_category_key ) ) {
        echo nl2br( $new_teaser_category_key[0] ) ;
        return ;
    }

    // -------------------------------------------------------------------------

    $new_teaser_category[
        $loaded_datasets['teaser_categories']['key_field_slug']
        ] = $new_teaser_category_key ;

    // -------------------------------------------------------------------------
    // Set new teaser_category's "title" field...
    // -------------------------------------------------------------------------

    $new_teaser_category['title'] .=
        ' (imported ' .
        gmdate( 'j M Y \a\t H:i:s \G\M\T' ) .
        ')'
        ;

    // -------------------------------------------------------------------------
    // Set new teaser_category's:-
    //      'imports_import_file_basename'
    //      'imports_export_file_basename'
    //      'imports_export_datetime_UTC'
    //      'imports_original_teaser_category_title'
    //
    // fields...
    // -------------------------------------------------------------------------

    $new_teaser_category['imports_import_file_basename'] =
        $_FILES[ $file_field_name ]['name']
        ;

    // -------------------------------------------------------------------------

    $new_teaser_category['imports_export_file_basename'] =
        $import_array['instance_data']['export_file_basename']
        ;

    // -------------------------------------------------------------------------

    $new_teaser_category['imports_export_datetime_UTC'] =
        $import_array['instance_data']['export_datetime_UTC']
        ;

    // -------------------------------------------------------------------------

    $new_teaser_category['imports_original_teaser_category_title'] =
        $imported_teaser_category['title']
        ;

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $new_teaser_category ) ;

    // -------------------------------------------------------------------------
    // Set new teaser_category's:-
    //      'image_url'
    //
    // field...
    // -------------------------------------------------------------------------

    // ========
    // TODO !!!
    // ========

    // -------------------------------------------------------------------------
    // UPDATE and SAVE the TEASER CATEGORYS Dataset...
    // -------------------------------------------------------------------------

    $loaded_datasets['teaser_categories']['records'][] = $new_teaser_category ;

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

    $dataset_slug          = 'teaser_categories' ;
    $dataset_records       = $loaded_datasets['teaser_categories']['records'] ;
    $question_die_on_error = FALSE ;

    // -------------------------------------------------------------------------

    $result = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_arrayStorage\save_numerically_indexed(
                    $dataset_slug               ,
                    $dataset_records            ,
                    $question_die_on_error
                    ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $result ) ) {
        echo nl2br( $result ) ;
        return ;
    }

    // =========================================================================
    // IMPORT the TEASER IMAGES...
    // =========================================================================

     require_once( dirname( __FILE__ ) . '/import-teaser-images.php' ) ;

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

    $teaser_image_urls_new_by_old = import_teaser_images(
                                        $core_plugapp_dirs      ,
                                        $import_array           ,
                                        $loaded_datasets
                                        ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $teaser_image_urls_new_by_old ) ) {
        echo nl2br( $teaser_image_urls_new_by_old ) ;
        return ;
    }

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $teaser_image_urls_new_by_old = Array(
    //          [http://localhost/plugdev/wp-content/uploads/2013/07/teaser-postcards-from-wonderland.png] =>
    //              http://www.example.com/wp-content/uploads/2014/05/teaser-postcards-from-wonderland.png
    //          )
    //
    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $teaser_image_urls_new_by_old ) ;

    // =========================================================================
    // ADD the teaser category's TEASERS...
    // =========================================================================

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $import_array = Array(
    //
    //          [instance_data] => Array(
    //              [export_file_basename] => sample-teaser-page-exported-28-may-2014-at-03-11-23-gmt.dat
    //              [export_datetime_UTC]  => 1401246683
    //              )
    //
    //          [teaser_category_records] => Array(
    //
    //              ...
    //
    //              [teasers] => Array(
    //                  [0] => Array(
    //                      [created_server_datetime_UTC]       => 1396257849
    //                      [last_modified_server_datetime_UTC] => 1401092342
    //                      [key]                               => 53393439b8b82
    //                      [parent_key]                        => 5382f8db5d0c1
    //                      [original_url]                      => http://www.rookiemag.com/2014/02/postcards-from-wonderland/
    //                      [original_title]                    => Postcards From Wonderland
    //                      [original_clipped_text]             => TXkgYmVzdiaG91c2UuLi4=
    //                      [text_format]                       => none
    //                      [original_media_url]                => http://static.rookiemag.com/2014/02/13927942057DbvL-700x466.jpeg
    //                      [sequence_number]                   => 10
    //                      )
    //                  ...
    //                  )
    //
    //          ...
    //
    //          )
    //
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // Get the new teaser keys...
    // -------------------------------------------------------------------------

    $new_teaser_keys_by_old_teaser_key = array() ;

    // -------------------------------------------------------------------------

    foreach ( $import_array['teaser_category_records']['teasers'] as $this_teaser ) {

        // ---------------------------------------------------------------------

        while ( TRUE ) {

            // -----------------------------------------------------------------

            $new_teaser_key =
                \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\get_unique_record_key_for_dataset(
                    $loaded_datasets['teasers']['record_indices_by_key']
                    ) ;

            // -----------------------------------------------------------------

            if ( is_array( $new_teaser_key ) ) {
                echo nl2br( $new_teaser_key[0] ) ;
                return ;
            }

            // -----------------------------------------------------------------

            if ( ! in_array( $new_teaser_key , $new_teaser_keys_by_old_teaser_key , TRUE ) ) {

                $new_teaser_keys_by_old_teaser_key[
                    $this_teaser[ $loaded_datasets['teasers']['key_field_slug'] ]
                    ] = $new_teaser_key ;

                break ;

            }

            // -----------------------------------------------------------------

        }

        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------
    // Import the teaser category's teasers...
    // -------------------------------------------------------------------------

    foreach ( $import_array['teaser_category_records']['teasers'] as $imported_teaser ) {

        // ---------------------------------------------------------------------
        // New Teaser = Imported Teaser (with a few fields added/changed)...
        // ---------------------------------------------------------------------

        $new_teaser = $imported_teaser ;

        // ========
        // TODO !!!
        // ========
        // We should CHECK ALL THE IMPORTED FIELDS (just as we'd do if we were
        // getting them from a $_POST (or whatever) form submission)

        // ---------------------------------------------------------------------
        // Set new teaser's:-
        //      'created_server_datetime_UTC'
        //      'last_modified_server_datetime_UTC'
        //
        // fields...
        // ---------------------------------------------------------------------

        $time = time() ;

        $new_teaser['created_server_datetime_UTC']       = $time ;
        $new_teaser['last_modified_server_datetime_UTC'] = $time ;

        // ---------------------------------------------------------------------
        // Set new teaser's "key" field...
        // ---------------------------------------------------------------------

        $new_teaser[
            $loaded_datasets['teasers']['key_field_slug']
            ] = $new_teaser_keys_by_old_teaser_key[
                    $imported_teaser[
                        $loaded_datasets['teasers']['key_field_slug']
                        ]
                    ] ;

        // ---------------------------------------------------------------------
        // Set new teaser's "parent_key" field...
        // ---------------------------------------------------------------------

        if ( $imported_teaser['parent_key'] !== $imported_teaser_category_key ) {

            $msg = <<<EOT
PROBLEM:&nbsp; Unrecognised/unsupported teaser category
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            echo nl2br( $msg ) ;

            return ;

        }

        // ---------------------------------------------------------------------

        $new_teaser['parent_key'] = $new_teaser_category_key ;

        // -------------------------------------------------------------------------
        // Set new teaser's:-
        //      'original_media_url'
        //
        // field...
        // -------------------------------------------------------------------------

        if ( array_key_exists(
                $imported_teaser['original_media_url']          ,
                $teaser_image_urls_new_by_old
                )
            ) {

            $new_teaser['original_media_url'] =
                $teaser_image_urls_new_by_old[ $imported_teaser['original_media_url'] ]
                ;

        }

        // -------------------------------------------------------------------------
        // Add the new teaser to the "Teasers" dataset...
        // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $new_teaser ) ;

        $loaded_datasets['teasers']['records'][] = $new_teaser ;

        // -------------------------------------------------------------------------
        // Repeat with the next teaser to import (if there is one)...
        // -------------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------
    // SAVE the updated TEASERS Dataset...
    // -------------------------------------------------------------------------

    $dataset_slug          = 'teasers' ;
    $dataset_records       = $loaded_datasets['teasers']['records'] ;
    $question_die_on_error = FALSE ;

    // -------------------------------------------------------------------------

    $result = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_arrayStorage\save_numerically_indexed(
                    $dataset_slug               ,
                    $dataset_records            ,
                    $question_die_on_error
                    ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $result ) ) {
        echo nl2br( $result ) ;
        return ;
    }

    // =========================================================================
    // Display the "SUCCESS" screen...
    // =========================================================================

    require_once( $core_plugapp_dirs['dataset_manager_includes_dir'] . '/get-dataset-urls.php' ) ;

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\get_manage_dataset_url(
    //      $caller_apps_includes_dir   ,
    //      $question_front_end         ,
    //      $dataset_slug = NULL
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Returns the "manage-dataset" URL.
    //
    // If $dataset_slug is NULL, then we use:-
    //      $_GET['dataset_slug']
    //
    // RETURNS
    //      o   On SUCCESS!
    //          - - - - - -
    //          STRING $url
    //
    //      o   On FAILURE!
    //          - - - - - -
    //          ARRAY( $error_message STRING )
    // -------------------------------------------------------------------------

    $caller_apps_includes_dir = $core_plugapp_dirs['plugins_includes_dir'] ;
    $question_front_end       = FALSE ;
    $dataset_slug             = 'teaser_categories' ;

    // -------------------------------------------------------------------------

    $_GET['application'] = 'teaser-maker' ;

    // -------------------------------------------------------------------------

    $ok_href = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\get_manage_dataset_url(
                    $caller_apps_includes_dir   ,
                    $question_front_end         ,
                    $dataset_slug
                    ) ;

    // -------------------------------------------------------------------------

    if ( is_array( $ok_href ) ) {
        echo nl2br( $ok_href[0] ) ;
        return ;
    }

    // -------------------------------------------------------------------------

    echo <<<EOT
<br />
Teaser Category (and it's Teasers) imported OK<br />
<br />
<a  href="{$ok_href}"
    style="text-decoration:none"
    >OK</a><br />
<br />
<br />
EOT;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// That's that!
// =============================================================================

