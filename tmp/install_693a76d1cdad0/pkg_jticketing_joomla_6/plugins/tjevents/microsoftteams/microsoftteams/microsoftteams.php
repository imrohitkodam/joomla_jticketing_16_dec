<?php
/**
 * @package     JTicketing
 * @subpackage  com_jticketing
 *
 * @author      Techjoomla <extensions@techjoomla.com>
 * @copyright   Copyright (C) 2009 - 2025 Techjoomla. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;
use Joomla\Registry\Registry;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Http\Http;
use Joomla\CMS\Http\Response;
use Joomla\CMS\Log\Log;
use Joomla\CMS\Log\LogEntry;
use Joomla\CMS\Log\Logger\FormattedtextLogger;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Uri\Uri;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;
use GuzzleHttp\Client;
use Joomla\CMS\Object\CMSObject;

require JPATH_PLUGINS . '/tjevents/microsoftteams/vendor/autoload.php';

/**
 * JTicketing event class for microsoftteams meetings.
 *
 * @since  3.0.0
 */
class JTicketingEventMicrosoftteams extends JTicketingEventJticketing implements JticketingEventOnline
{
	/**
	 * Tenant ID of the microsoftteams user/app
	 *
	 * @var    Http
	 * @since  3.0.0
	 */
	private $tenantId;

	/**
	 * Client ID for microsoftteams app
	 *
	 * @var    string
	 * @since  3.0.0
	 */
	private $clientId;

	/**
	 * Client secrete for microsoftteams app
	 *
	 * @var    string
	 * @since  3.0.0
	 */
	private $clientSecret;

	/**
	 * User ID / Object ID of microsoftteams user
	 *
	 * @var    string
	 * @since  3.0.0
	 */
	private $objectId;

	/**
	 * Access token for graph client
	 *
	 * @var    string
	 * @since  3.0.0
	 */
	private $accessToken;

	/**
	 * Plugin params for tjevents microsoftteams
	 *
	 * @var    object
	 * @since  3.0.0
	 */
	public $params;

	/**
	 * Online meeting join URL
	 *
	 * @var    string
	 * @since  3.0.0
	 */
	private $joinUrl;

	/**
	 * Online meeting ID
	 *
	 * @var    string
	 * @since  3.0.0
	 */
	private $meetingId;

	/**
	 * The graph client instance to access microsoftteams apis
	 *
	 * @var    Http
	 * @since  3.0.0
	 */
	private $graph = null;

	/**
	 * The guzzle client to make http requests
	 *
	 * @var    Http
	 * @since  3.0.0
	 */
	private $guzzle = null;

	/**
	 * Constructor activating the default information of the event
	 *
	 * @param   JTicketingEventJticketing  $event  The event object
	 * @param   JTicketingVenue            $venue  The venue object
	 *
	 * @since   3.0.0
	 */
	public function __construct(JTicketingEventJticketing $event, JTicketingVenue $venue = null) // 1
	{
		parent::__construct($event->id);

		// Initialise the graph client and guzzle client
		$this->graph  = new Graph();
		$this->guzzle = new \GuzzleHttp\Client;

		// Get the venue details
		$venueObj = JT::venue($event->venue);
		$venueObj = empty($venueObj->id) && !is_null($venue) ? $venue : $venueObj;

		// Get the venue params to get client credentials for MSTeams
		$params             = new Registry($venueObj->getParams());
		$this->tenantId     = $params->get('tenantId', '');
		$this->clientId     = $params->get('clientId', '');
		$this->clientSecret = $params->get('clientSecret', '');
		$this->objectId     = $params->get('objectId', '');

		// Fetch the access token
		if (empty($this->accessToken))
		{
			$this->setAccessToken();
		}

		$this->loadMeetingIdAndUrl($this->id);
	}

