<?php
namespace Functions\Calendar;

use Carbon\Carbon;

class itre_list {

/*

I shamelessly stole most of this code from the base plugin Simple Calendar
But I figure it only works if that's installed anyway, and I would have just
used the functions they wrote but they were private so...

This is the messiest way to do this, but I don't know how else to. Hopefully
I'll clean this up later or move away from this plugin altogether.

*/

	public function __construct( $calendar = '' ) {
		$this->calendar = $calendar;
	}

	public function get_list_events($timestamp) {

		$calendar = $this->calendar;

		if ( ! $calendar->group_type || ! $calendar->group_span ) {
			return array();
		}

		$current = Carbon::createFromTimestamp( $timestamp, $calendar->timezone );
		$prev = clone $current;
		$next = clone $current;

		$this->start = $timestamp;

		$interval = $span = max( absint( $calendar->group_span ), 1 );

		if ( 'monthly' == $calendar->group_type ) {
			$this->prev = $prev->subMonths( $span )->getTimestamp();
			$this->next = $next->addMonths( $span )->getTimestamp();
		} elseif ( 'weekly' == $calendar->group_type ) {
			$week = new Carbon( $calendar->timezone );
			$week->setTimestamp( $timestamp );
			$week->setWeekStartsAt( $calendar->week_starts );
			$this->prev = $prev->subWeeks( $span )->getTimestamp();
			$this->next = $next->addWeeks( $span )->getTimestamp();
		} elseif ( 'daily' == $calendar->group_type ) {
			$this->prev = $prev->subDays( $span )->getTimestamp();
			$this->next = $next->addDays( $span )->getTimestamp();
		}

		$events = $calendar->events;
		$daily_events = $paged_events = $flattened_events = array();

		if ( 'events' != $calendar->group_type ) {

			$this->end   = $this->next - 1;

			$timestamps   = array_keys( $events );
			$lower_bound  = array_filter( $timestamps,  array( $this, 'filter_events_before' ) );
			$higher_bound = array_filter( $lower_bound, array( $this, 'filter_events_after'  ) );

			if ( is_array( $higher_bound ) && !empty( $higher_bound ) ) {
				$filtered = array_intersect_key( $events, array_combine( $higher_bound, $higher_bound ) );
				foreach ( $filtered as $timestamp => $events ) {
					$paged_events[ intval( $timestamp ) ] = $events;
				}
			}

		} else {

			foreach ( $events as $timestamp => $e ) {
				$second = 0;
				foreach ( $e as $event ) {
					$flattened_events[ intval( $timestamp + $second ) ][] = $event;
					$second++;
				}
			}

			ksort( $flattened_events, SORT_NUMERIC );

			$keys  = array_keys( $flattened_events );
			$current = 0;
			foreach ( $keys as $timestamp ) {
				if ( $timestamp < $this->start ) {
					$current++;
				}
			}

			$paged_events = array_slice( $flattened_events, $current, $interval, true );

			$events_end = isset( $keys[ $current + $interval ] ) ? $keys[ $current + $interval ] : $calendar->end;
			$this->end  = $events_end > $calendar->end ? $calendar->end : $events_end;

			$this->prev = isset( $keys[ $current - $interval ] ) ? $keys[ $current - $interval ] : $calendar->earliest_event;
			$this->next = isset( $keys[ $current + $interval ] ) ? $keys[ $current + $interval ] : $this->end;

		}

		foreach ( $paged_events as $timestamp => $events ) {

			if ( $timestamp <= $this->end ) {

				$dtz = new \DateTimeZone( $calendar->timezone );

				$date = \DateTime::createFromFormat( 'U', $timestamp );

				$offset = $dtz->getOffset( $date );
				$date_offset = clone $date;
				$date_offset->add( \DateInterval::createFromDateString( $offset . ' seconds' ) );

				$dateYmd = $date_offset->format( 'Ymd' );


		$daily_events[ intval( $dateYmd ) ][] = $events;
			}
		}

		ksort( $daily_events, SORT_NUMERIC );

		if ( ! empty( $paged_events ) ) {
			$first_event       = array_slice( $paged_events, 0, 1, true );
			$first_event       = array_pop( $first_event );
			$this->first_event = $first_event[0]->start;

			$last_event       = array_pop( $paged_events );
			$this->last_event = $last_event[0]->start;
		}

		return $daily_events;
	}

	public function sort_events($timestamp) {

		$current_events = $this->get_list_events( $timestamp );
		$calendar = $this->calendar;

    $list =  '<ul class="calendar-events">';

		foreach ( $current_events as $ymd => $events ) {

			$first_event = $events[0][0];

			if ( isset( $first_event->multiple_days ) && $first_event->multiple_days > 0 ) {

				if ( 'current_day_only' == get_post_meta( $calendar->id, '_default_calendar_expand_multi_day_events', true ) ) {

					$year  = substr( $ymd, 0, 4 );
					$month = substr( $ymd, 4, 2 );
					$day   = substr( $ymd, 6, 2 );

					$temp_date = Carbon::createFromDate( $year, $month, $day );

					if ( ! ( $temp_date < Carbon::now()->endOfDay() ) ) {

						// Break here only if event already shown once.
						if ( $last_event == $first_event ) {
							continue;
						} else {
							// Save event as "last" for next time through, then break.
							$last_event = $first_event;
						}
					}
				}
			}

			$day_date = Carbon::createFromFormat( 'Ymd', $ymd, $calendar->timezone );
			$day_date_offset = clone $day_date;
			$day_date_offset->addSeconds( $day_date->offset );
			$day_date_ts_offset = $day_date_offset->timestamp;


/* The Whole point of this, i.e. Reformatting the widget */



			foreach($events as $days) {

				foreach ($days as $event) {
					$start = Carbon::createFromFormat( 'U', $event->start );
					$end = Carbon::createFromFormat( 'U', $event->end );

					$list .= '<li class="event">';
						$list .= '<div class="event-date">';
							$list .= '<div class="date-month">';
								$list .= $start->format('M');
							$list .= '</div>';
							$list .= '<div class="date-days">';
								$list .= $start->format('j');
								if ($event->multiple_days) {
									$list .= '-'.$end->format('j');
								}
							$list .= '</div>';
						$list .= '</div>';

						$list .= '<div class="event-content">';
							$list .= '<h4 class="event-title">';
								$list .= $event->title;
							$list .= '</h4>';
							$list .= '<p class="event-time">';
								if ($event->whole_day) {
									$list .= 'Full Day';
								} else {
										$list .= $start->format('h:i a').'-'.$end->format('h:i a');
								}
							$list .= '</p>';
							$list .= '<p class="event-location">';
								$list .= $event->start_location['name'];
							$list .= '</p>';
							$list .= '<div class="event-description">';
								$list .= $event->description;
							$list .= '</div>';
							$list .= '<div class="event-calendar">';
								$list .= '<a href="'.get_permalink($calendar->id).'">';
								$list .= $event->source;
								$list .= '</a>';
							$list .= '</div>';
						$list .= '</div>';
					$list .= '</li>';
				}
			}
		}

    $list .= '</ul>';

    echo $list;
    
	}
}
?>
