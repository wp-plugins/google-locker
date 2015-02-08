<?php
/*-----------------------------------------------------------------------------------*/
/*	Footer Scripting for Short Code
/*-----------------------------------------------------------------------------------*/
 
// Global variable
$count = 0;

function gl_get_script_footer() {
	global $count;
	
    // General Values
    $general_settings = gl_get_general_settings_values();
    
    // Configure Urls
    $postID  = get_the_ID();
	
	// Use postID = 0 and count = 1 in admin mode
	if ( is_admin() ) {
		$postID = 0;
		$count = 1;
    }
	
    // Footer Script and Callback Functions
    $script_footer = $script_footer . '
		<!-- 
			Creater Script for Google Locker
			Created by WPTP Net
			http://wptp.net
		-->
	';
    
	// Google & Youtube Callback
    if ( $general_settings[ 'google_active' ] || $general_settings[ 'google_share' ] || $general_settings[ 'youtube_active' ] ) {
        $script_footer = $script_footer . '
			<script type="text/javascript">
			  window.___gcfg = {lang: "' . $general_settings[ 'short_language' ] .'"};

			  (function() {
				var po = document.createElement("script"); po.type = "text/javascript"; po.async = true;
				po.src = "https://apis.google.com/js/platform.js";
				var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(po, s);
			  })();
			</script>
            <script type="text/javascript">
                function gl_unlock_g_social() {
					gl_unlocksocial( "google" );
                };
                function gl_unlock_g_content() {
					gl_unlockcontent( "google" );
                };
				
                function gl_unlock_g_share_start_social( params ) {
					if ( params.type == "confirm" )
						console.log("start social confirm");
					else if ( params.type == "hover" )
						console.log("start social hover");
                };
                function gl_unlock_g_share_start_content( params ) {
					if ( params.type == "confirm" )
						console.log("start content confirm");
					else if ( params.type == "hover" )
						console.log("start content hover");
                };
				
                function gl_unlock_g_share_end_social( params ) {
					if ( params.type == "confirm" )
						gl_unlocksocial( "google_share" );
					else if ( params.type == "hover" )
						console.log("end social hover");
                };
                function gl_unlock_g_share_end_content( params ) {
					if ( params.type == "confirm" )
						gl_unlockcontent( "google_share" );
					else if ( params.type == "hover" )
						console.log("end content hover");
                };
            </script>
            <script type="text/javascript">
                function gl_unlock_y_social( payload ) {
					if (payload.eventType == "subscribe") {
						gl_unlocksocial( "youtube" );
					}					
                };
                function gl_unlock_y_content( payload ) {
					if (payload.eventType == "subscribe") {
						gl_unlockcontent( "youtube" );
					}
                };
            </script>
        ';
    }
    
	// Lock & Unlock script
	$script_footer = $script_footer . '
		<script type="text/javascript">
			var glTimerSocial = setInterval ( function() { lock("g-locker-to-lock-social"); }, 100 );
			var glTimerContent = setInterval ( function() { lock("g-locker-to-lock-content"); }, 100 );
			
			function gl_unlocksocial( social ) {
				clearInterval(glTimerSocial);
				gl_createCookie("g_locker_social", ' . $general_settings[ 'cookie_days' ] . ');
				
				window.location.reload( true );
			}
			
			function gl_unlockcontent( social ) {
				clearInterval(glTimerContent);
				gl_createCookie("g_locker_' . $postID . '_content", ' . $general_settings[ 'cookie_days' ] . ');
				
				window.location.reload(true);
			}

			function lock(className) {
				var id = "";
				for	( i = 1; i <= ' . $count . '; i++ ) {
					id = className + "-" + String(i);
					var x = document.getElementById( id );
					if ( x ) {
						x.style.display = "none";
					}
				}
			}                
		</script>			
	';
        
    // Cookie
    $script_footer = $script_footer . '
        <script type="text/javascript">
            function gl_createCookie(id, days) {
				var d = new Date();
				
                if ( days > 0 ) {
                    d.setTime(d.getTime() + (days * 24 * 60 * 60 * 1000));
                }
                else {
                    d.setTime(d.getTime() + (24 * 60 * 60 * 1000));
                }
				
                var expires = "expires=" + d.toGMTString();
                document.cookie = id + "=true; " + expires;
            }
        </script>			
    ';
	
	// Effects
	$script_footer = $script_footer . '
		<script>
			function effectFadeToggle() {
				jQuery(this).find("#g-locker-effect").stop(true,false).fadeToggle();
			}
			function effectSlideToggle() {
				jQuery(this).find("#g-locker-effect").stop(true,false).slideToggle();
			}
			function effectToggle() {
				jQuery(this).find("#g-locker-effect").stop(true,false).toggle("slow");
			}
			
			// for mouse down
			function effectFadeToggleTimer() {
				jQuery(this).find("#g-locker-effect").fadeToggle();
				jQuery(this).find("#g-locker-effect").delay( 1800 ).fadeToggle();
			}
			function effectSlideToggleTimer() {
				jQuery(this).find("#g-locker-effect").slideToggle();
				jQuery(this).find("#g-locker-effect").delay( 1800 ).slideToggle();
			}
			function effectToggleTimer() {
				jQuery(this).find("#g-locker-effect").toggle("slow");
				jQuery(this).find("#g-locker-effect").delay( 1800 ).toggle("slow");
			}
			
			jQuery( document ).ready( function() {
	';
	
	for	( $i = 1; $i <= $count; $i++ ) {
		$script_footer = $script_footer . '
				jQuery( "#g-locker-google-one-fade-' . $i . '" ).hover( effectFadeToggle, effectFadeToggle );
				jQuery( "#g-locker-google-share-fade-' . $i . '" ).hover( effectFadeToggle, effectFadeToggle );				
				jQuery( "#g-locker-youtube-fade-' . $i . '" ).hover( effectFadeToggle, effectFadeToggle );
				
				jQuery( "#g-locker-google-one-fade-' . $i . '" ).mousedown ( effectFadeToggleTimer );
				jQuery( "#g-locker-google-share-fade-' . $i . '" ).mousedown ( effectFadeToggleTimer );
				jQuery( "#g-locker-youtube-fade-' . $i . '" ).mousedown ( effectFadeToggleTimer );
				
				//slide
				jQuery( "#g-locker-google-one-slide-' . $i . '" ).hover( effectSlideToggle, effectSlideToggle	);
				jQuery( "#g-locker-google-share-slide-' . $i . '" ).hover( effectSlideToggle, effectSlideToggle );				
				jQuery( "#g-locker-youtube-slide-' . $i . '" ).hover( effectSlideToggle, effectSlideToggle );
				
				jQuery( "#g-locker-google-one-slide-' . $i . '" ).mousedown( effectSlideToggleTimer	);
				jQuery( "#g-locker-google-share-slide-' . $i . '" ).mousedown( effectSlideToggleTimer );				
				jQuery( "#g-locker-youtube-slide-' . $i . '" ).mousedown( effectSlideToggleTimer );
				
				//hide
				jQuery( "#g-locker-google-one-hide-' . $i . '" ).hover( effectToggle, effectToggle );
				jQuery( "#g-locker-google-share-hide-' . $i . '" ).hover( effectToggle, effectToggle );				
				jQuery( "#g-locker-youtube-hide-' . $i . '" ).hover( effectToggle, effectToggle);
				
				jQuery( "#g-locker-google-one-hide-' . $i . '" ).mousedown( effectToggleTimer );
				jQuery( "#g-locker-google-share-hide-' . $i . '" ).mousedown( effectToggleTimer );				
				jQuery( "#g-locker-youtube-hide-' . $i . '" ).mousedown( effectToggleTimer );
		';
	}
	
	$script_footer = $script_footer . '
			});
		</script>
	';
    
    echo $script_footer;
}

