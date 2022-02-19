<?php
class User {
  static public function isOnAdminstrator()
  {
    $app = JFactory::getApplication();
    if($app->getName() === "administrator")
      return true;
    else
      return false;
  }
}
