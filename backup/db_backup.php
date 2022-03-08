<?php
class DbBackup
{
  static function getBackup($dbhost,$dbusername,$dbpassword,$dbname)
  {
    $db = new mysqli($dbhost, $dbusername, $dbpassword, $dbname);

    $tables = array();
    $result = $db->query("SHOW TABLES");
    while($row = $result->fetch_row()) {
      $tables[] = $row[0];
    }

    $return = '';

    foreach($tables as $table){
      $result = $db->query("SELECT * FROM $table");
      $numColumns = $result->field_count;

      $result2 = $db->query("SHOW CREATE TABLE $table");
      $row2 = $result2->fetch_row();

      $return .= "\n\n".$row2[1].";\n\n";

      for($i = 0; $i < $numColumns; $i++) {
        while($row = $result->fetch_row()) {
          $return .= "INSERT INTO $table VALUES(";
          for($j=0; $j < $numColumns; $j++) {
            $row[$j] = addslashes($row[$j]);
            $row[$j] = $row[$j];
            if (isset($row[$j])) {
              $return .= '"'.$row[$j].'"' ;
            } else {
              $return .= '""';
            }
            if ($j < ($numColumns-1)) {
              $return.= ',';
            }
          }
          $return .= ");\n";
        }
      }

      $return .= "\n\n\n";
    }

    $dir = __DIR__ . "/db_file";

      // delete previus backup if exist
      if (file_exists($dir)) {
        DbBackup::deleteBackupFile($dir);
      }

      mkdir($dir);
      $handle = fopen(__DIR__ . '/db_file/your_db_'.time().'.sql','w+');
      fwrite($handle,$return);
      fclose($handle);
  }

  static public function deleteBackupFile($dir) {
    $files = glob( $dir . '*', GLOB_MARK );
        foreach( $files as $file )
        {
          $dir_handle = opendir( $dir );
          if( $dir_handle )
          {
            while( $file = readdir( $dir_handle ) )
            {
              if($file != "." && $file != "..")
              {
                if( ! is_dir( $dir."/".$file ) )
                {
                  unlink( $dir."/".$file );
                }
                else
                {
                  delete_directory($dir.'/'.$file);
                }
              }
            }
            closedir( $dir_handle );
          }
          rmdir( $dir );
        }
  }
}
