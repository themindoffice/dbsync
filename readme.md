#Installation
Install with ```composer require --dev themindoffice/dbsync```

Upon installation, composer is instructed to execute the install method on the provider.
This will add the ```dbsync.php``` config file to the config folder in your laravel installation.
It will automatically add this config file to the gitignore file.

#Config
Add your environments to the ```dbsync.php``` config file.

#Usage
call ```php artisan db:pull {environment}``` to fetch the database from that environment.  
call ```php artisan db:push {environment}``` to push your database to the that environment.