add_action( 'wp_footer', 'gl_get_script_footer' );

/*-----------------------------------------------------------------------------------*/
/*	Current Page Function
/*-----------------------------------------------------------------------------------*/

function gl_current_page( ) {
    // Get Post ID and URL
    $postID  = get_the_ID();
    $postURL = get_permalink( $postID );
    return $postURL;
}

/*-----------------------------------------------------------------------------------*/
/*	ShortCode Handler
/*-----------------------------------------------------------------------------------*/

function gl_locker_handle( $atts, $content ) {
    // Extract variables from shortcode tag, set defaults
    extract( shortcode_atts( array(
		"type" => 'social'
    ), $atts ) );
	
    $type = strtolower( $type );    
    $postID  = get_the_ID();
    
    // Check Cookies
    if ( $type == 'social' && $_COOKIE["g_locker_social"] == 'true') {
		return do_shortcode( $content );
    }
	else if ( $type == 'content' && $_COOKIE["g_locker_" . $postID . "_content"] == 'true') {
		return do_shortcode( $content );
    }
    else {
		// General Values
		$general_settings = gl_get_general_settings_values();
		
		// Configure Urls
		$youtube_channel      = $general_settings[ 'youtube_channel' ];
		$googleurl            = ( ($type == 'social') ? $general_settings[ 'google_url' ]   : gl_current_page() );
        return gl_generate( $content, $type, $googleurl, $youtube_channel );
    }
}

