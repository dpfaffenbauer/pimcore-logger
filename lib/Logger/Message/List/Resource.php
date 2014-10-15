<?php
/**
 * Resource Class for Messages List
 *
 * @author     Dominik Pfaffenbauer <dominik@pfaffenbauer.at>
 * @copyright  2014 Dominik Pfaffenbauer
 * @license    http://www.wtfpl.net/ Do What the Fuck You Want to Public License
 * @version    Release: 0.1
 */
class Logger_Message_List_Resource extends Pimcore_Model_List_Resource_Mysql_Abstract
{
    public function load()
    {
        $items = array();
        $itemsData = $this->db->fetchAll(sprintf("SELECT * FROM %s%s%s%s",
            Logger_Message_Resource::TABLE_NAME,
            $this->getCondition(),
            $this->getOrder(),
            $this->getOffsetLimit()
        ), $this->model->getConditionVariables());

        foreach ($itemsData as $data) {
            $item = new Logger_Message();
            $item->setValues($data);

            $items[] = $item;
        }

        $this->model->setMessages($items);

        return $items;
    }

    /**
     * @return integer
     */
    public function getTotalCount()
    {
        return (int)$this->db->fetchOne(sprintf(
            "SELECT COUNT(*) as total FROM %s%s",
            HeadMeta_MetaTag_Resource::TABLE_NAME,
            $this->getCondition()
        ), $this->model->getConditionVariables());
    }

}