	/**
	 * Set access token
	 *
	 * @return  Boolean  True on success
	 *
	 * @since   3.0.0
	 */
	private function setAccessToken()
	{
		$requestBody = [
			'form_params' => [
				'client_id'     => $this->clientId,
				'client_secret' => $this->clientSecret,
				'scope'         => 'https://graph.microsoft.com/.default',
				'grant_type'    => 'client_credentials',
			],
		];
		$url = Uri::getInstance('https://login.microsoftonline.com/' . $this->tenantId . '/oauth2/v2.0/token');
		$log = $this->getLogResponseObject('POST', $url->toString());

		try
		{
			$response          = $this->guzzle->post($url->toString(), $requestBody);
			$responseBody      = json_decode($response->getBody()->getContents());
			$this->accessToken = $responseBody->access_token;

			$this->graph->setAccessToken($this->accessToken);

			$log->body = $responseBody;
			$log->code = $response->getStatusCode();

			// $this->logResponse($log);

			return true;
		}
		catch (Exception $e)
		{
			$log->message = $e->getMessage();
			$log->code    = $e->getCode();

			$this->logResponse($log, true);

			return false;
		}
	}

	/**
	 * Create a graph client request for specified object
	 *
	 * @param   string  $endpoint   Endpoint url
	 * @param   string  $type  Type of request GET/POST/PUT/PATCH/DELETE
	 * @param   array   $body  Request body
	 * @param   object   $returnType  Fully qualified name of a class
	 *
	 * @return  array  Returns an array with sucess, message and result keys
	 *
	 * @since   3.0.0
	 */
	private function createGraphRequest($endpoint, $type, $body, $returnType, $headers= [])
	{
		$url = Uri::getInstance($endpoint)->toString();
		$log = $this->getLogResponseObject($type, $url);

		try
		{
			$request = $this->graph
					->createRequest($type, $url)
					->setReturnType($returnType);

			if (!empty($headers)) {
				$request->addHeaders($headers);
			}

			if (in_array($type, ['POST', 'PUT', 'PATCH']))
			{
				$request->attachBody($body);
			}

			$result = $request->execute();

			$log->body = $result;

			$this->logResponse($log);

			return ['success' => true, 'message' => null, 'result' => $result];
		}
		catch (Exception $e)
		{
			$log->message = $e->getMessage();
			$log->code    = $e->getCode();

			$this->logResponse($log, true);

			return ['success' => false, 'message' => $e->getMessage(), 'result' => null];
		}
	}

	/**
	 * Create a graph client request for specified collection
	 *
	 * @param   string  $endpoint    Endpoint url
	 * @param   object  $returnType  Fully qualified name of a class
	 * @param   int     $pageSize    Page size default is 999 (Max Value by Graph client)
	 *
	 * @return  array  Returns an array with sucess, message and result keys
	 *
	 * @since   3.0.0
	 */
	private function createGraphCollectionRequest($endpoint, $returnType, $pageSize = 999)
	{
		$url = Uri::getInstance($endpoint)->toString();
		$log = $this->getLogResponseObject('GET', $url);

		try
		{
			$result = $this->graph
				->createCollectionRequest("GET", $url)
				->setReturnType($returnType)
				->setPageSize($pageSize)
				->getPage();

			$log->body = $result;
			$this->logResponse($log);

			return ['success' => true, 'message' => null, 'result' => $result];
		}
		catch (Exception $e)
		{
			$log->message = $e->getMessage();
			$log->code    = $e->getCode();

			$this->logResponse($log, true);

			return ['success' => false, 'message' => $e->getMessage(), 'result' => null];
		}
	}

	/**
	 * Load the meeting related info from event params using event ID
	 *
	 * @param   string    $eventId   Event ID
	 *
	 * @return  void
	 *
	 * @since   3.0.0
	 */
	public function loadMeetingIdAndUrl($eventId)
	{
		$params                 = new Registry($this->params);
		$this->meetingId        = $params->get('microsoftteams.meeting_id', '');
		$this->joinUrl          = $params->get('microsoftteams.join_url', '');
	}

