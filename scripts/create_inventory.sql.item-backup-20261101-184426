CREATE TABLE IF NOT EXISTS liste_departement (
 id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
 departement VARCHAR(150) NOT NULL,
 observations TEXT NOT NULL,
 enabled TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE IF NOT EXISTS inventory_article (
 id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
 departement INT UNSIGNED NOT NULL,
 nom VARCHAR(200) NOT NULL,
 observations TEXT NOT NULL,
 enabled TINYINT(1) NOT NULL DEFAULT 1,
 UNIQUE KEY inventory_article_department (id, departement),
 KEY inventory_article_active (departement, enabled),
 CONSTRAINT inventory_article_dept_fk FOREIGN KEY (departement) REFERENCES liste_departement(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE IF NOT EXISTS inventory_record (
 id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
 id_article INT UNSIGNED NOT NULL,
 id_departement INT UNSIGNED NOT NULL,
 observation TEXT NOT NULL,
 `date` DATE NOT NULL,
 nb INT NOT NULL,
 enabled TINYINT(1) NOT NULL DEFAULT 1,
 KEY inventory_record_stock (id_departement, id_article, enabled),
 CONSTRAINT inventory_record_article_fk FOREIGN KEY (id_article, id_departement)
 REFERENCES inventory_article(id, departement)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
