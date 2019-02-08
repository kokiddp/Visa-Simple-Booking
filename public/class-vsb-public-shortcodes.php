<?php

/**
 * The shortcodes class for the public-facing functionality of the plugin.
 *
 * @link       www.visamultimedia.com
 * @since      1.0.0
 *
 * @package    Vsb
 * @subpackage Vsb/public
 */

/**
 * The helper class for the public-facing functionality of the plugin.
 *
 * @package    Vsb
 * @subpackage Vsb/public
 * @author     Gabriele Coquillard <gabriele.coquillard@gmail.com>
 */
class Vsb_Public_Shortcodes {

	/**
	 * Undocumented variable
	 *
	 * @var [type]
	 */
	private $options;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->options = get_option( 'vsb_options' );
		$this::add_shortocdes();
	}

	/**
	 * Undocumented function
	 *
	 * @since    1.0.0
	 */
	public function add_shortocdes() {

		add_shortcode( 'vsb_display_form', array( $this, 'vsb_display_form' ) );

	}

	/**
	 * Undocumented function
	 * 
	 * @since    1.0.0
	 *
	 * @param [type] $atts
	 * @return void
	 */
	public function vsb_display_form( $atts ){
		$atts = shortcode_atts(
            array(),
			$atts,
			'vsb_display_form'
		);

		ob_start();
		?>

		<div id="vsb" class="clearfix" ng-app="vsb" ng-controller="vsbController" ng-init="
			internal.url='<?= $this->options['url'] ?>';
			submit.hid=<?= $this->options['hid'] ?>;
			internal.minNights=<?= $this->options['min_nights'] ?>;
			internal.maxRooms=<?= $this->options['max_rooms'] ?>;
			internal.maxPeople=<?= $this->options['max_people'] ?>;
			internal.defaultAdults=<?= $this->options['default_adults'] ?>;
			internal.minAdultsFirstRoom=<?= $this->options['min_adults_first_room'] ?>;
			internal.minAdultsOtherRooms=<?= $this->options['min_adults_other_rooms'] ?>;
			internal.maxAgeChildren=<?= $this->options['max_age_children'] ?>;
		" ng-cloak ng-strict-di>

			<form name="vsbForm" novalidate>

				<div class="vsb_dates clearfix">
					<div class="vsb_date vsb_date_arrival clearfix">
						<label><?= __( 'Arrival date', 'visa-simple-booking' ) ?></label>
						<input name="arrivalDate" type="date" ng-model="form.arrivalDate" ng-min="{{internal.minArrivalDate}}" min="{{internal.minArrivalDate | date:'yyyy-MM-dd'}}" required>
						<label class="validation-error" ng-if="vsbForm.arrivalDate.$invalid"><?= __( 'Invalid date!', 'visa-simple-booking' ) ?></label>
					</div>
					<div class="vsb_date vsb_date_depart clearfix">
						<label><?= __( 'Departure date', 'visa-simple-booking' ) ?></label>
						<input name="departDate" type="date" ng-model="form.departDate" ng-min="{{internal.minDepartDate}}" min="{{internal.minDepartDate | date:'yyyy-MM-dd'}}" required>
						<label class="validation-error" ng-if="vsbForm.departDate.$invalid"><?= __( 'Invalid date!', 'visa-simple-booking' ) ?></label>
					</div>
				</div>

				<div class="vsb_rooms_controls clearfix">
					<label><?= __( 'Rooms', 'visa-simple-booking' ) ?></label>
					<input type="button" ng-click="removeRoom()" ng-disabled="form.rooms.length == 1" value="<?= __( '-', 'visa-simple-booking' ) ?>" />
					<input type="number" name="totalRooms" value="{{form.rooms.length}}" readonly/>
					<input type="button" ng-click="addRoom()" ng-disabled="form.rooms.length >= internal.maxRooms" value="<?= __( '+', 'visa-simple-booking' ) ?>" />					
				</div>

				<div class="vsb_rooms clearfix">
					<div ng-repeat="x in form.rooms" class="vsb_room clearfix">
						<div class="people clearfix">
							<label><?= __( 'Room ', 'visa-simple-booking' ) ?>{{x.id}}</label>
							<div class="adults clearfix">
								<label><?= __( 'Adults', 'visa-simple-booking' ) ?></label>
								<select ng-model="x.adulti" ng-options="n for n in [] | range:x.minAdulti:(x.maxAdulti - x.bambini)"></select>
							</div>
							<div class="children clearfix">
								<label><?= __( 'Children', 'visa-simple-booking' ) ?></label>
								<select ng-model="x.bambini" ng-options="n for n in [] | range:x.minBambini:(x.maxBambini - x.adulti)"></select>
							</div>
						</div>
						<div class="ages clearfix">
							<div class="age clearfix" ng-repeat="y in [] | range:1:(x.bambini)">
								<label><?= __( 'Child age ', 'visa-simple-booking' ) ?>{{y}}</label>
								<select ng-model="form.ages[x.id][y]" ng-options="n for n in [] | range:0:(internal.maxAgeChildren)" ng-init="form.ages[x.id][y]=0" ng-required="true"></select>
								<label class="validation-error" ng-if="!form.ages[x.id][y] && form.ages[x.id][y] !== 0"><?= __( 'Select child age', 'visa-simple-booking' ) ?></label>
							</div>
						</div>
					</div>
				</div>

				<div class="vsb_coupon clearfix">
					<label><?= __( 'Coupon', 'visa-simple-booking' ) ?>{{y}}</label>
					<input type="text" name="coupon" ng-model="submit.coupon" />
					<label class="validation-error" ng-if="vsbForm.$invalid"><?= __( 'There is at least one error in your request. Please correct check the form before submitting.', 'visa-simple-booking' ) ?></label>
				</div>

				<div class="vsb_submit clearfix">
					<input type="submit" ng-click="submitForm()" ng-disabled="vsbForm.$invalid" value="<?= __( 'Submit', 'visa-simple-booking' ) ?>" />
					<label class="validation-error" ng-if="vsbForm.$invalid"><?= __( 'There is at least one error in your request. Please correct check the form before submitting.', 'visa-simple-booking' ) ?></label>
				</div>
			</form>

		</div>		

		<?php
		return ob_get_clean();
	}
	
}
