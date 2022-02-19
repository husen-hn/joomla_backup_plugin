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

include("user.php");
include("db_backup.php");

/**
 * Joomla Back-Up plugin class.
 *
 * @since  0.0.1
 */
class PlgContentJBP extends CMSPlugin
{
  public function onAfterDispatch()
	{
    if(User::isOnAdminstrator())
    {
			DbBackup::getBackup('localhost','root','','joomladb');
		}
  }
}
