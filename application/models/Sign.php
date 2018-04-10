<?php

/**
 * Class SignModel
 */
class SignModel extends \BaseModel
{

    private $dao;

    public function __construct()
    {
        parent::__construct();
        $this->dao = new Dao_Sign();
    }


    /**
     * @param $params
     * @return array
     */
    public function getSignReport($params)
    {
        $paramList = array();
        $params['hotelid'] ? $paramList['hotelid'] = intval($params['hotelid']) : false;
        $params['type'] ? $paramList['type'] = trim($params['type']) : false;
        $params['start'] ? $paramList['start'] = trim($params['start']) : false;
        $params['end'] ? $paramList['end'] = trim($params['end']) : false;
        $paramList['limit'] = $params['limit'];
        $paramList['page'] = $params['page'];

        return $this->dao->getSignList($paramList);
    }

    /**
     * @param $params
     * @return int
     */
    public function getSignReportCount($params): int
    {
        $paramList = array();
        $params['hotelid'] ? $paramList['hotelid'] = intval($params['hotelid']) : false;
        $params['type'] ? $paramList['type'] = trim($params['type']) : false;
        $params['start'] ? $paramList['start'] = trim($params['start']) : false;
        $params['end'] ? $paramList['end'] = trim($params['end']) : false;

        return $this->dao->getSignCount($paramList);
    }

    public function getSignCategoryList($params): array
    {
        $paramList = array();
        $params['hotelid'] ? $paramList['hotelid'] = intval($params['hotelid']) : false;
        $params['id'] ? $paramList['id'] = intval($params['id']) : false;
        !is_null($params['status']) ? $paramList['status'] = intval($params['status']) : false;
        $paramList['limit'] = $params['limit'];
        $paramList['page'] = $params['page'];

        return $this->dao->getSignCategoryList($paramList);
    }

    public function getSignCategoryCount($params): int
    {
        $paramList = array();
        $params['hotelid'] ? $paramList['hotelid'] = intval($params['hotelid']) : false;
        $params['id'] ? $paramList['id'] = intval($params['id']) : false;
        !is_null($params['status']) ? $paramList['status'] = intval($params['status']) : false;

        return $this->dao->getSignCategoriesCount($paramList);
    }

    public function addSignCategory($param)
    {
        $info = array();
        isset($param['hotelid']) ? $info['hotelid'] = $param['hotelid'] : false;
        isset($param['status']) ? $info['status'] = $param['status'] : false;
        isset($param['pic']) ? $info['pic'] = $param['pic'] : false;
        isset($param['title_lang1']) ? $info['title_lang1'] = $param['title_lang1'] : false;
        isset($param['title_lang2']) ? $info['title_lang2'] = $param['title_lang2'] : false;
        isset($param['title_lang3']) ? $info['title_lang3'] = $param['title_lang3'] : false;
        return $this->dao->addCategory($info);
    }

    /**
     * @param array $param
     * @param int $id
     * @return bool|number|string
     */
    public function updateSignCategoryById(array $param, int $id)
    {
        $result = false;
        if ($id) {
            $info = array();
            !is_null($param['hotelid']) ? $info['hotelid'] = $param['hotelid'] : false;
            !is_null($param['status']) ? $info['status'] = $param['status'] : false;
            !is_null($param['pic']) ? $info['pic'] = $param['pic'] : false;
            !is_null($param['title_lang1']) ? $info['title_lang1'] = $param['title_lang1'] : false;
            !is_null($param['title_lang2']) ? $info['title_lang2'] = $param['title_lang2'] : false;
            !is_null($param['title_lang3']) ? $info['title_lang3'] = $param['title_lang3'] : false;
            $result = $this->dao->updateCategory($info, $id);
        }
        return $result;
    }

    public function getSignItemsList($params): array
    {
        $paramList = array();
        $params['hotelid'] ? $paramList['hotelid'] = intval($params['hotelid']) : false;
        $params['category_id'] ? $paramList['category_id'] = intval($params['category_id']) : false;
        !is_null($params['status']) ? $paramList['status'] = intval($params['status']) : false;
        $paramList['limit'] = $params['limit'];
        $paramList['page'] = $params['page'];

        return $this->dao->getSignItems($paramList);
    }

    public function getSignItemsCount($params): int
    {
        $paramList = array();
        $params['hotelid'] ? $paramList['hotelid'] = intval($params['hotelid']) : false;
        $params['category_id'] ? $paramList['category_id'] = intval($params['category_id']) : false;
        !is_null($params['status']) ? $paramList['status'] = intval($params['status']) : false;

        return $this->dao->getSignItemsCount($paramList);
    }

    public function addSignItem($param)
    {
        $info = array();
        isset($param['hotelid']) ? $info['hotelid'] = $param['hotelid'] : false;
        isset($param['status']) ? $info['status'] = $param['status'] : false;
        isset($param['category_id']) ? $info['category_id'] = $param['category_id'] : false;
        isset($param['title_lang1']) ? $info['title_lang1'] = $param['title_lang1'] : false;
        isset($param['title_lang2']) ? $info['title_lang2'] = $param['title_lang2'] : false;
        isset($param['title_lang3']) ? $info['title_lang3'] = $param['title_lang3'] : false;
        return $this->dao->addItem($info);
    }

    public function updateSignItemById(array $param, int $id)
    {
        $result = false;
        if ($id) {
            $info = array();
            !is_null($param['hotelid']) ? $info['hotelid'] = $param['hotelid'] : false;
            !is_null($param['status']) ? $info['status'] = $param['status'] : false;
            !is_null($param['category_id']) ? $info['category_id'] = $param['category_id'] : false;
            !is_null($param['title_lang1']) ? $info['title_lang1'] = $param['title_lang1'] : false;
            !is_null($param['title_lang2']) ? $info['title_lang2'] = $param['title_lang2'] : false;
            !is_null($param['title_lang3']) ? $info['title_lang3'] = $param['title_lang3'] : false;
            $result = $this->dao->updateItem($info, $id);
        }
        return $result;
    }
}
