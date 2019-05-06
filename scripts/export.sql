SELECT
  citation.author AS authors,
  citation.citation,
  IFNULL(citation.annotation,"") AS 'annotation/notes',
  GROUP_CONCAT(codes.description SEPARATOR '; ') AS categories
FROM citation, codelookup, codes
WHERE
  citation.ID=codelookup.CitID
  AND codelookup.CodeID=codes.ID
GROUP BY citation.ID