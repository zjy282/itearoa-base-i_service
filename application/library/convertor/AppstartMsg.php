<?php

/**
 * APP启动消息convertor
 * @author ZXM
 */
class Convertor_AppstartMsg extends Convertor_Base {

    public function __construct() {
        parent::__construct();
    }

    public function getEffectiveAppStartMsgConvertor($msgList, $msgLogHistoryMsgId) {
        $msgList = array_column($msgList, null, 'id');
        $effectiveMsgList = array_diff_key($msgList, array_flip($msgLogHistoryMsgId));
        krsort($effectiveMsgList);
        $effectiveMsg = current($effectiveMsgList);
        $data = array(
            'list' => array()
        );
        if ($effectiveMsg) {
            $dataTemp['msgId'] = $effectiveMsg['id'];
            $dataTemp['pic'] = Enum_Img::getPathByKeyAndType($effectiveMsg['pic']);
            $dataTemp['msg'] = $effectiveMsg['msg'];
            $dataTemp['url'] = $effectiveMsg['url'];
            $data['list'][] = $dataTemp;
        }
        
        return $data;
    }
}