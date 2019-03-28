<?php

namespace srag\Plugins\Notifications4Plugins\Parser;

use ilNotifications4PluginsPlugin;
use srag\DIC\Notifications4Plugins\DICTrait;
use srag\Plugins\Notifications4Plugins\Utils\Notifications4PluginsTrait;
use Twig_Environment;
use Twig_Error;
use Twig_Loader_String;

/**
 * Class twigParser
 *
 * @package srag\Plugins\Notifications4Plugins\Parser
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 * @author  Stefan Wanzenried <sw@studer-raimann.ch>
 */
class twigParser implements Parser {

	use DICTrait;
	use Notifications4PluginsTrait;
	const PLUGIN_CLASS_NAME = ilNotifications4PluginsPlugin::class;
	/**
	 * @var array
	 */
	protected $options = array(
		"autoescape" => false, // Do not auto escape variables by default when using {{ myVar }}
	);


	/**
	 * twigParser constructor
	 *
	 * @param array $options
	 */
	public function __construct(array $options = array()) {
		$this->options = array_merge($this->options, $options);
	}


	/**
	 * @inheritdoc
	 *
	 * @throws Twig_Error
	 */
	public function parse(string $text, array $placeholders = array()): string {
		$loader = new Twig_Loader_String();

		$twig = new Twig_Environment($loader, $this->options);

		return $twig->render($text, $placeholders);
	}
}
