<?php

/**
 *
 * @link       www.visamultimedia.com
 * @since      1.0.0
 *
 * @package    Vsb
 * @subpackage Vsb/admin
 */


/**
 * The helper class for the public-facing functionality of the plugin.
 *
 * @package    Vsb
 * @subpackage Vsb/public
 * @author     Gabriele Coquillard <gabriele.coquillard@gmail.com>
 */
class Vsb_Admin_Options {

	/**
	 * Helper class
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      array    $options
	 */
	public $options;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		$this->options = get_option( 'vsb_options' );
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function vsb_add_options_page() {
		add_options_page( __('Visa Simple Booking', 'visa-simple-booking'), __('Visa Simple Booking', 'visa-simple-booking'), 'manage_options', 'vsb', array( $this, 'vsb_options_page' ) );
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function vsb_options_page() {
		include_once 'partials/vsb-admin-display.php';
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function vsb_init_options() {
		register_setting( 'vsb_options', 'vsb_options', array( $this, 'vsb_options_validate' ) );
		
		add_settings_section( 'vsb_main', __('Main Settings', 'visa-simple-booking'), array( $this, 'vsb_main_section_text' ), 'vsb' );
		add_settings_field( 'vsb_url', __('URL base', 'visa-simple-booking'), array( $this, 'vsb_setting_url'), 'vsb', 'vsb_main' );
		add_settings_field( 'vsb_id_albergo', __('ID Albergo', 'visa-simple-booking'), array( $this, 'vsb_setting_id_albergo'), 'vsb', 'vsb_main' );
		add_settings_field( 'vsb_id_stile', __('ID Stile', 'visa-simple-booking'), array( $this, 'vsb_setting_id_stile'), 'vsb', 'vsb_main' );
		add_settings_field( 'vsb_dc', __('DC', 'visa-simple-booking'), array( $this, 'vsb_setting_dc'), 'vsb', 'vsb_main' );

		add_settings_section( 'vsb_config', __('Configuration Settings', 'visa-simple-booking'), array( $this, 'vsb_config_section_text' ), 'vsb' );
		add_settings_field( 'vsb_min_nights', __('Minimum nights stay', 'visa-simple-booking'), array( $this, 'vsb_setting_min_nights'), 'vsb', 'vsb_config' );
		add_settings_field( 'vsb_max_rooms', __('Maximum bookable rooms', 'visa-simple-booking'), array( $this, 'vsb_setting_max_rooms'), 'vsb', 'vsb_config' );
		add_settings_field( 'vsb_max_people', __('Maximum people per room', 'visa-simple-booking'), array( $this, 'vsb_setting_max_people'), 'vsb', 'vsb_config' );
		add_settings_field( 'vsb_default_adults', __('Default adults per room', 'visa-simple-booking'), array( $this, 'vsb_setting_default_adults'), 'vsb', 'vsb_config' );
		add_settings_field( 'vsb_min_adults_first_room', __('Minimum adults in first room', 'visa-simple-booking'), array( $this, 'vsb_setting_min_adults_first_room'), 'vsb', 'vsb_config' );
		add_settings_field( 'vsb_min_adults_other_rooms', __('Minimum adults in other rooms', 'visa-simple-booking'), array( $this, 'vsb_setting_min_adults_other_rooms'), 'vsb', 'vsb_config' );
		add_settings_field( 'vsb_max_age_children', __('Maximum age for children', 'visa-simple-booking'), array( $this, 'vsb_setting_max_age_children'), 'vsb', 'vsb_config' );
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	function vsb_main_section_text() {
		echo '<p>' . __('Theese are the general settings', 'visa-simple-booking') . '</p>';
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function vsb_setting_url() {
		echo "<input type='text' style='width:100%' id='vsb_url' name='vsb_options[url]' value='{$this->options['url']}' />";
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function vsb_setting_id_albergo() {
		echo "<input type='text' id='vsb_id_albergo' name='vsb_options[id_albergo]' value='{$this->options['id_albergo']}' />";
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function vsb_setting_id_stile() {
		echo "<input type='text' id='vsb_id_stile' name='vsb_options[id_stile]' value='{$this->options['id_stile']}' />";
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function vsb_setting_dc() {
		echo "<input type='text' id='vsb_dc' name='vsb_options[dc]' value='{$this->options['dc']}' />";
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	function vsb_config_section_text() {
		echo '<p>' . __('Theese are the configuration settings', 'visa-simple-booking') . '</p>';
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function vsb_setting_min_nights() {
		echo "<input type='number' step='1' min='1' id='vsb_min_nights' name='vsb_options[min_nights]' value='{$this->options['min_nights']}' />";
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function vsb_setting_max_rooms() {
		echo "<input type='number' step='1' min='1' id='vsb_max_rooms' name='vsb_options[max_rooms]' value='{$this->options['max_rooms']}' />";
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function vsb_setting_max_people() {
		echo "<input type='number' step='1' min='1' id='vsb_max_people' name='vsb_options[max_people]' value='{$this->options['max_people']}' />";
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function vsb_setting_default_adults() {
		echo "<input type='number' step='1' min='1' id='vsb_default_adults' name='vsb_options[default_adults]' value='{$this->options['default_adults']}' />";
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function vsb_setting_min_adults_first_room() {
		echo "<input type='number' step='1' min='1' id='vsb_min_adults_first_room' name='vsb_options[min_adults_first_room]' value='{$this->options['min_adults_first_room']}' />";
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function vsb_setting_min_adults_other_rooms() {
		echo "<input type='number' step='1' min='1' id='vsb_min_adults_other_rooms' name='vsb_options[min_adults_other_rooms]' value='{$this->options['min_adults_other_rooms']}' />";
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function vsb_setting_max_age_children() {
		echo "<input type='number' step='1' min='1' max='17' id='vsb_max_age_children' name='vsb_options[max_age_children]' value='{$this->options['max_age_children']}' />";
	}

	/**
	 * Undocumented function
	 *
	 * @param mixed $input
	 * @return mixed
	 */
	public function vsb_options_validate( $input ) {
		
		return $input;
	}
}
