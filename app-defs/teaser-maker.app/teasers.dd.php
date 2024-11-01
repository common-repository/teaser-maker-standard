<?php

// *****************************************************************************
// TEASER-MAKER.APP / TEASERS.DD.PHP
// (C) 2014 Peter Newman. All Rights Reserved.
// *****************************************************************************

    namespace greatKiwi_byFernTec_teaserMaker_std_v0x1x114_datasetDef_teasers ;
        //  NOTE!
        //  -----
        //  The dataset name/slug should be camel cased.  Eg:-
        //      projects
        //      referenceUrls
        //      globalLogMessages

// =============================================================================
// get_dataset_details()
// =============================================================================

function get_dataset_details(
    $caller_app_slash_plugins_global_namespace      ,
    $question_front_end
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_datasetDef_teasers\get_dataset_details(
    //      $caller_app_slash_plugins_global_namespace      ,
    //      $question_front_end
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Returns an array holding the specified dataset's details - as required
    // by the dataset manager.
    //
    // The returned array is like (eg):-
    //
    //      $dataset_details = array(
    //          'dataset_slug'              =>  'projects'      ,
    //          'dataset_name_singular'     =>  'project'       ,
    //          'dataset_name_plural'       =>  'projects'      ,
    //          'dataset_title_singular'    =>  'Project'       ,
    //          'dataset_title_plural'      =>  'Projects'      ,
    //          'basepress_dataset_handle'  =>  array(...)
    //          ) ;
    //
    // -------------------------------------------------------------------------

    // =========================================================================
    // Define this dataset's BASEPRESS DATASET HANDLE...
    // =========================================================================

    $basepress_dataset_uid =
        'b902e187-ac3e-4e40-a2e0-34263b6c7a53' . '-' .
        'f6093032-cff3-42a6-8788-a0e30c6738c7' . '-' .
        '91cdfd70-a02f-11e3-a5e2-0800200c9a66' . '-' .
        'b09321ba-6359-47bd-8dfc-6038ebd484ed'
        ;

    // -------------------------------------------------------------------------

    $basepress_dataset_handle = array(
        'nice_name'     =>  'teaserMaker_byFernTec_teasers'         ,
        'unique_key'    =>  $basepress_dataset_uid                  ,
        'version'       =>  '0.1'
        ) ;

    // =========================================================================
    // Support...
    // =========================================================================

    require_once( dirname( __FILE__ ) . '/teaser-resources.php' ) ;

    // =========================================================================
    // Record Structure...
    // =========================================================================

    $array_storage_record_structure = array(

//      array(
//          'slug'          =>  'datetime_created_UTC'      ,
//          'type'          =>  STANDARD_DATASET_MANAGER_FIELD_TYPE_CREATED_SERVER_DATETIME_UTC
//          )   ,
//      array(
//          'slug'          =>  'datetime_last_modified_UTC'    ,
//          'type'          =>  STANDARD_DATASET_MANAGER_FIELD_TYPE_LAST_MODIFIED_SERVER_DATETIME_UTC
//          )   ,
//      array(
//          'slug'          =>  'key'           ,
//          'post_var_name' =>  'record_key'    ,
//          'type'          =>  STANDARD_DATASET_MANAGER_FIELD_TYPE_UNIQUE_KEY
//          )   ,
//      array(
//          'slug'          =>  'title'         ,
//          'post_var_name' =>  'title'         ,
//          'constraints'   =>  array(
//                                  array(
//                                      'type'  =>  'unique-case-insensitively'
//                                      )
//                                  )
//          )   ,
//      array(
//          'slug'          =>  'notes_slash_comments'      ,
//          'post_var_name' =>  'notes_slash_comments'
//          )

        array(
            'slug'          =>  'created_server_datetime_UTC'       ,
            'value_from'    =>  array(
                                    'method'    =>  'created-server-datetime-utc'
                                    )   ,
            'constraints'   =>  array(
                                    array(
                                        'method'    =>  'unix-timestamp'
                                        )
                                    )
            )   ,

        array(
            'slug'          =>  'last_modified_server_datetime_UTC'     ,
            'value_from'    =>  array(
                                    'method'    =>  'last-modified-server-datetime-utc'
                                    )   ,
            'constraints'   =>  array(
                                    array(
                                        'method'    =>  'unix-timestamp'
                                        )
                                    )
            )   ,

        array(
            'slug'          =>  'key'       ,
            'value_from'    =>  array(
                                    'method'    =>  'unique-key'
                                    )   ,
            'constraints'   =>  array(
                                    array(
                                        'method'    =>  'unique-key'
                                        )
                                    )
            )   ,

        array(
            'slug'          =>  'parent_key'        ,
            'value_from'    =>  array(
                                    'method'    =>  'post'              ,
                                    'instance'  =>  'parent_key'
                                    )   ,
            'constraints'   =>  array(
                                    array(
                                        'method'    =>  'unique-key-or-empty-string'
                                        )
                                    )
            )   ,

        array(
            'slug'          =>  'original_url'              ,
            'value_from'    =>  array(
                                    'method'    =>  'post'              ,
                                    'instance'  =>  'original_url'
                                    )   ,
            'constraints'   =>  array()
            )   ,

        array(
            'slug'          =>  'original_title'                ,
            'value_from'    =>  array(
                                    'method'    =>  'post'              ,
                                    'instance'  =>  'original_title'
                                    )   ,
            'constraints'   =>  array()
            )   ,

        array(
            'slug'          =>  'original_clipped_text'         ,
            'value_from'    =>  array(
                                    'method'    =>  'post'                      ,
                                    'instance'  =>  'original_clipped_text'
                                    )   ,
            'constraints'   =>  array()     ,
            'base64_encode' =>  'pre-check'
            )   ,

        array(
            'slug'          =>  'text_format'                   ,
            'value_from'    =>  array(
                                    'method'    =>  'post'          ,
                                    'instance'  =>  'text_format'   ,
                                    'default'   =>  'none'      //  "default" must be specified for "radio" type controls
                                    )   ,
            'constraints'   =>  array()
            )   ,

        array(
            'slug'          =>  'original_media_url'        ,
            'value_from'    =>  array(
                                    'method'    =>  'post'                  ,
                                    'instance'  =>  'original_media_url'
                                    )   ,
            'constraints'   =>  array()
            )   ,

        array(
            'slug'          =>  'sequence_number'               ,
            'value_from'    =>  array(
                                    'method'    =>  'post'              ,
                                    'instance'  =>  'sequence_number'
                                    )   ,
            'constraints'   =>  array()
            )

        ) ;

    // =========================================================================
    // Zebra-Form Form Definition...
    // =========================================================================

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\get_add_edit_form_cancel_href_and_onclick(
    //      $caller_app_slash_plugins_global_namespace      ,
    //      $question_front_end                             ,
    //      $dataset_slug
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // RETURNS
    //      o   On SUCCESS!
    //          - - - - - -
    //          array(
    //              $cancel_href STRING
    //              $onclick STRING
    //              )
    //
    //      o   On FAILURE!
    //          - - - - - -
    //          $error_message STRING
    // -------------------------------------------------------------------------

//  $result = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\get_add_edit_form_cancel_href_and_onclick(
//                  $caller_app_slash_plugins_global_namespace      ,
//                  $question_front_end                             ,
//                  'teasers'
//                  ) ;
//
//  // -------------------------------------------------------------------------
//
//  if ( is_string( $result ) ) {
//      return $result ;
//  }
//
//  // -------------------------------------------------------------------------
//
//  list(
//      $cancel_href    ,
//      $onclick
//      ) = $result ;

    // -------------------------------------------------------------------------

    $get_cancel_button_onclick_attribute_value_function_name =
        '\\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager' .
        '\\get_cancel_button_onclick_attribute_value'
        ;

    // -------------------------------------------------------------------------

    $help_markdown = <<<EOT
<a target="_blank" href="http://michelf.ca/projects/php-markdown/reference/" style="text-decoration:none"><b>help</b></a>
EOT;

    // -------------------------------------------------------------------------

    $help_bbcode = <<<EOT
<a target="_blank" href="http://nbbc.sourceforge.net/readme.php?page=intro_over" style="text-decoration:none"><b>help</b></a>
EOT;

    // -------------------------------------------------------------------------

    $focus_field_slug = 'parent_key' ;

    if (    function_exists( '\\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_pluginSetup\\is_export_version_short_slug' )
            &&
            \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_pluginSetup\is_export_version_short_slug( 'std' )
        ) {
        $focus_field_slug = 'original_url' ;
    }

    // -------------------------------------------------------------------------

    $zebra_form = array(

        'form_specs'    =>  array(
                                'name'                      =>  'add_edit_teaser'       ,
                                'method'                    =>  'POST'                  ,
                                'action'                    =>  ''                      ,
                                'attributes'                =>  array()                 ,
                                'clientside_validation'     =>  TRUE
                                )   ,

        'field_specs'   =>  array(


            array(
                'form_field_name'       =>  'parent_key'                ,
                'zebra_control_type'    =>  'hidden'                    ,
                'value_from'            => Array(
                    'add' => Array(
                                'method'    =>  'literal'   ,
                                'args'      =>  ''
                        )   ,
                    'edit' => Array(
                                'method'    =>  'literal'   ,
                                'args'      =>  ''
                        )
                    )   ,
                'attributes'            =>  array()     ,
                'rules'                 =>  array(
                    'required'  =>  array(
                                        'error'             ,   // variable to add the error message to
                                        'Field is required'     // error message if value doesn't validate
                                        )
                    )
                )   ,




            array(
                'form_field_name'       =>  'original_url'      ,
                'zebra_control_type'    =>  'text'              ,
                'label'                 =>  'Original URL'      ,
                'help_text'             =>  'The URL of the page the teaser points to.&nbsp; This page can be on your <b>own site or an external site</b>.'       ,
                'attributes'            =>  array(
                                                'style'     =>  'width:98%'
                                                )               ,
                'rules'                 =>  array(
                    'required'  =>  array(
                                        'error'             ,   // variable to add the error message to
                                        'Field is required'     // error message if value doesn't validate
                                        )
                    )
                )   ,

            array(
                'form_field_name'       =>  'original_title'    ,
                'zebra_control_type'    =>  'text'              ,
                'label'                 =>  'Title'             ,
                'help_text'             =>  'The title for this teaser.&nbsp; Using the <b>same title as the page the teaser points to</b> usually works well.'     ,
                'attributes'            =>  array(
                                                'style'     =>  'width:98%'
                                                )               ,
                'rules'                 =>  array(
                    'required'  =>  array(
                                        'error'             ,   // variable to add the error message to
                                        'Field is required'     // error message if value doesn't validate
                                        )
                    )
                )   ,

            array(
                'form_field_name'       =>  'original_clipped_text'         ,
                'zebra_control_type'    =>  'textarea'                      ,
                'label'                 =>  'Text'                          ,
                'help_text'             =>  'A description of the page/content the teaser points to (eg; <b>copy/paste the first paragraph</b> of the page the teaser points to).'     ,
                'attributes'            =>  array(
                                                'style'     =>  'width:98%; height:200px'
                                                )                           ,
                'rules'                 =>  array(
                    'required'  =>  array(
                                        'error'             ,   // variable to add the error message to
                                        'Field is required'     // error message if value doesn't validate
                                        )
                    )
                )   ,

            array(
                'form_field_name'       =>  'text_format'                   ,
                'zebra_control_type'    =>  'radios'                        ,
                'label'                 =>  'Text Format'                   ,
                'help_text'             =>  'In case you want/need to <b>re-format</b> - or <b>add links, lists and/or images (etc)</b> to - the copy/pasted text...'        ,
                'attributes'            =>  array(
                                                'style'     =>  'margin-left:1.5em'
                                                )                           ,
                'rules'                 =>  array()                         ,
                'type_specific_args'    =>  array(
                    'radios'    =>  array(
                        'none'          =>  'Render the <b>text/HTML</b> as is (default)'       ,
                        'nl2br'         =>  '<b>nl2br</b> (Preserve line breaks)'               ,
                        'markdown'      =>  '<b>Markdown</b>&nbsp;' . $help_markdown            ,
                        'bbcode'        =>  '<b>BBCode</b>&nbsp;' . $help_bbcode
                        )
                        //  Make sure that:-
                        //      ['array_storage_record_structure']['value_from']['default']
                        //  is set to one of the above
                    )
                )   ,

            array(
                'form_field_name'       =>  'original_media_url'        ,
                'zebra_control_type'    =>  'text'                      ,
                'label'                 =>  'Original Image URL'        ,
                'help_text'             =>  'Optional (make your teaser more interesting/eye-catching with an image)...'     ,
                'attributes'            =>  array(
                                                'style'     =>  'width:98%'
                                                )                       ,
                'rules'                 =>  array()
                )   ,

            array(
                'form_field_name'       =>  'sequence_number'   ,
                'zebra_control_type'    =>  'text'              ,
                'label'                 =>  'Sequence Number'   ,
//              'help_text'             =>  'The title for this teaser.&nbsp; Using the <b>same title as the page the teaser points to</b> usually works well.'     ,
                'attributes'            =>  array(
                                                'style'     =>  'width:98%'
                                                )               ,
                'rules'                 =>  array()
                )   ,

            array(
                'form_field_name'       =>  'save_me'       ,
                'zebra_control_type'    =>  'submit'        ,
                'label'                 =>  NULL            ,
                'attributes'            =>  array()         ,
                'rules'                 =>  array()         ,
                'type_specific_args'    =>  array(
                    'caption'   =>  'Submit'
                    )
                )   ,

            array(
                'form_field_name'       =>  'cancel'                    ,
                'zebra_control_type'    =>  'button'                    ,
                'label'                 =>  NULL                        ,
//              'attributes'            =>  array(
//                                              'onclick'   =>  $onclick
//                                              )   ,
                'dynamic_attributes'    =>  array(
                    'onclick'       =>  array(
                        'function_name'     =>  $get_cancel_button_onclick_attribute_value_function_name    ,
                        'extra_args'        =>  NULL
                        )
                    )   ,
                'rules'                 =>  array()                     ,
                'type_specific_args'    =>  array(
                    'caption'       =>  'Cancel'        ,
                    'type'          =>  'button'
                    )
                )

            )   ,

        'focus_field_slug'  =>  $focus_field_slug

        ) ;

    // =========================================================================
    // Dataset Records Table...
    // =========================================================================

    $dataset_records_table_columns = array(

//      array(
//          'base_slug'                     =>  'xxx'
//          'label'                         =>  'Xxx' OR ''/NULL (means use "to_title( <base slug> )"
//          'question_sortable'             =>  TRUE OR FALSE/NULL
//          'raw_value_from'                =>  array(
//                                                  'method'    =>  'array-storage-field-slug'      ,
//                                                  'instance'  =>  "xxx"
//                                                  )   ,
//                                              --OR--
//                                              array(
//                                                  'method'    =>  'special-type'                  ,
//                                                  'instance'  =>  "action"
//                                                  )   ,
//                                              --OR--
//                                              array(
//                                                  'method'    =>  'foreign-field'                 ,
//                                                  'instance'  =>  "<target-field-name>"
//                                                  'args'      =>  array(
//                                                                      array(
//                                                                          'pointer_field_array_storage_slug'  =>  '<pointer_field_slug>'  ,
//                                                                          'foreign_dataset'                   =>  '<dataset_slug>'
//                                                                          )   ,
//                                                                      ...
//                                                                      )
//                                                  )   ,
//
//          'width_in_percent'              =>  1 to 100 (All columns must add up 100%.  Though
//                                              some columns may be left 0/NULL or unspecified -
//                                              in which case the leftover width will be evenly
//                                              distributed amongst these columns.
//          'header_halign'                 =>  'left' | 'center' | 'right'
//          'header_valign'                 =>  'top' | 'middle' | 'bottom'
//          'data_halign'                   =>  'left' | 'center' | 'right'
//          'data_valign'                   =>  'top' | 'middle' | 'bottom'
//
//          'data_field_slug_4_display'     =>  "xxx" (generated automatically; DON'T specify)
//          'data_field_slug_4_sort'        =>  "xxx" (generated automatically; DON'T specify)
//          )   ,

        array(
            'base_slug'                     =>  'original_title'        ,
            'label'                         =>  'Title'                 ,
            'question_sortable'             =>  TRUE                    ,
            'raw_value_from'                =>  array(
                                                    'method'    =>  'array-storage-field-slug'  ,
                                                    'instance'  =>  'original_title'
                                                    )   ,
            'display_treatments'            =>  NULL
            )   ,

        array(
            'base_slug'                     =>  'original_clipped_text'     ,
            'label'                         =>  'Clipping'                  ,
            'question_sortable'             =>  FALSE                       ,
            'raw_value_from'                =>  array(
                                                    'method'    =>  'array-storage-field-slug'  ,
                                                    'instance'  =>  'original_clipped_text'
                                                    )   ,
            'display_treatments'            =>  array(
                array(
                    'method'    =>  'wrapper'       ,
                    'args'      =>  array(
                                        'before'    =>  '<div style="height:80px; overflow:auto">'      ,
                                        'after'     =>  '</div>'
                                        )
                    )
                )
            )   ,

        array(
            'base_slug'                     =>  'original_media_url'        ,
            'label'                         =>  'Media'                     ,
            'question_sortable'             =>  FALSE                       ,
            'raw_value_from'                =>  array(
                                                    'method'    =>  'array-storage-field-slug'  ,
                                                    'instance'  =>  'original_media_url'
                                                    )   ,
            'display_treatments'            =>  array(
                array(
                    'method'    =>  'image'         ,
                    'args'      =>  array(
                                        'style'     =>  'height:80px'       ,
                                        )
                                    )
                    )
            )   ,

        array(
            'base_slug'                     =>  'action'            ,
            'label'                         =>  'Action'            ,
            'question_sortable'             =>  FALSE               ,
            'raw_value_from'                =>  array(
                                                    'method'    =>  'special-type'      ,
                                                    'instance'  =>  'record-action'
                                                    )   ,
            'display_treatments'            =>  NULL
            )

        ) ;

    // -------------------------------------------------------------------------
    // The Complete "Dataset Records Table" Definition...
    // -------------------------------------------------------------------------

//      'data_field_defs'                       =>  array(...) OR array()/NULL (means default to columns suggested by dataset records)

    $dataset_records_table = array(

//      'column_defs'                           =>  array(...) OR array()/NULL (means default to columns suggested by "data_field_defs")
//      'rows_per_page'                         =>  10                                          ,
//      'default_data_field_slug_to_orderby'    =>  'xxx' || ''/NULL (means orderby FIRST data field)
//      'default_order'                         =>  'asc' OR 'desc' OR ''/NULL (means default to "asc")
//      'actions'                               =>  array(
//                                                      'edit'      =>  'edit'      ,
//                                                      'delete'    =>  'delete'
//                                                      )   ,
//      'action_separator'                      =>  ' &nbsp;&nbsp; '

        'column_defs'                           =>  $dataset_records_table_columns              ,
        'rows_per_page'                         =>  10                                          ,
        'default_data_field_slug_to_orderby'    =>  'original_title'                            ,
        'default_order'                         =>  'asc'                                       ,
        'buttons'                               =>  array(
                                                        array(
                                                            'type'  =>  'add_record'
                                                            )
//                                                      array(
//                                                          'type'                          =>  'custom'                                                            ,
//                                                          'title'                         =>  'Clone/Copy Built-In Layout'                                        ,
//                                                          'get_button_html_function_name' =>  '\\' . __NAMESPACE__ . '\\get_clone_built_in_layout_button_html'    ,
//                                                          'extra_args'                    =>  NULL
//                                                          )   ,
//                                                      array(
//                                                          'type'  =>  'delete_all_records'
//                                                          )   ,
//                                                      array(
//                                                          'type'  =>  'show_orphaned_records'
//                                                          )
                                                        )   ,
        'record_actions'                        =>  array(
                                                        array(
                                                            'type'          =>  'standard'      ,
                                                            'slug'          =>  'edit'          ,
                                                            'link_title'    =>  'edit'
                                                            )   ,
                                                        array(
                                                            'type'          =>  'standard'      ,
                                                            'slug'          =>  'delete'        ,
                                                            'link_title'    =>  'delete'
                                                            )   ,
//                                                      array(
//                                                          'type'          =>  'custom'        ,
//                                                          'slug'          =>  'post-teaser'   ,
//                                                          'link_title'    =>  'post'
//                                                          )
                                                        )   ,
        'action_separator'                      =>  ' &nbsp;&nbsp; '

        ) ;

    // =========================================================================
    // CUSTOM ACTIONS
    // =========================================================================

//  $custom_action_teaser_to_post_filespec =
//      dirname( __FILE__ ) . '/plugin.stuff/scripts/teaser-to-post.php'
//      ;

    // -------------------------------------------------------------------------

    $custom_actions = array(

//      array(
//          'slug'      =>  'post-teaser'                   ,
//          'args'      =>  array(
//                              'include_filespec'              =>  $custom_action_teaser_to_post_filespec                                                  ,
//                              'namespace_and_function_name'   =>  '\\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_teaserMaker\\teaser_to_post'
//                              )
//          )

        ) ;

    // =========================================================================
    // Define this dataset's details - as required by the dataset manager...
    // =========================================================================

    $dataset_details = array(
        'dataset_slug'                      =>  'teasers'                           ,
        'dataset_name_singular'             =>  'teaser'                            ,
        'dataset_name_plural'               =>  'teasers'                           ,
        'dataset_title_singular'            =>  'Teaser'                            ,
        'dataset_title_plural'              =>  'Teasers'                           ,
        'basepress_dataset_handle'          =>  $basepress_dataset_handle           ,
        'dataset_records_table'             =>  $dataset_records_table              ,
        'zebra_forms'                       =>  array(
                                                    'default'   =>  $zebra_form
                                                    )                               ,
        'array_storage_record_structure'    =>  $array_storage_record_structure     ,
        'array_storage_key_field_slug'      =>  'key'                               ,
        'custom_actions'                    =>  $custom_actions                     ,
        'parent_details'                    =>  array(
            'type'                  =>  'single-parent-key-field'   ,
            'type_specific_args'    =>  array(
                'parent_dataset_slug'                       =>  'teaser_categories'     ,
                'parent_dataset_key_field_slug'             =>  'parent_key'
                )
            )
            //  This dataset's records ***may*** optionally have a PARENT.
            //  o   "parent_dataset_slug" must be a non-empty string.
            //  o   The array storage record's:-
            //          ""
            //      field may contain either:-
            //          --  The empty string (in which case, this child
            //              record has NO parent), or;
            //          --  A "record key" from the parent dataset.
            //
            //  The dataset records may have CHILDREN too (see
            //  "child_dataset_slugs", below).
        ) ;

    // =========================================================================
    // Return this dataset's details...
    // =========================================================================

    return $dataset_details ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// That's that!
// =============================================================================

