<?php

// *****************************************************************************
// INCLUDES / FORCE-COOKIE.PHP
// (C) 2013 Peter Newman. All Rights Reserved.
// *****************************************************************************

//    namespace pluginPlant_byFernTec_adminSection ;

// =============================================================================
// home_page()
// =============================================================================

//function home_page() {

    // =========================================================================
    // FORCE COOKIE ?
    // =========================================================================

/*
    if (    isset( $_GET['force_cookie_name'] )
            ||
            isset( $_GET['force_cookie_value'] )
        ) {

        // ---------------------------------------------------------------------

        $question_amp = FALSE ;

        $query_changes = array(
                            'force_cookie_name'     =>  NULL        ,
                            'force_cookie_value'    =>  NULL
                            ) ;

        $cleaned_url = adjust_query(
                            $_SERVER['REQUEST_URI']     ,
                            $query_changes              ,
                            $question_amp
                            ) ;

        // ---------------------------------------------------------------------

        if ( isset( $_GET['force_cookie_name'] ) ) {

            // -----------------------------------------------------------------

            $allowed_force_cookies = array(
                'wooDeals_byFernTec_productPlanner_timeslotGroup_selectedTab'   =>  array(
                    'old'       ,
                    'current'   ,
                    'planned'
                    )
                ) ;

            // -----------------------------------------------------------------

            if ( array_key_exists( $_GET['force_cookie_name'] , $allowed_force_cookies ) ) {

                // -------------------------------------------------------------

                if ( isset( $_GET['force_cookie_value'] ) ) {

                    // ---------------------------------------------------------

                    if ( in_array( $_GET['force_cookie_value'] , $allowed_force_cookies[ $_GET['force_cookie_name'] ] , TRUE ) ) {

                        // -----------------------------------------------------
                        // Set the Cookie Value...
                        // -----------------------------------------------------

                        $js_dir_url = WOO_DEALS_BY_FERNTEC_PLUGIN_ROOT_URL . '/js' ;

                        // -----------------------------------------------------

                        echo <<<EOT
<script type="text/javascript"
        src="{$js_dir_url}/scottHamperCookies.js"
        ></script>
<script type="text/javascript">
    scottHamperCookies.set( '{$_GET['force_cookie_name']}' , '{$_GET['force_cookie_value']}' ) ;
    location.href = '{$cleaned_url}' ;
</script>
EOT;

                        // -----------------------------------------------------

                    } else {

                        // -----------------------------------------------------
                        // Bad Cookie Value...
                        // -----------------------------------------------------

                        echo <<<EOT
PROBLEM: Unrecognised/unsupported "force_cookie_value"
Detected in: "manage_promotions()"
EOT;

                        // -----------------------------------------------------

                    }

                    // ---------------------------------------------------------

                } else {

                    // ---------------------------------------------------------
                    // Delete the Cookie...
                    // ---------------------------------------------------------

                    echo <<<EOT
<script type="text/javascript"
        src="{$js_dir_url}/scottHamperCookies.js"
        ></script>
<script type="text/javascript">
    scottHamperCookies.expire( '{$_GET['force_cookie_name']}' ) ;
    location.href = '{$cleaned_url}' ;
</script>
EOT;

                    // ---------------------------------------------------------

                }

                // -------------------------------------------------------------

            } else {

                // -------------------------------------------------------------
                // Bad Cookie Name...
                // -------------------------------------------------------------

                echo <<<EOT
PROBLEM: Unrecognised/unsupported "force_cookie_name"
Detected in: "manage_promotions()"
EOT;

                // -------------------------------------------------------------

            }

            // -----------------------------------------------------------------

            return ;

            // -----------------------------------------------------------------

        } else {

            // -----------------------------------------------------------------
            // Either or both of:-
            //      "force_cookie_name", and;
            //      "force_cookie_value"
            //
            // are invalid...
            // -----------------------------------------------------------------

            wp_redirect( $cleaned_url ) ;

            exit() ;

            // -----------------------------------------------------------------

        }

        // ---------------------------------------------------------------------

    }
*/

    // =========================================================================
    // That's that!
    // =========================================================================

//}

// =============================================================================
// That's that!
// =============================================================================

