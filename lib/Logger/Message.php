<?php
/**
 * Message Class
 *
 * @author     Dominik Pfaffenbauer <dominik@pfaffenbauer.at>
 * @copyright  2014 Dominik Pfaffenbauer
 * @license    http://www.wtfpl.net/ Do What the Fuck You Want to Public License
 * @version    Release: 0.1
 */
 
class Logger_Message extends Pimcore_Model_Abstract
{
    public $id;
    public $level;
    public $text;
    public $date;
    public $class;
    public $method;
    public $line;
    
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = (int)$id;
        return $this;
    }

    public function getLevel()
    {
        return $this->level;
    }

    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }

    public function getText()
    {
        return $this->text;
    }

    public function getDate()
    {
        if(!$this->date instanceof Zend_Date)
            $this->date = new Zend_Date($this->date);

        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    public function getClass()
    {
        return $this->class;
    }

    public function setClass($class)
    {
        $this->class = $class;
        return $this;
    }
    
    public function getMethod()
    {
        return $this->method;
    }

    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }
    
    public function getLine()
    {
        return $this->line;
    }

    public function setLine($line)
    {
        $this->line = (int)$line;
        return $this;
    }

    public function save()
    {
        if ($this->getId()) {
            $this->update();
        } else {
            $this->getResource()->create();
        }

        return $this;
    }

    /**
     * @param integer $id
     * @return Poll_Answer
     */
    public static function getById($id)
    {
        $voting = new self();
        $voting->getResource()->getById($id);
        return $voting;
    }

}
