-- Exécuter après résolution des anciens appels sans correspondance unique.
ALTER TABLE appel_log_tbl ADD COLUMN id_anniversaire INT NULL AFTER Id;
UPDATE appel_log_tbl l
JOIN (
    SELECT logs.Id AS log_id, MIN(a.id) AS id_anniversaire
    FROM (SELECT Id, Id_resident, date_appel FROM appel_log_tbl) logs
    JOIN anniversaire_tbl a ON a.id_resident = logs.Id_resident
        AND a.annee = YEAR(logs.date_appel) AND a.motif = 'Birthday'
    GROUP BY logs.Id HAVING COUNT(*) = 1
) matches ON matches.log_id = l.Id
SET l.id_anniversaire = matches.id_anniversaire;
-- Vérifier qu'aucune ligne n'a id_anniversaire NULL avant cette étape.
ALTER TABLE appel_log_tbl
    MODIFY id_anniversaire INT NOT NULL,
    DROP INDEX idx_appel_resident,
    DROP COLUMN Id_resident,
    ADD KEY idx_appel_anniversaire (id_anniversaire, enabled, date_appel);