	/**
	 * Method to log the HTTP response
	 *
	 * @param   array    $data   Data array to log the response
	 * @param   boolean  $error  Flag to indicate that this is an error
	 *
	 * @return  boolean  True on success
	 *
	 * @since   3.0.0
	 */
	private function logResponse($data, $error = false)
	{
		static $logApiResponse = null;
		static $logBody        = '';

		if (is_null($logApiResponse))
		{
			$params         = $this->getPluginParams();
			$logApiResponse = $params->get('debug_integration', 1);
			$logBody        = $params->get('log_response', 0);
		}

		if (empty($logApiResponse))
		{
			return true;
		}

		$data->body = empty($logBody) ? '' : $data->body;
		$priority   = $error ? Log::ERROR : Log::INFO;
		$format     = '{DATETIME} | {PRIORITY} | {CLIENTIP} | {EVENTID} | {METHOD} | {URL} | {CODE} | {MESSAGE}';
		$message    = json_encode($data->body) . " | " . $data->eventId . " | " . $data->method . " | " . $data->url . " | " . $data->code . " | " . $data->message;
		$options    = array("text_file" => "microsoftteams_event_debug.log", "text_file_no_php" => true, 'text_entry_format' => $format);

		$formatLogger   = new FormattedtextLogger($options);
		$entry          = new LogEntry($message, $priority);

		$formatLogger->addEntry($entry);

		return true;
	}

	/**
	 * Get tjevents microsoftteams plugin params
	 *
	 * @return  Object  Returns plugin params
	 *
	 * @since   3.0.0
	 */
	private function getPluginParams()
	{
		PluginHelper::importPlugin('tjevents', 'microsoftteams');
		$plugin = PluginHelper::getPlugin('tjevents', 'microsoftteams');
		$params = new Registry($plugin->params);

		return $params;
	}

	/**
	 * Get log response object
	 *
	 * @param   String  $method   HTTP method name of api
	 * @param   String  $url      URL of an api
	 * @param   String  $message  Error message
	 * @param   Number  $code     Error code or Response code received from api
	 * @param   String  $body     Response body received from api
	 *
	 * @return  Object  Eeturns object
	 *
	 * @since   3.0.0
	 */
	private function getLogResponseObject($method = '', $url = '', $code = 0, $message = '', $body = '')
	{
		$log = new stdClass;

		$log->method  = $method;
		$log->url     = $url;
		$log->message = $message;
		$log->code    = $code;
		$log->body    = $body;

		$log->eventId = $this->id;

		return $log;
	}

	/**
	 * Validate credentials by checking if the user exists with given ID
	 *
	 * @return  Boolean  True on success
	 *
	 * @since   3.0.0
	 */
	public function isValidCredentials()
	{
		$user = $this->createGraphRequest(
			'/users/' . $this->objectId,
			'GET',
			null,
			Model\User::class
		);

		return $user['success'];
	}

	/**
	 * Return the online meeting object
	 * https://docs.microsoft.com/en-us/graph/api/onlinemeeting-get?view=graph-rest-1.0&tabs=http
	 *
	 * @return  Object  Online meeting object
	 *
	 * @since   3.0.0
	 */
	private function getMeeting()
	{
		$meeting = $this->createGraphRequest(
			'/users/' . $this->objectId . '/onlineMeetings/' . $this->meetingId,
			'GET',
			null,
			Model\OnlineMeeting::class
		);

		return $meeting['result'];
	}

	/**
	 * Creates and returns the online meeting object
	 * https://docs.microsoft.com/en-us/graph/api/application-post-onlinemeetings?view=graph-rest-1.0&tabs=http
	 *
	 * @param   Object  $eventData   Event details
	 *
	 * @return  Object  Online meeting object
	 *
	 * @since   3.0.0
	 */
	private function createMeeting($eventData)
	{
		$params   = $this->getPluginParams();
		$body = array(
			'subject'             => $eventData['title'],
			'startDateTime'       => Factory::getDate($eventData['startdate'], 'UTC')->format('Y-m-d\TH:i:s.u+05:30'),
			'endDateTime'         => Factory::getDate($eventData['enddate'], 'UTC')->format('Y-m-d\TH:i:s.u+05:30'),
			'recordAutomatically' => (bool) $params->get('enable_automatic_recording', 1),
		);

		$lobbyBypassScope = (string) $params->get('lobby_bypass_scope', 'none');

		if ($lobbyBypassScope !== 'none')
		{
			$body['lobbyBypassSettings'] = [
				'scope' => $lobbyBypassScope,
				'isDialInBypassEnabled' => true
			];
		}

		$meeting = $this->createGraphRequest(
			'/users/' . $this->objectId . '/onlineMeetings/',
			'POST',
			$body,
			Model\OnlineMeeting::class,
			['Prefer' => 'include-unknown-enum-members']
		);

		return $meeting['result'];
	}

