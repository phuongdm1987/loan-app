# Loan API Project

### How to run in local for first time
```bash
cp .env.example .env
docker-compose build app
docker-compose up -d
bin/run composer install
bin/run artisan key:generate
docker-compose exec mysql mysql
```

```mysql
create database loan character set utf8mb4 collate utf8mb4_unicode_ci;
exit;
```

```bash
bin/run artisan migrate
bin/run artisan db:seed
```

in **/etc/hosts**, made a record:

```127.0.0.1 loan.local```
### Run

project avaiable on http://loan.local:93


### Stop

```docker-compose stop```

### Start again

```docker-compose up -d```

### Note
- ```bin/run artisan migrate:fresh --seed``` # Reset database
- Re-run ```docker-compose up``` # after change .env file
- ```bin/run artisan optimize:clear``` # to clear cache services
- ```bin/run artisan queue:work --queue={default},{emails}``` # run queue by manual
