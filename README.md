# Aptostat_api
The API-part of Aptostat. It handles API-requests and fetches data from the database.

## Environment (Requirements)
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

- You need Pingdom access crededtials for the Api for Live information:
    - Username
    - Password
    - API-token