# MDHC

Maryland History and Culture Bibliography, PHP 5.3 app with Docker

## Running docker

Place a copy of the mdhc MySQL database dump file in the data directory.

```
docker-compose build
docker-compose up
```

Alternatively, manually load or re-load the database dump file

```
cat data/*.sql | docker exec -i mdhc_mysql_1 /usr/bin/mysql --user=root --password=123456 mdhc
```

## URLs/Ports

* <http://localhost:8080/> - MDHC website
* <http://localhost:8080/admin> - MDHC admin interface
* <http://localhost:8081/> - phpMyAdmin

A MySQL client (such as MySQL Workbench) can connect to the database on
port 3306.

## Exporting data

```
bash scripts/export.sh
```

Will output to data/export.tsv

## TODO

* Determine if character set encoding is being handled properly
* Run the export automaticaly using the mysql container

## License

See the [LICENSE](LICENSE.md) file for license rights and limitations (Apache 2.0).
