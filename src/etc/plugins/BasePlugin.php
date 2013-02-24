<?php
namespace Blocks;

/**
 * Plugin base class
 */
abstract class BasePlugin extends BaseSavableComponentType
{
	public $isInstalled = false;
	public $isEnabled = false;

	/**
	 * @access protected
	 * @var string The type of component this is
	 */
	protected $componentType = 'Plugin';

	/**
	 * Returns the plugin’s version.
	 *
	 * @abstract
	 * @return string
	 */
	abstract public function getVersion();

	/**
	 * Returns the plugin developer's name.
	 *
	 * @return string
	 */
	abstract public function getDeveloper();

	/**
	 * Returns the plugin developer's URL.
	 *
	 * @return string
	 */
	abstract public function getDeveloperUrl();

	/**
	 * Returns whether this plugin has its own section in the CP.
	 *
	 * @return bool
	 */
	public function hasCpSection()
	{
		return false;
	}

	/**
	 * Creates any tables defined by the plugin's records.
	 */
	public function createTables()
	{
		$records = $this->getRecords('install');

		// Create all tables first
		foreach ($records as $record)
		{
			$record->createTable();
		}

		// Then add the foreign keys
		foreach ($records as $record)
		{
			$record->addForeignKeys();
		}
	}

	/**
	 * Drops any tables defined by the plugin's records.
	 */
	public function dropTables()
	{
		$records = $this->getRecords();

		// Drop all foreign keys first
		foreach ($records as $record)
		{
			$record->dropForeignKeys();
		}

		// Then drop the tables
		foreach ($records as $record)
		{
			$record->dropTable();
		}
	}

	/**
	 * Perform any actions after the plugin has been installed.
	 */
	public function onAfterInstall()
	{
	}

	/**
	 * Perform any actions before the plugin gets uninstalled.
	 */
	public function onBeforeUninstall()
	{
	}

	/**
	 * Returns the record classes provided by this plugin.
	 *
	 * @access protected
	 * @param string|null $scenario The scenario to initialize the records with
	 * @return array
	 */
	public function getRecords($scenario = null)
	{
		$records = array();
		$classes = blx()->plugins->getPluginComponentClassesByType($this->getClassHandle(), 'record');

		foreach ($classes as $class)
		{
			if (blx()->components->validateClass($class))
			{
				$class = __NAMESPACE__.'\\'.$class;
				$records[] = new $class($scenario);
			}
		}

		return $records;
	}
}
