#!/bin/bash

mysql --host=127.0.0.1 --user=mdhc --password=mdhc --database=mdhc \
< scripts/export.sql \
> data/export.tsv
