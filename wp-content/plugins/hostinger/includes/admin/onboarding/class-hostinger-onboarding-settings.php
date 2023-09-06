<?php

defined( 'ABSPATH' ) || exit;

class Hostinger_Onboarding_Settings {
	public static function all_steps_completed(): bool {
		$actions               = Hostinger_Admin_Actions::ACTIONS_LIST;
		$total_steps           = count( $actions );
		$completed_steps       = get_option( 'hostinger_onboarding_steps', [] );
		$completed_steps_count = count( array_intersect( $completed_steps, $actions ) );

		return $completed_steps_count === $total_steps;
	}
}

new Hostinger_Onboarding_Settings();
