# https://toao.net/48-replacing-smart-quotes-and-em-dashes-in-mysql

# citation
UPDATE citation SET author = REPLACE(author, 0xE28098, "'");
UPDATE citation SET author = REPLACE(author, 0xE28099, "'");
UPDATE citation SET author = REPLACE(author, 0xE2809C, '"');
UPDATE citation SET author = REPLACE(author, 0xE2809D, '"');
UPDATE citation SET author = REPLACE(author, 0xE28093, '-');
UPDATE citation SET author = REPLACE(author, 0xE28094, '--');
UPDATE citation SET author = REPLACE(author, 0xE280A6, '...');

UPDATE citation SET author = REPLACE(author, CHAR(145), "'");
UPDATE citation SET author = REPLACE(author, CHAR(146), "'");
UPDATE citation SET author = REPLACE(author, CHAR(147), '"');
UPDATE citation SET author = REPLACE(author, CHAR(148), '"');
UPDATE citation SET author = REPLACE(author, CHAR(150), '-');
UPDATE citation SET author = REPLACE(author, CHAR(151), '--');
UPDATE citation SET author = REPLACE(author, CHAR(133), '...');

UPDATE citation SET author = REPLACE(author, "\n", '');
UPDATE citation SET author = REPLACE(author, "\r", '');
UPDATE citation SET author = REPLACE(author, "\t", '');

# citation.citation
UPDATE citation SET citation = REPLACE(citation, 0xE28098, "'");
UPDATE citation SET citation = REPLACE(citation, 0xE28099, "'");
UPDATE citation SET citation = REPLACE(citation, 0xE2809C, '"');
UPDATE citation SET citation = REPLACE(citation, 0xE2809D, '"');
UPDATE citation SET citation = REPLACE(citation, 0xE28093, '-');
UPDATE citation SET citation = REPLACE(citation, 0xE28094, '--');
UPDATE citation SET citation = REPLACE(citation, 0xE280A6, '...');

UPDATE citation SET citation = REPLACE(citation, CHAR(145), "'");
UPDATE citation SET citation = REPLACE(citation, CHAR(146), "'");
UPDATE citation SET citation = REPLACE(citation, CHAR(147), '"');
UPDATE citation SET citation = REPLACE(citation, CHAR(148), '"');
UPDATE citation SET citation = REPLACE(citation, CHAR(150), '-');
UPDATE citation SET citation = REPLACE(citation, CHAR(151), '--');
UPDATE citation SET citation = REPLACE(citation, CHAR(133), '...');

UPDATE citation SET citation = REPLACE(citation, "\n", '');
UPDATE citation SET citation = REPLACE(citation, "\r", '');
UPDATE citation SET citation = REPLACE(citation, "\t", '');

# citaiton.annotation
UPDATE citation SET annotation = REPLACE(annotation, 0xE28098, "'");
UPDATE citation SET annotation = REPLACE(annotation, 0xE28099, "'");
UPDATE citation SET annotation = REPLACE(annotation, 0xE2809C, '"');
UPDATE citation SET annotation = REPLACE(annotation, 0xE2809D, '"');
UPDATE citation SET annotation = REPLACE(annotation, 0xE28093, '-');
UPDATE citation SET annotation = REPLACE(annotation, 0xE28094, '--');
UPDATE citation SET annotation = REPLACE(annotation, 0xE280A6, '...');

UPDATE citation SET annotation = REPLACE(annotation, CHAR(145), "'");
UPDATE citation SET annotation = REPLACE(annotation, CHAR(146), "'");
UPDATE citation SET annotation = REPLACE(annotation, CHAR(147), '"');
UPDATE citation SET annotation = REPLACE(annotation, CHAR(148), '"');
UPDATE citation SET annotation = REPLACE(annotation, CHAR(150), '-');
UPDATE citation SET annotation = REPLACE(annotation, CHAR(151), '--');
UPDATE citation SET annotation = REPLACE(annotation, CHAR(133), '...');

UPDATE citation SET annotation = REPLACE(annotation, "\n", '');
UPDATE citation SET annotation = REPLACE(annotation, "\r", '');
UPDATE citation SET annotation = REPLACE(annotation, "\t", '');
