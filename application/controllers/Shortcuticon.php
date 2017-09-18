<?php

/**
 * 酒店快捷图标控制器类
 *
 */
class ShortcutIconController extends \BaseController {

    /**
     * @var ShortcutIconModel
     */
    private $model;
    /** @var  Convertor_ShortcutIcon */
    private $convertor;

    public function init() {
        parent::init();
        $this->model = new ShortcutIconModel();
        $this->convertor = new Convertor_ShortcutIcon();
    }

    /**
     * 获取酒店快捷图标列表
     *
     * @return Json
     */
    public function getShortcutIconListAction() {
        $param = array();
        $param ['page'] = intval($this->getParamList('page', 1));
        $limit = $this->getParamList('limit');
        $param ['limit'] = isset ($limit) ? $limit : null;
        $param['id'] = intval($this->getParamList('id'));
        $param['hotelid'] = intval($this->getParamList('hotelid'));
        $data = $this->model->getShortcutIconList($param);
        $count = $this->model->getShortcutIconCount($param);
        $data = $this->convertor->getShortcutIconListConvertor($data, $count, $param);
        $this->echoSuccessData($data);
    }


    /**
     * 根据id获取酒店快捷图标详情
     * @param int id 获取详情信息的id
     * @return Json
     */
    public function getShortcutIconDetailAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $data = $this->model->getShortcutIconDetail($id);
            $data = $this->convertor->getShortcutIconDetail($data);
        } else {
            $this->throwException(1, '查询条件错误，id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 根据id修改酒店快捷图标信息
     * @param int id 获取详情信息的id
     * @param array param 需要更新的字段
     * @return Json
     */
    public function updateShortcutIconByIdAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $param = array();
            $param['hotelid'] = $this->getParamList('hotelid');
            $param['key'] = $this->getParamList('key');
            $param['sort'] = $this->getParamList('sort');
            $param['title_lang1'] = $this->getParamList('title_lang1');
            $param['title_lang2'] = $this->getParamList('title_lang2');
            $param['title_lang3'] = $this->getParamList('title_lang3');

            $checkKey = $this->model->getShortcutIconList(array('key' => $param['key'], 'hotelid' => $param['hotelid']));
            $keyIdList = array_column($checkKey, 'id');
            if (count($keyIdList) > 1 || (count($keyIdList) == 1 && !in_array($id, $keyIdList))) {
                $this->throwException(2, 'KEY已经存在');
            }

            $data = $this->model->updateShortcutIconById($param, $id);
            $data = $this->convertor->statusConvertor($data);
        } else {
            $this->throwException(1, 'id不能为空');
        }
        $this->echoSuccessData($data);
    }

    /**
     * 添加酒店快捷图标信息
     * @param array param 需要新增的信息
     * @return Json
     */
    public function addShortcutIconAction() {
        $param = array();
        $param['hotelid'] = intval($this->getParamList('hotelid'));
        $param['sort'] = intval($this->getParamList('sort'));
        $param['key'] = trim($this->getParamList('key'));
        $param['title_lang1'] = trim($this->getParamList('title_lang1'));
        $param['title_lang2'] = trim($this->getParamList('title_lang2'));
        $param['title_lang3'] = trim($this->getParamList('title_lang3'));

        $checkKeyCount = $this->model->getShortcutIconCount(array('key' => $param['key'], 'hotelid' => $param['hotelid']));
        if ($checkKeyCount > 0) {
            $this->throwException(2, 'KEY已经存在');
        }

        $data = $this->model->addShortcutIcon($param);
        $data = $this->convertor->statusConvertor(array(
            'id' => $data
        ));
        $this->echoSuccessData($data);
    }

}
