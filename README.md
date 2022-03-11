# New Blog

This is the new customer blog with auto-feed from previous blog.

### Installation
- Clone the repo
- Install php packages via composer by running **composer install**
- Make copy of **.env.example** and set the database credentials
- Generate key by running **php artisan key:generate**


### Testing
```
   php artisan test
```

### Run schedule task
There is a task schedule to get posts from the blog API and save to the database, hourly.
To run this locally you can run the following command in a terminal:

```
   php artisan schedule:run
```
To run  this using cron, you can setup a cron job on your server to run hourly:

```
   * * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1
```

