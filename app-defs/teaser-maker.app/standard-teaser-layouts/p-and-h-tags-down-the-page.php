<?php

// *****************************************************************************
// TEASER-MAKER.APP / STANDARD-TEASER-LAYOUTS / P-AND-H-TAGS-DOWN-THE-PAGE.PHP
// (C) 2014 Peter Newman. All Rights Reserved.
// *****************************************************************************

    namespace greatKiwi_byFernTec_teaserMaker_std_v0x1x114_datasetDef_teaserLayouts ;

// =============================================================================
// get_standard_teaser_layout_p_and_h_tags_down_the_page()
// =============================================================================

function get_standard_teaser_layout_p_and_h_tags_down_the_page() {

    // -------------------------------------------------------------------------
    // get_standard_teaser_layout_p_and_h_tags_down_the_page()
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // RETURNS
    //      array(
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
    //      )
    //
    // -------------------------------------------------------------------------

    // =========================================================================
    // Init.
    // =========================================================================

    $container_div_class_name  = 'teaserMaker_std_v0x1x114_containerDiv' ;

    $image_div_class_name      = 'teaserMaker_std_v0x1x114_imageDiv'     ;

    $title_div_class_name      = 'teaserMaker_std_v0x1x114_titleDiv'     ;

    $text_div_class_name       = 'teaserMaker_std_v0x1x114_textDiv'      ;

    $read_more_div_class_name  = 'teaserMaker_std_v0x1x114_readMoreDiv'  ;

    $date_div_class_name       = 'teaserMaker_std_v0x1x114_dateDiv'      ;

    $spacer_div_class_name     = 'teaserMaker_std_v0x1x114_spacerDiv'    ;

    // =========================================================================
    // CONTAINER...
    // =========================================================================

    $container_html = <<<EOT
[**TEASER.TEMPLATE**QUESTION.SPACER**]
<div class="{$container_div_class_name}">
    [**TEASER.TEMPLATE**QUESTION.IMAGE**]
    [**TEASER.TEMPLATE**QUESTION.TITLE**]
    [**TEASER.TEMPLATE**QUESTION.TEXT**]
    [**TEASER.TEMPLATE**QUESTION.READ.MORE**]
</div>
EOT;

    // -------------------------------------------------------------------------

    $container_css = <<<EOT
DIV.{$container_div_class_name} {
    margin:4em 0;
}
DIV.{$container_div_class_name}:first {
    margin:2em 0;
}
DIV.{$container_div_class_name} A {
    text-decoration:none;
}
DIV.{$container_div_class_name} P {
    margin:0.5em 0;
}
EOT;

    // -------------------------------------------------------------------------

    $container_js = '' ;

    // =========================================================================
    // TITLE...
    // =========================================================================

    $title_html = <<<EOT
<div class="{$title_div_class_name}">
    <h2><a
        target="_blank"
        href="[**TEASER**FULL.TARGET.URL**]"
        onmouseover="this.style.textDecoration='underline'"
        onmouseout="this.style.textDecoration='none'"
        >[**TEASER**TITLE**]</a></h2>
</div>
EOT;

    // -------------------------------------------------------------------------

    $title_css = <<<EOT
DIV.{$title_div_class_name} > H2 {
    margin:0.34em 0 0.25em 0;
    padding:0;
}
EOT;

    // -------------------------------------------------------------------------

    $title_js = '' ;

    // =========================================================================
    // TEXT...
    // =========================================================================

    $text_html = <<<EOT
<div class="{$text_div_class_name}">
    <p>[**TEASER**TEXT**]</p>
</div>
EOT;

    // -------------------------------------------------------------------------

    $text_css = <<<EOT
DIV.{$text_div_class_name} > P {
    margin:0;
    padding:0;
}
EOT;

    // -------------------------------------------------------------------------

    $text_js = '' ;

    // =========================================================================
    // IMAGE...
    // =========================================================================

    $image_html = <<<EOT
<div class="{$image_div_class_name}">
    <a  target="_blank"
        href="[**TEASER**FULL.TARGET.URL**]"
        ><img
            border="0"
            src="[**TEASER**FULL.IMAGE.URL**]"
            /></a>
</div>
EOT;

    // -------------------------------------------------------------------------

    $image_css = <<<EOT
DIV.{$image_div_class_name} IMG {
    max-width:500px;
    max-height:300px;
}
EOT;

    // -------------------------------------------------------------------------

    $image_js = '' ;

    // =========================================================================
    // READ-MORE...
    // =========================================================================

    $read_more_html = <<<EOT
<div class="{$read_more_div_class_name}">
    <table
        border="0"
        cellpadding="0"
        cellspacing="0"
        ><tr>
            <td class="read-more-title-td"
                >Read more at...</td>
            <td class="read-more-spacer-td">&nbsp;</td>
            <td class="read-more-url-td"><a
                target="_blank"
                href="[**TEASER**FULL.TARGET.URL**]"
                onmouseover="this.style.textDecoration='underline'"
                onmouseout="this.style.textDecoration='none'"
                >[**TEASER**SHORT.TARGET.URL**]</a></td>
    </tr></table>
</div>
EOT;

    // -------------------------------------------------------------------------

    $read_more_css = <<<EOT
DIV.{$read_more_div_class_name} {
    margin-top:0.5em;
}
DIV.{$read_more_div_class_name} TABLE   ,
DIV.{$read_more_div_class_name} THEAD   ,
DIV.{$read_more_div_class_name} TBODY   ,
DIV.{$read_more_div_class_name} TFOOT   ,
DIV.{$read_more_div_class_name} TR      ,
DIV.{$read_more_div_class_name} TD {
    border:none;
}
DIV.{$read_more_div_class_name} TD.read-more-title-td {
    text-align:right;
    font-size:150%;
    line-height:100%;
    font-weight:bold;
    font-style:italic;
    padding-right:0;
}
DIV.{$read_more_div_class_name} TD.read-more-spacer-td {
    padding:0;
    width:1em;
}
DIV.{$read_more_div_class_name} TD.read-more-url-td {
    font-size:150%;
    line-height:110%;
    padding-left:0;
}
EOT;

    // -------------------------------------------------------------------------

    $read_more_js = '' ;

    // =========================================================================
    // DATE...
    // =========================================================================

    $date_html = <<<EOT
<div class="{$date_div_class_name}">
    [**TEASER**DATE.CREATED**]
</div>
EOT;

    // -------------------------------------------------------------------------

    $date_css = '' ;

    // -------------------------------------------------------------------------

    $date_js = '' ;

    // =========================================================================
    // SPACER...
    // =========================================================================

    $spacer_html = <<<EOT
<div class="{$spacer_div_class_name}">
    <p>&nbsp;</p>
    <p>&nbsp;</p>
</div>
EOT;

    $spacer_html = '' ;

    // -------------------------------------------------------------------------

    $spacer_css = <<<EOT
DIV.{$spacer_div_class_name} {
/*  height:4em;     */
/*  border:1px solid #000000;   */
}
EOT;

    $spacer_css = '' ;

    // -------------------------------------------------------------------------

    $spacer_js = '' ;

    // =========================================================================
    // SUCCESS!
    // =========================================================================

    return array(

        'container' =>  array(
            'html'  =>  $container_html     ,
            'css'   =>  $container_css      ,
            'js'    =>  $container_js
            )   ,

        'title' =>  array(
            'html'  =>  $title_html     ,
            'css'   =>  $title_css      ,
            'js'    =>  $title_js
            )   ,

        'text' =>  array(
            'html'  =>  $text_html     ,
            'css'   =>  $text_css      ,
            'js'    =>  $text_js
            )   ,

        'image' =>  array(
            'html'  =>  $image_html     ,
            'css'   =>  $image_css      ,
            'js'    =>  $image_js
            )   ,

        'read_more' =>  array(
            'html'  =>  $read_more_html     ,
            'css'   =>  $read_more_css      ,
            'js'    =>  $read_more_js
            )   ,

        'date' =>  array(
            'html'  =>  $date_html     ,
            'css'   =>  $date_css      ,
            'js'    =>  $date_js
            )   ,

        'spacer' =>  array(
            'html'  =>  $spacer_html     ,
            'css'   =>  $spacer_css      ,
            'js'    =>  $spacer_js
            )

    ) ;

    // =========================================================================
    // THAT'S THAT!
    // =========================================================================

}

// =============================================================================
// THAT'S THAT
// =============================================================================

