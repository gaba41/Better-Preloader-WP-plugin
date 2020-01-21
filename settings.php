<?php

    defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

    function WPTime_preloader_settings() {
        add_plugins_page( 'Preloader Settings', 'Preloader', 'manage_options', 'WPTime_preloader_settings', 'WPTime_preloader_settings_page');
    }
    add_action( 'admin_menu', 'WPTime_preloader_settings' );
    
    function WPTime_preloader_register_settings() {
        register_setting( 'WPTime_preloader_register_setting', 'wptpreloader_bg_color' );
        register_setting( 'WPTime_preloader_register_setting', 'wptpreloader_image' );
        register_setting( 'WPTime_preloader_register_setting', 'wptpreloader_screen' );
        register_setting( 'WPTime_preloader_register_setting', 'wptpreloader_image_width' );
        register_setting( 'WPTime_preloader_register_setting', 'wptpreloader_image_height' );
    }
    add_action( 'admin_init', 'WPTime_preloader_register_settings' );
    
    // settings page function

    function WPTime_preloader_settings_page(){
        if( get_option('wptpreloader_bg_color') ){
            $background_color = get_option('wptpreloader_bg_color');
        }else{
            $background_color = '#FFFFFF';
        }
        
        if( get_option('wptpreloader_image') ){
            $preloader_image = get_option('wptpreloader_image');
        }else{
            $preloader_image = plugins_url( '/images/preloader.GIF', __FILE__ );
        }

        if( get_option('wptpreloader_image_width') ){
            $image_width = get_option('wptpreloader_image_width');
        }else{
            $image_width = "64";
        }

        if( get_option('wptpreloader_image_height') ){
            $image_height = get_option('wptpreloader_image_height');
        }else{
            $image_height = "64";
        }

        $get_theme = wp_get_theme();
        $theme_name = strtolower( $get_theme->get('Name') );
        $remove_d = str_replace(" ", "-", $theme_name);
        $get_theme_name = rtrim($remove_d, "-");

        if( is_ssl() ){
            $header_file_url = admin_url("theme-editor.php?file=header.php&theme=$get_theme_name", "https");
        }else{
            $header_file_url = admin_url("theme-editor.php?file=header.php&theme=$get_theme_name", "http");
        }

        $preloader_element = esc_html('now after <body> insert Preloader HTML element: <div id="wptime-plugin-preloader"></div>');
        ?>
            <div class="wrap">
                <h2>Preloader Settings</h2>
                
                <?php if( isset($_GET['settings-updated']) && $_GET['settings-updated'] ){ ?>
                    <div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible"> 
                        <p><strong>Settings saved.</strong></p>
                        <button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
                    </div>
                <?php } ?>
                
                <form method="post" action="options.php">
                    <?php settings_fields( 'WPTime_preloader_register_setting' ); ?>
                    
                    <table class="form-table">
                        <tbody>
                        
                            <tr>
                                <th scope="row"><label for="wptpreloader_bg_color">Background Color</label></th>
                                <td>
                                    <input class="regular-text" name="wptpreloader_bg_color" type="text" id="wptpreloader_bg_color" value="<?php echo esc_attr( $background_color ); ?>">
                                    <p class="description">Enter background color code, default color is white #FFFFFF.</p>
                                </td>
                            </tr>
                            
                            <tr>
                                <th scope="row"><label for="wptpreloader_image">Preloader Image</label></th>
                                <td>
                                    <input class="regular-text" name="wptpreloader_image" type="text" id="wptpreloader_image" value="<?php echo esc_attr( $preloader_image ); ?>">
                                    <p class="description"><?php echo ('Enter preloader image link, image size must be 128x128 (will be retina ready).'); ?> <a href="https://icons8.com/preloaders/" target="_blank">Get FREE Preloader Image</a>.</p>
                                </td>
                            </tr>

                            <tr>
                                <th scope="row"><label for="wptpreloader_image_width">Preloader Image Width</label></th>
                                <td>
                                        <input class="regular-text" name="wptpreloader_image_width" type="text" id="wptpreloader_image_width" value="<?php echo esc_attr( $image_width ); ?>">
                                        <?echo ("px");?>
                                        <p class="description">Enter your desider image width in px, default size is 64px</p>
                                </td>
                            </tr>

                            <tr>
                                <th scope="row"><label for="wptpreloader_image_height">Preloader Image Height</label></th>
                                <td>
                                        <input class="regular-text" name="wptpreloader_image_height" type="text" id="wptpreloader_image_height" value="<?php echo esc_attr( $image_height ); ?>">
                                        <?echo ("px");?>
                                        <p class="description">Enter your desider image height in px, default size is 64px</p>
                                </td>
                            </tr>
                            
                            <tr>
                                <th scope="row">Display Preloader</th>
                                <td>
                                    <?php
                                        $display_preloader = get_option( 'wptpreloader_screen' );
                                        
                                    ?>
                                    <fieldset>
                                        <legend class="screen-reader-text"><span>Display Preloader</span></legend>
                                        <label title="Display Preloader in full website like home page, posts, pages, categories, tags, attachment, etc..">
                                            <input type="radio" name="wptpreloader_screen" value="full" <?php checked( $display_preloader, 'full' ); ?>>In The Entire Website.
                                        </label>
                                        <br>
                                        <label title="Display Preloader in home page">
                                            <input type="radio" name="wptpreloader_screen" value="homepage" <?php checked( $display_preloader, 'homepage' ); ?>>In Home Page only.
                                        </label>
                                        <br>
                                        <label title="Display Preloader in front page">
                                            <input type="radio" name="wptpreloader_screen" value="frontpage" <?php checked( $display_preloader, 'frontpage' ); ?>>In Front Page only.
                                        </label>
                                        <br>
                                        <label title="Display Preloader in posts only">
                                            <input type="radio" name="wptpreloader_screen" value="posts" <?php checked( $display_preloader, 'posts' ); ?>>In Posts only.
                                        </label>
                                        <br>
                                        <label title="Display Preloader in pages only">
                                            <input type="radio" name="wptpreloader_screen" value="pages" <?php checked( $display_preloader, 'pages' ); ?>>In Pages only.
                                        </label>
                                        <br>
                                        <label title="Display Preloader in categories only">
                                            <input type="radio" name="wptpreloader_screen" value="cats" <?php checked( $display_preloader, 'cats' ); ?>>In Categories only.
                                        </label>
                                        <br>
                                        <label title="Display Preloader in tags only">
                                            <input type="radio" name="wptpreloader_screen" value="tags" <?php checked( $display_preloader, 'tags' ); ?>>In Tags only.
                                        </label>
                                        <br>
                                        <label title="Display Preloader in attachment only">
                                            <input type="radio" name="wptpreloader_screen" value="attachment" <?php checked( $display_preloader, 'attachment' ); ?>>In Attachment only.
                                        </label>
                                        <br>
                                        <label title="Display Preloader in 404 error page">
                                            <input type="radio" name="wptpreloader_screen" value="404error" <?php checked( $display_preloader, '404error' ); ?>>In 404 Error Page only.
                                        </label>
                                        <br>
                                        <label title="Display Preloader in WooCommerce page">
                                            <?php
                                                if( function_exists('is_woocommerce') ){
                                                    ?>
                                                        <input type="radio" name="wptpreloader_screen" value="woocommerce" <?php checked( $display_preloader, 'woocommerce' ); ?>>In WooCommerce only (shop page, product page, checkout page, etc).
                                                    <?php
                                                }else{
                                                    ?>
                                                        <input disabled type="radio" name="wptpreloader_woo" value="disabled">In WooCommerce only (shop page, product page, checkout page, etc).<br><span style="font-style: italic; color:#666; font-size:14px;">This option will be available after activation WooCommerce plugin.</span>
                                                    <?php
                                                }
                                            ?>
                                        </label>
                                    </fieldset>
                                </td>
                            </tr>

                            <tr>
                                <th scope="row"><label>Preloader Element</label></th>
                                <td>
                                    <p class="description">Open <a target="_blank" href="<?php echo $header_file_url; ?>">header.php</a> file for your theme, <?php echo $preloader_element; ?></p>
                                </td>
                            </tr>
                            
                        </tbody>
                    </table>
                    
                    <p class="submit"><input id="submit" class="button button-primary" type="submit" name="submit" value="Save Changes"></p>
                </form>
                                
            </div>
        <?php
    }