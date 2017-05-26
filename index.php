<?php
/**
 * ZF3 Application
 *
 * @author     Daniel Henninger <info@dhe.de>
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 */

use Zend\Mvc\Application;
use Zend\Stdlib\ArrayUtils;

define('PROJECT_ROOT', realpath(__DIR__ . '/..'));

$darray = explode('.', $_SERVER['HTTP_HOST']);
$narray = array_reverse($darray);
$domain = $narray[0];
unset($darray, $narray);
if ($domain == "dev") {
  define(
      'APPLICATION_ENV', (getenv('APPLICATION_ENV')
      ? getenv('APPLICATION_ENV')
      : 'development')
  );
} else {
  define(
      'APPLICATION_ENV', (getenv('APPLICATION_ENV')
      ? getenv('APPLICATION_ENV')
      : 'production')
  );
}

if (php_sapi_name() === 'cli-server') {
    $path = realpath(
        __DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
    );

    if (__FILE__ !== $path && is_file($path)) {
        return false;
    }

    unset($path);
}

require_once PROJECT_ROOT . '/vendor/autoload.php';

chdir(dirname(__DIR__));

$appConfig = require PROJECT_ROOT . '/config/application.config.php';

$configFile = PROJECT_ROOT . '/config/' . APPLICATION_ENV . '.config.php';
if (file_exists($configFile)) {
    $appConfig = ArrayUtils::merge($appConfig, require $configFile);
}

Application::init($appConfig)->run();
