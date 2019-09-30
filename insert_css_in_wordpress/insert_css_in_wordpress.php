<?php
/*
Plugin Name: Insert CSS in Wordpress
Plugin URI: https://profiles.wordpress.org/gustavosapienza/
Description: Adicionar CSS Customizado
Version: 1.1.1
Author: Gustavo Sapienza
Author URI: https://profiles.wordpress.org/gustavosapienza/
License: MIT
License URI: https://opensource.org/licenses/MIT
*/




//Theme Options
function add_theme_menu_item()
{
  add_menu_page("CSS Customizado", "CSS Customizado", "manage_options", "theme-panel", "theme_settings_page", null, 99);
}

add_action("admin_menu", "add_theme_menu_item");


function theme_settings_page()
{
    ?>
      <div class="wrap">
      <h1>Custom CSS</h1>
      <form method="post" action="options.php">
          <?php
              settings_fields("section");
              do_settings_sections("theme-options");      
              submit_button(); 
          ?>          
      </form>
    </div>
  <?php
}


function display_css_desktop_element()
{
  ?>
      <h2>Desktop CSS</h2>
      <textarea name="css_desktop" id="css_desktop" style="width:100%; height: 400px"><?php echo get_option('css_desktop'); ?></textarea>
    <?php
}

function display_css_mobile_element()
{
  ?>
      <h2>Mobile CSS</h2>
      <textarea name="css_mobile" id="css_mobile" style="width:100%; height: 400px"><?php echo get_option('css_mobile'); ?></textarea>
    <?php
}

function display_theme_panel_fields()
{
  add_settings_section("section", "Todas configurações", null, "theme-options");
  
    add_settings_field("css_desktop", "CSS Desktop", "display_css_desktop_element", "theme-options", "section");
    add_settings_field("css_mobile", "CSS Mobile", "display_css_mobile_element", "theme-options", "section");

    register_setting("section", "css_desktop");
    register_setting("section", "css_mobile");
}

function minimizeCSSsimple($css){
  $css = preg_replace('/\/\*((?!\*\/).)*\*\//','',$css); // negative look ahead
  $css = preg_replace('/\s{2,}/',' ',$css);
  $css = preg_replace('/\s*([:;{}])\s*/','$1',$css);
  $css = preg_replace('/;}/','}',$css);
  return $css;
}

add_action("admin_init", "display_theme_panel_fields");

//echo get_option('css_desktop');



function css_externo() {
?>


<style type="text/css" class="adicionar-css-customizado"><?php echo minimizeCSSsimple(get_option('css_desktop')) ?> @media (max-width:991px) { <?php echo minimizeCSSsimple(get_option('css_mobile')); ?> }</style>


<?php
}

add_action('wp_head','css_externo');


?>