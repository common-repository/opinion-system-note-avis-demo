<?php
/*
Plugin Name:  Opinion System note & avis Demo
Text Domain:  opinion-system-note-avis-demo
Plugin URI:   https://www.amauryrambaud.fr/plugin-opinion-system-note-avis/
Description:  Afficher la moyenne des notes Opinion System et les avis avec un shortcode (mode démonstration)
Version:      1.2.1
Author:       Amaury Rambaud
Author URI:   https://www.amauryrambaud.fr/
License:      GPLv3
License URI:  https://www.gnu.org/licenses/gpl.html

Opinion System note & avis Demo is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
any later version.
 
Opinion System note & avis is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with Opinion System note & avis Demo. If not, see https://www.gnu.org/licenses/gpl.html.
*/

if(!is_admin()){
    add_action('wp_enqueue_scripts', 'opinion_system_note_avis_scripts'); 
} else {
    add_action('admin_enqueue_scripts', 'opinion_system_note_avis_admin_scripts');
	add_action('admin_menu', 'opinion_system_note_avis_menu');
    add_action('admin_init', 'update_opinion_system_note_avis_settings');
}

function opinion_system_settings_action_links( $links, $file ) {
    array_unshift( $links, '<a href="' . admin_url( 'options-general.php?page=opinion_system_menu' ) . '">' . __( 'Settings' ) . '</a>' );
    return $links;
}

add_filter( 'plugin_action_links_'.plugin_basename( __FILE__ ), 'opinion_system_settings_action_links', 10, 2 );

function opinion_system_note_avis_admin_scripts(){
    wp_enqueue_style('opinion_system_note_avis_style', plugins_url('/opinion_system_note_avis.css', __FILE__));
    if (get_option('couleur_opinion_system') == 'blanc')
        wp_enqueue_style('opinion_system_note_avis_style_blanc', plugins_url('/opinion_system_note_avis_blanc.css', __FILE__));
}

function opinion_system_note_avis_menu(){
    add_options_page( 'Opinion System note avis Demo paramétrage', 'Opinion System note avis Demo', 'manage_options', 'opinion_system_menu', 'opinion_system_parametrage_page' );
}

function opinion_system_parametrage_page(){
    echo '<h1>Opinion System note avis Demo paramétrage</h1>';
    echo '<form method="post" action="options.php">';
    settings_fields('opinion-system-note-avis-settings');
    do_settings_sections('opinion-system-note-avis-settings');
    echo '<table class="form-table">';
    echo '<tr valign="top"><th scope="row">Couleur :</th>';
    if (get_option('couleur_opinion_system') == 'blanc'){
        echo '<td><input type="radio" name="couleur_opinion_system" value="bleu"> Bleu';
        echo '<input type="radio" name="couleur_opinion_system" value="blanc" checked> Blanc</td></table>';
    } else {
        echo '<td><input type="radio" name="couleur_opinion_system" value="bleu" checked> Bleu';
        echo '<input type="radio" name="couleur_opinion_system" value="blanc"> Blanc</td></table>';
    }
    submit_button();
    echo '</form>';
    echo '<br><b>Mode d\'emploi :</b> utiliser le shortcode "<b>[opinion_system_note_avis]</b>" pour afficher le plugin là où vous le souhaitez.<br><br>';
	echo '<br>Dans la <b>version complète du plugin</b> il existe également 2 autres shortcodes pour afficher la liste des témoignages client directement sur votre site WordPress et un paramètre pour filtrer par numéro adhérent (company_id).<br>';
    echo '<br>Pour acheter la <b>version complète du plugin</b> rendez-vous sur mon site web en suivant <a href="https://www.amauryrambaud.fr/plugin-opinion-system-note-avis/" target="_blank">ce lien</a>.<br><br>';
    echo '<h2>Aperçu</h2>';
    echo wp_kses_post(opinion_system_note_avis());
}

