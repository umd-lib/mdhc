#!/bin/bash

# Fix windows "special" characters
mysql --host=127.0.0.1 --user=mdhc --password=mdhc --database=mdhc \
< scripts/fix-encoding.sql

# Export to TSV
mysql --host=127.0.0.1 --user=mdhc --password=mdhc --database=mdhc \
< scripts/export.sql \
> data/export.tsv

# Convert to CSV (using csvkit)
in2csv --tabs --format=csv --encoding=windows-1252 data/export.tsv > data/export.csv
