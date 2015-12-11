# Input automation

In this section you will learn

* [How to automate jobs](#automation)

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

This will take the latest job on the queue and execute it.

Unfortunately, in Laravel 4 there's no direct way of adding jobs onto the queue with a certain execution time (Laravel 5 has though). Therefore, we've added a command intuitively called "triggerjobs". This command will trigger the jobs that are due by pushing them onto the queue. It should be this command that you add to your crontab! By executing this command every 12 hours it will make sure that even the jobs that have the smallest interval (12 hours) will make it onto the queue in time. It will check every job, take its last execution timestamp, compare it with the current time and decide whether or not the job should be executed or not.

## Ideal situation

In an ideal set-up, you have the following command scheduled in a cronjob to run every 12 hours:

    $ php artisan input:triggerjobs

combined with the artisan queue listening for new jobs:

    $ php artisan queue:listen

This way, jobs will get added to the queue when they are due and processed by the queue sequentially.