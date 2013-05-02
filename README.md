# Aptostat_api
The API-part of Aptostat. It handles API-requests and fetches data from the database.

## Installation
Note: Most of the commands might require sudo
### Setting up your server
#### Initial setup your server
You need:
- Ubuntu 12.04 LTS x64

Install the following with apt-get
- apache2
- php5
- mysql-server
- curl
- php5-memcached
- php5-curl
- php5-mysql
- git

    $ sudo apt-get install apache2 php5 mysql-server curl php5-memcached php5-curl php5-mysql git

#### Configure apache
Configure your DNS with a domain to the server
Apart from setting up apache as normal you have to:

- Enable rewrite engine

    $ sudo a2enmod rewrite

- Change your Virtual host settings (Typically in sites-available named default)
- Add /web to your DocumentRoot. Example: `/var/www/web`. (From a default of /var/www)
- Change Directory `/var/www/` into `/var/www/web`.
- `AllowOverride all` in <Directory /var/www/web/>

Example file: (first few lines)
```xml
<VirtualHost *:80>
    ServerAdmin webmaster@localhost

    DocumentRoot /var/www/web
    <Directory />
        Options FollowSymLinks
        AllowOverride None
    </Directory>
    <Directory /var/www/web>
        Options Indexes FollowSymLinks MultiViews
        AllowOverride All
        Order allow,deny
        allow from all
    </Directory>
[...]
```
Restart apache2
    $ sudo service apache2 restart

#### Download and install Composer
Navigate into home or any other place to store files temporarily:
    $ curl -sS https://getcomposer.org/installer | php
    $ mv composer.phar /usr/local/bin/composer

