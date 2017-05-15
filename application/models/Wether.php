<?php

/**
 * Class WetherModel
 * 天气信息Model
 */
class WetherModel extends \BaseModel {

    /**
     * 根据城市获取雅虎天气信息
     * @param $wetherKey
     * @return array|bool|mixed|string
     */
    public function getWeatherFromYahoo($wetherKey) {
        $cache = Cache_Redis::getInstance();
        $cacheKey = "weatherInfo_yahoo_{$wetherKey}";
        $weatherInfo = $cache->get($cacheKey);
        if (! $weatherInfo) {
            $BASE_URL = "http://query.yahooapis.com/v1/public/yql";
            $yql_query = 'select item from weather.forecast where woeid in (select woeid from geo.places(1) where text="' . $wetherKey . '")';
            $yql_query_url = $BASE_URL . "?q=" . urlencode($yql_query) . "&format=json";
            $session = curl_init($yql_query_url);
            curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
            $json = curl_exec($session);
            $phpObj = json_decode($json, true);
            $todayWether = $phpObj['query']['results']['channel']['item']['forecast'][0];
            $weather = $this->code2char($todayWether['code']);
            $weatherInfo = array(
                'temperatureFrom' => intval($this->temperatureChange($todayWether['low'])) . "℃",
                'temperatureTo' => intval($this->temperatureChange($todayWether['high'])) . "℃",
                'weather' => $weather,
                'weatherEn' => $todayWether['text'],
                'weatherCode' => $todayWether['code']
            );
            if ($todayWether) {
                $re = $cache->set($cacheKey, json_encode($weatherInfo), 6 * 3600);
            }
        } else {
            $weatherInfo = json_decode($weatherInfo, true);
        }
        return $weatherInfo;
    }

    /**
     * 气温转换
     * @param $temperature
     * @return float
     */
    private function temperatureChange($temperature) {
        return ($temperature - 32) / 1.8;
    }

    /**
     * 天气编号和中文对应
     * @param $code
     * @return string
     */
    private function code2char($code) {
        switch ($code) {
            case 0:
                return '龙卷风';
            case 1:
                return '热带风暴';
            case 2:
                return '暴风';
            case 3:
                return '大雷雨';
            case 4:
                return '雷阵雨';
            case 5:
                return '雨夹雪';
            case 6:
                return '雨夹雹';
            case 7:
                return '雪夹雹';
            case 8:
                return '冻雾雨';
            case 9:
                return '细雨';
            case 10:
                return '冻雨';
            case 11:
                return '阵雨';
            case 12:
                return '阵雨';
            case 13:
                return '阵雪';
            case 14:
                return '小阵雪';
            case 15:
                return '高吹雪';
            case 16:
                return '雪';
            case 17:
                return '冰雹';
            case 18:
                return '雨淞';
            case 19:
                return '粉尘';
            case 20:
                return '雾';
            case 21:
                return '薄雾';
            case 22:
                return '烟雾';
            case 23:
                return '大风';
            case 24:
                return '风';
            case 25:
                return '冷';
            case 26:
                return '阴';
            case 27:
                return '多云';
            case 28:
                return '多云';
            case 29:
                return '局部多云';
            case 30:
                return '局部多云';
            case 31:
                return '晴';
            case 32:
                return '晴';
            case 33:
                return '转晴';
            case 34:
                return '转晴';
            case 35:
                return '雨夹冰雹';
            case 36:
                return '热';
            case 37:
                return '局部雷雨';
            case 38:
                return '偶有雷雨';
            case 39:
                return '偶有雷雨';
            case 40:
                return '偶有阵雨';
            case 41:
                return '大雪';
            case 42:
                return '零星阵雪';
            case 43:
                return '大雪';
            case 44:
                return '局部多云';
            case 45:
                return '雷阵雨';
            case 46:
                return '阵雪';
            case 47:
                return '局部雷阵雨';
            default:
                return '读取失败';
        }
    }
}


