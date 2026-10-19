CREATE TABLE IF NOT EXISTS appel_log_tbl (
    Id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    id_anniversaire INT NOT NULL,
    id_user INT NOT NULL,
    date_appel DATETIME NOT NULL,
    Etat VARCHAR(255) NOT NULL,
    numero VARCHAR(255) NOT NULL,
    enabled TINYINT(1) NOT NULL DEFAULT 1,
    date_rappel DATETIME NULL,
    controller_name VARCHAR(100) NOT NULL,
    method_name VARCHAR(100) NOT NULL,
    view_name VARCHAR(255) NOT NULL,
    PRIMARY KEY (Id),
    KEY idx_appel_anniversaire (id_anniversaire, enabled, date_appel),
    KEY idx_appel_rappel (enabled, Etat, date_rappel),
    KEY idx_appel_user (id_user)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Les tables anniversaire_tbl et users existantes sont MyISAM : pas de clé
-- étrangère, afin de préserver leur structure. Les IDs sont validés côté PHP.
-- Dates et heures enregistrées dans le fuseau America/Halifax.
