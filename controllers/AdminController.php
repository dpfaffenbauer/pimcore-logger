<?php
/**
 * AdminController for Logger Plugin
 *
 * @author     Dominik Pfaffenbauer <dominik@pfaffenbauer.at>
 * @copyright  2014 Dominik Pfaffenbauer
 * @license    http://www.wtfpl.net/ Do What the Fuck You Want to Public License
 * @version    Release: 0.1
 */

class Logger_AdminController extends Pimcore_Controller_Action_Admin 
{
    public function getMessagesAction()
    {
        $total = new Logger_Message_List();
        $total = count($total->load());
        
        $list = new Logger_Message_List();
        $list->setLimit($this->getParam("limit", 40));
        $list->setOffset($this->getParam("start", 0));
        $list->setOrderKey($this->getParam("sort", "id"));
        $list->setOrder($this->getParam("dir", "ASC"));
        
        $messages = array();

        foreach($list->load() as $message)
        {
            $messages[] = array(
                "id" => $message->getId(),
                "level" => $message->getLevel(),
                "text" => $message->getText(),
                "date" => $message->getDate()->get("dd.MM.yyyy hh:mm"),
                "class" => $message->getClass(),
                "method" => $message->getMethod() . ":" . $message->getLine()
            );
        }
        
        $this->_helper->json(array("success" => true, "messages" => $messages, "total" => $total));
    }
}
