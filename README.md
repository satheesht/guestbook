# Guestbook

Guestbook is a simple application to create, reply messages
  - New, modify, remove and reply messages
  - Dockerized
  - User registration login

# Installation

```sh
$ #clone the
$ git clone https://github.com/satheesht/guestbook.git guestbook
$ cd guestbook
$ docker-compose build
$ docker-compose up -d

$ #restore database dump
$ mysql -u root -p guestbook -P33061 -h127.0.0.1 < ./guestbook.sql
$ #password: rootpassword
```
Access the application:
  - Please restore this dump to the MySQL after you brought the container up ``./guestbook/guestbook.sql``
  - Make sure the port 80 not open with any other services (usually a web server)
  - The MySQL is exposed to a port 33061
  - You can access the application here ``https://localhost/home``

**NOTE: No thirdparty library or framework used tod evelop this application. I got a little help from composer to autoload classes ;)**