-- Fix Car Rentals page: "A database error occurred"
-- Cause: missing `currency` column on `cars` (migration not run on production)
-- Run in cPanel → phpMyAdmin on the StayNets database.
-- Skip this if the column already exists.

ALTER TABLE `cars`
  ADD COLUMN `currency` VARCHAR(3) NOT NULL DEFAULT 'RWF' AFTER `price_to_buy`;

UPDATE `cars` SET `currency` = 'RWF' WHERE `currency` IS NULL OR `currency` = '';
