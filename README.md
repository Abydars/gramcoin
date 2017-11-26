# Laravel PHP Framework

[![Build Status](https://travis-ci.org/laravel/framework.svg)](https://travis-ci.org/laravel/framework)
[![Total Downloads](https://poser.pugx.org/laravel/framework/d/total.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/framework/v/stable.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/framework/v/unstable.svg)](https://packagist.org/packages/laravel/framework)
[![License](https://poser.pugx.org/laravel/framework/license.svg)](https://packagist.org/packages/laravel/framework)

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as authentication, routing, sessions, queueing, and caching.

Laravel is accessible, yet powerful, providing tools needed for large, robust applications. A superb inversion of control container, expressive migration system, and tightly integrated unit testing support give you the tools you need to build any application with which you are tasked.

## Official Documentation

Documentation for the framework can be found on the [Laravel website](http://laravel.com/docs).

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](http://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).

## Preinstallation
1. PHP 5.6
2. MySQL
3. Composer [Composer Installing](https://getcomposer.org/doc/00-intro.md)
4. Node.js [Node.js Installing](https://nodejs.org/)
5. Bower [Bower Installing](https://bower.io/)

## Install
1. Installing PHP libraries using composer

    run the command below on project root

    ```
    composer install
    ```

2. Build resources

    run command below on project root

    ```
    npm install
    bower install
    gulp build
    ```

3. Run Server (required if you are not using any web server like APACHE)

    If you have PHP installed locally and you would like to use PHP's built-in development server to serve your application, you may use the serve Artisan command. This command will start a development server at http://localhost:8000
    See [Laravel documentation](https://laravel.com/docs/5.3).

    ```
    php artisan serve
    ```

# Using APACHE
**Setup Virtual Host**

1. Edit XAMPP or WAMP vhosts file (usually located at ```XAMPP_FOLDER/apache/conf/extra/httpd-vhosts.conf```)

2. Add new virtual host
    ```
    <VirtualHost *:PORT_NUMBER>
        DocumentRoot "PROJECT_PUBLIC_PATH"
        ServerName app.gramcoin.localhost
    	RewriteEngine on
    	<Directory PROJECT_PUBLIC_PATH>
    	    Options Indexes FollowSymLinks MultiViews
    	    AllowOverride all
    	    Order Deny,Allow
    	    Allow from all
    	    Require all granted
    	</Directory>
    </VirtualHost>
    ```
3. Save and restart XAMPP/WAMP

4. Visit [app.gramcoin.localhost:PORT_NUMBER](http://app.gramcoin.localhost:PORT_NUMBER)

**Configuration**

1. Edit ```PROJECT_ROOT/.env``` file

2. Set ```DB_DATABASE=YOUR DB NAME HERE```

3. Set ```DB_USERNAME=YOUR DB USERNAME HERE```

4. Set ```DB_PASSWORD=YOUR DB USER PASSWORD HERE```

5. Set ```APP_URL=http://app.gramcoin.localhost:YOUR PORT NUMBER HERE```

6. Set ```APP_DOMAIN=app.gramcoin.localhost:YOUR PORT NUMBER HERE```