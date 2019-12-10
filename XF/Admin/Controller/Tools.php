<?php namespace Hampel\TimeZoneDebug\XF\Admin\Controller;

class Tools extends XFCP_Tools
{
	public function actionTimeZoneDebug()
	{
		$this->setSectionContext('timeZoneDebug');

		$timestamp = \XF::$time;

		$dateTimeUTC = new \DateTime();
		$dateTimeUTC->setTimestamp($timestamp);
		$dateTimeUTC->setTimezone(new \DateTimeZone('UTC'));

		/** @var \XF\Data\TimeZone $tzData */
		$tzData = \XF::app()->data('XF:TimeZone');
		$tzOptions = $tzData->getTimeZoneOptions();

		$visitor = \XF::visitor();
		$vtz = $visitor->timezone;
		$visitorTimeZone = \XF::phrase('timezonedebug_timezone_display',
		                             [
		                                'tz' => $vtz,
		                                'desc' => $tzOptions[$vtz]
		                             ]);

		$gtz = \XF::options()->guestTimeZone;
		$guestTimeZone = \XF::phrase('timezonedebug_timezone_display',
		                             [
		                                'tz' => $gtz,
		                                'desc' => $tzOptions[$gtz]
		                             ]);

		$guestTime = new \DateTime();
		$guestTime->setTimestamp($timestamp);
		$guestTime->setTimezone(new \DateTimeZone($gtz));

		$viewParams = compact('timestamp', 'dateTimeUTC', 'visitorTimeZone', 'guestTime', 'guestTimeZone');
		return $this->view('XF:Tools\TimeZoneDebug', 'tools_time_zone_debug', $viewParams);
	}
}