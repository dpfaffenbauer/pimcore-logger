<?
/**
 * Log Class
 *
 * @author     Dominik Pfaffenbauer <dominik@pfaffenbauer.at>
 * @copyright  2014 Dominik Pfaffenbauer
 * @license    http://www.wtfpl.net/ Do What the Fuck You Want to Public License
 * @version    Release: 0.1
 */
class Log
{
    public $DEBUG = "debug";
    public $INFO = "info";
    public $NOTICE = "notice";
    public $WARN = "warning";
    public $ERROR = "error";

    public static function __callStatic($name, $arguments) 
    {
        $caller = get_calling_class();
        $method = strtoupper($name);

        self::createMessage($arguments[0], get_user_prop(get_class($this), $method), $caller['class'], $caller['function'], $caller['line']);
    }
    
    protected static function createMessage($text, $level, $caller, $method, $line)
    {
        $message = new Logger_Message();
        $message->setLevel($level);
        $message->setText($text);
        $message->setDate(new Zend_Date());
        $message->setClass($caller);
        $message->setMethod($method);
        $message->setLine($line);
        $message->save();
        
        return $message;
    }
}

function get_user_prop($className, $property) 
{
    if(!class_exists($className)) return null;
    if(!property_exists($className, $property)) return null;

    $vars = get_class_vars($className);
    return $vars[$property];
}

function get_calling_class() 
{
    //get the trace
    $trace = debug_backtrace();

    // Get the class that is asking for who awoke it
    $class = $trace[1]['class'];

    // +1 to i cos we have to account for calling this function
    for ( $i=1; $i<count( $trace ); $i++ ) 
    {
        if ( isset( $trace[$i] ) ) // is it set?
        {
             if ( $class != $trace[$i]['class'] ) // is it a different class
             {
                 return $trace[$i];
             }
        }
    }
}