	/**
	 * Updates and returns the online meeting object
	 * https://docs.microsoft.com/en-us/graph/api/onlinemeeting-update?view=graph-rest-1.0&tabs=http
	 *
	 * @param   Object  $eventData   Event details
	 *
	 * @return  Object  Online meeting object
	 *
	 * @since   3.0.0
	 */
	private function updateMeeting($eventData)
	{
		$params = $this->getPluginParams();

		$body = array(
			'subject'             => $eventData['title'],
			'startDateTime'       => Factory::getDate($eventData['startdate'], 'UTC')->format('Y-m-d\TH:i:s.u+05:30'),
			'endDateTime'         => Factory::getDate($eventData['enddate'], 'UTC')->format('Y-m-d\TH:i:s.u+05:30'),
		);

		$meeting = $this->createGraphRequest(
			'/users/' . $this->objectId . '/onlineMeetings/' . $this->meetingId,
			'PATCH',
			$body,
			Model\OnlineMeeting::class
		);

		return $meeting['result'];
	}

	/**
	 * Method to save the Event object to the database
	 *
	 * @param   array  $data  The event data to be bind with the object
	 *
	 * @return  boolean  True on success
	 *
	 * @since   3.0.0
	 */
	public function save($data)
	{
		$meeting = $data['venuechoice'] === 'existing' ? $this->updateMeeting($data) : $this->createMeeting($data);

		$this->updateParams($meeting, $data);

		return true;
	}

	/**
	 * This method prepare the params data to be stored against the event
	 *
	 * @param   object  $meeting        Online meeting object
	 * @param   array   $eventData      Event Data
	 *
	 * @return  boolean  True on success
	 *
	 * @since   3.0.0
	 */
	private function updateParams($meeting, $eventData)
	{
		$oldParams = isset($eventData['params']) ? $eventData['params'] : array();

		$newParams = array(
			'meeting_id' => $meeting->getId(),
			'host_id'    => $this->objectId,
			'start_time' => $eventData['startdate'],
			'join_url'   => Uri::getInstance($meeting->getJoinWebUrl())->toString()
		);

		if (is_string($oldParams))
		{
			if (json_decode($oldParams))
			{
				$oldParams = json_decode($oldParams);
			}
		}

		if (is_array($oldParams))
		{
			$oldParams['microsoftteams'] = $newParams;
		}

		if (is_object($oldParams))
		{
			$oldParams->microsoftteams = $newParams;
		}

		$this->params = json_encode($oldParams);

		return true;
	}

	/**
	 * Method to get Meeting attendance
	 * https://docs.microsoft.com/en-us/graph/api/resources/meetingattendancereport?view=graph-rest-1.0
	 *
	 * @return  boolean|array  False on failure and return attendee array on success
	 *
	 * @since   3.0.0
	 */
	public function getAttendance()
	{
		$this->setAccessToken();

		$meetings = $this->createGraphCollectionRequest(
			'/users/' . $this->objectId . '/onlineMeetings/' . $this->meetingId . '/attendanceReports',
			Model\MeetingAttendanceReport::class
		);

		if (!$meetings['success']) {
			return false;
		}

		$meeting = $meetings['result'][0];

		$participants = $this->createGraphCollectionRequest(
			'/users/' . $this->objectId . '/onlineMeetings/' . $this->meetingId . '/attendanceReports/' . $meeting->getId() . '/attendanceRecords',
			Model\AttendanceRecord::class,
			$meeting->getTotalParticipantCount()
		);

		if (!$participants['success']) {
			return false;
		}

		$participants = json_decode(json_encode($participants['result']), true);
		$attendees = array();

		foreach ($participants as $participant)
		{
			// Exclude the organiser
			if ($participant['role'] === 'Organizer') {
				continue;
			}

			$attendee = JT::table('attendees');
			$attendee->load(array('owner_email' => $participant['emailAddress'], 'event_id' => $this->integrationId));
			$attendeeId = $attendee->id;

			// If attendee is not present
			if (!$attendeeId)
			{
				continue;
			}

			$firstConnect = $participant['attendanceIntervals'][0];
			$startDate    = Factory::getDate($firstConnect['joinDateTime'])->toSql();
			$endDate      = Factory::getDate($firstConnect['leaveDateTime'])->toSql();

			$attendees[$attendeeId]['email']        = $participant['emailAddress'];
			$attendees[$attendeeId]['checkin']      = $startDate;
			$attendees[$attendeeId]['checkout']     = $endDate;
			$attendees[$attendeeId]['registrantId'] = $participant['id'];
			$attendees[$attendeeId]['spentTime']    = $firstConnect['durationInSeconds'];
		}

		return $attendees;
	}

