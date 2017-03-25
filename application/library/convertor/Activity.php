<?php

/**
 * 活动convertor
 * @author ZXM
 */
class Convertor_Activity extends Convertor_Base {

    public function __construct() {
        parent::__construct();
    }

    public function getActivityListConvertor($activityList, $tagList, $activityCount, $param) {
        $tagListNew = array();
        foreach ($tagList as $tag) {
            $tagListNew[$tag['id']] = $this->handlerMultiLang('title', $tag);
        }
        
        $data = array(
            'list' => array()
        );
        foreach ($activityList as $activity) {
            $activityTemp = array();
            $activityTemp['id'] = $activity['id'];
            $activityTemp['title'] = $this->handlerMultiLang('title', $activity);
            $activityTemp['article'] = Enum_Img::getPathByKeyAndType($this->handlerMultiLang('article', $activity));
            $activityTemp['tagId'] = $activity['tagid'];
            $activityTemp['tagName'] = $tagListNew[$activityTemp['tagId']];
            $activityTemp['createtime'] = $activity['createtime'];
            $activityTemp['updatetime'] = $activity['updatetime'];
            $data['list'][] = $activityTemp;
        }
        $data['total'] = $activityCount;
        $data['page'] = $param['page'];
        $data['limit'] = $param['limit'];
        $data['nextPage'] = Util_Tools::getNextPage($data['page'], $data['limit'], $data['total']);
        return $data;
    }
}