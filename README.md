# baculareport
This tools is used to show the amount of the data consumed by customers, group by customer's account

Prerequisites :
- Bacula with catalog stored in MySQL
- A traditionnal Apache/PHP/MySQL hosting service

Install :
- View and edit the settings.inc.php
- Create a database (or use the Bacula's mysql database) with the structure of database.sql
- Browse with your web browser
- Create your Customers (with billing information)
- Associate the Bacula's client to your customers groups created before
- Show the repports generated

History :
- 2017-08-23 : Adding to database at which day the full is to be running. - USEFUL only if you're running ONE full every week, and diff/incr others times
- 2017-08-23 : Changing input type select to radio for storage pool
- 2017-08-17 : Adding details for each job : endtime, and calculated duration
- 2017-04-25 : Adding storage pool information table for each client
- 2016-07-12 : first commit(s)
