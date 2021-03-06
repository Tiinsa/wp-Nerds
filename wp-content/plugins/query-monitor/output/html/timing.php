<?php
/**
 * Timing and profiling output for HTML pages.
 *
 * @package query-monitor
 */

class QM_Output_Html_Timing extends QM_Output_Html {

	public function __construct( QM_Collector $collector ) {
		parent::__construct( $collector );
		add_filter( 'qm/output/menus', array( $this, 'admin_menu' ), 15 );
	}

	public function output() {

		$data = $this->collector->get_data();

		if ( empty( $data['timing'] ) && empty( $data['warning'] ) ) {
			return;
		}

		echo '<div class="qm" id="' . esc_attr( $this->collector->id() ) . '">';
		echo '<table>';

		echo '<caption class="screen-reader-text">' . esc_html__( 'Function Timing', 'query-monitor' ) . '</caption>';

		echo '<thead>';
		echo '<tr>';
		echo '<th scope="col">' . esc_html__( 'Tracked Function', 'query-monitor' ) . '</th>';
		echo '<th scope="col" class="qm-num">' . esc_html__( 'Time', 'query-monitor' ) . '</th>';
		echo '<th scope="col" class="qm-num">' . esc_html__( 'Memory', 'query-monitor' ) . '</th>';
		echo '<th scope="col">' . esc_html__( 'Component', 'query-monitor' ) . '</th>';
		echo '</tr>';
		echo '</thead>';

		echo '<tbody>';
		if ( ! empty( $data['timing'] ) ) {
			foreach ( $data['timing'] as $row ) {

				$component = $row['trace']->get_component();
				$trace     = $row['trace']->get_filtered_trace();
				$file      = self::output_filename( $row['function'], $trace[0]['file'], $trace[0]['line'] );

				echo '<tr>';

				if ( self::has_clickable_links() ) {
					echo '<td class="qm-ltr">';
					echo $file; // WPCS: XSS ok.
					echo '</td>';
				} else {
					echo '<td class="qm-ltr qm-has-toggle"><ol class="qm-toggler">';
					echo self::build_toggler(); // WPCS: XSS ok;
					echo '<li>';
					echo $file; // WPCS: XSS ok.
					echo '</li>';
					echo '</ol></td>';
				}

				printf(
					'<td class="qm-num">%s</td>',
					esc_html( number_format_i18n( $row['function_time'] * 1000, 4 ) )
				);

				$mem = sprintf(
					/* translators: %s: Approximate memory used in kilobytes */
					__( '~%s kB', 'query-monitor' ),
					number_format_i18n( $row['function_memory'] / 1024 )
				);
				printf(
					'<td class="qm-num">%s</td>',
					esc_html( $mem )
				);
				printf(
					'<td class="qm-nowrap">%s</td>',
					esc_html( $component->name )
				);

				echo '</tr>';

			}
		}
		if ( ! empty( $data['warning'] ) ) {
			foreach ( $data['warning'] as $row ) {
				$component = $row['trace']->get_component();
				$trace     = $row['trace']->get_filtered_trace();
				$file      = self::output_filename( $row['function'], $trace[0]['file'], $trace[0]['line'] );

				echo '<tr class="qm-warn">';
				if ( self::has_clickable_links() ) {
					echo '<td class="qm-ltr">';
					echo $file; // WPCS: XSS ok.
					echo '</td>';
				} else {
					echo '<td class="qm-ltr qm-has-toggle"><ol class="qm-toggler">';
					echo self::build_toggler(); // WPCS: XSS ok;
					echo '<li>';
					echo $file; // WPCS: XSS ok.
					echo '</li>';
					echo '</ol></td>';
				}

				printf(
					'<td colspan="2">%s</td>',
					esc_html( $row['message'] )
				);

				printf(
					'<td class="qm-nowrap">%s</td>',
					esc_html( $component->name )
				);
			}
		}

		echo '</tbody>';
		echo '</table>';
		echo '</div>';

	}

	public function admin_menu( array $menu ) {
		$data = $this->collector->get_data();

		if ( ! empty( $data['timing'] ) || ! empty( $data['warning'] ) ) {
			$count = 0;
			if ( ! empty( $data['timing'] ) ) {
				$count += count( $data['timing'] );
			}
			if ( ! empty( $data['warning'] ) ) {
				$count += count( $data['warning'] );
			}
			/* translators: %s: Number of function timing results that are available */
			$label = _n( 'Timings (%s)', 'Timings (%s)', $count, 'query-monitor' );
			$menu[] = $this->menu( array(
				'title' => esc_html( sprintf(
					$label,
					number_format_i18n( $count )
				) ),
			) );
		}

		return $menu;
	}

}

function register_qm_output_html_timing( array $output, QM_Collectors $collectors ) {
	if ( $collector = QM_Collectors::get( 'timing' ) ) {
		$output['timing'] = new QM_Output_Html_Timing( $collector );
	}
	return $output;
}

add_filter( 'qm/outputter/html', 'register_qm_output_html_timing', 15, 2 );