function update_opinion_system_note_avis_settings(){
    register_setting( 'opinion-system-note-avis-settings', 'couleur_opinion_system' );
}

function opinion_system_note_avis_scripts(){
    wp_enqueue_style('opinion_system_note_avis_style', plugins_url('/opinion_system_note_avis.css', __FILE__));
    if (get_option('couleur_opinion_system') == 'blanc')
        wp_enqueue_style('opinion_system_note_avis_style_blanc', plugins_url('/opinion_system_note_avis_blanc.css', __FILE__));
}

function opinion_system_note_avis() {
        if (get_option('couleur_opinion_system') == 'blanc') {
            $content = '<div id="opinion-system-plugin"><div class="company-rating"><div class="stars-container"><img class="os-logo" src="'.plugins_url("/check_black.png", __FILE__).'">';
			$content .= '<img class="stars" src="'.plugins_url("/jauge_etoiles_blanc.png", __FILE__).'">';
        } else {
            $content = '<div id="opinion-system-plugin"><div class="company-rating"><div class="stars-container"><img class="os-logo" src="'.plugins_url("/check.png", __FILE__).'">';
			$content .= '<img class="stars" src="'.plugins_url("/jauge_etoiles.png", __FILE__).'">';
		}
        $content .= '<div class="numbers">4<div class="small_number"><div class="comma">,</div>0</div></div>';
        $content .= '</div><div class="text"><b>Mode Démonstration</b><br>Note calculée à partir des 100 avis contrôlés par Opinion System. Sont exclus de cette note les avis clients provenant de sources externes.</div></div>';
        $content .= '<div class="rating-box-container"><div class="rating-box-cell"><div class="rating-box"><img class="rating-box-icon" src="'.plugins_url("/smiley_good.png", __FILE__).'"><div class="rating-label">75</div></div></div>';
        $content .= '<div class="rating-box-cell"><div class="rating-box"><img class="rating-box-icon" src="'.plugins_url("/smiley_neutral.png", __FILE__).'"><div class="rating-label">20</div></div></div>';
        $content .= '<div class="rating-box-cell"><div class="rating-box"><img class="rating-box-icon" src="'.plugins_url("/smiley_bad.png", __FILE__).'"><div class="rating-label">5</div></div></div>';
        $content .= '<div class="rating-box-cell last"><div class="rating-box"><a href="https://www.opinionsystem.fr/" target="_blank"><img class="rating-box-icon" src="'.plugins_url("/icon_com.png", __FILE__).'"><div class="rating-label">100</div></a></div></div></div></div>';
	return $content;
}

add_shortcode('opinion_system_note_avis', 'opinion_system_note_avis');

function opinion_system_note_avis_register_widget() {
register_widget( 'opinion_system_note_avis_widget' );
}

add_action( 'widgets_init', 'opinion_system_note_avis_register_widget' );

class opinion_system_note_avis_widget extends WP_Widget {

function __construct() {
parent::__construct(
// widget ID
'opinion_system_note_avis_widget',
// widget name
__('Opinion System note & avis Demo widget', 'opinion_system_note_avis_widget_domain'),
// widget description
array( 'description' => __( 'Opinion System note & avis Demo widget', 'opinion_system_note_avis_widget_domain' ), )
);
}
public function widget( $args, $instance ) {
$title = apply_filters( 'widget_title', $instance['title'] );
echo $args['before_widget'];
//if title is present
if ( ! empty( $title ) )
echo $args['before_title'] . esc_html($title) . $args['after_title'];
//output
echo wp_kses_post(opinion_system_note_avis());
echo $args['after_widget'];
}
public function form( $instance ) {
if ( isset( $instance[ 'title' ] ) )
$title = $instance[ 'title' ];
else
$title = __( '', 'opinion_system_note_avis_widget_domain' );
?>
<p>
<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php _e( 'Title:' ); ?></label>
<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>
<?php
}
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
return $instance;
}

}

?>