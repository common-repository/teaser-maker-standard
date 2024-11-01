<?php

// *****************************************************************************
// PROTO-PRESS / ADMIN / MANAGE-DATASET-WP-LIST-TABLE-INNER.PHP
// (C) 2013 Peter Newman. All Rights Reserved.
// *****************************************************************************

    namespace greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager ;

// =============================================================================
// get_wordpress_table_for_dataset()
// =============================================================================

function get_wordpress_table_for_dataset(
    $singular_name_of_the_listed_records    ,
    $plural_name_of_the_listed_records      ,
    $column_titles_by_name                  ,
    $sortable_columns                       ,
    $default_orderby                        ,
    $default_order                          ,
    $rows_per_page                          ,
    $table_data
    ) {

//pr( func_get_args() ) ;

    // -------------------------------------------------------------------------
    // get_wordpress_table_for_dataset(
    //      $singular_name_of_the_listed_records    ,
    //      $plural_name_of_the_listed_records      ,
    //      $column_titles_by_name                  ,
    //      $sortable_columns                       ,
    //      $default_orderby                        ,
    //      $default_order                          ,
    //      $rows_per_page                          ,
    //      $table_data
    //      )
    // - - - - - - - - - - - - - - - - - -
    // $sortable_columns should be like (eg):-
    //
    //      $sortable_columns = array(
    //          '<column name in $column_titles_by_name>'   =>  array( '<field name in $table_data>' , TRUE/FALSE )
    //          ...
    //          )
    //
    // Where TRUE/FALSE indicates whether or not the table data is already
    // sorted on this column (use FALSE unless you're sure).
    //
    // RETURNS
    //      $body_content STRING
    // -------------------------------------------------------------------------

    $table_obj = new List_Table_4_Standard_Dataset_Manager(
                        $singular_name_of_the_listed_records    ,
                        $plural_name_of_the_listed_records
                        ) ;

    // -------------------------------------------------------------------------

    $table_obj->column_titles_by_name = $column_titles_by_name ;

    $table_obj->sortable_columns = $sortable_columns ;

    $table_obj->default_orderby = $default_orderby ;

    $table_obj->default_order = $default_order ;

    $table_obj->rows_per_page = $rows_per_page ;

    $table_obj->table_data = $table_data ;

    // -------------------------------------------------------------------------

    //Fetch, prepare, sort, and filter our data...
    $table_obj->prepare_items() ;

    // -------------------------------------------------------------------------

    ob_start() ;
        $table_obj->display() ;
    $table_html = ob_get_clean() ;

    // -------------------------------------------------------------------------

//  <form   id="greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager_listTable"

    $body_content = <<<EOT
<div class="wrap">
    <form   method="get"
            action=""
            >
        <input type="hidden" name="page" value="{$_REQUEST['page']}" />
        {$table_html}
    </form>
</div>
EOT;

    // -------------------------------------------------------------------------

    return $body_content ;

    // -------------------------------------------------------------------------

}

// =============================================================================
// List Table for WordPress...
// =============================================================================

/*
Plugin Name: Custom List Table Example
Plugin URI: http://www.mattvanandel.com/
Description: A highly documented plugin that demonstrates how to create custom List Tables using official WordPress APIs.
Version: 1.1
Author: Matt Van Andel
Author URI: http://www.mattvanandel.com
License: GPL2
*/

/*  Copyright 2011  Matthew Van Andel  (email : matt@mattvanandel.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/* == NOTICE ===================================================================
 * Please do not alter this file. Instead: make a copy of the entire plugin,
 * rename it, and work inside the copy. If you modify this plugin directly and
 * an update is released, your changes will be lost!
 * ========================================================================== */

/*************************** LOAD THE BASE CLASS *******************************
 *******************************************************************************
 * The WP_List_Table class isn't automatically available to plugins, so we need
 * to check if it's available and load it if necessary.
 */
