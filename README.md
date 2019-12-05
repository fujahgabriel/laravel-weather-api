
##  Weather Temperature API TWO way communication

A RESTful API

### Installation
Change database config in .env file

Migrate schema

Serve application

Run `php artisan serve`

#### PART A



#### CLI Usage

Ability to import csv with the option to specify how many records should be imported using CLI

```bash
$ php artisan import:csv /path/to/file rows
```
E.g
```bash
$ php artisan import:csv /document/record.csv 5
```

#### API endpoints

Return daily temperature records between two dates passed: parameters date ("from" and "to")
http://127.0.0.1:8000/api/search

Updating the temperature value for any date that has a record on the system: parameters: ("temperature" and "date") in json format
http://127.0.0.1:8000/update

Displaying daily temperature values for the last 7 days
http://127.0.0.1:8000/recent

#### PART B

<p align="center"><img src="https://i.imgur.com/u3ermq1.png" width="400"></p>

1) A web interface for displaying daily temperature values for the last 7 days

2) A web interface for updating the temperature value for any date that has a
record on the system


