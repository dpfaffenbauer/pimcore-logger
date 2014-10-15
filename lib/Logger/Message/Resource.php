<?php
/**
 * Resource Class for Message
 *
 * @author     Dominik Pfaffenbauer <dominik@pfaffenbauer.at>
 * @copyright  2014 Dominik Pfaffenbauer
 * @license    http://www.wtfpl.net/ Do What the Fuck You Want to Public License
 * @version    Release: 0.1
 */
 
class Logger_Message_Resource extends Pimcore_Model_Resource_Mysql_Abstract
{
    const TABLE_NAME = 'plugin_logger';

    /**
     * @var Pimcore_Resource_Wrapper
     */
    protected $db;

    /**
     * @var Poll_Answer
     */
    protected $model;

    /**
     * Contains the valid database colums
     *
     * @var array
     */
    protected $_validColumns = array();

    /**
     * Get the valid database columns from database
     *
     */
    public function init()
    {
        $this->_validColumns = $this->getValidTableColumns(self::TABLE_NAME);
    }

    /**
     * Get the data for the object by the given id
     *
     * @param integer $id
     */
    public function getById($id)
    {
        $select = new Zend_Db_Select($this->db->getResource());
        $data = $select
            ->from(self::TABLE_NAME)
            ->where('id = ?', $id)
            ->query()->fetch();

        if ($data && $data["id"] > 0) {
            $this->assignVariablesToModel($data);
        } else {
            throw new Exception("Meesage with ID '$id' doesn't exists");
        }
    }

    /**
     * Create a new record for the object in database,
     *
     */
    public function create()
    {
        $values = get_object_vars($this->model);

        foreach ($values as $key => $value) {
            if (in_array($key, $this->_validColumns)) {

                if($key == "date" && $value instanceof Zend_Date)
                    $data[$key] = $value->get(Zend_Date::TIMESTAMP);
                else
                    $data[$key] = $value;
            }
        }

        $this->db->insert(self::TABLE_NAME, $data);
        $this->model->setId($this->db->lastInsertId());
    }

    /**
     * Save changes to database, it's an good idea to use save() instead
     *
     */
    public function update()
    {
        $values = get_object_vars($this->model);

        foreach ($values as $key => $value) {
            if (in_array($key, $this->_validColumns))
            {
                if($key == "date" && $value instanceof Zend_Date)
                    $data[$key] = $value->get(Zend_Date::TIMESTAMP);
                else
                    $data[$key] = $value;
            }
        }

        $this->db->update(
            self::TABLE_NAME,
            $data,
            array('id = ?' => $this->model->getId())
        );
    }

    /**
     * Deletes object from database.
     *
     */
    public function delete()
    {
        $this->db->delete(self::TABLE_NAME, array('id = ?' => $this->model->getId()));
    }

}
