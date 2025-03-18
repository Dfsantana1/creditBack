### For Windows Xampp

1) Install Xampp version 8.X

2) Clone repo from git-hub to xampp's htdocs folder

3) Run composer install command from terminal and you will get following errors if you are in windows

```
Problem 1 - Root composer.json requires PHP extension ext-pcntl * but it is missing from your system. Install or enable PHP's pcntl extension.

Problem 2 - Root composer.json requires PHP extension ext-posix * but it is missing from your system. Install or enable PHP's posix extension.

Problem 3 - laravel/horizon is locked to version v5.9.1 and an update of this package was not requested. - laravel/horizon v5.9.1 requires ext-pcntl * -> it is missing from your system. Install or enable PHP's pcntl extension.
```

4) After that you have to run following command for solve above problems

```
composer install --ignore-platform-req
```

5) Setup .env file and write database name

6) Run following command for migration and seeders.

```
php artisan migrate
php artisan db:seed
```

7) Then After there are two ways to run 

```
i) Run php artisan serve command
ii) You can make virtual-host in xampp for this.
```

### Notes for Wampp 
With Wampp you might need some additional features from microsoft like vc++ distribution applications and extensions.
This purely based on user's system configuration.