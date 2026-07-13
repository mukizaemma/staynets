-- Fix for: "A database error occurred" on StayNets homepage
-- Cause: missing why_choose_us_items table (migration not run on production)
-- Run this in cPanel → phpMyAdmin (or MySQL) on the StayNets database.

CREATE TABLE IF NOT EXISTS `why_choose_us_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NULL,
  `icon` varchar(32) NULL DEFAULT '★',
  `sort_order` smallint unsigned NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `why_choose_us_items` (`title`, `description`, `icon`, `sort_order`, `is_active`, `created_at`, `updated_at`)
SELECT * FROM (
  SELECT 'Tailor-Made Tours' AS `title`, 'Tailor-made tours across Rwanda & East Africa.' AS `description`, '★' AS `icon`, 1 AS `sort_order`, 1 AS `is_active`, NOW() AS `created_at`, NOW() AS `updated_at`
  UNION ALL SELECT 'Local Expert Guides', 'Professional, local guides who know the region deeply.', '★', 2, 1, NOW(), NOW()
  UNION ALL SELECT 'Rich Experiences', 'Wildlife, primates, culture & scenic adventures.', '★', 3, 1, NOW(), NOW()
  UNION ALL SELECT 'For Every Budget', 'Options for both luxury and budget-friendly travel.', '★', 4, 1, NOW(), NOW()
  UNION ALL SELECT 'Hassle-Free Support', 'Hassle-free booking and complete travel support.', '★', 5, 1, NOW(), NOW()
) AS seed
WHERE NOT EXISTS (SELECT 1 FROM `why_choose_us_items` LIMIT 1);
