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
- 2018-02-28 : Changing customer\_billing.customer\_name to utf8\_general\_ci ; Changing method to add data customer name to DB;
- 2017-11-03 : Correcting the SQL Queries in the associate script to select only jobs of type Backup and level Full to obtain the name of the Client (otherwise, restoreJob is sometimes associated to the ID of the clientName)
- 2017-10-23 : Adding to database at which day the full is to be running. - USEFUL only if you're running ONE full every week, and diff/incr others times
- 2017-10-23 : Changing input type select to radio for storage pool
- 2017-08-17 : Adding details for each job : endtime, and calculated duration
- 2017-04-25 : Adding storage pool information table for each client
- 2016-07-12 : first commit(s)
