<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  Content.jbp
 *
 * @copyright   (C) 2022 Open Source Matters, Inc. <https://www.joomla.org>
 * @license    Apache License Version 2.0 or later; see LICENSE.txt
 */

use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Factory;

defined('_JEXEC') or die;

include("user_intraction/user.php");
include("backup/db_backup.php");
include("backup/db/backup_table.php");

/**
 * Joomla Back-Up plugin class.
 *
 * @since  0.0.1
 */
class PlgContentJBP extends CMSPlugin
{
  public function onAfterDispatch()
	{
    $googleDrivetokenPath = __DIR__ . '/google_drive/token.json';
    if(User::isOnAdminstrator() && file_exists($googleDrivetokenPath))
    {
      // check backup_date table is exist or not
      // if(!BackupTable::isTableExist()) {
      //   BackupTable::createBackupTable();
      // }

      $lastBackupDate = BackupTable::getLastBackupDate();
      if(!$lastBackupDate) {
        BackupTable::setLastBackupDate();
      } else {
        //TODO: check last backup date and set limit to start backup process
      }
      DbBackup::getBackup('localhost','root','','joomladb');
      //TODO: upload backupfile to drive
      //TODO: delete backup file
      //TODO: update backup date on db

		}
  }
}
