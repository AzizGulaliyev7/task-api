## Installation

 ##### Clone project
    git clone https://github.com/AzizGulaliyev7/task-api.git

 ##### Go to the folder application using cd command on your cmd or terminal
    cd task-api
 
 ##### Run your cmd or terminal
    composer install

 ##### Run
    php artisan key:generate
    

### Install db
 ##### Open your .env file and change the database name (DB_DATABASE) to whatever you have, username (DB_USERNAME) and password (DB_PASSWORD) field correspond to your configuration.

 ##### Run Migration
    php artisan migrate

 ##### JWT pacage configuration
    php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"

 ##### JWT pacage configuration. Generating secret key
    php artisan jwt:secret



 ##### Create default Admin User
    php artisan admin:install

 ##### Create default Company User
    php artisan admin:install
