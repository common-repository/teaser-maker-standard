<?php

// *****************************************************************************
// TEASER-MAKER.APP / STANDARD-TEASER-LAYOUTS.PHP
// (C) 2014 Peter Newman. All Rights Reserved.
// *****************************************************************************

    namespace greatKiwi_byFernTec_teaserMaker_std_v0x1x114_datasetDef_teaserLayouts ;

// =============================================================================
// get_standard_teaser_layouts()
// =============================================================================

function get_standard_teaser_layouts() {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_datasetDef_teaserLayouts\
    // get_standard_teaser_layouts()
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // RETURNS
    //
    //      array(
    //          'p-and-h-tags-down-the-page'        =>  array(
    //              'title'             =>  'P and H Tags - Down the Page'      ,
    //              'layout_details'    =>  <layout-html-css-js-array>
    //              )   ,
    //          ...
    //          )
    //
    // Where:-
    //
    //      <layout-html-css-js-array> = array(
    //          'container' =>  array(
    //              'html'  =>  "xxx"   ,
    //              'css'   =>  "xxx"   ,
    //              'js'    =>  "xxx"
    //              )   ,
    //          'title' =>  array(
    //              'html'  =>  "xxx"   ,
    //              'css'   =>  "xxx"   ,
    //              'js'    =>  "xxx"
    //              )   ,
    //          'text' =>  array(
    //              'html'  =>  "xxx"   ,
    //              'css'   =>  "xxx"   ,
    //              'js'    =>  "xxx"
    //              )   ,
    //          'image' =>  array(
    //              'html'  =>  "xxx"   ,
    //              'css'   =>  "xxx"   ,
    //              'js'    =>  "xxx"
    //              )   ,
    //          'read_more' =>  array(
    //              'html'  =>  "xxx"   ,
    //              'css'   =>  "xxx"   ,
    //              'js'    =>  "xxx"
    //              )   ,
    //          'date' =>  array(
    //              'html'  =>  "xxx"   ,
    //              'css'   =>  "xxx"   ,
    //              'js'    =>  "xxx"
    //              )
    //          )
    //
    // The returned HTML may contain the following tags:-
    //
    //      o   [**TEASER.TEMPLATE**QUESTION.SPACER**]
    //      o   [**TEASER.TEMPLATE**QUESTION.IMAGE**]
    //      o   [**TEASER.TEMPLATE**QUESTION.TITLE**]
    //      o   [**TEASER.TEMPLATE**QUESTION.TEXT**]
    //      o   [**TEASER.TEMPLATE**QUESTION.READ.MORE**]
    //
    //      o   [**TEASER.TEMPLATE**SPACER**]
    //      o   [**TEASER.TEMPLATE**IMAGE**]
    //      o   [**TEASER.TEMPLATE**TITLE**]
    //      o   [**TEASER.TEMPLATE**TEXT**]
    //      o   [**TEASER.TEMPLATE**READ.MORE**]
    //
    //      o   [**TEASER**TARGET.URL**]
    //      o   [**TEASER**TITLE**]
    //      o   [**TEASER**TEXT**]
    //      o   [**TEASER**IMAGE.URL**]
    //      o   [**TEASER**DATE.CREATED**]
    //      o   [**TEASER**DATE.LAST_MODIFIED**]
    //      o   [**TEASER**DATE.CREATED**<date-format_string>**]
    //      o   [**TEASER**DATE.LAST_MODIFIED**<date-format_string>**]
    //
    // -------------------------------------------------------------------------

    require_once( dirname( __FILE__ ) . '/standard-teaser-layouts/p-and-h-tags-down-the-page.php' ) ;

    require_once( dirname( __FILE__ ) . '/standard-teaser-layouts/p-and-h-tags-floated-image.php' ) ;

    // -------------------------------------------------------------------------

    return array(

        'p-and-h-tags-down-the-page'        =>  array(
            'title'             =>  'P and H Tags - Down the Page'      ,
            'layout_details'    =>  get_standard_teaser_layout_p_and_h_tags_down_the_page()
            )   ,

        'p-and-h-tags-floated-image'        =>  array(
            'title'             =>  'P and H Tags - Floated Image'      ,
            'layout_details'    =>  get_standard_teaser_layout_p_and_h_tags_floated_image()
            )   ,

//      'div-and-span-tags-down-the-page'   =>  array(
//          'title'             =>  'DIV and SPAN Tags - Down the Page'         ,
//          'layout_details'    =>  get_standard_teaser_layout_p_and_h_tags_down_the_page()
//          )   ,
//
//      'div-and-span-tags-floating'        =>  array(
//          'title'             =>  'DIV and SPAN Tags - Floating'      ,
//          'layout_details'    =>  get_standard_teaser_layout_p_and_h_tags_floating()
//          )

        ) ;

    // -------------------------------------------------------------------------

}

// =============================================================================
// THAT'S THAT
// =============================================================================

