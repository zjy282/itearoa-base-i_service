<?php

/**
 * Class AppVersionModel
 * APP版本管理
 */
class AppVersionModel extends \BaseModel {

    private $dao;

    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_AppVersion();
    }

    /**
     * 获取AppVersion列表信息
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getAppVersionList(array $param) {
        $param['id'] ? $paramList['id'] = $param['id'] : false;
        $param['platform'] ? $paramList['platform'] = $param['platform'] : false;
        isset($param['forced']) ? $paramList['forced'] = intval($param['forced']) : false;
        isset($param['latest']) ? $paramList['latest'] = intval($param['latest']) : false;
        $param['groupid'] ? $paramList['groupid'] = $param['groupid'] : false;
        $paramList['limit'] = $param['limit'];
        $paramList['page'] = $param['page'];
        return $this->dao->getAppVersionList($paramList);
    }

    /**
     * 获取AppVersion数量
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getAppVersionCount(array $param) {
        $paramList = array();
        $param['id'] ? $paramList['id'] = $param['id'] : false;
        $param['platform'] ? $paramList['platform'] = $param['platform'] : false;
        isset($param['forced']) ? $paramList['forced'] = intval($param['forced']) : false;
        isset($param['latest']) ? $paramList['latest'] = intval($param['latest']) : false;
        $param['groupid'] ? $paramList['groupid'] = $param['groupid'] : false;
        return $this->dao->getAppVersionCount($paramList);
    }

    /**
     * 根据id查询AppVersion信息
     *
     * @param
     *            int id 查询的主键
     * @return array
     */
    public function getAppVersionDetail($id) {
        $result = array();
        if ($id) {
            $result = $this->dao->getAppVersionDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新AppVersion信息
     *
     * @param
     *            array param 需要更新的信息
     * @param
     *            int id 主键
     * @return array
     */
    public function updateAppVersionById($param, $id) {
        $result = false;
        if ($id) {
            !is_null($param['platform']) ? $info['platform'] = $param['platform'] : false;
            !is_null($param['forced']) ? $info['forced'] = $param['forced'] : false;
            !is_null($param['version']) ? $info['version'] = $param['version'] : false;
            !is_null($param['description']) ? $info['description'] = $param['description'] : false;
            !is_null($param['latest']) ? $info['latest'] = $param['latest'] : false;
            $result = $this->dao->updateAppVersionById($info, $id);
        }
        return $result;
    }

    /**
     * AppVersion新增信息
     *
     * @param
     *            array param 需要增加的信息
     * @return array
     */
    public function addAppVersion($param) {
        !is_null($param['platform']) ? $info['platform'] = $param['platform'] : false;
        !is_null($param['forced']) ? $info['forced'] = $param['forced'] : false;
        !is_null($param['version']) ? $info['version'] = $param['version'] : false;
        !is_null($param['description']) ? $info['description'] = $param['description'] : false;
        !is_null($param['latest']) ? $info['latest'] = $param['latest'] : false;
        !is_null($param['groupid']) ? $info['groupid'] = $param['groupid'] : false;
        $info['createtime'] = time();
        return $this->dao->addAppVersion($info);
    }

    /**
     * 根据设备获取APP最新的版本信息
     *
     * @param
     *            int platform 设备类型 1IOS，2安卓
     * @return array
     */
    public function getLatestAppVersionByPlatform($param) {
        $platform = intval($param['platform']);
        $groupid = intval($param['groupid']);

        if (!array_key_exists($platform, Enum_Platform::getPlatformNameList())) {
            $this->throwException('设备类型参数错误', 2);
        }
        $result = $this->dao->getLatestAppVersionByPlatform($platform, $groupid);
        if (!$result) {
            $this->throwException('设备没有可用版本', 3);
        }
        return $result;
    }
}
