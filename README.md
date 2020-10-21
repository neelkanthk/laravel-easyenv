![Laravel Surveillance Logo](https://github.com/neelkanthk/repo_logos/blob/master/LaravelEasyEnv_logo.png?raw=true)

# EasyEnv

A Laravel package to easily manage and switch between multiple environment files using artisan cli.

## Installation
```bash
composer require neelkanthk/laravel-easyenv
```
## Publish the config file.

```bash
php artisan vendor:publish --provider="Neelkanth\Laravel\EasyEnv\Providers\EasyEnvServiceProvider" --tag="config"
```

## Usage

Add the following lines just before the ```php return $app; ``` in the ``` bootstrap/app.php```

```php
use Neelkanth\Laravel\EasyEnv\EasyEnv;
$app->useEnvironmentPath(EasyEnv::path())->loadEnvironmentFrom(EasyEnv::file());
```

## Managing the Envrionments through CLI

The package provides following ```artisan``` commands to add/remove and enable/disable environments.

The commands have following signature.
```bash
php artisan easyenv:[action] {env} {path} {file}
```

```bash
[action] : Following action are available list|add|remove|enable|disable
````

```bash
{env}: The name of your choice for the environment.
{path}: The absolute path of the location of the environment file
{file}: The name of the environment file residing on the filesystem.
```

#### 1. Add a new environment.

```bash
php artisan easyenv:add staging /var/www/env/ .staging
```
#### 2. Enable an environment. 
_Only 1 environment can be enabled at a time._
```bash
php artisan easyenv:enable staging
```

#### 3. Listing all available environments.

```bash
php artisan easyenv:list
```
| Environment | Status  | Path          | File     |
|-------------|---------|---------------|----------|
| staging     | Enabled | /var/www/env/ | .staging |


#### 4. Disable currently enabled environment.

```bash
php artisan easyenv:disable
```

#### 5. Remove an environment

```bash
php artisan easyenv:remove staging
```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

## Security
If you discover any security-related issues, please email me.neelkanth@gmail.com instead of using the issue tracker.

## Credits

- [Neelkanth Kaushik](https://github.com/username)
- [All Contributors](../../contributors)

## License
[MIT](https://choosealicense.com/licenses/mit/)
