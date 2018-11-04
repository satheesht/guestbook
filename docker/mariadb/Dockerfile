FROM mariadb:10.2

ARG MY_CNF_FILE

COPY ./my.cnf /etc/mysql/conf.d/my.cnf
COPY ./docker-entrypoint-initdb.d/guestbook.sql /docker-entrypoint-initdb.d/

CMD ["mysqld"]

EXPOSE 3306
