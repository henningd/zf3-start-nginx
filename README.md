Bei Verwendung von nginx/valet kann man auch die folgenden Zeilen integrieren, anstatt APPLICATION_ENV zu setzen.

```php
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
```
