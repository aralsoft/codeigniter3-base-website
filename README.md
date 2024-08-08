# codeigniter v3 base

Improved Codeigniter v3 web site framework.

### Added Functionality

* User registration, login, verification & logging.
* User dashboard.
* Forms class to create forms.
* Table class to create tables.
* Functionality to translate to other languages using Google Translate.
* Class to display messages.
* Email sending using AWS SES.
* Base model class for common DB functions.
* Geoip to determine user location using Maxmind.
* Google Analytics functionality.
* Google captcha functionality.
* Cron job locking & logging

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
* Edit httpdocs/.htaccess

### Initial Setup

* For staging environment delete config/development.txt
* For production delete config/development.txt & staging.txt
* Replace application/data/google-key-file.json with your Google Translate API json file.

### Cron Jobs

* php /var/www/html/XXXXXXX/httpdocs/index.php cli Daily

#### Add here to run more frequently than every minute

* /var/www/html/XXXXXXX/application/controllers/cli/cronJobs.sh

#### Get rid off bad formatting with:

* sed -i -e 's/\r$//' application/controllers/cli/cronJobs.sh
* chmod 777 application/controllers/cli/cronJobs.sh

### Translate Site

php /var/www/html/XXXXXXX/httpdocs/index.php cli Translate
