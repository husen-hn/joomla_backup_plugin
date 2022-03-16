<?php

use Joomla\CMS\Factory;

class BackupTable {
  static function isTableExist() {
    try {
    $db = Factory::getDBO();
    $query = $db->getQuery(true);
    $query = "SHOW TABLES LIKE 'back_plugin_jbp'";

    $db->setQuery($query);
    if(is_null($db->execute()))
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
    if(is_null($db->execute()))
      return false;

    return $db->loadObject()->date_last_backup;
  }

  static function createBackupTable() {
    $db = Factory::getDBO();
    $query = $db->getQuery(true);
    $query =
    "CREATE TABLE IF NOT EXISTS back_plugin_jbp (
      id INT AUTO_INCREMENT,
      date_last_backup DATETIME NOT NULL,
      PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    $db->setQuery($query);
    if(is_null($db->execute()))
      return false;

    return true;
  }

  static function setLastBackupDate() {
    $currentDate = new DateTime();
    $dateTime = $currentDate->format('Y-m-d H:i:s');
    $db = Factory::getDBO();
    $query = $db->getQuery(true);
    $fields = array(
      $db->quoteName("date_last_backup") . " = '$dateTime'",
    );

    $conditions = array(
      $db->quoteName('id') . ' = 2'
    );

    $query->update($db->quoteName('back_plugin_jbp'))->set($fields)->where($conditions);

    $db->setQuery($query);
    if(is_null($db->execute()))
      return false;

    return true;
  }
}
