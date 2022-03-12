<?php

use Joomla\CMS\Factory;

class BackupTable {
  static function isTableExist() {
    try {
    $db = Factory::getDBO();
    $query = $db->getQuery(true);
    $query = "select 1 from `back_plugin_jbp` LIMIT 1";

    $db->setQuery($query);
    if(is_null($db->loadObject()))
      return false;

      return true;

    } catch (Exception $ex) {
      return false;
    }
  }

  static function getLastBackupDate() {
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);
    $query
        ->select($db->quoteName(array('date_last_backup')))
        ->from($db->quoteName('back_plugin_jbp'))
        ->where($db->quoteName('id'). ' = '. $db->quote(2));

  $db->setQuery($query);
  if(is_null($db->loadObject()))
    return false;

  return $db->loadObject()->date_last_backup;
  }

  static function createBackupTable() {
    $db = Factory::getDBO();
    $query = $db->getQuery(true);
    $query = "CREATE TABLE IF NOT EXISTS `back_plugin_jbp` (
      `id` int(10) NOT NULL,
      `date_last_backup` DATETIME NOT NULL,
      PRIMARY KEY (`id`) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    $db->setQuery($query);
    if(is_null($db->loadObject()))
      return false;

    return true;
  }

  static function setLastBackupDate() {
    $db = Factory::getDBO();
    $query = $db->getQuery(true);
    $query = "INSERT INTO `back_plugin_jbp` (`id`, `date_last_backup`)
    VALUES (2,CURRENT_TIME())";

    $db->setQuery($query);
    if(is_null($db->loadObject()))
      return false;

    return true;
  }


}
