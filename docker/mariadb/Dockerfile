FROM mariadb:10.2

ARG MY_CNF_FILE

COPY ./my.cnf /etc/mysql/conf.d/my.cnf
#COPY ./docker-entrypoint-initdb /docker-entrypoint-initdb

CMD ["mysqld"]

EXPOSE 3306
