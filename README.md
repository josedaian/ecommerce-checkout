## How to install

- git clone 
- sudo chown -R yourUser:www-data ecommerce-checkout
- sudo chmod -R 775 ecommerce-checkout/storage ecommerce-checkout/bootstrap
- cd ecommerce-checkout
- cp .env.example .env
- Edit .env whit your database connection
- php artisan key:generate
- composer install

## Database
- Download and restore backup https://drive.google.com/file/d/1IybDy6bDZYi59ugWxkfNlPsx5SIJbz_J/view?usp=sharing
- Edit data of table webservice_credentials, the following columns, with AdamsPay Credentials:
    * client_secret
    * api_key

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
