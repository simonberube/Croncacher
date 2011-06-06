<?php
/**
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package    Fuel
 * @version    1.0
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2011 Fuel Development Team
 * @link       http://fuelphp.com
 */

namespace Fuel\Tasks;

/**
 * This Task enables you to handle caching on your own schedule.
 *
 * Refresh caches as often as needed, not just when it's requested & expired.
 *
 * @package		Cron Cacher
 * @version		1.0
 * @author		Simon Bérubé
 */

class Croncacher {
	
	/**
	 * This method does all the caching set forth in the config file.
	 *
	 * Usage (from command line):
	 * php oil r croncacher
	 *
	 */
	public static function run()
	{
 		$config = \Config::load('croncacher', false);
		foreach ($config as $cache_item) {
			try
			{
				// If the cache exists and hasn't expired, we'll move on to the next cache_item.
				\Cache::get($cache_item[0]);
			}
			catch (\Exception $e)
			{
				// This part caches content that doesn't exist yet or is expired.
				$cache_item[1] = eval("return $cache_item[1];");
				call_user_func_array('\Cache::set',$cache_item);
			}
		}
	}
}

/* End of file tasks/croncacher.php */