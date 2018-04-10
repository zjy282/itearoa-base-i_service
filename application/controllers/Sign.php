<?php

/**
 * Class SignController
 */
class SignController extends \BaseController
{

    /**
     *
     * @var SignModel
     */
    private $model;

    /**
     *
     * @var Convertor_Sign
     */
    private $convertor;

    public function init()
    {
        parent::init();
        $this->model = new SignModel();
        $this->convertor = new Convertor_Sign();
    }

    /**
     * Action for get sign history list
     */
    public function getSignListAction()
    {
        $params = array();
        $params['hotelid'] = $this->getParamList('hotelid');
        $params['start'] = $this->getParamList('start');
        $params['end'] = $this->getParamList('end');
        $params['type'] = trim($this->getParamList('type'));
        $params['page'] = $this->getParamList('page');
        $params['limit'] = $this->getParamList('limit');

        $data = $this->model->getSignReport($params);
        $count = $this->model->getSignReportCount($params);
        $result = $this->convertor->getSignListConvertor($data, $count, $params);

        $this->echoSuccessData($result);
    }


    public function getSignCategoryListAction()
    {
        $params = array();
        $params['hotelid'] = $this->getParamList('hotelid');
        $params['status'] = $this->getParamList('status');
        $params['id'] = trim($this->getParamList('id'));
        $params['page'] = $this->getParamList('page');
        $params['limit'] = $this->getParamList('limit');

        $data = $this->model->getSignCategoryList($params);
        $count = $this->model->getSignCategoryCount($params);
        $result = $this->convertor->getSignCategoryListConvertor($data, $count, $params);

        $this->echoSuccessData($result);
    }

    public function addSignCategoryAction()
    {
        $param = array();
        $param['hotelid'] = $this->getParamList('hotelid');
        $param['pic'] = $this->getParamList('pic');
        $param['status'] = intval($this->getParamList('status'));
        $param['title_lang1'] = $this->getParamList('title_lang1');
        $param['title_lang2'] = $this->getParamList('title_lang2');
        $param['title_lang3'] = intval($this->getParamList('title_lang3'));
        $data = $this->model->addSignCategory($param);
        $data = $this->convertor->statusConvertor(array('id' => $data));
        $this->echoSuccessData($data);
    }

    public function updateSignCategoryAction()
    {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $param = array();
            $param ['hotelid'] = $this->getParamList('hotelid');
            $param ['status'] = $this->getParamList('status');
            $param ['pic'] = $this->getParamList('pic');
            $param ['title_lang1'] = $this->getParamList('title_lang1');
            $param ['title_lang2'] = $this->getParamList('title_lang2');
            $param ['title_lang3'] = $this->getParamList('title_lang3');
            $data = $this->model->updateSignCategoryById($param, $id);
            $data = $this->convertor->statusConvertor($data);
            $this->echoSuccessData($data);
        } else {
            $this->throwException(1, 'id不能为空');
        }
    }

    public function getSignItemListAction()
    {
        $params = array();
        $params['hotelid'] = $this->getParamList('hotelid');
        $params['category_id'] = trim($this->getParamList('category_id'));
        $params['status'] = $this->getParamList('status');
        $params['id'] = trim($this->getParamList('id'));
        $params['page'] = $this->getParamList('page');
        $params['limit'] = $this->getParamList('limit');

        $data = $this->model->getSignItemsList($params);
        $categories = $this->model->getSignCategoryList(array('hotelid' => $params['hotelid']));
        $count = $this->model->getSignItemsCount($params);
        $result = $this->convertor->getSignItemListConvertor($data, $categories, $count, $params);

        $this->echoSuccessData($result);
    }

    public function addSignItemAction()
    {
        $param = array();
        $param['hotelid'] = $this->getParamList('hotelid');
        $param['category_id'] = $this->getParamList('category_id');
        $param['status'] = intval($this->getParamList('status'));
        $param['title_lang1'] = $this->getParamList('title_lang1');
        $param['title_lang2'] = $this->getParamList('title_lang2');
        $param['title_lang3'] = intval($this->getParamList('title_lang3'));
        $data = $this->model->addSignItem($param);
        $data = $this->convertor->statusConvertor(array('id' => $data));
        $this->echoSuccessData($data);
    }

    public function updateSignItemAction()
    {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $param = array();
            $param ['hotelid'] = $this->getParamList('hotelid');
            $param ['status'] = $this->getParamList('status');
            $param ['category_id'] = $this->getParamList('category_id');
            $param ['title_lang1'] = $this->getParamList('title_lang1');
            $param ['title_lang2'] = $this->getParamList('title_lang2');
            $param ['title_lang3'] = $this->getParamList('title_lang3');
            $data = $this->model->updateSignItemById($param, $id);
            $data = $this->convertor->statusConvertor($data);
            $this->echoSuccessData($data);
        } else {
            $this->throwException(1, 'id不能为空');
        }
    }

}