/**
 * Generate Google Locker
 */ 
function gl_generate( $content, $type, $googleurl, $youtube_channel, $is_preview = false ) {
    // General Values
    $general_settings = gl_get_general_settings_values();
    
    // Locker Values
    $social_lock_settings  = gl_get_social_lock_setting_values();
    $content_lock_settings = gl_get_content_lock_setting_values();

    $title           = $social_lock_settings[ 'sl_title' ];
    $message         = $social_lock_settings[ 'sl_message' ];
    $style           = $social_lock_settings[ 'sl_style' ];
    $title_color     = $social_lock_settings[ 'sl_title_color' ];
    $message_color   = $social_lock_settings[ 'sl_message_color' ];
    $bg_color        = $social_lock_settings[ 'sl_bg_color' ];
    $shadow_color    = $social_lock_settings[ 'sl_shadow_color' ];
    $button_layout   = $social_lock_settings[ 'sl_layout' ];
    $button_effect   = $social_lock_settings[ 'sl_btn_effect' ];
    
    if ( $type == 'content' ) {
        $title           = $content_lock_settings[ 'cl_title' ];
        $message         = $content_lock_settings[ 'cl_message' ];
        $style           = $content_lock_settings[ 'cl_style' ];
        $title_color     = $content_lock_settings[ 'cl_title_color' ];
        $message_color   = $content_lock_settings[ 'cl_message_color' ];
        $bg_color        = $content_lock_settings[ 'cl_bg_color' ];
        $shadow_color    = $content_lock_settings[ 'cl_shadow_color' ];
        $button_layout   = $content_lock_settings[ 'cl_layout' ];
		$button_effect   = $content_lock_settings[ 'cl_btn_effect' ];
    }
    
    // Layout Button
    if ( $button_layout == 'count' ) {
        $gp_layout = 'medium';
        $gps_layout = 'bubble';
        $youtube_layout = 'horizontal';
        $height_button = 22;
    } else if ( $button_layout == 'box' ) {
        $gp_layout = 'tall';
        $gps_layout = 'vertical-bubble';
        $youtube_layout = 'vertical';
        $height_button = 65;
    }
	
	// Only use "Round Style" with "Count Social Layout"
	if ( $button_layout == 'box' && $style == 'round' )
		$style = 'corner';
	
    // Create Locker
	global $count;
	$count = $count + 1;   
    
    // Create Button Locks
	if ( $general_settings[ 'google_active' ] ) {
		$btn_locks = $btn_locks . '
			<div class="g-locker-' . $style . '-box" id="g-locker-google-one-' . $button_effect . '-' . $count . '">
				<a class="g-locker-' . $style . '-effect" id="g-locker-effect" style="line-height: normal;">
					<div class="g-locker-' . $style . '-icon-google"></div>
				</a>
				<div class="g-locker-' . $style . '-button" style="line-height: normal; height:' . $height_button .'px;">
					<div class="g-plusone" data-size="' . $gp_layout . '" data-callback="gl_unlock_g_' . $type . '" data-href="' . $googleurl . '"></div>
				</div>
			</div>
		';
	}
	if ( $general_settings[ 'google_share' ] ) {
		$btn_locks = $btn_locks . '
			<div class="g-locker-' . $style . '-box" id="g-locker-google-share-' . $button_effect . '-' . $count . '">
				<a class="g-locker-' . $style . '-effect" id="g-locker-effect" style="line-height: normal;">
					<div class="g-locker-' . $style . '-icon-google"></div>
				</a>
				<div class="g-locker-' . $style . '-button" style="line-height: normal; height:' . $height_button .'px;">
					<div class="g-plus" data-action="share" data-annotation="' . $gps_layout . '" data-onstartinteraction="gl_unlock_g_share_start_' . $type . '" data-onendinteraction="gl_unlock_g_share_end_' . $type . '" data-href="' . $googleurl . '" ></div>
				</div>
			</div>
		';
	}
	if ( $general_settings[ 'youtube_active' ] ) {
		if ( $youtube_layout  == 'vertical') {
			$counter = gl_get_counter_youtube( $youtube_channel );
			$btn_locks = $btn_locks . '
				<div class="g-locker-' . $style . '-box" id="g-locker-youtube-' . $button_effect . '-' . $count . '">
					<a class="g-locker-' . $style . '-effect" id="g-locker-effect" style="line-height: normal;">
						<div class="g-locker-' . $style . '-icon-youtube"></div>
					</a>
					<div class="g-locker-' . $style . '-button" style="line-height: normal; height:' . $height_button .'px;">
						<div class="box_counter_ver" style="width: 88px;" ><span id="followers">' . $counter . '</span></div>
						<div class="g-ytsubscribe" data-channel="' . $youtube_channel .'" data-count="hidden" data-onytevent="gl_unlock_y_' . $type . '"></div>
					</div>
				</div>
			';
		} else {
			$btn_locks = $btn_locks . '
				<div class="g-locker-' . $style . '-box" id="g-locker-youtube-' . $button_effect . '-' . $count . '">
					<a class="g-locker-' . $style . '-effect" id="g-locker-effect" style="line-height: normal;">
						<div class="g-locker-' . $style . '-icon-youtube"></div>
					</a>
					<div class="g-locker-' . $style . '-button" style="line-height: normal; height:' . $height_button .'px;">
						<div class="g-ytsubscribe" data-channel="' . $youtube_channel .'" data-onytevent="gl_unlock_y_' . $type . '"></div>
					</div>
				</div>
			';
		}
	}
    
	// Google Locker all
	// before
    $gl_locker = $gl_locker . '<div class="g-locker-' . $type . ' g-locker-' . $style . '" id="g-locker-' . $type . '-' . $count . '" style="background-color:' . $bg_color . '; box-shadow:0 0 40px ' . $shadow_color . '; -webkit-box-shadow:0 0 40px ' . $shadow_color . ';">
        ';
		
	// buttons locker
	$gl_locker = $gl_locker . '
			<div class="g-locker-' . $style . '-text">
				<div class="g-locker-' . $style . '-strong" style="color: ' . $title_color . ';">' . $title . '</div>
				<div class="g-locker-' . $style . '-message" style="color: ' . $message_color . ';">' . $message . '</div>
			</div>
			<div class="g-locker-' . $style . '-buttons">
				' . $btn_locks . '
			</div>
		';
    
	// after
    $gl_locker = $gl_locker . '
		</div>
        ';
    
    return $gl_locker;
}

/**
 * Function convert number to short value with M, B, k
 */
function gl_get_number_format($value) {
	if ( $value > 1000000000 ) return round( ($value/1000000000), 1 ).'B';
	else if ( $value > 1000000 ) return round( ($value/1000000), 1 ).'M';
	else if ( $value > 1000 ) return round( ($value/1000), 1 ).'k';

	return $value;
}

/**
 * Function get Subscriber Counter for Youtube
 */ 
function gl_get_counter_youtube($user) {
	
	$CHECK_URL_PREFIX = 'https://gdata.youtube.com/feeds/api/users/';
	
	$check_url = $CHECK_URL_PREFIX . $user . '?alt=json';
	
	try {
		$response = file_get_contents( $check_url );
		$result = json_decode( $response, true );
		
		if (isset( $result['entry']['yt$statistics']['subscriberCount'] )) {
			return gl_get_number_format( $result['entry']['yt$statistics']['subscriberCount'] );
		}
		else {
			return "0";
		}
	} catch ( Exception $e ) {
		return "0";
	}
}

/**
 * Add the short code to WordPress
 */
add_shortcode( "g_locker", "gl_locker_handle" );
?>