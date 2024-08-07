# codeigniter v3 base

Improved Codeigniter v3 web site framework.

### Includes:

* User registration, login, verification & logging.
* User dashboard with photo upload functionality.
* Forms class to create forms.
* Table class to create tables.
* Functionality to translate to other languages using Google Translate.
* Class to display messages.
* Email sending using AWS SES.
* Base model class for common DB functions.
* Geoip to determine user location.
* Google Analytics functionality.
* Google captcha functionality.

### Uses:

* Bootstrap 4.3.1
* Jquery 3.4.1

### Installation:

* Create database. 
* Change admin user data in sql/db.sql and import db.sql into database.
* Edit files application/config/config.php, database.php, aws.php, maxmind.php
* chmod 777 application/cache
* chmod 777 application/logs
* chmod 777 application/tmp
* chmod 777 application/data
* chmod 777 -R application/language
* chmod 777 -R httpdocs/img/users
* composer install (--ignore-platform-reqs if required)

### Initial Setup

* For staging environment delete config/development.txt
* For production delete config/development.txt & staging.txt
* Replace application/data/google-key-file.json with your Google Translate API json file.
