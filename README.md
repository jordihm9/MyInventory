# My Inventory

## Deployment

Clone the repository to an specific folder
```
git clone https://github.com/jordihm9/MyInventory.git ./MyInventory
```

Install depencendies using composer
```
composer install
```

### Prepare development mode
```
composer prepare-dev-environment
```

### Prepare production mode
```
composer prepare-prod-environment
```

## Other commands

### Deploy the database container using docker
```
composer deploy-local-db
```

### Access the database via terminal
```
composer mysql
```

### Stop the database container
```
composer stop-local-db
```

### Set the permisions for a laravel project
```
composer set-permisions
```

## Running the scheduler in production
- Edit the cron file from the owner of the project (should be `www-data`)
```
$ sudo crontab -u www-data -e
```
- Append the following line at the end of the file (every minute will try to execute the schedules from the project)
```
* * * * * cd /var/www/myinventory.link/ && php artisan schedule:run >> /dev/null 2>&1
```
> Author: Jordi Hernàndez i Magí