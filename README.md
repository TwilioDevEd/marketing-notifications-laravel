# SMS Notifications with Twilio and Laravel

[![Build Status](https://travis-ci.org/TwilioDevEd/marketing-notifications-laravel.svg)](https://travis-ci.org/TwilioDevEd/marketing-notifications-laravel)

Use Twilio to create sms notifications to keep your subscribers in the loop.

[Read the full tutorial here](https://www.twilio.com/docs/tutorials/walkthrough/marketing-notifications/php/laravel)!

## Local Development

1. You will need to configure Twilio to send requests to your application when SMS are received.

   You will need to provision at least one Twilio number with sms capabilities so the application's users can make property reservations. You can buy a number [right here](https://www.twilio.com/user/account/phone-numbers/search). Once you have a number you need to configure your number to work with your application. Open [the number management page](https://www.twilio.com/user/account/phone-numbers/incoming) and open a number's configuration by clicking on it.

   Remember that the number where you change the _SMS webhook_ must be the same one you set on the `TWILIO_PHONE_NUMBER` environment variable.

   ![Configure Voice](http://howtodocs.s3.amazonaws.com/twilio-number-config-all-med.gif)

   To start using `ngrok` on our project you'll have execute to the following line in the _command prompt_.

   ```
   ngrok http 8000
   ```

   Keep in mind that our endpoint is:

   ```
   http://<your-ngrok-subdomain>.ngrok.io/subscribers/register
   ```

2. Clone this repository and `cd` into it.

   ```
   git clone git@github.com:TwilioDevEd/marketing-notifications-laravel.git
   cd marketing-notifications-laravel
   ```

3. Install the application's dependencies with [Composer](https://getcomposer.org/).

  ```bash
  $ composer install
  ```

4. The application uses PostgreSQL as the persistence layer. If you don't have it already, you should install it. The easiest way is by using [Postgres.app](http://postgresapp.com/).

5. Create a database.

   ```bash
   $ createdb marketing_notifications
   ```

6. Copy the sample configuration file and edit it to _match your configuration_.

   ```bash
   $ cp .env.example .env
   ```

  You'll need to set `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`, `TWILIO_ACCOUNT_SID`, `TWILIO_AUTH_TOKEN`, and `TWILIO_PHONE_NUMBER` in your .env file.

7. Generate an `APP_KEY`.

   ```bash
   $ php artisan key:generate
   ```

8. Run the migrations.

   ```bash
   $ php artisan migrate
   ```

9. Run the application using Artisan.

   ```bash
   $ php artisan serve
   ```

10. Check it out at [http://localhost:8000](http://localhost:8000)

## Run the tests

1. Create a database.

   ```bash
   $ createdb marketing_notifications_test
   ```

2. Run the database migrations for the test database.

   ```bash
   $ APP_ENV=testing php artisan migrate
   ```

3. Run at the top-level directory.

   ```bash
   $ phpunit
   ```

## Meta

* No warranty expressed or implied. Software is as is. Diggity.
* [MIT License](http://www.opensource.org/licenses/mit-license.html)
* Lovingly crafted by Twilio Developer Education.
