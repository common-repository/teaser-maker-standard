<?php

// *****************************************************************************
// PLUGINS / PLUGIN-PLANT / TEST-DEBUG.PHP
// (C) 2013 Peter Newman. All Rights Reserved.
// *****************************************************************************

    namespace greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug ;

    // -------------------------------------------------------------------------
    // <plugin_root_dir>/test-debug.php
    // SYNOPSIS
    // ================================
    // Defines:-
    //
    //      o   pr( $value , [ $name = NULL ] )
    //
    // All in the namespace:-
    //      greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug
    // -------------------------------------------------------------------------

// =============================================================================
// pr()
// =============================================================================

    function pr( $value , $name = NULL ) {
        if ( $name === NULL ) {
            echo '<pre>' ;
        } else {
            echo '<h2>' , $name , '</h2><pre>' ;
        }
        print_r( $value ) ;
        echo '</pre>' ;
    }

// =============================================================================
// debug_print_backtrace()
// dpbt()
// =============================================================================

    function debug_print_backtrace( $title = NULL ) {

        // ---------------------------------------------------------------------

//echo '<pre>' , \debug_print_backtrace() , '</pre>' ;
//return ;

        // ---------------------------------------------------------------------

        $debug_backtrace = \debug_backtrace() ;

        // ---------------------------------------------------------------------
        // Here we should have (eg):-
        //
        //      $debug_backtrace = Array(
        //
        //          [0] => Array(
        //                      [file]      => /opt/lampp/htdocs/plugdev/wp-content/plugins/teaser-maker-std-v0.1.54/includes/dataset-manager/common.php
        //                      [line]      => 2656
        //                      [function]  => greatKiwi_byFernTec_teaserMaker_std_v0x1x54_testDebug\debug_print_backtrace
        //                      [args]      => Array()
        //                      )
        //
        //          ...
        //
        //          [8] => Array(
        //                      [file]      => /opt/lampp/htdocs/plugdev/wp-content/plugins/teaser-maker-std-v0.1.54/app-defs/teaser-maker.app/plugin.stuff/admin/home.php
        //                      [line]      => 255
        //                      [function]  => greatKiwi_byFernTec_teaserMaker_std_v0x1x54_standardDatasetManager\page_controller_wordpress_back_end
        //                      [args]      => Array(
        //                                          [0] => pluginPlant_byFernTec
        //                                          [1] => /opt/lampp/htdocs/plugdev/wp-content/plugins/teaser-maker-std-v0.1.54/app-defs
        //                                          [2] => /opt/    lampp/htdocs/plugdev/wp-content/plugins/teaser-maker-std-v0.1.54/includes
        //                                          [3] => Teaser Maker  Std 0.1.54
        //                                          [4] => ?page=teaserMakerStdV0x1x54
        //                                          [5] => Admin Home
        //                                          [6] => teaserMakerStdV0x1x54
        //                                          )
        //                      )
        //
        //          [9] => Array(
        //                      [function]  => greatKiwi_byFernTec_teaserMaker_std_v0x1x54_adminSection\home_page
        //                      [args]      => Array(
        //                                          [0] =>
        //                                          )
        //                      )
        //
        //          [10] => Array(
        //                      [file]      => /opt/lampp/htdocs/plugdev/wp-includes/plugin.php
        //                      [line]      => 406
        //                      [function]  => call_user_func_array
        //                      [args]      => Array(
        //                                          [0] => \greatKiwi_byFernTec_teaserMaker_std_v0x1x54_adminSection\home_page
        //                                          [1] => Array(
        //                                                      [0] =>
        //                                                      )
        //                                          )
        //                      )
        //
        //          [11] => Array(
        //                      [file]      => /opt/lampp/htdocs/plugdev/wp-admin/admin.php
        //                      [line]      => 149
        //                      [function]  => do_action
        //                      [args]      => Array(
        //                                          [0] => toplevel_page_teaserMakerStdV0x1x54
        //                                          )
        //
        //                      )
        //
        //          )
        //
        // ---------------------------------------------------------------------

//pr( \debug_backtrace() ) ;

        foreach ( $debug_backtrace as $this_depth => $this_details ) {

            // -----------------------------------------------------------------

            $rows = <<<EOT
<tr>
    <td align="right" style="padding-right:1em">Depth:</td>
    <td><big><b>{$this_depth}</b></big></td>
</tr>
EOT;

            // -----------------------------------------------------------------

            if ( array_key_exists( 'file' , $this_details ) ) {

                $dirname = dirname( $this_details['file'] ) ;

                $basename = basename( $this_details['file'] ) ;

                $rows .= <<<EOT
<tr>
    <td align="right" style="padding-right:1em">File:</td>
    <td>{$dirname}/<b>{$basename}</b></td>
</tr>
EOT;

            }

            // -----------------------------------------------------------------

            if ( array_key_exists( 'line' , $this_details ) ) {

                $line = number_format( $this_details['line'] ) ;

                $rows .= <<<EOT
<tr>
    <td align="right" style="padding-right:1em">Line:</td>
    <td>{$line}</td>
</tr>
EOT;

            }

            // -----------------------------------------------------------------

            $parts = explode( '\\' , $this_details['function'] ) ;

            $fn = $parts[ count( $parts ) - 1 ] ;

            unset( $parts[ count( $parts ) - 1 ] ) ;

            $ns = implode( '\\' , $parts ) ;

            // -----------------------------------------------------------------

            $rows .= <<<EOT
<tr>
    <td align="right" style="padding-right:1em">Function:</td>
    <td>{$ns}\\<b style="font-size:120%">{$fn}</b></td>
</tr>
EOT;

            // -----------------------------------------------------------------

            if (    is_array( $this_details['args'] )
                    &&
                    count( $this_details['args'] ) > 0
                ) {

                ob_start() ;
                    pr( $this_details['args'] ) ;
                $args = ob_get_clean() ;

                $number_args = count( $this_details['args'] ) ;

                $args = <<<EOT
<a  href="javascript:void()"
    onclick="greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug_toggleArgs({$this_depth})"
    style="text-decoration:none; font-weight:bold"
    >toggle {$number_args} args</a>
<div    id="greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug_args{$this_depth}"
        style="display:none"
        >{$args}</div>
EOT;

            } else {

                $args = '&mdash;' ;

            }

            // -----------------------------------------------------------------

            $rows .= <<<EOT
<tr>
    <td align="right" style="padding-right:1em">Args:</td>
    <td>{$args}</td>
</tr>
EOT;

            // -----------------------------------------------------------------

            echo <<<EOT
<div style="margin-top:1em">
    <table border="1" cellpadding="3" cellspacing="0" style="background-color:#F7F7F7">
        {$rows}
    </table>
</div>\n
EOT;

            // -----------------------------------------------------------------

        }

        // ---------------------------------------------------------------------

        echo <<<EOT
<script type="text/javascript">
    function greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug_toggleArgs( depth ) {
        var id = 'greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug_args' + depth ;
        var el = document.getElementById( id ) ;
        if ( el.style.display === 'none' ) {
            el.style.display = '' ;
        } else {
            el.style.display = 'none' ;
        }
    }
</script>
EOT;

return ;

        // ---------------------------------------------------------------------
        // Original version
        // ---------------------------------------------------------------------

        // ---------------------------------------------------------------------
        // From:-
        //     http://web.enavu.com/tutorials/the-css-pre-wrap-trick/
        // pre {
        //     white-space: pre-wrap;       /* css-3 */
        //     white-space: -pre-wrap;      /* Opera 4-6 */
        //     white-space: -o-pre-wrap;    /* Opera 7 */
        //     word-wrap: break-word;       /* Internet Explorer 5+ */
        //     white-space: -moz-pre-wrap;  /* Older Versions of Mozilla */
        // }
        // ---------------------------------------------------------------------

        $pre_style = <<<EOT
width:          98%;
overflow:       auto;
white-space:    pre-wrap;
white-space:    -pre-wrap;
white-space:    -o-pre-wrap;
word-wrap:      break-word;
white-space:    -moz-pre-wrap
EOT;
        if ( $title === NULL ) {
            echo '<pre style="' , $pre_style , '">' ;
        } else {
            echo '<h2>' , $title , '</h2><pre style="' , $pre_style , '">' ;
        }
        ob_start() ;
            \debug_print_backtrace() ;
        echo str_replace( "\n" , "\n\n" , ob_get_clean() ) ;
        echo '</pre>' ;

        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------

    function dpbt( $title = NULL ) {
        debug_print_backtrace( $title ) ;
    }

// =============================================================================
// echo_list()
// =============================================================================

function echo_list( $numeric_array , $title = NULL ) {

    if (    is_string( $title )
            &&
            trim( $title ) !== ''
        ) {
        echo '<h2>' , $title , '</h2>' ;
    }

    echo '<pre>' ;

    if ( count( $numeric_array ) === 0 ) {
        echo 'array()' ;

    } else {

        foreach ( $numeric_array as $this_entry ) {
            if ( trim( $this_entry ) === '' ) {
                echo '&lt;empty&gt;' ;
            } else {
                echo $this_entry ;
            }
            echo "\n" ;
        }

    }

    echo '</pre>' ;

}

// =============================================================================
// echo_key_list()
// echo_keyed_list()
// =============================================================================

function echo_key_list( $numeric_array , $title = NULL ) {

    if (    is_string( $title )
            &&
            trim( $title ) !== ''
        ) {
        echo '<h2>' , $title , '</h2>' ;
    }

    if ( count( $numeric_array ) === 0 ) {

        echo 'array()<br /><br />' ;

    } else {

        $rows = '' ;

        foreach ( $numeric_array as $name => $value ) {

            $rows .= <<<EOT
<td>{$name}</td>
<td>:&nbsp;&nbsp;</td>
<td>{$value}</td>
EOT;

        }

        echo <<<EOT
<table border="1" cellpadding="3" cellspacing="0">{$rows}</table>
EOT;

    }

}

function echo_keyed_list( $numeric_array , $title = NULL ) {
    echo_key_list( $numeric_array , $title ) ;
}

// =============================================================================
// That's that!
// =============================================================================

