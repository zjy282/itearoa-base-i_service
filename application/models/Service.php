<?php

/**
 * Class ServiceModel
 */
class ServiceModel extends \BaseModel
{

    /**
     * @var Dao_TaskCategories
     */
    private $_daoCategory;

    /**
     * @var Dao_Task
     */
    private $_daoTask;

    const ERROR_NOG_CHANGED = "Not changed";

    public function __construct()
    {
        parent::__construct();
        $this->_daoCategory = new Dao_TaskCategories();
        $this->_daoTask = new Dao_Task();
    }

    /**
     * @param array $param
     * @return array
     */
    public function getTaskCategoryList(array $param)
    {
        $paramList = array();
        $param['id'] ? $paramList['id'] = $param['id'] : false;
        $param['hotelid'] ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        $paramList['limit'] = $param['limit'];
        $paramList['page'] = $param['page'];
        return $this->_daoCategory->getTaskCategoryList($paramList);
    }

    /**
     * @param array $param
     * @return int
     */
    public function getTaskCategoryCount(array $param)
    {
        $paramList = array();
        $param['id'] ? $paramList['id'] = intval($param['id']) : false;
        $param['hotelid'] ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        return $this->_daoCategory->getTaskCategoriesCount($paramList);
    }

    /**
     * Update task category by ID
     *
     * @param $param
     * @param $id
     * @throws Exception
     * @return bool
     */
    public function updateTaskCategoryById($param, $id)
    {
        $info = array();
        !is_null($param['title_lang1']) ? $info['title_lang1'] = trim($param['title_lang1']) : false;
        !is_null($param['title_lang2']) ? $info['title_lang2'] = trim($param['title_lang2']) : false;
        !is_null($param['title_lang3']) ? $info['title_lang3'] = trim($param['title_lang3']) : false;
        !is_null($param['parentid']) ? $info['parentid'] = intval($param['parentid']) : false;
        if (empty($info) || $id <= 0) {
            $this->throwException('Lack of param', 1);
        }
        $result = $this->_daoCategory->updateCategory($info, $id);
        if (!$result) {
            $this->throwException(self::ERROR_NOG_CHANGED, 2);
        } else {
            return true;
        }
    }

    /**
     * Add a new task category
     *
     * @param $param
     * @return int
     */
    public function addTaskCategory($param)
    {
        $info = array();
        $param['hotelid'] > 0 ? $info['hotelid'] = $param['hotelid'] : $this->throwException('Lack of param', 1);
        $param['title_lang1'] ? $info['title_lang1'] = $param['title_lang1'] : $this->throwException('Lack of param', 1);
        $info['title_lang2'] = $param['title_lang2'];
        $info['title_lang3'] = $param['title_lang3'];
        $info['parentid'] = $param['parentid'];
        return $this->_daoCategory->addCategory($info);
    }

    /**
     * Get task list
     *
     * @param array $params
     * @return array
     */
    public function getTaskList(array $params): array
    {
        $paramList = array();
        is_null($params['limit']) ? false : $paramList['limit'] = intval($params['limit']);
        is_null($params['page']) ? false : $paramList['page'] = intval($params['page']);
        is_null($params['hotelid']) ? false : $paramList['hotelid'] = intval($params['hotelid']);
        is_null($params['category_id']) ? false : $paramList['category_id'] = intval($params['category_id']);
        is_null($params['status']) ? false : $paramList['status'] = intval($params['status']);
        is_null($params['title_lang1']) ? false : $paramList['title_lang1'] = trim($params['title_lang1']);
        is_null($params['id']) ? false : $paramList['id'] = intval($params['id']);


        return $this->_daoTask->getTaskList($paramList);
    }

    /**
     * Get task count
     *
     * @param array $params
     * @return int
     */
    public function getTaskCount(array $params)
    {
        $paramList = array();
        is_null($params['hotelid']) ? false : $paramList['hotelid'] = intval($params['hotelid']);
        is_null($params['category_id']) ? false : $paramList['category_id'] = intval($params['category_id']);
        is_null($params['status']) ? false : $paramList['status'] = intval($params['status']);
        is_null($params['title_lang1']) ? false : $paramList['title_lang1'] = trim($params['title_lang1']);
        return $this->_daoTask->getTasksCount($paramList);
    }

    /**
     * Update task by ID
     *
     * @param $param
     * @param $id
     * @throws Exception
     * @return bool
     */
    public function updateTaskById(array $params, int $id)
    {
        $info = array();
        //task info
        is_null($params['title_lang1']) ? false : $info['title_lang1'] = trim($params['title_lang1']);
        is_null($params['title_lang2']) ? false : $info['title_lang2'] = trim($params['title_lang2']);
        is_null($params['title_lang3']) ? false : $info['title_lang3'] = trim($params['title_lang3']);
        is_null($params['pic']) ? false : $info['pic'] = trim($params['pic']);
        is_null($params['price']) ? false : $info['price'] = floatval($params['price']);
        is_null($params['category_id']) ? false : $info['category_id'] = intval($params['category_id']);
        is_null($params['status']) ? false : $info['status'] = intval($params['status']);
        //task process info
        is_null($params['department_id']) ? false : $info['department_id'] = intval($params['department_id']);
        is_null($params['staff_id']) ? false : $info['staff_id'] = intval($params['staff_id']);
        is_null($params['highest_level']) ? false : $info['highest_level'] = intval($params['highest_level']);
        is_null($params['level_interval_1']) ? false : $info['level_interval_1'] = intval($params['level_interval_1']);
        is_null($params['level_interval_2']) ? false : $info['level_interval_2'] = intval($params['level_interval_2']);
        is_null($params['level_interval_3']) ? false : $info['level_interval_3'] = intval($params['level_interval_3']);
        is_null($params['level_interval_4']) ? false : $info['level_interval_4'] = intval($params['level_interval_4']);
        is_null($params['level_interval_5']) ? false : $info['level_interval_5'] = intval($params['level_interval_5']);
        is_null($params['sms']) ? false : $info['sms'] = intval($params['sms']);
        is_null($params['email']) ? false : $info['email'] = intval($params['email']);

        if (empty($info) || $id <= 0) {
            $this->throwException('Lack of param', 1);
        }
        $result = $this->_daoTask->updateTask($info, $id);
        if (!$result) {
            $this->throwException(self::ERROR_NOG_CHANGED, 2);
        } else {
            return true;
        }
    }

    /**
     * Add a new task
     *
     * @param $param
     * @return int
     */
    public function addTask(array $params): int
    {
        $info = array();
        is_null($params['title_lang1']) ? $this->throwException("Lack title", 1) : $info['title_lang1'] = trim($params['title_lang1']);
        is_null($params['title_lang2']) ? false : $info['title_lang2'] = trim($params['title_lang2']);
        is_null($params['title_lang3']) ? false : $info['title_lang3'] = trim($params['title_lang3']);
        is_null($params['pic']) ? false : $info['pic'] = trim($params['pic']);
        is_null($params['price']) ? false : $info['price'] = floatval($params['price']);
        is_null($params['category_id']) ? $this->throwException("Lack category_id", 1) : $info['category_id'] = intval($params['category_id']);
        is_null($params['status']) ? false : $info['status'] = intval($params['status']);
        return $this->_daoTask->addTask($info);
    }

}
