# Laravel-SPA
- A single page application with crud, graph and custom email sending I made using vue and laravel. :)))))))))))))



##### Clone this project and run to your local computer
- run in terminal/bash `git clone https://github.com/VinceSanityyy/Laravel-SPA.git`
- run `composer install` to install php dependencies
- run `npm install` to install node dependencies
- run `php artisan passport:install` to get api key in authorization
- configure local database in `.env`
- also, configure email in `.env` like this
```
MAIL_DRIVER=smtp
MAIL_HOST=smtp.googlemail.com
MAIL_PORT=465
MAIL_USERNAME=your email
MAIL_PASSWORD=the password of your email
MAIL_ENCRYPTION=ssl
```
 - run `php artisan migrate` 
 - run `php artisan serve` and `npm run watch --poll`
 - go to `127.0.0.1:8000`
 - if you want full previlage just edit the user type in the database manually and set it to `admin` all lowercase. Thanks
 
### Feel free to use -Vince
- If you want to contribute or become a contributor message me in facebook. `facebook.com/vincentsanityyy`



## To Do's
- Add Graph/Chart ✓
- Can send dynamic email msg from users ✓
- Make single page - modal inputs ✓
- Can add/edit profile picture ✓
- CRUD ✓
- Add API token for passport ✓
- Add rules/authorization for users eg. Admin,User ✓
- Add alerts/Notif/Toasts ✓
- Convert table into data table ✗
- Chat module ✗
- Real time notifications ✗
- Good landing page ✗ 
- Good User Interface ✗
- Must conver API routes to regular routes ? 
