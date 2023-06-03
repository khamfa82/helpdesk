# Setting Up The Laravel Queue Using Supervisor (Ubuntu/Debian)

The Laravel queue service provides a unified API across a variety of different queue back-ends. In Faveo-Helpdesk is used to process email sending jobs on 60 second delay.
## Installation
Install Supervisor

```bash
sudo apt install supervisor
```

## Copy config file
copy faveo-worker.conf to /etc/supervisor/conf.d/
Install Supervisor

```bash
cd /var/www/html/faveo-helpdesk/
sudo cp faveo-worker.conf /etc/supervisor/conf.d/faveo-worker.conf
```
## Usage

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start laravel-worker:*
```

## Check Supervisor Status

```bash
sudo supervisorctl status
```

## Sample Content for the faveo-worker.conf
```config
[program:faveo-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/html/faveo-helpdesk/artisan queue:work --sleep=3 --tries=3 --daemon
autostart=true
autorestart=true
user=admin
numprocs=1
redirect_stderr=true
stdout_logfile=/var/www/html/faveo-helpdesk/storage/logs/worker.log

```

Please make sure to update tests as appropriate.
