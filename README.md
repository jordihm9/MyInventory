# My Inventory

## Deployment
1. Clone the repository to an specific folder
```
$ sudo git clone https://github.com/jordihm9/MyInventory.git /var/www/myinventory.link/
```
2. Make a copy of the `.env.example` to `.env`
```
$ cp .env.example .env
```
3. Setup the environments variables (`.env` file)  
- Change to production
```
APP_ENV=production
```
- Turn off debug mode
```
APP_DEBUG=false
```
- Change credentials/drivers for database and mail
4. Generate the app key
```
$ php artisan key:generate
```
5. Optimize configuration, view and route loading
```
$ php artisan config:cache
$ php artisan view:cache
$ php artisan route:cache
```
6. Generate the storage links
```
$ php artisan storage:link
```
7. Install dependencies
```
$ composer install
```
8. Optimize the autoloader
```
$ composer install --optimize-autoloader --no-dev
```
9. Change project permisions
- Change owner
```
$ sudo chown www-data:www-data -R /var/www/myinventory.link
```
- Change permisions for files and folders
```
$ sudo find /var/www/myinventory.link -type f -exec chmod 664 {} \;
$ sudo find /var/www/myinventory.link -type d -exec chmod 775 {} \;
```
- Change specific permisions for the following folders
```
$ sudo chmod -R ug+rwx /var/www/myinventory.link/storage /var/www/myinventory.link/bootstrap/cache
```
10. Run the scheduler
- Edit the cron file from the owner of the project
```
$ sudo crontab -u www-data -e
```
- Append the following line at the end of the file (every minute will try to execute the schedules from the project)
```
* * * * * cd /var/www/myinventory.link/ && php artisan schedule:run >> /dev/null 2>&1
```
> Author: Jordi Hernàndez i Magí