<?php
/**
 * Meeting schedule: 1st and 3rd Tuesday of every month, 20:00–22:00,
 * Europe/Brussels.
 *
 * Computed server-side so the next date is present in the HTML for search
 * engines and for visitors without JavaScript.
 *
 * @package tmhasselt
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Club timezone. Deliberately explicit rather than the site setting, which is
 * stored as a fixed +01:00 offset and would therefore be an hour out all summer.
 *
 * @return DateTimeZone
 */
function tmh_timezone() {
	return new DateTimeZone( 'Europe/Brussels' );
}

/**
 * Upcoming meeting datetimes.
 *
 * @param int $count How many to return.
 * @return DateTimeImmutable[]
 */
function tmh_upcoming_meetings( $count = 6 ) {
	$tz  = tmh_timezone();
	$now = new DateTimeImmutable( 'now', $tz );
	$out = array();

	for ( $offset = 0; count( $out ) < $count && $offset < 24; $offset++ ) {
		$month = $now->modify( 'first day of +' . $offset . ' month' )->setTime( 0, 0 );

		foreach ( array( 'first tuesday of', 'third tuesday of' ) as $rule ) {
			$candidate = new DateTimeImmutable(
				$rule . ' ' . $month->format( 'F Y' ),
				$tz
			);
			$candidate = $candidate->setTime( 20, 0 );

			if ( $candidate > $now ) {
				$out[] = $candidate;
			}
		}
	}

	usort(
		$out,
		function ( $a, $b ) {
			return $a <=> $b;
		}
	);

	return array_slice( $out, 0, $count );
}

/**
 * The next meeting.
 *
 * @return DateTimeImmutable|null
 */
function tmh_next_meeting() {
	$list = tmh_upcoming_meetings( 1 );
	return empty( $list ) ? null : $list[0];
}

/**
 * Dutch long date, e.g. "dinsdag 1 september".
 *
 * Hand-rolled rather than strftime(), which is deprecated and depends on a
 * nl_BE locale being installed on the server.
 *
 * @param DateTimeInterface $dt        Date.
 * @param bool              $with_year Append the year.
 * @return string
 */
function tmh_dutch_date( $dt, $with_year = false ) {
	$days = array(
		'Mon' => 'maandag',
		'Tue' => 'dinsdag',
		'Wed' => 'woensdag',
		'Thu' => 'donderdag',
		'Fri' => 'vrijdag',
		'Sat' => 'zaterdag',
		'Sun' => 'zondag',
	);

	$months = array(
		1  => 'januari',
		2  => 'februari',
		3  => 'maart',
		4  => 'april',
		5  => 'mei',
		6  => 'juni',
		7  => 'juli',
		8  => 'augustus',
		9  => 'september',
		10 => 'oktober',
		11 => 'november',
		12 => 'december',
	);

	$out = $days[ $dt->format( 'D' ) ] . ' ' . (int) $dt->format( 'j' )
		. ' ' . $months[ (int) $dt->format( 'n' ) ];

	if ( $with_year ) {
		$out .= ' ' . $dt->format( 'Y' );
	}

	return $out;
}

/**
 * "vanavond" / "morgenavond" / "over 12 dagen".
 *
 * @param DateTimeInterface $dt Date.
 * @return string
 */
function tmh_relative_date( $dt ) {
	$tz    = tmh_timezone();
	$today = new DateTimeImmutable( 'today', $tz );
	$that  = new DateTimeImmutable( $dt->format( 'Y-m-d' ), $tz );
	$days  = (int) $today->diff( $that )->format( '%r%a' );

	if ( 0 === $days ) {
		return 'vanavond';
	}
	if ( 1 === $days ) {
		return 'morgenavond';
	}

	/* translators: %d: number of days. */
	return sprintf( 'over %d dagen', $days );
}
