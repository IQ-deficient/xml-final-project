# xml-final-project
Final project for the subject XML-technologies using Laravel &amp; VueJS - Excel files manipulation and data export to files


INSTRUCTIONS:

-make mysql database with xampp up

-copy .env.example to newly made .env file on root/back and rename the database entry to match your mysql db name

cd back

composer install

npm install

php artisan migrate:refresh --seed

npm run watch

php artisan serve
