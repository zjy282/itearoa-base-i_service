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

    public function __construct()
    {
        parent::__construct();
        $this->_daoCategory = new Dao_TaskCategories();
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
            $this->throwException('DB fail', 2);
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
}
