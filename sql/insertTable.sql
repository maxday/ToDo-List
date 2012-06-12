-- phpMyAdmin SQL Dump
-- version 2.6.4-pl3
-- http://www.phpmyadmin.net
-- 
-- Serveur: db2657.1and1.fr
-- Généré le : Mardi 15 Mai 2012 à 21:32
-- Version du serveur: 5.0.91
-- Version de PHP: 5.3.3-7+squeeze9
-- 
-- Base de données: `db362233246`
-- 

-- 
-- Contenu de la table `MYTODO_USER`
-- 

INSERT INTO `MYTODO_USER` VALUES ('4fb2ac296cb276.69528154', '0cc175b9c0f1b6a831c399e269772661', NULL, 'a', 1, 0, '2012-05-15', 0, 0);
INSERT INTO `MYTODO_USER` VALUES ('4fb2ac817c62b3.98435945', NULL, 'tutu@tutu.com', 'b', 1, 1, '2012-05-15', 0, 0);


-- 
-- Contenu de la table `MYTODO_TAG`
-- 

INSERT INTO `MYTODO_TAG` VALUES ('4fb2ad45ca3832.31621383', 'UTC', '2012-05-15', NULL, '4fb2ac296cb276.69528154');
INSERT INTO `MYTODO_TAG` VALUES ('4fb2ad676c1b09.70544903', 'FAMILLE', '2012-05-15', NULL, '4fb2ac296cb276.69528154');
INSERT INTO `MYTODO_TAG` VALUES ('4fb2adde752d24.32814995', 'COUSE', '2012-05-15', NULL, '4fb2ac817c62b3.98435945');
INSERT INTO `MYTODO_TAG` VALUES ('4fb2ade740cea7.17256240', 'VOYAGES', '2012-05-15', NULL, '4fb2ac817c62b3.98435945');

-- 
-- Contenu de la table `MYTODO_TASK`
-- 

INSERT INTO `MYTODO_TASK` VALUES ('4fb2ad12ef2b78.30573048', '2012-05-15', NULL, NULL, 'Ceci est la première tâche (c', NULL, '+1', 0, 1, '4fb2ad45ca3832.31621383', '4fb2ac296cb276.69528154');
INSERT INTO `MYTODO_TASK` VALUES ('4fb2ad8ff042c5.68498844', '2012-05-15', NULL, NULL, 'Ceci est la seconde tâche', NULL, '-2', 1, 2, '4fb2ad676c1b09.70544903', '4fb2ac296cb276.69528154');
INSERT INTO `MYTODO_TASK` VALUES ('4fb2ae1bba5fa2.99991321', '2012-05-15', NULL, NULL, 'Première tâche de b (no tag)', NULL, '+2', 0, 3, NULL, '4fb2ac817c62b3.98435945');
INSERT INTO `MYTODO_TASK` VALUES ('4fb2ae739497f4.61444638', '2012-05-15', NULL, NULL, 'seconde tâche de b (with tag)', NULL, '+2', 1, 4, '4fb2ade740cea7.17256240', '4fb2ac817c62b3.98435945');

