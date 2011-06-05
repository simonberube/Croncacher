Cron Cacher
===========

This task enables you to handle caching on your own schedule.

Refresh caches as often as needed, not just when it's requested & expired.

Installation
------------

To install the Cron Cacher task, place the included files into their respective Fuel app folders. 

* fuel/app/tasks/croncacher.php
* fuel/app/config/croncacher.php

Configuration
-------------

Configuring Cron Cacher is easy. The config file accepts arrays containing the parameters to be used directly with the Cache class' `set` method.

### Example

In the following example, the `global/header` view will be cached to the identifier `header` every time the cron job is run.

	<?php
	
	return array(
		array(
			'header',
			View::factory('global/header')
		)
	);

### Further documentation

All parameters for `Cache::set()` work with this task. Please refer to the [Cache Class documentation](http://fuelphp.com/docs/classes/cache/usage.html).

Usage
-----

With your config file ready, you'll want to add a cron job for the following.

	php oil r croncacher

Methods for adding cron jobs will vary by hosting provider and plan, so you may have to tweak it to make it work. As an example, as of this writing, my host, [Media Temple](http://www.mediatemple.net/go/order/?refdom=pxls.co), still uses PHP 5.2 by default. Obviously, Fuel is a framework for PHP 5.3, which means that I have to find the location of a PHP 5.3 binary for the cron job to run. Here is what I've found to work:

	"/usr/local/php-5.3.2/bin/php" "/nfs/xXX/xXX/mnt/XXXXXX/domains/XXXX/oil" r croncacher