<?php

class Convertor_Base {

    public function __construct() {
    }

    public function commonConvertor(array $result) {
        $data = array();
        $data['code'] = $result['code'];
        if (isset($result['code']) && ! $result['code']) {
            $data['data'] = $result['data'];
        } else {
            $data['code'] = empty($result['code']) ? 1 : $result['code'];
            $data['msg'] = $result['msg'];
        }
        return $data;
    }

    public function statusConvertor(array $result) {
        $data = array();
        $data['code'] = $result['code'];
        if (isset($result['code']) && ! $result['code']) {
            $data['data'] = $result['data'];
        } else {
            $data['code'] = empty($result['code']) ? 1 : $result['code'];
            $data['msg'] = $result['msg'];
        }
        return $data;
    }
}

?>