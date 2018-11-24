<?php /** @noinspection SpellCheckingInspection */
declare(strict_types=1);

namespace Plugin;

use UCRM\Common\SettingsBase;

/**
 * @author Ryan Spaeth <rspaeth@mvqn.net>
 *
 * @method static bool|null getDebugEnabled()
 * @method static string|null getLanguage()
 */
final class Settings extends SettingsBase
{
	/** @const string The name of this Project, based on the root folder name. */
	public const PROJECT_NAME = 'tests';

	/** @const string The absolute path to this Project's root folder. */
	public const PROJECT_ROOT_PATH = 'C:\Users\rspaeth\Documents\PhpStorm\Projects\ucrm-modules\common\tests';

	/** @const string The name of this Project, based on the root folder name. */
	public const PLUGIN_NAME = 'plugin-example';

	/** @const string The absolute path to the root path of this project. */
	public const PLUGIN_ROOT_PATH = 'C:\Users\rspaeth\Documents\PhpStorm\Projects\ucrm-modules\common\tests\plugin-example';

	/** @const string The absolute path to the data path of this project. */
	public const PLUGIN_DATA_PATH = 'C:\Users\rspaeth\Documents\PhpStorm\Projects\ucrm-modules\common\tests\plugin-example\data';

	/** @const string The absolute path to the source path of this project. */
	public const PLUGIN_SOURCE_PATH = 'C:\Users\rspaeth\Documents\PhpStorm\Projects\ucrm-modules\common\tests\plugin-example\src';

	/** @const string The publicly accessible URL of this UCRM, null if not configured in UCRM. */
	public const UCRM_PUBLIC_URL = 'http://ucrm.example.com/';

	/** @const string The publicly accessible URL assigned to this Plugin by the UCRM. */
	public const PLUGIN_PUBLIC_URL = null;

	/** @const string An automatically generated UCRM API 'App Key' with read/write access. */
	public const PLUGIN_APP_KEY = 'CVng+dj2tQLI9Gl3P8Fk0birJkDksytjlud2rzV9v8LSbkuxfmYWj1Buvxp5WhyG';

	/**
	 * Debug Enabled?
	 * @var bool|null If enabled, verbose debug messages are sent to the log.
	 */
	protected static $debugEnabled;

	/**
	 * Language
	 * @var string|null The desired language for notifications.
	 */
	protected static $language;
}
