<?php

/**
 * Class ShareIconModel
 * 分享平台管理
 */
class ShareIconModel extends \BaseModel {

    private $dao;

    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_ShareIcon();
    }

    /**
     * 获取ShareIcon列表信息
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getShareIconList(array $param) {
        $paramList = array();
        $param['id'] ? $paramList['id'] = intval($param['id']) : false;
        $param['hotelid'] ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        $paramList['limit'] = $param['limit'];
        $paramList['page'] = $param['page'];
        return $this->dao->getShareIconList($paramList);
    }

    /**
     * 获取ShareIcon数量
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getShareIconCount(array $param) {
        $paramList = array();
        $param['id'] ? $paramList['id'] = intval($param['id']) : false;
        $param['hotelid'] ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        return $this->dao->getShareIconCount($paramList);
    }

    /**
     * 根据id查询ShareIcon信息
     *
     * @param
     *            int id 查询的主键
     * @return array
     */
    public function getShareIconDetail($id) {
        $result = array();
        if ($id) {
            $result = $this->dao->getShareIconDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新ShareIcon信息
     *
     * @param
     *            array param 需要更新的信息
     * @param
     *            int id 主键
     * @return array
     */
    public function updateShareIconById($param, $id) {
        $result = false;
        // 自行添加要更新的字段,以下是age字段是样例
        if ($id) {
            $info['age'] = intval($param['age']);
            $result = $this->dao->updateShareIconById($info, $id);
        }
        return $result;
    }

    /**
     * ShareIcon新增信息
     *
     * @param
     *            array param 需要增加的信息
     * @return array
     */
    public function addShareIcon($param) {
        // 自行添加要添加的字段,以下是age字段是样例
        $info['age'] = intval($param['age']);
        return $this->dao->addShareIcon($info);
    }

    /**
     * 根据hotelId修改ShareIcon信息
     * @param int hotelId 物业的id
     * @param array param 分享平台信息
     * @return Json
     */
    public function updateShareByHotelId($param, $hotelId) {
        $oldShareInfo = $this->dao->getShareIconList(array('hotelid' => $hotelId));
        $shareInfo = explode(',', $param['share']);
        $deleteInfo = array();
        foreach ($oldShareInfo as $oldData) {
            if (in_array($oldData['key'], $shareInfo)) {
                $newSort = array_search($oldData['key'], $shareInfo) + 1;
                if ($newSort != $oldData['sort']) {
                    $this->dao->updateShareIconById(array('sort' => $newSort), $oldData['id']);
                }
                unset($shareInfo[$newSort - 1]);
            } else {
                $deleteInfo[] = $oldData['id'];
            }
        }

        if ($deleteInfo) {
            $this->dao->deleteShareIconByIds($deleteInfo, $hotelId);
        }

        $newData = array();
        foreach ($shareInfo as $key => $share) {
            $newData[] = array('key' => $share, 'sort' => $key + 1, 'hotelid' => $hotelId);
        }
        $this->dao->batchAddShareIcon($newData);
        return true;
    }
}
