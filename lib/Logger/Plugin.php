<?php
/**
 * Pimcore Plugin Class
 *
 * @author     Dominik Pfaffenbauer <dominik@pfaffenbauer.at>
 * @copyright  2014 Dominik Pfaffenbauer
 * @license    http://www.wtfpl.net/ Do What the Fuck You Want to Public License
 * @version    Release: 0.1
 */

class Logger_Plugin  extends Pimcore_API_Plugin_Abstract implements Pimcore_API_Plugin_Interface {
    
    /**
     * @var Zend_Translate
     */
    protected static $_translate;
    
    public function preDispatch()
    {
        require_once(PIMCORE_PLUGINS_PATH . '/Logger/lib/Log.php');
    }
    
    public static function install (){
        try 
        {
            $install = new Logger_Plugin_Install();
            $install->createTables();
        } 
        catch(Exception $e) 
        {
            logger::crit($e);
            return self::getTranslate()->_('logger_install_failed');
        }

        return self::getTranslate()->_('logger_installed_successfully');
    }
    
    public static function uninstall ()
    {
        try 
        {
            $install = new Logger_Plugin_Install();
            $install->dropTables();

            return self::getTranslate()->_('logger_uninstalled_successfully');
        } 
        catch (Exception $e) 
        {
            Logger::crit($e);
            return self::getTranslate()->_('logger_uninstall_failed');
        }
    }

    public static function isInstalled () 
    {
        $install = new Logger_Plugin_Install();
        
        return $install->isInstalled();;
    }

    /**
     * @return string
     */
    public static function getTranslationFileDirectory()
    {
        return PIMCORE_PLUGINS_PATH . '/Logger/static/texts';
    }

    /**
     * @param string $language
     * @return string path to the translation file relative to plugin direcory
     */
    public static function getTranslationFile($language)
    {
        if (is_file(self::getTranslationFileDirectory() . "/$language.csv")) {
            return "/Logger/static/texts/$language.csv";
        } else {
            return '/Logger/static/texts/en.csv';
        }
    }

    /**
     * @return Zend_Translate
     */
    public static function getTranslate()
    {
        if(self::$_translate instanceof Zend_Translate) {
            return self::$_translate;
        }

        try {
            $lang = Zend_Registry::get('Zend_Locale')->getLanguage();
        } catch (Exception $e) {
            $lang = 'en';
        }

        self::$_translate = new Zend_Translate(
            'csv',
            PIMCORE_PLUGINS_PATH . self::getTranslationFile($lang),
            $lang,
            array('delimiter' => ',')
        );
        return self::$_translate;
    }


}
