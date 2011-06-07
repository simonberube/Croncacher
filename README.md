Cron Cacher
===========

This task enables you to handle caching on your own schedule.

Refresh caches as often as needed, not just when it's requested & expired.

Installation
------------

Tested with Fuel V1.0 RC3.

To install the Cron Cacher task, place the included files into their respective Fuel app folders. 

* fuel/app/tasks/croncacher.php
* fuel/app/config/croncacher.php

### Usage

You will have to set a cron job for Cron Cacher to run. If you plan to cache frequently, set the cron job for every 5 or 15 minutes. Methods for adding cron jobs will vary by hosting provider and plan. The following is the Oil command you would use.

	php oil r croncacher

You may need to tweak it to make it work. For example, [Media Temple](http://www.mediatemple.net/go/order/?refdom=pxls.co) uses PHP 5.2 by default and offers ways to opt in to newer versions of PHP. Since Fuel is a framework for PHP 5.3, you have to find the location of a PHP 5.3 binary to run. For Grid Service, here is what I've found to work.

	"/usr/local/php-5.3.2/bin/php" "/home/XXXXXX/domains/XXXXXX/oil" r croncacher

Simply replace the first set of X's is the account number and the second set is the domain.

Configuration
-------------

The config file accepts arrays for parameters to be used directly with the Cache class' `set` method. The second param is where you add a view or static method. Please note that there is a specific way to actually cache the code as it would output to the browser. Details below. 

### Example

In the following example, the `global/header` view is set for caching every hour. Note that `->render()` allows the cache to be executed then stored as a string.

	<?php
	
	return array(
		array(
			'header',
			"View::factory('global/header')->render()",
			3600
		)
	);

You can also cache methods. Your controller methods can be cached similarly to the example below. Note the use of the Request class and the string casting operator, `(string)`. Without it, you won't get the executed code.

	<?php
	
	return array(
		array(
			'index-dynamic',
			"(string) Request::factory('welcome/index')->execute()",
			86400
		)
	);

### Getting Caches

When retrieving a cache, you probably won't want to trigger the expiration. To grab the header view from the example above, the code would be as follows.

	Cache::get('header',false);

### Further documentation

All parameters for `Cache::set()` also work with this task. Please refer to the [Cache Class documentation](http://fuelphp.com/docs/classes/cache/usage.html).