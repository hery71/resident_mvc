CREATE TABLE IF NOT EXISTS `2ndchoice` (
    `id` TINYINT UNSIGNED NOT NULL DEFAULT 1,
    `Breakfast` TEXT NOT NULL,
    `lunch` TEXT NOT NULL,
    `diner` TEXT NOT NULL,
    `enabled` TINYINT(1) NOT NULL DEFAULT 1,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
