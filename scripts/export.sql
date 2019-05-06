SELECT
  citation.ID,
  citation.author,
  citation.citation,
  citation.annotation,
  codes.description AS category
FROM citation
LEFT JOIN codelookup ON citation.ID=codelookup.CitID
LEFT JOIN codes ON codelookup.CodeID=codes.ID
