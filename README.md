## How to install

- git clone 
- sudo chown -R yourUser:www-data ecommerce-checkout
- sudo chmod -R 775 ecommerce-checkout/storage ecommerce-checkout/bootstrap
- cd ecommerce-checkout
- cp .env.example .env
- Edit .env whit your database connection
- php artisan key:generate
- composer install

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
