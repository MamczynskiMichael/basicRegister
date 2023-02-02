This is a small sweepstakes application
- Backend build with Laravel
- A form collects
  - First name
  - Last name
  - Email
  - Password
  - Phone number
  - Accepting the rules checkbox
  - Optin to our newsletter checkbox
- Prevents SQL injection and protects the password
- Proper validation of all fields.
  - All fields are required except the optin
- Save data to a database (mysql)
- Users can only access the internal site once  day
- A user must confirm to enter the site
- The page is styled in Tailwind
- The site uses vue to handle the frontend

### Setup ###
- Run `composer install` to install backend packages
- Run `npm install` to install frontend packages
- Run `npm run dev` to start the server
- Run `php artisan serve` to start the laravel server


