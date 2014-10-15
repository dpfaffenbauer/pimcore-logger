<?php

/**
 * Messages List
 *
 * @author     Dominik Pfaffenbauer <dominik@pfaffenbauer.at>
 * @copyright  2014 Dominik Pfaffenbauer
 * @license    http://www.wtfpl.net/ Do What the Fuck You Want to Public License
 * @version    Release: 0.1
 */
 
class Logger_Message_List extends Pimcore_Model_List_Abstract
    implements
        Zend_Paginator_Adapter_Interface,
        Zend_Paginator_AdapterAggregate,
        Iterator
{
    public $messages = array();
    public $validOrderKeys = array(
        'id'
    );

    public function _construct()
    {
	 	$this->setOrderKey("id");
    }

    public function isValidOrderKey($key)
    {
        if (in_array($key, $this->validOrderKeys)) {
            return true;
        }
        return false;
    }

    public function getItems($offset, $itemCountPerPage) {
        $this->setOffset($offset);
        $this->setLimit($itemCountPerPage);
        return $this->load();
    }

    public function count() {
        return $this->getTotalCount();
    }

    public function getPaginatorAdapter() {
        return $this;
    }

    public function getMessages()
    {
        if (empty($this->messages)) {
            $this->load();
        }
        return $this->messages;
    }

    public function setMessages(array $message)
    {
        $this->messages = $messages;
        return $this;
    }


    public function rewind() {
        $this->getMessages();
        reset($this->messages);
    }

    public function current() {
        $this->getMessages();
        return current($this->messages);
    }

    public function key() {
        $this->getMessages();
        return key($this->messages);
    }

    public function next() {
        $this->getMessages();
        return next($this->messages);
    }

    public function valid() {
        $this->getMessages();
        return $this->current() !== false;
    }

}
