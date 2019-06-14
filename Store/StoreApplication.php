<?php

/**
 * Web application class for a store
 *
 * @package   Store
 * @copyright 2005-2016 silverorange
 * @license   http://www.gnu.org/copyleft/lesser.html LGPL License 2.1
 */
abstract class StoreApplication extends SiteWebApplication
{
	// {{{ public properties

	/**
	 * A convenience reference to the database connection of this store
	 * application
	 *
	 * This reference is available after StoreWebApplication::initModules() is
	 * called. This means this convenience reference is usually available just
	 * after the construction of this application is completed.
	 *
	 * @var MDB2_Driver_Common
	 */
	public $db;

	/**
	 * Default locale
	 *
	 * This locale is used for translations, collation and locale-specific
	 * formatting. The locale is a five character identifier composed of a
	 * language code (ISO 639) an underscore and a country code (ISO 3166). For
	 * example, use 'en_CA' for Canadian English.
	 *
	 * @var string
	 */
	public $default_locale = null;

	// }}}
	// {{{ protected properties

	/**
	 * @var string
	 */
	protected $locale;

	/**
	 * @var StoreRegion
	 */
	protected $region;

	// }}}
	// {{{ public function getCountry()

	/**
	 * @return string
	 */
	public function getCountry($locale = null)
	{
		if ($locale === null)
			$locale = $this->locale;

		$country = mb_substr($locale, 3, 2);

		return $country;
	}

	// }}}
	// {{{ public function getLocale()

	/**
	 * @return string
	 */
	public function getLocale()
	{
		return $this->locale;
	}

	// }}}
	// {{{ public function getRegion()

	/**
	 * @return StoreRegion
	 */
	public function getRegion()
	{
		return $this->region;
	}

	// }}}
	// {{{ protected function getDefaultModuleList()

	protected function getDefaultModuleList()
	{
		return array_merge(
			parent::getDefaultModuleList(),
			[
				'database' => SiteDatabaseModule::class,
				'session' => SiteAccountSessionModule::class,
				'cookie' => SiteCookieModule::class,
				'cart' => StoreCartModule::class,
				'checkout' => StoreCheckoutModule::class,
				'messages' => SiteMessagesModule::class,
				'config' => SiteConfigModule::class,
				'ads' => SiteAdModule::class,
				'analytics' => SiteAnalyticsModule::class,
				'timer' => SiteTimerModule::class,
				'notifier' => SiteNotifierModule::class,
				'crypt' => SiteCryptModule::class,
			]
		);
	}

	// }}}
	// {{{ protected function initModules()

	protected function initModules()
	{
		$this->session->registerDataObject(
			'account',
			SwatDBClassMap::get('StoreAccount')
		);

		$this->session->registerDataObject(
			'order',
			SwatDBClassMap::get('StoreOrder')
		);

		$this->session->registerDataObject(
			'vouchers',
			SwatDBClassMap::get('StoreVoucherWrapper')
		);

		parent::initModules();

		// set up convenience references
		$this->db = $this->database->getConnection();
	}

	// }}}
	// {{{ protected function addConfigDefinitions()

	/**
	 * Adds configuration definitions to the config module of this application
	 *
	 * @param SiteConfigModule $config the config module of this application to
	 *                                  which to add the config definitions.
	 */
	protected function addConfigDefinitions(SiteConfigModule $config)
	{
		parent::addConfigDefinitions($config);
		$config->addDefinitions(Store::getConfigDefinitions());
		$config->addDefinitions(Admin::getConfigDefinitions());
	}

	// }}}
	// {{{ protected function loadPage()

	protected function loadPage()
	{
		if ($this->locale === null)
			$this->locale = $this->default_locale;

		if ($this->locale !== null)
			setlocale(LC_ALL, $this->locale.'.UTF-8');

		parent::loadPage();
	}

	// }}}
}

?>
