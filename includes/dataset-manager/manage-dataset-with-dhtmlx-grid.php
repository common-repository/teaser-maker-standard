<?php

// *****************************************************************************
// DATASET-MANAGER / MANAGE-DATASET-WITH-DHTMLX-GRID.PHP
// (C) 2013 Peter Newman. All Rights Reserved.
// *****************************************************************************

    namespace greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager ;

// =============================================================================
// manage_dataset_with_dhtmlx_grid()
// =============================================================================

function manage_dataset_with_dhtmlx_grid(
    $caller_app_slash_plugins_global_namespace      ,
    $dataset_manager_home_page_title                ,
    $caller_apps_includes_dir                       ,
    $all_application_dataset_definitions            ,
    $selected_datasets_dmdd                         ,
    $dataset_records                                ,
    $dataset_title                                  ,
    $dataset_slug                                   ,
    $question_front_end                             ,
    $orphaned_record_indices
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\manage_dataset_with_dhtmlx_grid(
    //      $caller_app_slash_plugins_global_namespace      ,
    //      $dataset_manager_home_page_title                ,
    //      $caller_apps_includes_dir                       ,
    //      $all_application_dataset_definitions            ,
    //      $selected_datasets_dmdd                         ,
    //      $dataset_records                                ,
    //      $dataset_title                                  ,
    //      $dataset_slug                                   ,
    //      $question_front_end                             ,
    //      $orphaned_record_indices
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Creates and returns a widget for adding, editing and deleting records
    // of the specified dataset.
    //
    // $all_application_dataset_definitions should be like (eg):-
    //
    //      $all_application_dataset_definitions = Array(
    //
    //          [projects] => Array(    //  <== "dataset_slug"
    //              [dataset_slug]              => projects
    //              [dataset_name_singular]     => project
    //              [dataset_name_plural]       => projects
    //              [dataset_title_singular]    => Project
    //              [dataset_title_plural]      => Projects
    //              [basepress_dataset_handle]  => array(...)
    //              )
    //
    //          ...
    //
    //          )
    //
    // NOTE!
    // =====
    // The returned widget be the widget requested proper.  Or it may be just
    // (eg;) a header, error message and footer.
    //
    // RETURNS:-
    //      $page_html STRING
    // -------------------------------------------------------------------------

    // =========================================================================
    // CHECK and DEFAULT the "DATASET REORDS TABLE" (definition) (from which
    // we create the DHTMLX GRID to display the records in)...
    // =========================================================================

    require_once( dirname( __FILE__ ) . '/check-and-default-dataset-records-table.php' ) ;

    // -------------------------------------------------------------------------
    // check_and_default_dataset_records_table(
    //      $dataset_manager_home_page_title        ,
    //      $caller_apps_includes_dir               ,
    //      $all_application_dataset_definitions    ,
    //      $selected_datasets_dmdd                 ,
    //      $dataset_records                        ,
    //      $dataset_title                          ,
    //      $dataset_slug                           ,
    //      $question_front_end
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - -
    // Checks for:-
    //      $selected_datasets_dmdd['dataset_records_table']
    //
    // defaulting it and it's members as necessary.
    //
    // RETURNS:-
    //      On SUCCESS!
    //      - - - - - -
    //      $dataset_records_table = array(
    //          'columns'                       =>  array(...) OR array()/NULL (means default to columns in "data")
    //          'data'                          =>  array(...) OR array()/NULL (means default to columns in dataset records)
    //          'data_field_slug_to_orderby'    =>  'xxx' || ''/NULL (means orderby FIRST data field)
    //          'order'                         =>  'asc' OR 'desc' OR ''/NULL (means default to "asc")
    //          'actions'                       =>  array(
    //                                                  'edit'      =>  'edit'      ,
    //                                                  'delete'    =>  'delete'
    //                                                  )   ,
    //          'action_separator'              =>  ' &nbsp;&nbsp; '
    //          )
    //
    //      On FAILURE!
    //      - - - - - -
    //      $error_message STRING
    // -------------------------------------------------------------------------

    $result = check_and_default_dataset_records_table(
                    $dataset_manager_home_page_title        ,
                    $caller_apps_includes_dir               ,
                    $all_application_dataset_definitions    ,
                    $selected_datasets_dmdd                 ,
                    $dataset_records                        ,
                    $dataset_title                          ,
                    $dataset_slug                           ,
                    $question_front_end
                    ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $result ) ) {

        return standard_dataset_manager_error(
            $dataset_manager_home_page_title    ,
            $result                             ,
            $caller_apps_includes_dir           ,
            $question_front_end
            ) ;

    }

    // -------------------------------------------------------------------------

    $selected_datasets_dmdd['dataset_records_table'] = $result ;

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $selected_datasets_dmdd['dataset_records_table'] = array(
    //
    //          'column_defs'   =>  array(
    //
    //      //      array(
    //      //          'base_slug'                     =>  'xxx'
    //      //          'label'                         =>  'Xxx' OR ''/NULL (means use "to_title( <base slug> )"
    //      //          'question_sortable'             =>  TRUE OR FALSE/NULL
    //      //          'raw_value_from'                =>  array(
    //      //                                                  'method'    =>  'array-storage-field-slug'      ,
    //      //                                                  'instance'  =>  "xxx"
    //      //                                                  )   ,
    //      //                                              --OR--
    //      //                                              array(
    //      //                                                  'method'    =>  'special-type'                  ,
    //      //                                                  'instance'  =>  "action"
    //      //                                                  )   ,
    //      //                                              --OR--
    //      //                                              array(
    //      //                                                  'method'    =>  'foreign-field'                 ,
    //      //                                                  'instance'  =>  "<target-field-name>"
    //      //                                                  'args'      =>  array(
    //      //                                                                      array(
    //      //                                                                          'pointer_field_array_storage_slug'  =>  '<pointer_field_slug>'  ,
    //      //                                                                          'foreign_dataset'                   =>  '<dataset_slug>'
    //      //                                                                          )   ,
    //      //                                                                      ...
    //      //                                                                      )
    //      //                                                  )   ,
    //      //
    //      //          'width_in_percent'              =>  1 to 100 (All columns must add up 100%.  Though
    //      //                                              some columns may be left 0/NULL or unspecified -
    //      //                                              in which case the leftover width will be evenly
    //      //                                              distributed amongst these columns.
    //      //          'header_halign'                 =>  'left' | 'center' | 'right'
    //      //          'header_valign'                 =>  'top' | 'middle' | 'bottom'
    //      //          'data_halign'                   =>  'left' | 'center' | 'right'
    //      //          'data_valign'                   =>  'top' | 'middle' | 'bottom'
    //      //
    //      //          'data_field_slug_to_display'    =>  "xxx" (generated automatically; DON'T specify)
    //      //          'data_field_slug_to_sort_by'    =>  "xxx" (generated automatically; DON'T specify)
    //      //          )   ,
    //
    //              array(
    //                  'base_slug'                     =>  'title'             ,
    //                  'label'                         =>  'Project Title'     ,
    //                  'question_sortable'             =>  TRUE                ,
    //                  'raw_value_from'                =>  array(
    //                                                          'method'    =>  'array-storage-field-slug'  ,
    //                                                          'instance'  =>  'title'
    //                                                          )   ,
    //                  'display_treatments'            =>  array()
    //                  'sort_treatments'               =>  array()
    //                  'data_field_slug_to_display'    =>  title
    //                  'data_field_slug_to_sort_by'    =>  title
    //                  'header_halign'                 =>  center
    //                  'header_valign'                 =>  middle
    //                  'data_halign'                   =>  center
    //                  'data_valign'                   =>  middle
    //                  'width_in_percent'              =>  50
    //                  )   ,
    //
    //              array(
    //                  'base_slug'                     =>  'action'            ,
    //                  'label'                         =>  'Action'            ,
    //                  'question_sortable'             =>  FALSE               ,
    //                  'raw_value_from'                =>  array(
    //                                                          'method'    =>  'special-type'  ,
    //                                                          'instance'  =>  'action'
    //                                                          )   ,
    //                  'display_treatments'            =>  array()
    //                  'sort_treatments'               =>  array()
    //                  'data_field_slug_to_display'    =>  action
    //                  'data_field_slug_to_sort_by'    =>  action
    //                  'header_halign'                 =>  center
    //                  'header_valign'                 =>  middle
    //                  'data_halign'                   =>  center
    //                  'data_valign'                   =>  middle
    //                  'width_in_percent'              =>  50
    //                  )
    //
    //              )   ,
    //
    //          [rows_per_page]                      => 10
    //          [default_data_field_slug_to_orderby] => title
    //          [default_order]                      => asc
    //          [actions]                            => Array(
    //                                                      [edit]   => edit
    //                                                      [delete] => delete
    //                                                      )
    //          [action_separator]                  =>
    //
    //          [checked_defaulted_ok]              => 1
    //
    //          )
    //
    // -------------------------------------------------------------------------

//pr( $selected_datasets_dmdd['dataset_records_table'] ) ;

    // =========================================================================
    // Get the URLs of the DHTMLX "codebase" and "imgs" dirs...
    // =========================================================================

    require_once( $caller_apps_includes_dir . '/path-utils.php' ) ;

    // -------------------------------------------------------------------------
    // \greatKiwi_pathUtils\wp_path2url(
    //      $path
    //      )
    // - - - - - - - - - - - - - - - - -
    // RETURNS:-
    //      o   $url on SUCCESS
    //      o   array( $error_message ) on FAILURE
    // -------------------------------------------------------------------------

    $codebase_path =    dirname( $caller_apps_includes_dir ) .
                        '/js/dhtmlxGrid/dhtmlxGrid/codebase'
                        ;

    // -------------------------------------------------------------------------

    $codebase_url = \greatKiwi_pathUtils\wp_path2url( $codebase_path ) ;

    // -------------------------------------------------------------------------

    if ( is_array( $codebase_url ) ) {

        return standard_dataset_manager_error(
            $dataset_manager_home_page_title    ,
            $codebase_url[0]                    ,
            $caller_apps_includes_dir           ,
            $question_front_end
            ) ;

    }

    // -------------------------------------------------------------------------

    $imgs_url = $codebase_url . '/imgs/' ;

    // =========================================================================
    // Get the various DHTMLX Grid setup strings (etc) required...
    // =========================================================================

    $column_titles  = '' ;
    $column_widthsP = '' ;
    $column_halign  = '' ;
    $column_valign  = '' ;

    $header_styles  = array() ;

    $comma      = '' ;

    foreach ( $selected_datasets_dmdd['dataset_records_table']['column_defs'] as $this_column_def ) {

        $column_titles  .= $comma . $this_column_def['label']                           ;
        $column_widthsP .= $comma . $this_column_def['width_in_percent']                ;
        $column_halign  .= $comma . $this_column_def['data_halign']                     ;
        $column_valign  .= $comma . $this_column_def['data_valign']                     ;

        $header_styles[] = 'text-align:' . $this_column_def['header_halign'] . ';' ;

        $comma = ',' ;

    }

    $header_styles = json_encode( $header_styles ) ;

    // =========================================================================
    // GET the DATASET RECORDS to be displayed...
    // =========================================================================

    require_once( dirname( __FILE__ ) . '/get-dataset-records-table-data.php' ) ;

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\get_dataset_records_table_data(
    //      $selected_datasets_dmdd     ,
    //      $dataset_records            ,
    //      $dataset_slug               ,
    //      $dataset_title              ,
    //      $question_front_end         ,
    //      $caller_apps_includes_dir   ,
    //      $data_for
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Gets the:-
    //      $table_data
    //
    // for the specified dataset and it's data.
    //
    // $data_for must be one of:-
    //      o   'wp-list-table'
    //      o   'dhtmlx-grid'
    //
    // RETURNS
    //      o   On SUCCESS
    //          - - - - -
    //          #   $data_for = 'wp-list-table'
    //                  array(
    //                      ARRAY  $table_data                              ,
    //                      ARRAY  $data_field_slugs_for_column_sorting     ,
    //                      STRING $support_javascript
    //                      )
    //          #   $data_for = 'dhtmlx-grid'
    //                  array(
    //                      ARRAY  $table_data                              ,
    //                      ARRAY  $sort_data                               ,
    //                      ARRAY  $data_field_slugs_for_column_sorting     ,
    //                      STRING $support_javascript
    //                      )
    //
    //          Where:-
    //              $support_javascript
    //          is the Javascript required (for things like "DELETE this
    //          record? ARE YOU SURE?" confirmation, etc),
    //
    //      o   On FAILURE
    //          - - - - -
    //          $error_message STRING
    // -------------------------------------------------------------------------

    $data_for = 'dhtmlx-grid' ;

    // -------------------------------------------------------------------------

    $result = get_dataset_records_table_data(
                    $all_application_dataset_definitions    ,
                    $selected_datasets_dmdd                 ,
                    $dataset_records                        ,
                    $dataset_slug                           ,
                    $dataset_title                          ,
                    $question_front_end                     ,
                    $caller_apps_includes_dir               ,
                    $data_for
                    ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $result ) ) {

        return standard_dataset_manager_error(
            $dataset_manager_home_page_title    ,
            $result                             ,
            $caller_apps_includes_dir           ,
            $question_front_end
            ) ;

    }

    // -------------------------------------------------------------------------

    list(
        $table_data                             ,
        $sort_data                              ,
        $data_field_slugs_for_column_sorting    ,
        $support_javascript
        ) = $result ;

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $table_data = array(
    //
    //          [0] => Array(
    //                      [project_title]     => Glavin 2
    //                      [category_title]    => Macabre
    //                      [url_title_display] => Google
    //                      [url_display]       => http://www.google.co.nz
    //                      [action]            => edit    delete
    //                      )
    //
    //          [1] => Array(
    //                      [project_title]     => Glavin 2
    //                      [category_title]    => Macabre
    //                      [url_title_display] => Fern 2
    //                      [url_display]       => http://www.ferntechnology.com
    //                      [action]            => edit    delete
    //                      )
    //
    //          )
    //
    // -------------------------------------------------------------------------

//pr( $table_data ) ;

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $sort_data = array(
    //
    //          [project_title] => Array(
    //              [0] => Glavin 2
    //              )
    //
    //          [category_title] => Array(
    //              [0] => Macabre
    //              )
    //
    //          [url_title] => Array(
    //              [0] => Google
    //              [1] => Fern 2
    //              )
    //
    //          [url] => Array(
    //              [0] => http://www.google.co.nz
    //              [1] => http://www.ferntechnology.com
    //              )
    //
    //          )
    //
    // -------------------------------------------------------------------------

//pr( $sort_data ) ;

    // =========================================================================
    // Create the arrays required to support the table sorting in
    // Javascript...
    // =========================================================================

    // -------------------------------------------------------------------------
    // bool natcasesort ( array &$array )
    // - - - - - - - - - - - - - - - - -
    // natcasesort() is a case insensitive version of natsort().
    //
    // This function implements a sort algorithm that orders alphanumeric
    // strings in the way a human being would while maintaining key/value
    // associations. This is described as a "natural ordering".
    //
    // PARAMETERS
    //
    //      array
    //          The input array.
    //
    // RETURN VALUES
    //      Returns TRUE on success or FALSE on failure.
    //
    // (PHP 4, PHP 5)
    //
    // EXAMPLES
    //
    //      Standard Sorting
    //      - - - - - - - -
    //          Array(
    //              [0] => IMG0.png
    //              [1] => IMG3.png
    //              [2] => img1.png
    //              [3] => img10.png
    //              [4] => img12.png
    //              [5] => img2.png
    //              )
    //
    //      Natural Order Sorting (Case-Insensitive)
    //      - - - - - - - - - - - - - - - - - - - -
    //          Array(
    //              [0] => IMG0.png
    //              [4] => img1.png
    //              [3] => img2.png
    //              [5] => IMG3.png
    //              [2] => img10.png
    //              [1] => img12.png
    //              )
    // -------------------------------------------------------------------------

    foreach ( $sort_data as $name => $values ) {

        // =====================================================================
        // SORT the VALUES...
        // =====================================================================

        if ( natcasesort( $values ) !== TRUE ) {

            $msg = <<<EOT
PROBLEM sorting table columns:&nbsp; "natcasesort()" failure
Detectd in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\manage_dataset_with_dhtmlx_grid()
EOT;

            return standard_dataset_manager_error(
                $dataset_manager_home_page_title    ,
                $msg                                ,
                $caller_apps_includes_dir           ,
                $question_front_end
                ) ;

        }

        // =====================================================================
        // CREATE the JS-REQUIRED ARRAY...
        // =====================================================================

        $values_js = array() ;

        $index = 1 ;

        // ---------------------------------------------------------------------

        foreach ( $values as $this_value ) {
            $values_js[ $this_value ] = $index ;
            $index++ ;
        }

        // =====================================================================
        // Update $sort_data...
        // =====================================================================

        $sort_data[ $name ] = $values_js ;

        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $sort_data = array(
    //
    //          [project_title] => Array(
    //              [Glavin 2] => 1
    //              )
    //
    //          [category_title] => Array(
    //              [Macabre] => 1
    //              )
    //
    //          [url_title] => Array(
    //              [Fern 2] => 1
    //              [Google] => 2
    //              )
    //
    //          [url] => Array(
    //              [http://www.ferntechnology.com] => 1
    //              [http://www.google.co.nz] => 2
    //              )
    //
    //          )
    //
    // -------------------------------------------------------------------------

//pr( $sort_data ) ;

    // =========================================================================
    // Create the DHTMLX "doInitGrid()" Javascript to add the table Column
    // Sorting support...
    // =========================================================================

    $dhtmlx_table_sorting_support_global     = '' ;
    $dhtmlx_table_sorting_support_doInitGrid = '' ;

    $setColSortingArg = '' ;

    $comma = '' ;

    $customSortFunctions = '' ;

    // -------------------------------------------------------------------------

    if ( count( $sort_data ) > 0 ) {

        // ---------------------------------------------------------------------
        // From DHTMLX Docs
        //  http://docs.dhtmlx.com/doku.php?id=dhtmlxgrid:sorting
        // ======================================================
        //
        // Sorting Types
        // -------------
        // The way of sorting depends on column sorting types. There are 4
        // predefined sorting types:
        //
        //  str  - Data will be sorted as strings (case sensitive)
        //
        //  int  - Data will be sorted as numbers (numbers must be in JS
        //         recognizable format, or the user can apply number formating
        //         feature of the grid);
        //
        //  date - Data will be sorted as a date (dates must be in JS
        //         recognizable format, or the user can apply date formating
        //         feature of the grid);
        //
        //  na   - Sorting is not available for a column (a column will not
        //         react on a header click and sortRows() calls)
        //
        // Sorting types are assigned to columns in the following way:
        //
        //      //grid.setColSorting(list_of_values);
        //      grid.setColSorting("int,str,na,str");
        //          // define sorting state for columns 0-3
        //
        // Custom Sorting (PROFESSIONAL ONLY)
        // - - - - - - - - - - - - - - - - -
        // It should be noted that 4 existing sorting types are not enough to
        // cover all use-cases, so the grid allows to create custom sorting
        // types. Basically the user should define a function that will receive
        // two values and the required order of sorting. The return value will
        // be as follows:
        //
        //      valueA > valueB => return 1
        //      valueA < valueB => return -1
        //
        // The following method should be used to setting custom sorting:
        //
        //      grid.setCustomSorting(func, col);
        //
        //      The parameters are as follows:
        //
        //          func - function to use for comparison;
        //          col - index of the column to apply custom sorting to.
        //
        // Also, if unknown type was used as parameter of setColSorting - grid
        // will try to locate the function with the same name and use it as
        // sorting function. The snippets below show some common use-cases.
        //
        // Case Insensitive Sorting
        // - - - - - - - - - - - -
        //
        //      function str_custom(a,b,order){    // the name of the function must be > than 5 chars
        //          if (order=="asc")
        //              return (a.toLowerCase()>b.toLowerCase()?1:-1);
        //          else
        //              return (a.toLowerCase()>b.toLowerCase()?-1:1);
        //      }
        //      grid.setColSorting("int,str_custom,na,str"); // define sorting state for columns 0-3
        //
        // Custom Time Sorting
        // - - - - - - - - - -
        // This type of custom sorting can be applied for such data as 14:56:
        //
        //      function time_custom(a,b,order){
        //          a=a.split(":")
        //          b=a.split(":")
        //          if (a[0]==b[0])
        //               return (a[1]>b[1]?1:-1)*(order=="asc"?1:-1);
        //          else
        //               return (a[0]>b[0]?1:-1)*(order=="asc"?1:-1);
        //      }
        //      grid.setColSorting("int,time_custom,na,str");
        //
        // Custom Date Sorting
        // - - - - - - - - - -
        // One more type of custom sorting can be for such data as dd/mm/yyyy
        // (the user doesn't need it, if he is using setDateFormat()
        // functionality):
        //
        //      function date_custom(a,b,order){
        //          a=a.split("/")
        //          b=b.split("/")
        //          if (a[2]==b[2]){
        //              if (a[1]==b[1])
        //                  return (a[0]>b[0]?1:-1)*(order=="asc"?1:-1);
        //              else
        //                  return (a[1]>b[1]?1:-1)*(order=="asc"?1:-1);
        //          } else
        //               return (a[2]>b[2]?1:-1)*(order=="asc"?1:-1);
        //      }
        //      grid.setColSorting("int,date_custom,na,st
        // ---------------------------------------------------------------------

        foreach ( $selected_datasets_dmdd['dataset_records_table']['column_defs'] as $this_column_def ) {

            // -----------------------------------------------------------------

            if ( $this_column_def['question_sortable'] ) {

                // -------------------------------------------------------------
                // Column is SORTABLE...
                // -------------------------------------------------------------

                $sort_slug = $this_column_def['data_field_slug_to_sort_by'] ;

                // -------------------------------------------------------------

                $js_custom_sort_function_name = <<<EOT
gk_sdm_byFernTec_customSort_{$sort_slug}
EOT;

                // -------------------------------------------------------------

                $customSortFunctions .= <<<EOT
function {$js_custom_sort_function_name}( a , b , order ) {
alert( a + ' --- ' + b + ' --- ' + order ) ;
    var retval = 0 ;
    if ( window.greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager_dhtmlxGrid_sortData['{$sort_slug}'][a] < window.greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager_dhtmlxGrid_sortData['{$sort_slug}'][b] ) {
        retval = -1 ;
    } else if ( window.greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager_dhtmlxGrid_sortData['{$sort_slug}'][a] > window.greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager_dhtmlxGrid_sortData['{$sort_slug}'][b] ) {
        retval = 1 ;
    }
alert( retval ) ;
    if ( order === 'asc' ) {
        return retval ;
    }
    return -retval ;
}\n
EOT;

                // -------------------------------------------------------------

/*
                $setColSortingArg .= <<<EOT
{$comma}{$js_custom_sort_function_name}
EOT;
*/

                $setColSortingArg .= <<<EOT
{$comma}str
EOT;

                // -------------------------------------------------------------

            } else {

                // -------------------------------------------------------------
                // Column is NOT SORTABLE...
                // -------------------------------------------------------------

                $setColSortingArg .= <<<EOT
{$comma}na
EOT;

                // -------------------------------------------------------------

            }

            // -----------------------------------------------------------------

            $comma = ',' ;

            // -----------------------------------------------------------------

        }

        // ---------------------------------------------------------------------

        $sort_data_js = json_encode( $sort_data ) ;

        // ---------------------------------------------------------------------

        $dhtmlx_table_sorting_support_global = <<<EOT
window.greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager_dhtmlxGrid_sortData = {$sort_data_js} ;
{$customSortFunctions}
EOT;

        // ---------------------------------------------------------------------

        $dhtmlx_table_sorting_support_doInitGrid = <<<EOT
mygrid.setColSorting('{$setColSortingArg}') ;\n
EOT;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // Add the required Javascript support routines to the
    // "support_javascript"...
    // =========================================================================

/*
    if ( $support_javascript !== '' ) {

        // ---------------------------------------------------------------------

//      $plugin_root_url = dirname( $caller_apps_includes_dir ) ;

        // ---------------------------------------------------------------------

//<script type="text/javascript" src="{$plugin_root_url}/js/nyman-martin-getElementsByClassName.js"></script>

        $support_javascript = <<<EOT
<script type="text/javascript">

    function researchAssistant_byFernTec_get_ancestor( start_el , like ) {
        // -----------------------------------------------------------------------
        // researchAssistant_byFernTec_get_ancestor( start_el , like )
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // "like" is an object (associative array) like:-
        //
        //      {   tagName                 :   "xxx"
        //          class                   :   "xxx"
        //          id                      :   "xxx"
        //          <property_name_1>       :   <property_value_1>
        //          ...
        //          <property_name_N>       :   <property_value_N>
        //          }
        //
        // All the name = value pairs are optional.  Just specify what you need
        // to identify the ancestor that you're looking for.
        //
        // Returns false if no such ancestor found.
        // -----------------------------------------------------------------------
        var current_el = start_el.parentNode ;
        var all_properties_match ;
        while ( current_el !== document ) {
            all_properties_match = true ;
            for ( name in like ) {
                if ( name === 'tagName' ) {
                    if ( ! current_el[ name ] === undefined || current_el[ name ].toUpperCase() !== like[ name ].toUpperCase() ) {
                        all_properties_match = false ;
                        break ;
                    }
                } else {
                    if ( ! current_el[ name ] === undefined || current_el[ name ] !== like[ name ] ) {
                        all_properties_match = false ;
                        break ;
                    }
                }
            }
            if ( all_properties_match ) {
                return current_el ;
            }
            current_el = current_el.parentNode ;
        }
        return false ;
    }

    function researchAssistant_byFernTec_in_list( list , string_or_number , exact ) {
        //  ------------------------------------------------------------------
        //  in_list( list , string_or_number , exact )
        //  - - - - - - - - - - - - - - - - - - - - -
        //  Check if the specified element is in the specified list.  Where
        //  by list we mean a list of numbers and/or strings.  Eg:-
        //      mylist = [ 1 , 2 , 3 ... ]
        //      mylist = [ 'one' , 'two' , 'three' ... ]
        //      mylist = [ 'one' , 2 , 'three' ... ]
        //
        //  "exact" defaults to false.
        //
        //  Returns true or false.
        //  ------------------------------------------------------------------
        if ( ! exact ) {
            var exact = false ;
        }
        var i , j=list.length ;
        if ( exact ) {
            for ( i=0 ; i<j ; i++ ) {
                if ( list[i] === string_or_number ) {
                    return true ;
                }
            }
        } else {
            for ( i=0 ; i<j ; i++ ) {
                if ( list[i] == string_or_number ) {
                    return true ;
                }
            }
        }
        return false ;
    }

    //  From: http://jamesroberts.name/blog/2010/02/22/string-functions-for-javascript-trim-to-camel-case-to-dashed-and-to-underscore/
    function researchAssistant_byFernTec_toCamelCase( instr ) {
	    return instr.replace( /(\-[a-z])/g , function(\$1){return \$1.toUpperCase().replace('-','')} )
    }

    function researchAssistant_byFernTec_setStyles( el , styles ) {
        //  "styles" is an object of name = value pairs.  Eg:-
        //      styles = {
        //          font-weight :   'bold'      ,
        //          font-size   :   '110%'
        //          }
        for ( var name in styles ) {
            el.style[ researchAssistant_byFernTec_toCamelCase( name ) ] = styles[ name ] ;
        }
    }

{$support_javascript}

</script>
EOT;

    }
*/

    // =========================================================================
    // CONVERT the TABLE DATA to the (field values only) JSARRAY format
    // expected by DHTMLX Grid...
    // =========================================================================

    $table_data_for_dhtmlx = array() ;

    // -------------------------------------------------------------------------

    foreach ( $table_data as $this_index => $this_record ) {
        $table_data_for_dhtmlx[] = array_values( $this_record ) ;
    }

    // -------------------------------------------------------------------------

    $table_data_for_dhtmlx = json_encode( $table_data_for_dhtmlx ) ;

//pr( $table_data_for_dhtmlx ) ;

    // =========================================================================
    // Create the HTML for the page to go in the IFRAME...
    // =========================================================================

    // -------------------------------------------------------------------------
    // NOTE!
    // =====
    // The WordPress front-end and back-end CSS and Javascript/jQuery both
    // interfere with the DHTMLX Grid (CSS and Javascript) (though the amount
    // of interference does depend on (eg); the fron-end theme and template
    // used, for example).
    //
    // To prevent this happening, we've little choice but to embed the DHTMLX
    // GRID in an IFRAME.
    // -------------------------------------------------------------------------

    $page_html = <<<EOT
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

    <head>
        <title>Manage "{$dataset_title}" Table</title>
        <link rel="STYLESHEET" type="text/css" href="{$codebase_url}/dhtmlxgrid.css">
        <script type="text/javascript" src="{$codebase_url}/dhtmlxcommon.js"></script>
        <script type="text/javascript" src="{$codebase_url}/dhtmlxgrid.js"></script>
        <script type="text/javascript" src="{$codebase_url}/dhtmlxgridcell.js"></script>
    </head>

    <body>
<div    id="mygrid_container"
        ></div>

<script type="text/javascript">

    var mygrid;

    var mygrids_data = {$table_data_for_dhtmlx} ;

    {$dhtmlx_table_sorting_support_global}

    function doInitGrid(){

        mygrid = new dhtmlXGridObject('mygrid_container');

        mygrid.setImagePath("{$imgs_url}");

        mygrid.enableAutoWidth(true);
        mygrid.enableAutoHeight(true);

        mygrid.setHeader('{$column_titles}',null,{$header_styles});
        mygrid.setInitWidthsP('{$column_widthsP}');
        mygrid.setColAlign('{$column_halign}');
        mygrid.setColVAlign('{$column_valign}');

        mygrid.setSkin("light");

        {$dhtmlx_table_sorting_support_doInitGrid}

        mygrid.init();

        mygrid.parse( mygrids_data , 'jsarray' ) ;

    }

    doInitGrid() ;

</script>

{$support_javascript}

    </body>
</html>
EOT;

    // =========================================================================
    // SAVE the page in the BASEPRESS PAGE CACHE...
    // =========================================================================

    require_once( $caller_apps_includes_dir . '/wordpress-page-cache.php' ) ;

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_wordpressPageCache\set_page(
    //      $page_name                      ,
    //      $question_session_specific      ,
    //      $question_remote_ip_specific    ,
    //      $question_user_agent_specific   ,
    //      $question_page_key              ,
    //      $page_content
    //      )
    // - - - - - - - - - - - - - - - - - - -
    // SAVES the specified PHP/HTML (or whatever) "page_content" into the
    // page cache.
    //
    // NOTES!
    // ======
    // 1.   Cached pages are stored in the wordPress MySQL database.  This is to
    //      eliminate the file access/permission problems that would occur if we
    //      to store the cached pages as files on the disk.
    //
    // 2.   This routine auto-creates the page cache table, if that table
    //      doesn't yet exist.
    //
    // RETURNS
    //      On SUCCESS!
    //      - - - - - -
    //      $page_key STRING (= blank string if $question_page_key = FALSE)
    //
    //      On FAILURE!
    //      - - - - - -
    //      array( $error_message STRING )
    // -------------------------------------------------------------------------

/*
    $fn =   <<<EOT
\\{$caller_app_slash_plugins_global_namespace}\\get_caller_app_slash_plugins_unique_name
EOT;

    $page_name = $fn() . '-great-kiwi-standard-dataset-manager' ;
*/

    $page_name =    \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_appsAPI\get_plugin_slug_dashed() .
                    '-great-kiwi-standard-dataset-manager'
                    ;

\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $page_name ) ;

    $question_session_specific    = TRUE ;
    $question_remote_ip_specific  = TRUE ;
    $question_user_agent_specific = TRUE ;
    $question_page_key            = TRUE ;

    // -------------------------------------------------------------------------

    $page_key = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_wordpressPageCache\set_page(
                    $page_name                      ,
                    $question_session_specific      ,
                    $question_remote_ip_specific    ,
                    $question_user_agent_specific   ,
                    $question_page_key              ,
                    $page_html
                    ) ;

    // -------------------------------------------------------------------------

    if ( is_array( $page_key ) ) {

        return standard_dataset_manager_error(
            $dataset_manager_home_page_title    ,
            $page_key[0]                        ,
            $caller_apps_includes_dir           ,
            $question_front_end
            ) ;

    }

    // =========================================================================
    // Get the URL of the CACHED PAGE...
    // =========================================================================

//  require_once( $caller_apps_includes_dir . '/path-utils.php' ) ;

    // -------------------------------------------------------------------------
    // \greatKiwi_pathUtils\wp_path2url(
    //      $path
    //      )
    // - - - - - - - - - - - - - - - - -
    // RETURNS:-
    //      o   $url on SUCCESS
    //      o   array( $error_message ) on FAILURE
    // -------------------------------------------------------------------------

    $iframe_src_path =  dirname( $caller_apps_includes_dir ) . <<<EOT
/remote/get-cached-page.php?page_name={$page_name}&page_key={$page_key}
EOT;

    // -------------------------------------------------------------------------

    $iframe_src_url = \greatKiwi_pathUtils\wp_path2url( $iframe_src_path ) ;

    // -------------------------------------------------------------------------

    if ( is_array( $iframe_src_url ) ) {

        return standard_dataset_manager_error(
            $dataset_manager_home_page_title    ,
            $iframe_src_url[0]                  ,
            $caller_apps_includes_dir           ,
            $question_front_end
            ) ;

    }

    // =========================================================================
    // Get the "Add Xxx" button...
    // =========================================================================

    if ( $question_front_end ) {

        require_once( $caller_apps_includes_dir . '/url-utils.php' ) ;

        // -------------------------------------------------------------------------
        // \greatKiwi_urlUtils\get_query_adjusted_current_page_url(
        //      $query_changes = array()        ,
        //      $question_amp = FALSE           ,
        //      $question_die_on_error = FALSE
        //      ) ;
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // Attempts to retrieve the current page URL from $_SERVER.
        //
        // If successful, returns the URL with the query part adjusted as
        // requested.
        //
        // RETURNS
        //      o   On SUCCESS!
        //          -----------
        //          $query_adjusted_current_page_url STRING
        //
        //      o   On FAILURE!
        //          -----------
        //          If $question_die_on_error = TRUE
        //              Doesn't return
        //          If $question_die_on_error = FALSE
        //              array( $error_message STRING )
        // -------------------------------------------------------------------------

        $query_changes = array(
                            'action'        =>  'add-record'            ,
                            'dataset_slug'  =>  $_GET['dataset_slug']
                            ) ;

        $question_amp = FALSE ;

        $question_die_on_error = FALSE ;

        $url = \greatKiwi_urlUtils\get_query_adjusted_current_page_url(
                    $query_changes              ,
                    $question_amp               ,
                    $question_die_on_error
                    ) ;

        if ( is_array( $url ) ) {

            return standard_dataset_manager_error(
                $dataset_manager_home_page_title    ,
                $url[0]                             ,
                $caller_apps_includes_dir           ,
                $question_front_end
                ) ;

        }

        $position_relative = '' ;

    } else {

        $url = admin_url() . <<<EOT
admin.php?page={$_GET['page']}&action=add-record&dataset_slug={$_GET['dataset_slug']}
EOT;

        $position_relative = ';position:relative; top:1em' ;

    }

    // -------------------------------------------------------------------------

    $add_record_button = <<<EOT
<div><a  href="{$url}"
    style="padding:3px 10px; background-color:#F1F1F1; font-size: 110%; font-weight:normal; text-decoration:none; text-align:left{$position_relative}"
    >Add&nbsp;{$selected_datasets_dmdd['dataset_title_singular']}</a></div>
EOT;

    // =========================================================================
    // GET the ORPHANED RECORDS BUTTON (if requested)...
    // =========================================================================

    $orphaned_records_button = '' ;

    $orphaned_records_expander = '' ;

    // -------------------------------------------------------------------------

    if (    isset( $selected_datasets_dmdd['dataset_records_table']['show_orphaned_records_button'] )
            &&
            $selected_datasets_dmdd['dataset_records_table']['show_orphaned_records_button'] === TRUE
            &&
            count( $orphaned_record_indices ) > 0
        ) {

        // -------------------------------------------------------------------------
        // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\get_orphaned_records_table_html(
        //      $all_application_dataset_definitions    ,
        //      $caller_apps_includes_dir               ,
        //      $selected_datasets_dmdd                 ,
        //      $dataset_records                        ,
        //      $dataset_slug                           ,
        //      $dataset_title                          ,
        //      $question_front_end                     ,
        //      $orphaned_record_indices                ,
        //      $data_for
        //      )
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // Returns the HTML for a table to display/delete the orphaned records in
        // the dataset.
        //
        // $data_for must be one of:-
        //      o   'wp-list-table'
        //      o   'dhtmlx-grid'
        //
        // RETURNS
        //      o   On SUCCESS
        //          - - - - -
        //          (Possibly empty) $orphaned_records_html STRING
        //
        //      o   On FAILURE
        //          - - - - -
        //          array( $error_message STRING )
        // -------------------------------------------------------------------------

        if ( $question_front_end ) {
            $data_for = 'dhtmlx-grid' ;

        } else {
            $data_for = 'wp-list-table' ;

        }

        // ---------------------------------------------------------------------

        $orphaned_records_html = get_orphaned_records_table_html(
                                    $all_application_dataset_definitions    ,
                                    $caller_apps_includes_dir               ,
                                    $selected_datasets_dmdd                 ,
                                    $dataset_records                        ,
                                    $dataset_slug                           ,
                                    $dataset_title                          ,
                                    $question_front_end                     ,
                                    $orphaned_record_indices                ,
                                    $data_for
                                    ) ;

        // ---------------------------------------------------------------------

        if ( is_array( $orphaned_records_html ) ) {

            return standard_dataset_manager_error(
                        $dataset_manager_home_page_title    ,
                        $orphaned_records_html[0]           ,
                        $caller_apps_includes_dir           ,
                        $question_front_end
                        ) ;

        }

        // ---------------------------------------------------------------------

        if ( $orphaned_records_html !== '' ) {

            // -----------------------------------------------------------------

            $onclick = '' ;
                //  TODO:  Show/Hide Expander

            // -----------------------------------------------------------------

            $orphaned_records_button = <<<EOT
<a  href="javascript:void()"
    onclick="{$onclick}"
    style="margin-left:1.5em; padding:3px 10px; background-color:#F1F1F1; font-size: 110%; font-weight:normal; text-decoration:none; text-align:left; position:relative; top:1em"
    >Show&nbsp;Orphaned&nbsp;{$selected_datasets_dmdd['dataset_title_plural']}</a>
EOT;

            // -----------------------------------------------------------------

            $orphaned_records_expander = <<<EOT
<div style="margin:4em 0 0 0">
{$orphaned_records_html}
</div>
EOT;

            // -----------------------------------------------------------------

        }

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // Create the IFRAME HTML...
    // =========================================================================

    $page_title = 'Manage ' . $selected_datasets_dmdd['dataset_title_plural'] ;

    $page_header = get_page_header(
                        $page_title                 ,
                        $caller_apps_includes_dir   ,
                        $question_front_end
                        ) ;

    // -------------------------------------------------------------------------

    $widget_html = <<<EOT
{$page_header}
<div>{$add_record_button}{$orphaned_records_button}</div>
{$orphaned_records_expander}
<iframe
    src="{$iframe_src_url}"
    width="100%"
    height="800"
    frameborder="0"
    ></iframe>
<br />
<br />
EOT;

    // =========================================================================
    // SUCCESS!
    // =========================================================================

    return $widget_html ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// That's that!
// =============================================================================