### Set up Aptostat
#### Clone the files
    $ git clone https://github.com/nox27/aptostat_api.git
    $ sudo mv aptostat_api/* /var/www/

`/var/www` will be described as projectRoot folder.

run `composer install` in projectRoot folder.

Apart from what is specified in composer.json:

You need to build the database and classes for propel:

Create a `build.properties` file (based on `build.properties.example` and update contents.

Build model and create tables:

     $ vendor/bin/propel-gen om
     $ vendor/bin/propel-gen sql

Note: If you are having problems with  permission try giving the execute-rights to phing.php. (Path will pop up in the error you might get)

Create database and database user:

    $ mysql -h localhost -u root -p
    > CREATE DATABASE aptostat;
    > CREATE USER 'aptostat'@'localhost' IDENTIFIED BY 'aptostat';
    > GRANT ALL ON aptostat.* TO 'aptostat'@'localhost';
    > exit;
    $ vendor/bin/propel-gen insert-sql

Create `runtime-conf.xml` (based on `runtime-conf.xml.example` and update contents. Then run:

    $ vendor/bin/propel-gen convert-conf

Create log dir, lock dir and make them writable:

    $ mkdir -p app/log
    $ mkdir -p app/lock

    #Ubuntu
    $ sudo setfacl -R -m u:www-data:rwx -m u:`whoami`:rwx app/log app/lock
    $ sudo setfacl -dR -m u:www-data:rwx -m u:`whoami`:rwx app/log app/lock

Note: You might need to install 'acl' first.

## Usage

### Report
#### List reports
    GET: http://your.url/api/report
Gives you a list over reports.

- Parameters:
    - showHidden (0 or 1)
        - default: 0
        - Show hidden reports (optional)
    - limit (int)
        - default: null
        - Limit the number of reports in the request (optional)
    - offset (int)
            - default: null
            - Offset the request (optional)

#### Get specific report by id
    GET: http://apto.vlab.iu.hio.no/api/report/{id}
Gives you a specific report and its history

#### Modify report
    PUT: http://apto.vlab.iu.hio.no/api/report/{id}
Modify a specific report. Parameters sent in the http body in JSON format

- Parameters:
    - hidden (bool)
        - default: false
        - Change hidden status on the report
    - flag (WARNING | CRITICAL | INTERNAL | IGNORED | RESPONDING | RESOLVED)
        - Change the flag in the report

### Incident
#### List incidents
    GET: http://your.url/api/incident
Gives you a list over reports.

- Parameters:
    - limit (int)
        - default: null
        - Limit the number of reports in the request (optional)
    - offset (int)
            - default: null
            - Offset the request (optional)

#### Get a specific incident by id
    GET: http://url/api/incident/{id}
Gives you a specific incident and more detailed information

#### List all reports connected to a specific incident
    GET: http://your.url/api/incident/{incidentId}/report
Gives you a list over reports connected to a specific incident.

#### List messages connected to a specific incident
    GET: http://your.url/api/incident/{incidentId}/message
Gives you a list over messages connected to a specific incident.

#### Create a new incident
    POST: http://url/api/incident
Create a new incident. Parameters sent in the http body in JSON format.

- Parameters:
    - title (string)
        - A descriptive title of the problem (mandatory)
    - author (string)
        - Authors name or nickname (mandatory)
    - messageText (string)
        - The message you wish to save (mandatory)
    - flag (WARNING | CRITICAL | INTERNAL | IGNORED | RESPONDING | RESOLVED)
        - Set the flag of the incident (mandatory)
    - hidden (bool)
        - default: false
        - Whether or not to hide the incident (optional)
    - reports (int or array)
        - Include the reportIds of the reports connected to this incident.

Example:
```json
{
    "title": "A descriptive title of the problem",
    "author": "Jacob",
    "messageText": "A message which will be the main body of the incident. Write reasons and estimated time for fix",
    "flag": "WARNING",
    "hidden": false,
    "reports": [1,2,3]
}
```

#### Modify a specific incident
    PUT: http://your.url/api/incident/{id}
Modify an incident. Parameters sent in the http body in JSON format.

- Parameters
    - reportAction (addReports | removeReport)
        - defines whether or not to add or to remove the listed reports
    - reports (int or array)
        - The report as a single int or an array to either remove or to add.
    - title (string)
        - A new title you want to modify into

Example - Couple new reports to an incident:
```json
{
    "reportAction": "addReports",
    "reports": [1,2,4]
}
```

Example - Decouple reports from an incident:
```json
{
    "reportAction": "removeReports",
    "reports": 5
}
```

Example - Change the title of an incident:
```json
{
    "title": "New title"
}
```

### Message
#### List messages
    GET: http://your.url/api/message
Gives you a list over messages.

- Parameters:
    - showHidden (0 or 1)
        - default: 0
        - Show hidden reports (optional)
    - limit (int)
        - default: null
        - Limit the number of reports in the request (optional)
    - offset (int)
            - default: null
            - Offset the request (optional)

####Get a specific message by id
    GET: http://url/api/message/{id}
Gives you a specific message

#### Add a new message to an incident
    POST: http://your.url/api/incident/{id}/message
Add a new message to an incident. Parameters sent in the http body in JSON format.

- Parameters
    - author (string)
        - Authors name or nickname (mandatory)
    - messageText (string)
        - The message you wish to save (mandatory)
    - flag (WARNING | CRITICAL | INTERNAL | IGNORED | RESPONDING | RESOLVED)
        - Set the flag (mandatory)
    - hidden (bool)
        - default: false
        - Whether or not to hide it (optional)

Example:
```json
{
    "author": "Jones Smith",
    "messageText": "A new message with some update about the situation. Perhaps a new estimated time of resolution",
    "flag": "RESOLVED",
    "hidden": true
}
```

#### Modify an existing message
    PUT: http://your.url/api/message/{messageId}
Modify an existing message. Parameters sent in the http body in JSON format.

- Parameters
    - author (string)
        - Authors name or nickname
    - messageText (string)
        - The message you wish to modify
    - flag (WARNING | CRITICAL | INTERNAL | IGNORED | RESPONDING | RESOLVED)
        - Set the flag
    - hidden (bool)
        - default: false
        - Whether or not to hide it (optional)

Example:
```json
{
    "author": "Mr. Smith Jones",
    "messageText": "You should edit an existing a message here. Perhaps a typo?",
    "flag": "RESOLVED",
    "hidden": false
}
```

### Get live status on the services
    GET: http://your.url/api/live
Get live status on the services

### Get 7-days history on the status for the services
    GET: http://your.url/api/uptime
Get uptime statistics the last 7 days

### Killswitch
#### Get killswitch status
    GET: http://your.url/api/killswitch
Get killswitch status; whether or not the system is currently fetching new reports.

#### Modify: Turn on the killswitch (Stop the system from collecting new reports)
    PUT: http://your.url/api/killswitch
Modify an incident. Parameters sent in the http body in JSON format.

- Parameters
    - action (on | off)
        - defines you action. To turn it off or not (Mandatory)

Example - Turn on killswitch:
```json
{
    "action": "on"
}
```

Example - Turn off killswitch:
```json
{
    "action": "off"
}
```
