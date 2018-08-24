# BackPack Track Admin Panel
Laravel based web application Admin Panel and API for BackPack Track

# Installation
- Download or Clone this repository
```
git clone https://github.com/afzafri/BackPack-Track-Admin-Panel.git
```
- Create a new database
- Copy or rename file ```.env.example``` to ```.env```, and edit the file to change the attributes for database to your database configurations (host,username,password etc)
- Run commands through Terminal/CMD/SSH:
  - ```
    sudo chgrp -R www-data /var/www/html/your-project
    sudo chmod -R 775 /var/www/html/your-project/storage
    ```
  - composer install
  - php artisan key:gen
  - php artisan migrate
  - php artisan db:seed
  - php artisan passport:install
  - php artisan storage:link
