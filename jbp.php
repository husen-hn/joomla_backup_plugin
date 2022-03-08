<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  Content.jbp
 *
 * @copyright   (C) 2022 Open Source Matters, Inc. <https://www.joomla.org>
 * @license    Apache License Version 2.0 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Plugin\CMSPlugin;

include("user_intraction/user.php");
include("backup/db_backup.php");
include("google_drive/google_drive.php");

/**
 * Joomla Back-Up plugin class.
 *
 * @since  0.0.1
 */
class PlgContentJBP extends CMSPlugin
{
  public function onAfterDispatch()
	{
    $tokenPath = __DIR__ . '/google_drive/token.json';
    if(User::isOnAdminstrator() && file_exists($tokenPath))
    {
      //TODO: check backup date to start
			DbBackup::getBackup('localhost','root','','joomladb');
      //TODO: upload backupfile to drive
      //TODO: set backup date on db
		}
  }
}
