<?php

namespace Automattic\VIP\Search;

require_once __DIR__ . '/class-versioningcleanupjob.php';

class FieldCountGaugeJob {
	public function init() {
		// We always add this action so that the job can unregister itself if it no longer should be running
		add_action( VersioningCleanupJob::CRON_EVENT_NAME, [ $this, 'maybe_alert_for_field_count' ] );
	}

	/**
	 * Set the field count gauge for posts for the current site
	 */
	public function maybe_alert_for_field_count() {
		Search::instance()->maybe_alert_for_field_count();
	}
}
