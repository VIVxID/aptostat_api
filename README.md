# Aptostat_api
The API-part of Aptostat. It handles API-requests and fetches data from the database.

## Installation
Apart from what is specified in composer.json:

You need to build the database and classes for propel:

    # May require sudo
    $ pear channel-discover pear.phing.info
    $ pear install phing/phing
    $ pear install Log

Create a `build.properties` file (based on `build.properties.example` and update contents.

Build model and create tables:

     $ vendor/bin/propel-gen om
     $ vendor/bin/propel-gen sql

Create database and database user:

    $ mysql -h localhost -u root -p
    > CREATE DATABASE aptostat_api;
    > CREATE USER 'aptostat'@'localhost' IDENTIFIED BY 'aptostat';
    > GRANT ALL ON aptostat_api.* TO 'aptostat'@'localhost';
    > exit;
    $ vendor/bin/propel-gen insert-sql

Create `runtime-conf.xml` and run:

    $ vendor/bin/propel-gen convert-conf

Create log dir and make it writable:

    $ mkdir -p app/log
    # Mac OS X
    $ sudo chmod +a "_www allow delete,write,append,file_inherit,directory_inherit" app/log
    $ sudo chmod +a "`whoami` allow delete,write,append,file_inherit,directory_inherit" app/log

- You need Pingdom access crededtials for the Api for Live information, as well as uptime stat:
    - Username
    - Password
    - API-token

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

### Get a specific incident by id
    GET: http://url/api/incident/{id}
Gives you a specific incident and more detailed information

### Create a new incident
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
    "flag": WARNING,
    "hidden": false,
    "reports": [1,2,3]
}
```

### Modify a specific incident
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

### Add a new message to an incident
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

### Modify an existing message
    PUT: http://your.url/api/incident/{incidentId}/message/{messageId}
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

### Get 7-days history on the status for the services