if(!class_exists('\WP_List_Table')){
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

/************************** CREATE A PACKAGE CLASS *****************************
 *******************************************************************************
 * Create a new list table package that extends the core WP_List_Table class.
 * WP_List_Table contains most of the framework for generating the table, but we
 * need to define and override some methods so that our data can be displayed
 * exactly the way we need it to be.
 *
 * To display this example on a page, you will first need to instantiate the class,
 * then call $yourInstance->prepare_items() to handle any data manipulation, then
 * finally call $yourInstance->display() to render the table to the page.
 *
 * Our theme for this list table is going to be movies.
 */
class List_Table_4_Standard_Dataset_Manager extends \WP_List_Table {

    /** ************************************************************************
     * Normally we would be querying data from a database and manipulating that
     * for use in your list table. For this example, we're going to simplify it
     * slightly and create a pre-built array. Think of this as the data that might
     * be returned by $wpdb->query().
     *
     * @var array
     **************************************************************************/
/*
    var $example_data = array(
            array(
                'ID'        => 1,
                'title'     => '300',
                'rating'    => 'R',
                'director'  => 'Zach Snyder'
            ),
            array(
                'ID'        => 2,
                'title'     => 'Eyes Wide Shut',
                'rating'    => 'R',
                'director'  => 'Stanley Kubrick'
            ),
            array(
                'ID'        => 3,
                'title'     => 'Moulin Rouge!',
                'rating'    => 'PG-13',
                'director'  => 'Baz Luhrman'
            ),
            array(
                'ID'        => 4,
                'title'     => 'Snow White',
                'rating'    => 'G',
                'director'  => 'Walt Disney'
            ),
            array(
                'ID'        => 5,
                'title'     => 'Super 8',
                'rating'    => 'PG-13',
                'director'  => 'JJ Abrams'
            ),
            array(
                'ID'        => 6,
                'title'     => 'The Fountain',
                'rating'    => 'PG-13',
                'director'  => 'Darren Aronofsky'
            ),
            array(
                'ID'        => 7,
                'title'     => 'Watchmen',
                'rating'    => 'R',
                'director'  => 'Zach Snyder'
            )
        );
*/

    var $table_data = array() ;

    var $column_titles_by_name = array() ;

    /** ************************************************************************
     * REQUIRED. Set up a constructor that references the parent constructor. We
     * use the parent reference to set some default configs.
     ***************************************************************************/
//  function __construct(){
//
//      global $status, $page;
//
//      //Set parent defaults
//      parent::__construct( array(
//          'singular'  => 'promotion',     //singular name of the listed records
//          'plural'    => 'promotions',    //plural name of the listed records
//          'ajax'      => false            //does this table support ajax?
//      ) );
//
//  }

    function __construct( $singular , $plural ){

        global $status, $page;

        //Set parent defaults
        parent::__construct( array(
            'singular'  =>  $singular   ,   //singular name of the listed records
            'plural'    =>  $plural     ,   //plural name of the listed records
            'ajax'      =>  FALSE           //does this table support ajax?
        ) );

    }

    /** ************************************************************************
     * Recommended. This method is called when the parent class can't find a method
     * specifically build for a given column. Generally, it's recommended to include
     * one method for each column you want to render, keeping your package class
     * neat and organized. For example, if the class needs to process a column
     * named 'title', it would first see if a method named $this->column_title()
     * exists - if it does, that method will be used. If it doesn't, this one will
     * be used. Generally, you should try to use custom column methods as much as
     * possible.
     *
     * Since we have defined a column_title() method later on, this method doesn't
     * need to concern itself with any column with a name of 'title'. Instead, it
     * needs to handle everything else.
     *
     * For more detailed insight into how columns are handled, take a look at
     * WP_List_Table::single_row_columns()
     *
     * @param array $item A singular item (one full row's worth of data)
     * @param array $column_name The name/slug of the column to be processed
     * @return string Text or HTML to be placed inside the column <td>
     **************************************************************************/
    function column_default($item, $column_name){

        // ---------------------------------------------------------------------
        // Here we should have (eg):-
        //
        //      $item = Array(
        //          [row_bg]                => #F7FFF7
        //          [name_slash_title]      => <a href="javascript:wooDeals_byFernTec_gotoPage_withArgs('edit-promotion-batches-products',{promotion_id:'526222202083d'})"><b style="color:#21759B">Xmas Specials</b></a>
        //          [promotion_type]        => One-off
        //          [start_datetime]        => Mon 2 Sep 2013 00:00:00 Pacific/Auckland
        //          [end_datetime]          => Sun 24 Nov 2013 23:59:59 Pacific/Auckland
        //          [product_details]       => 3 products in 2 batches
        //          [timeslot_details]      => 12 timeslots of 1 week each
        //          [promotion_enabled]     => Yes
        //          [promotion_status]      => LIVE
        //          [action]                => Array(
        //              [0] => Array(
        //                          [text]  => edit
        //                          [js]    => wooDeals_byFernTec_gotoPage_withArgs('edit-promotion-general-settings',{promotion_id:'526222202083d'})
        //                          )
        //              [1] => Array(
        //                          [text]  => disable
        //                          [js]    => wooDeals_byFernTec_gotoPage_withArgs('disable-promotion',{promotion_id:'526222202083d',return_to:'manage-promotions'})
        //                          )
        //              ...
        //              [6] => Array(
        //                          [text]  => get&nbsp;shortcode
        //                          [js]    => wooDeals_byFernTec_gotoPage_withArgs('edit-promotion-publish-unpublish',{promotion_id:'526222202083d'})
        //                          )
        //              )
        //          [start_datetime_UTC]    => 1378036800
        //          [end_datetime_UTC]      => 1385290799
        //          )
        //
        // ---------------------------------------------------------------------

//pr( $item ) ;

//      switch($column_name){
//          case 'rating':
//          case 'director':
//              return $item[$column_name];
//          default:
//              return print_r($item,true); //Show the whole array for troubleshooting purposes
//      }

/*
        if ( $column_name === 'action' ) {

            // -----------------------------------------------------------------

            $td_content = '' ;

            // -----------------------------------------------------------------

            if ( question_daily_deals_version() ) {

                // -------------------------------------------------------------

                $comma = '' ;

                foreach ( $item['action'] as $this_action ) {

                    $td_content .= <<<EOT
{$comma}<a  href="javascript:void()"
    onclick="{$this_action['js']}"
    >{$this_action['text']}</a>
EOT;

                    $comma = '<br />' ;

                }

                // -------------------------------------------------------------

            } else {

                // -------------------------------------------------------------

                foreach ( $item['action'] as $this_action ) {

                    $text = ucwords( $this_action['text'] ) ;

                    $td_content .= <<<EOT
<option onclick="{$this_action['js']}"> {$text} </option>
EOT;

                }

                // -------------------------------------------------------------

                $td_content = <<<EOT
<select><option> Select... </option>{$td_content}</select>
EOT;

                // -------------------------------------------------------------

            }

            // -----------------------------------------------------------------

        } else {
*/

            // -----------------------------------------------------------------

            if ( isset( $item[ $column_name ] ) ) {
                $item[ $column_name ] = trim( $item[ $column_name ] ) ;
                if ( $item[ $column_name ] === '' ) {
                    $td_content = '&nbsp;' ;
                } else {
                    $td_content = $item[ $column_name ] ;
                }
            } else {
                $td_content = $column_name . ' ?' ;
            }

            // -----------------------------------------------------------------

//      }

//row_actions( $actions, $always_visible = false )   X-Ref
//Generate row actions div
//
//param: array $actions The list of actions
//param: bool $always_visible Whether the actions should be always visible
//return: string

//  row_actions( $actions, $always_visible = false )
//  Call this method (usually from one of your column methods) to insert a row
//  actions div. The $actions parameter should be an associative array, where
//  the key is the name of the action and the value is a link.

        // ---------------------------------------------------------------------

        return $td_content ;

        // ---------------------------------------------------------------------

    }

    /**************************************************************************
     * Recommended. This is a custom column method and is responsible for what
     * is rendered in any column with a name/slug of 'title'. Every time the class
     * needs to render a column, it first looks for a method named
     * column_{$column_title} - if it exists, that method is run. If it doesn't
     * exist, column_default() is called instead.
     *
     * This example also illustrates how to implement rollover actions. Actions
     * should be an associative array formatted as 'slug'=>'link html' - and you
     * will need to generate the URLs yourself. You could even ensure the links
     *
     *
     * @see WP_List_Table::::single_row_columns()
     * @param array $item A singular item (one full row's worth of data)
     * @return string Text to be placed inside the column <td> (movie title only)
     **************************************************************************/
//  function column_title($item){
//
//      //Build row actions
//      $actions = array(
//          'edit'      => sprintf('<a href="?page=%s&action=%s&movie=%s">Edit</a>',$_REQUEST['page'],'edit',$item['ID']),
//          'delete'    => sprintf('<a href="?page=%s&action=%s&movie=%s">Delete</a>',$_REQUEST['page'],'delete',$item['ID']),
//      );
//
//      //Return the title contents
//      return sprintf('%1$s <span style="color:silver">(id:%2$s)</span>%3$s',
//          /*$1%s*/ $item['title'],
//          /*$2%s*/ $item['ID'],
//          /*$3%s*/ $this->row_actions($actions)
//      );
//  }

    /** ************************************************************************
     * REQUIRED if displaying checkboxes or using bulk actions! The 'cb' column
     * is given special treatment when columns are processed. It ALWAYS needs to
     * have it's own method.
     *
     * @see WP_List_Table::::single_row_columns()
     * @param array $item A singular item (one full row's worth of data)
     * @return string Text to be placed inside the column <td> (movie title only)
     **************************************************************************/
//  function column_cb($item){
//      return sprintf(
//          '<input type="checkbox" name="%1$s[]" value="%2$s" />',
//          /*$1%s*/ $this->_args['singular'],  //Let's simply repurpose the table's singular label ("movie")
//          /*$2%s*/ $item['ID']                //The value of the checkbox should be the record's id
//      );
//  }

    /** ************************************************************************
     * REQUIRED! This method dictates the table's columns and titles. This should
     * return an array where the key is the column slug (and class) and the value
     * is the column's title text. If you need a checkbox for bulk actions, refer
     * to the $columns array below.
     *
     * The 'cb' column is treated differently than the rest. If including a checkbox
     * column in your table you must create a column_cb() method. If you don't need
     * bulk actions or checkboxes, simply leave the 'cb' entry out of your array.
     *
     * @see WP_List_Table::::single_row_columns()
     * @return array An associative array containing column information: 'slugs'=>'Visible Titles'
     **************************************************************************/
//  function get_columns(){
//      $columns = array(
//          'cb'        => '<input type="checkbox" />', //Render a checkbox instead of text
//          'title'     => 'Title',
//          'rating'    => 'Rating',
//          'director'  => 'Director'
//      );
//      return $columns;
//  }
    function get_columns(){
        return $this->column_titles_by_name ;
    }

    /** ************************************************************************
     * Optional. If you want one or more columns to be sortable (ASC/DESC toggle),
     * you will need to register it here. This should return an array where the
     * key is the column that needs to be sortable, and the value is db column to
     * sort by. Often, the key and value will be the same, but this is not always
     * the case (as the value is a column name from the database, not the list table).
     *
     * This method merely defines which columns should be sortable and makes them
     * clickable - it does not handle the actual sorting. You still need to detect
     * the ORDERBY and ORDER querystring variables within prepare_items() and sort
     * your data accordingly (usually by modifying your query).
     *
     * @return array An associative array containing all the columns that should be sortable: 'slugs'=>array('data_values',bool)
     **************************************************************************/
    function get_sortable_columns() {
/*
        $sortable_columns = array(
//          'title'     => array('title',false),     //true means it's already sorted
//          'rating'    => array('rating',false),
//          'director'  => array('director',false)
        'name_slash_title'      =>  array( 'name_slash_title_pure'  , FALSE )   ,
        'promotion_type'        =>  array( 'promotion_type'         , FALSE )   ,
        'start_datetime'        =>  array( 'start_datetime_UTC'     , FALSE )   ,
        'end_datetime'          =>  array( 'end_datetime_UTC'       , FALSE )   ,
        'product_details'       =>  array( 'product_details'        , FALSE )   ,
        'timeslot_details'      =>  array( 'timeslot_details'       , FALSE )   ,
        'promotion_enabled'     =>  array( 'promotion_enabled'      , FALSE )   ,
        'promotion_status'      =>  array( 'promotion_status'       , FALSE )
        );
        if ( question_daily_deals_version() ) {
            unset( $sortable_columns['product_details'] ) ;
            unset( $sortable_columns['timeslot_details'] ) ;
        }
        if ( ! question_pro_version() ) {
            unset( $sortable_columns['promotion_type'] ) ;
        }
        return $sortable_columns;
*/

        return $this->sortable_columns;

    }


    /** ************************************************************************
     * Optional. If you need to include bulk actions in your list table, this is
     * the place to define them. Bulk actions are an associative array in the format
     * 'slug'=>'Visible Title'
     *
     * If this method returns an empty value, no bulk action will be rendered. If
     * you specify any bulk actions, the bulk actions box will be rendered with
     * the table automatically on display().
     *
     * Also note that list tables are not automatically wrapped in <form> elements,
     * so you will need to create those manually in order for bulk actions to function.
     *
     * @return array An associative array containing all the bulk actions: 'slugs'=>'Visible Titles'
     **************************************************************************/
    function get_bulk_actions() {
//      $actions = array(
//          'delete'    => 'Delete'
//      );
//      return $actions;
        return array() ;
    }


    /** ************************************************************************
     * Optional. You can handle your bulk actions anywhere or anyhow you prefer.
     * For this example package, we will handle it in the class to keep things
     * clean and organized.
     *
     * @see $this->prepare_items()
     **************************************************************************/
    function process_bulk_action() {

//      //Detect when a bulk action is being triggered...
//      if( 'delete'===$this->current_action() ) {
//          wp_die('Items deleted (or they would be if we had items to delete)!');
//      }

    }


    /** ************************************************************************
     * REQUIRED! This is where you prepare your data for display. This method will
     * usually be used to query the database, sort and filter the data, and generally
     * get it ready to be displayed. At a minimum, we should set $this->items and
     * $this->set_pagination_args(), although the following properties and methods
     * are frequently interacted with here...
     *
     * @global WPDB $wpdb
     * @uses $this->_column_headers
     * @uses $this->items
     * @uses $this->get_columns()
     * @uses $this->get_sortable_columns()
     * @uses $this->get_pagenum()
     * @uses $this->set_pagination_args()
     **************************************************************************/
    function usort_reorder($a,$b){
        //  NOTE!
        //  -----
        //  This usort routine assumes that it's sorting STRINGs.
//      $orderby = (!empty($_REQUEST['orderby'])) ? $_REQUEST['orderby'] : 'title'; //If no sort, default to title
        $orderby = (!empty($_REQUEST['orderby'])) ? $_REQUEST['orderby'] : $this->default_orderby ;
        $order = (!empty($_REQUEST['order'])) ? $_REQUEST['order'] : $this->default_order ; //If no order, default to asc
        $result = strcmp($a[$orderby], $b[$orderby]); //Determine sort order
        return ($order==='asc') ? $result : -$result; //Send final sort direction to usort
    }

    function prepare_items() {
//      global $wpdb; //This is used only if making any database queries

        /**
         * First, lets decide how many records per page to show
         */
        $per_page = $this->rows_per_page ;


        /**
         * REQUIRED. Now we need to define our column headers. This includes a complete
         * array of columns to be displayed (slugs & titles), a list of columns
         * to keep hidden, and a list of columns that are sortable. Each of these
         * can be defined in another method (as we've done here) before being
         * used to build the value for our _column_headers property.
         */
        $columns = $this->get_columns() ;
        $hidden = array() ;
        $sortable = $this->sortable_columns ;


        /**
         * REQUIRED. Finally, we build an array to be used by the class for column
         * headers. The $this->_column_headers property takes an array which contains
         * 3 other arrays. One for all columns, one for hidden columns, and one
         * for sortable columns.
         */
        $this->_column_headers = array($columns, $hidden, $sortable);


        /**
         * Optional. You can handle your bulk actions however you see fit. In this
         * case, we'll handle them within our package just to keep things clean.
         */
        $this->process_bulk_action();


        /**
         * Instead of querying a database, we're going to fetch the example data
         * property we created for use in this plugin. This makes this example
         * package slightly different than one you might build on your own. In
         * this example, we'll be using array manipulation to sort and paginate
         * our data. In a real-world implementation, you will probably want to
         * use sort and pagination data to build a custom query instead, as you'll
         * be able to use your precisely-queried data immediately.
         */
        $data = $this->table_data;


        /**
         * This checks for sorting input and sorts the data in our array accordingly.
         *
         * In a real-world situation involving a database, you would probably want
         * to handle sorting by passing the 'orderby' and 'order' values directly
         * to a custom query. The returned data will be pre-sorted, and this array
         * sorting technique would be unnecessary.
         */
        if ( count( $this->sortable_columns ) > 0 ) {
            usort( $data , array( get_class() , 'usort_reorder' ) ) ;
        }

        /***********************************************************************
         * ---------------------------------------------------------------------
         * vvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv
         *
         * In a real-world situation, this is where you would place your query.
         *
         * ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
         * ---------------------------------------------------------------------
         **********************************************************************/


        /**
         * REQUIRED for pagination. Let's figure out what page the user is currently
         * looking at. We'll need this later, so you should always include it in
         * your own package classes.
         */
        $current_page = $this->get_pagenum();

        /**
         * REQUIRED for pagination. Let's check how many items are in our data array.
         * In real-world use, this would be the total number of items in your database,
         * without filtering. We'll need this later, so you should always include it
         * in your own package classes.
         */
        $total_items = count($data);


        /**
         * The WP_List_Table class does not handle pagination for us, so we need
         * to ensure that the data is trimmed to only the current page. We can use
         * array_slice() to
         */
        $data = array_slice($data,(($current_page-1)*$per_page),$per_page);



        /**
         * REQUIRED. Now we can add our *sorted* data to the items property, where
         * it can be used by the rest of the class.
         */
        $this->items = $data;


        /**
         * REQUIRED. We also have to register our pagination options & calculations.
         */
        $this->set_pagination_args( array(
            'total_items' => $total_items,                  //WE have to calculate the total number of items
            'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
            'total_pages' => ceil($total_items/$per_page)   //WE have to calculate the total number of pages
        ) );
    }

}   //  END of class Manage_Promotions_List_Table

/** ************************ REGISTER THE TEST PAGE ****************************
 *******************************************************************************
 * Now we just need to define an admin page. For this example, we'll add a top-level
 * menu item to the bottom of the admin menus.
 */
//function tt_add_menu_items(){
//    add_menu_page('Example Plugin List Table', 'List Table Example', 'activate_plugins', 'tt_list_test', 'tt_render_list_page');
//} add_action('admin_menu', 'tt_add_menu_items');


/***************************** RENDER TEST PAGE ********************************
 *******************************************************************************
 * This function renders the admin page and the example list table. Although it's
 * possible to call prepare_items() and display() from the constructor, there
 * are often times where you may need to include logic here between those steps,
 * so we've instead called those methods explicitly. It keeps things flexible, and
 * it's the way the list tables are used in the WordPress core.
 */

/*
function tt_render_list_page(){

    //Create an instance of our package class...
    $testListTable = new Manage_Promotions_List_Table();
    //Fetch, prepare, sort, and filter our data...
    $testListTable->prepare_items();
    ?>
    <div class="wrap">

        <div id="icon-users" class="icon32"><br/></div>
        <h2>List Table Test</h2>

        <div style="background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
            <p>This page demonstrates the use of the <tt><a href="http://codex.wordpress.org/Class_Reference/WP_List_Table" target="_blank" style="text-decoration:none;">WP_List_Table</a></tt> class in plugins.</p>
            <p>For a detailed explanation of using the <tt><a href="http://codex.wordpress.org/Class_Reference/WP_List_Table" target="_blank" style="text-decoration:none;">WP_List_Table</a></tt>
            class in your own plugins, you can view this file <a href="/wp-admin/plugin-editor.php?plugin=table-test/table-test.php" style="text-decoration:none;">in the Plugin Editor</a> or simply open <tt style="color:gray;"><?php echo __FILE__ ?></tt> in the PHP editor of your choice.</p>
            <p>Additional class details are available on the <a href="http://codex.wordpress.org/Class_Reference/WP_List_Table" target="_blank" style="text-decoration:none;">WordPress Codex</a>.</p>
        </div>

        <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
        <form id="movies-filter" method="get">
            <!-- For plugins, we also need to ensure that the form posts back to our current page -->
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
            <!-- Now we can render the completed list table -->
            <?php $testListTable->display() ?>
        </form>

    </div>
    <?php
}
*/

// =============================================================================
// That's that!
// =============================================================================

