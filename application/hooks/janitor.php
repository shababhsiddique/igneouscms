<?php

/**
 * Cleans up mess temp files, download temps session jot!
 * 
 * @author shabab
 */
class Janitor {

   /**
    *  Clean up backup.zip if exist and sql.txt if exist
    */ 
    public function cleanbackup() {
        if (file_exists('backup.zip')) {
            unlink('backup.zip');
        }
        if (file_exists('db_cms_sql.txt')) {
            unlink("db_cms_sql.txt");
        }
    }

}
