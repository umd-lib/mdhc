SELECT
  TRIM(REPLACE(REPLACE(citation.author, "\n", ""), "\t", "")) AS authors,
  TRIM(REPLACE(REPLACE(citation.citation, "\n", ""), "\t", "")) AS citation,
  TRIM(REPLACE(REPLACE(IFNULL(citation.annotation,""), "\n", ""), "\t", "")) AS 'annotation/notes',
  TRIM(REPLACE(REPLACE(GROUP_CONCAT(codes.description SEPARATOR '; '), "\n", ""), "\t", "")) AS categories
FROM citation, codelookup, codes
WHERE
  citation.ID=codelookup.CitID
  AND codelookup.CodeID=codes.ID
GROUP BY citation.ID