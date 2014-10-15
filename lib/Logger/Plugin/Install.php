<?php
/**
 * Plugin installation Class
 *
 * @author     Dominik Pfaffenbauer <dominik@pfaffenbauer.at>
 * @copyright  2014 Dominik Pfaffenbauer
 * @license    http://www.wtfpl.net/ Do What the Fuck You Want to Public License
 * @version    Release: 0.1
 */
class Logger_Plugin_Install
{
    public function createTables()
    {
        $db = Pimcore_Resource_Mysql::get();
        
        $table = "CREATE TABLE `plugin_logger` (
                  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                  `level` enum('debug','info','notice','warning','error') NOT NULL,
                  `text` text NOT NULL,
                  `date` bigint(20) NOT NULL,
                  `class` varchar(255) NOT NULL,
                  `method` varchar(255) NOT NULL,
                  `line` int(11)
                );";
                
        return $db->query($table);
    }
    
    public function dropTables()
    {
        $db = Pimcore_Resource_Mysql::get();
        
        $db->query("DROP TABLE IF EXISTS `plugin_logger`;");
    }
    
    public function isInstalled()
    {
        $db = Pimcore_Resource_Mysql::get();
        
        try
        {
            if($db->describeTable('plugin_logger'))
                return true;
        }
        catch(Exception $ex)
        {
            
        }
        
        return false;
    }
}
