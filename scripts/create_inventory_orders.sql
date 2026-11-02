CREATE TABLE IF NOT EXISTS inventory_order_request (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 id_departement INT UNSIGNED NOT NULL,
 departement_nom VARCHAR(150) NOT NULL,
 nom VARCHAR(200) NOT NULL,
 demandeur VARCHAR(200) NOT NULL DEFAULT '',
 statut ENUM('brouillon','envoyee') NOT NULL DEFAULT 'brouillon',
 version INT UNSIGNED NOT NULL DEFAULT 1,
 created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
 updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
 sent_at DATETIME NULL,
 consulted_at DATETIME NULL,
 KEY inventory_order_new (statut, consulted_at),
 CONSTRAINT inventory_order_department_fk FOREIGN KEY (id_departement) REFERENCES liste_departement(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE IF NOT EXISTS inventory_order_request_line (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 id_request INT UNSIGNED NOT NULL,
 id_article INT UNSIGNED NOT NULL,
 nom_article VARCHAR(200) NOT NULL,
 item VARCHAR(200) NOT NULL DEFAULT '',
 quantite INT UNSIGNED NOT NULL,
 UNIQUE KEY inventory_order_article (id_request, id_article),
 CONSTRAINT inventory_order_line_request_fk FOREIGN KEY (id_request) REFERENCES inventory_order_request(id),
 CONSTRAINT inventory_order_line_article_fk FOREIGN KEY (id_article) REFERENCES inventory_article(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
