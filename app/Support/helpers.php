<?php
/***************************************************************************
 *                               helper.php
 *                            -------------------
 *   begin                : Jan 03, 2019
 *   copyright            : (C) 2019 Paden Clayton
 *   email                : me@padenclayton.com
 *
 *
 ***************************************************************************/


if ( ! function_exists( 'filterNameForPublic' ) ) {
	/**
	 * Converts a name to a version where the last name is trimmed to a single character.
	 *
	 * @param  string $name Full name
	 *
	 * @return string
	 */
	function filterNameForPublic( $name ) {
		$nameParts              = explode( ' ', $name );
		$lastPart               = count( $nameParts ) - 1;
		$nameParts[ $lastPart ] = substr( $nameParts[ $lastPart ], 0, 1 ) . '.';

		return implode( ' ', $nameParts );
	}
}