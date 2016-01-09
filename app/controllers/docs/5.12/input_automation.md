# Input automation

In this section you will learn

* [How to automate jobs](#automation)
* [How the ideal set-up looks like](#ideal-setup)

<a id='automation' class='anchor'></a>
## Automating ETL jobs

Upon creating an ETL job you can choose several values for the "schedule" property. This property will let the ETL know how often the data should be refreshed. The default value is "once" which will add the job to the Beanstalk queue and allow for it to be processed. The entire ETL process isn't that complex, but needs some explanation in order to get things right, so let's get started!

First of all you'll create a job with a certain schedule. It doesn't really matter whether this is one single time or every day, the job will end up in the queue after adding it. You can then do two things:

1. You have the artisan queue command listening for new jobs
2. Trigger the queue to execute a command

The first is achieved by the following command:

    $ php artisan queue:listen

You might want to pass a couple of parameters such as the timeout time which defaults at 60 seconds.

The second is done by the following command:

    $ php artisan queue:work

Executing queue:work will take the latest job on the queue and execute it.

Unfortunately, in Laravel 4 there's no direct way of adding jobs onto the queue with a certain execution time (Laravel 5 has though). Therefore, we've added a command intuitively called "triggerjobs". This command will trigger the jobs that are due by pushing them onto the queue. It should be this command that you add to your crontab! By executing this command every 12 hours it will make sure that even the jobs that have the smallest interval (12 hours) will make it onto the queue in time. It will check every job, take its last execution timestamp, compare it with the current time and decide whether or not the job should be executed or not.

<a id='ideal-setup' class='anchor'></a>
## Ideal situation

In an ideal set-up, you have the following command scheduled in a cronjob to run every 12 hours:

    $ php artisan input:triggerjobs

combined with the artisan queue listening for new jobs:

    $ php artisan queue:listen

This way, jobs will get added to the queue when they are due and processed by the queue sequentially. In order to make sure that the queue will keeps listening, and will be rebooted when it stops, you'll have to install something called "Supervisor".

Install Supervisor by [following the installation instructions](http://supervisord.org/installing.html) and configure the command 'php artisan queue:listen' to be supervised. Finally, in order to fetch some logging from the supervisor daemon on the queue command, add a logging file like so:

```

; Enter the supervisor configuration file
vi /etc/supervisord.conf

; Add the following to the bottom of the file
[program:queue-listener]
command=php /var/www/path/to/artisan queue:listen --env=production --timeout=0
stdout_logfile=/var/www/pat/to/app/storage/logs/supervisor.log
redirect_stderr=true

```

In order to start the supervisor process with the new configuration hit the following command:

    $ sudo supervisorctl

This will bring you into the console environment of supervisor and allows you to reread the configuration:

    $ reread

Just to make sure that the supervisor is actually supervising the new "queue-listener" program:

    $ add queue-listener
    $ start queue-listener

If you're getting an error on the latest command, don't worry, it's probably because the queue is already running.

Sometimes you might end up with jobs that are failing and are stuck in the queue, we build a handy command that should flush those jobs out of the queue and make the appropriate changes in the back-end of the input package:

    $ php artisan input:clearqueue

Another precaution might be that when configuring the queue:listen command, you set the "--tries" option to a certain number. This will tell the queue to try to execute it a maximum of times, before kicking it out.


## Summary

To sum this up, we have 4 major components in the ETL automation

1. A job that can be executed through the command-line, starting the ETL sequence
2. A command that checks if jobs are due
3. A queue that listens for news jobs to execute
4. A daemon that makes sure the queue keeps listening for new jobs

