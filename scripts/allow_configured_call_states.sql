-- Les valeurs autorisées sont définies dans app/config/options.php (EtatAppel)
-- et validées par BirthdayController. Conserve les états des appels existants.
ALTER TABLE appel_log_tbl MODIFY COLUMN Etat VARCHAR(255) NOT NULL;
