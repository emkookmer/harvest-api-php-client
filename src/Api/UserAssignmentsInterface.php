<?php

namespace Required\Harvest\Api;

use DateTime;

/**
 * API client for user assignments endpoint.
 *
 * @link https://help.getharvest.com/api-v2/projects-api/projects/user-assignments/
 */
interface UserAssignmentsInterface {

	/**
	 * Retrieves a list of user assignments.
	 *
	 * @param array $parameters {
	 *     Optional. Parameters for filtering the list of user assignments. Default empty array.
	 *
	 * 		@type bool $is_active                Pass `true` to only return active user assignments and `false` to
	 *                                           return  inactive user assignments.
	 * 		@type DateTime|string $updated_since Only return user assignments that have been updated since the given
	 *                                           date and time.
	 * }
	 * @return array
	 */
	public function all( array $parameters = []);
}
