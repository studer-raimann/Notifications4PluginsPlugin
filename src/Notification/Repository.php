<?php

namespace srag\Plugins\Notifications4Plugins\Notification;

use ilNotifications4PluginsPlugin;
use srag\DIC\Notifications4Plugins\DICTrait;
use srag\Plugins\Notifications4Plugins\Utils\Notifications4PluginsTrait;

/**
 * Class Repository
 *
 * @package srag\Plugins\Notifications4Plugins\Notification
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
final class Repository {

	use DICTrait;
	use Notifications4PluginsTrait;
	const PLUGIN_CLASS_NAME = ilNotifications4PluginsPlugin::class;
	/**
	 * @var self
	 */
	protected static $instance = null;


	/**
	 * @return self
	 */
	public static function getInstance()/*: self*/ {
		if (self::$instance === null) {
			self::$instance = new self();
		}

		return self::$instance;
	}


	/**
	 * Repository constructor
	 */
	private function __construct() {

	}


	/**
	 * @param Notification $notification
	 */
	public function deleteNotification(Notification $notification)/*: void*/ {
		$notification->delete();

		foreach ($notification->getNotificationLanguages() as $language) {
			$language->delete();
		}
	}


	/**
	 * @return Factory
	 */
	public function factory()/*: Factory*/ {
		return Factory::getInstance();
	}


	/**
	 * @return array
	 */
	public function getArrayForSelection()/*: array*/ {
		$notifications = $this->getNotifications();

		$array = array();

		foreach ($notifications as $notification) {
			$array[$notification->getName()] = $notification->getTitle() . " (" . $notification->getName() . ")";
		}

		return $array;
	}


	/**
	 * @return array
	 */
	public function getArrayForTable()/*: array*/ {
		$data = array();

		$notifications = $this->getNotifications();

		foreach ($notifications as $notification) {
			$row = array();
			$row["id"] = $notification->getId();
			$row["title"] = $notification->getTitle();
			$row["name"] = $notification->getName();
			$row["description"] = $notification->getDescription();
			$row["default_language"] = $notification->getDefaultLanguage();
			$row["languages"] = implode(", ", $notification->getLanguages());
			$data[] = $row;
		}

		return $data;
	}


	/**
	 * @param int $id
	 *
	 * @return Notification|null
	 */
	public function getNotificationById(/*int*/
		$id)/*: ?Notification*/ {
		/**
		 * @var Notification|null $notification
		 */

		$notification = Notification::where(array( "id" => $id ))->first();

		return $notification;
	}


	/**
	 * @param string $name
	 *
	 * @return Notification|null
	 */
	public function getNotificationByName(/*string*/
		$name)/*: ?Notification*/ {
		/**
		 * @var Notification|null $notification
		 */

		$notification = Notification::where(array( "name" => $name ))->first();

		return $notification;
	}


	/**
	 * @return Notification[]
	 */
	public function getNotifications()/*: array*/ {
		/**
		 * @var Notification[] $notifications
		 */

		$notifications = Notification::orderBy("title", "ASC")->get();

		return $notifications;
	}


	/**
	 * @param Notification $notification
	 */
	public function storeInstance(Notification $notification)/*: void*/ {
		$date = date("Y-m-d H:i:s");

		if (empty($notification->getId())) {
			$notification->setCreatedAt($date);
		}

		$notification->setUpdatedAt($date);

		$notification->store();

		foreach ($notification->getNotificationLanguages() as $language) {
			$language->store();
		}
	}


	/**
	 * @return UI
	 */
	public function ui()/*: UI*/ {
		return UI::getInstance();
	}
}
