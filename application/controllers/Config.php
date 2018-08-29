<?php

use Frankli\Itearoa\Models\Config;

/**
 * config
 *
 */
class ConfigController extends \BaseController
{

    /**
     * Get config detail
     */
    public function getConfigDetailAction()
    {
        $result = array(
            'code' => 0,
            'message' => 'success',
            'data' => array()
        );
        $params = array();
        intval($this->getParamList('id')) ?
            $params['id'] = intval($this->getParamList('id')) : false;
        intval($this->getParamList('hotelid')) > 0 ?
            $params['hotelid'] = intval($this->getParamList('hotelid')) : false;
        intval($this->getParamList('userid')) ?
            $params['userid'] = intval($this->getParamList('userid')) : false;
        intval($this->getParamList('staffid')) ?
            $params['staffid'] = intval($this->getParamList('staffid')) : false;
        !is_null($this->getParamList('name')) ?
            $params['name'] = intval($this->getParamList('name')) : false;

        $config = Config::where($params)->first();
        if ($config) {
            $result['data'][] = $config->toArray();
        }
        $this->echoJson($result);
    }

    public function updateConfigAction()
    {
        if (is_null($this->getParamList('id')) || is_null($this->getParamList('value'))) {
            $this->throwException(1, 'Lack param[id or value]');
        }
        $id = intval($this->getParamList('id'));
        $value = trim($this->getParamList('value'));
        $result = Config::where('id', '=', $id)->update(['value' => $value]);
        if ($result) {
            $result = [
                'code' => 0,
                'message' => 'success'
            ];
        } else {
            $result = [
                'code' => 1,
                'message' => 'fail'
            ];
        }
        $this->echoJson($result);
    }

}