	/**
	 * Return the event join url for participant
	 *
	 * @param   JTicketingAttendee  $attendee  Attendee Object
	 *
	 * @return  string  The join URL required to attend event
	 *
	 * @since   3.0.0
	 */
	public function getJoinUrl(JTicketingAttendee $attendee)
	{
		return $this->joinUrl;
	}

	/**
	 * Method to get the list of all the event
	 *
	 * @param   array  $query  filters used to retrieve meetings
	 *
	 * @return  array  List of events
	 *
	 * @since   3.0.0
	 */
	public function list(array $query = [])
	{
		return array();
	}

	/**
	 * Method to add registrant against event
	 *
	 * @param   JTicketingAttendee  $attendee  Attendee Object
	 * @param   array               $data      Registrant data
	 *
	 * @return  boolean  True on success
	 *
	 * @since   3.0.0
	 */
	public function addAttendee(JTicketingAttendee $attendee, $data = [])
	{
		return true;
	}

	/**
	 * Method to remove the meeting details
	 *
	 * @return  boolean True on success
	 *
	 * @since   3.0.0
	 */
	public function delete()
	{
		$body = array(
			'subject'       => $eventData['title'],
			'startDateTime' => Factory::getDate($eventData['startdate'], 'UTC')->format('Y-m-d\TH:i:s.u+05:30'),
			'endDateTime'   => Factory::getDate($eventData['enddate'], 'UTC')->format('Y-m-d\TH:i:s.u+05:30'),
		);

		$meeting = $this->createGraphRequest(
			'/users/' . $this->objectId . '/onlineMeetings/' . $this->meetingId,
			'DELETE',
			null,
			Model\OnlineMeeting::class
		);

		return $meeting['success'];
	}

	/**
	 * Method to delete registrant against event
	 *
	 * @param   JTicketingAttendee  $attendee  Attendee Object
	 *
	 * @return  boolean  True on success
	 *
	 * @since   3.0.0
	 */
	public function deleteAttendee(JTicketingAttendee $attendee)
	{
		return true;
	}

	/**
	 * Method to get Meeting Recording Url
	 *
	 * @return  boolean|String  False on failure and return recording Url
	 *
	 * @since   3.0.0
	 */
	public function getRecording()
	{
		$this->setError(Text::_('PLG_TJEVENTS_MICROSOFTTEAMS_VIDEO_NO_RECORDING_AVAILBLE'));

		return false;
	}

	public function getMailReplacementTags(JTicketingAttendee $attendee)
	{
		return '';
	}

	/**
	 * Update Event params after saving the event.
	 *
	 * @param   int  $id  Event id
	 *
	 * @return  boolean
	 *
	 * @since   3.3.1
	 */
	public function updateParamsAfterEventSave()
	{
		$params = json_decode($this->params);

		if (empty($params->microsoftteams->meeting_id))
		{
			$params->microsoftteams->meeting_id = $this->meetingId;
			$params->microsoftteams->join_url   = $this->joinUrl;

			$event         = new JTicketingEventJticketing($this->id);
			$event->params = json_encode($params);
			$event->save($data);
		}

		return true;
	}
}
