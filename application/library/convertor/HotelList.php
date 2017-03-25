<?php

/**
 * 物业列表convertor
 * @author ZXM
 */
class Convertor_HotelList extends Convertor_Base {

    public function __construct() {
        parent::__construct();
    }

    public function getEffectiveHotelListConvertor($list) {
        $data = array(
            'list' => array()
        );
        $cityIdList = array_column($list, 'cityid');
        $cityModel = new CityModel();
        $cityInfoList = $cityModel->getCityList(array(
            'id' => $cityIdList
        ));
        $cityInfoList = array_column($cityInfoList, null, 'id');
        foreach ($list as $hotel) {
            $dataTemp = array();
            $dataTemp['hotelId'] = $hotel['id'];
            $dataTemp['propertyinterfId'] = $hotel['propertyinterfid'];
            $dataTemp['cityId'] = $hotel['cityid'];
            $cityInfo = $cityInfoList[$dataTemp['cityId']];
            $dataTemp['cityName'] = $cityInfo['name'];
            $dataTemp['cityEnName'] = $cityInfo['enname'];
            $dataTemp['countryName'] = $cityInfo['countryname'];
            $dataTemp['countryEnName'] = $cityInfo['countryenname'];
            $dataTemp['name'] = $hotel['name_lang1'];
            $dataTemp['address'] = $hotel['address'];
            $data['list'][] = $dataTemp;
        }
        return $data;
    }

    public function getHotelListDetailConvertor($hotelInfo, $hotelShareIcon, $hotelShortCutIcon) {
        $cityModel = new CityModel();
        $cityInfo = $cityModel->getCityDetail($hotelInfo['cityid']);
        $langNameList = Enum_Lang::getLangNameList();
        $wetherModel = new WetherModel();
        $wetherInfo = $wetherModel->getWeatherFromYahoo($cityInfo['enname'] . ',' . $cityInfo['countryenname']);
        
        $data = array();
        $data['hotelId'] = $hotelInfo['id'];
        $data['groupId'] = $hotelInfo['groupid'];
        $data['propertyinterfId'] = $hotelInfo['propertyinterfid'];
        $data['lng'] = $hotelInfo['lng'];
        $data['lat'] = $hotelInfo['lat'];
        $data['cityId'] = $hotelInfo['cityid'];
        $data['cityName'] = $cityInfo['name'];
        $data['cityEnName'] = $cityInfo['enname'];
        $data['countryName'] = $cityInfo['countryname'];
        $data['countryEnName'] = $cityInfo['countryenname'];
        $data['tel'] = $hotelInfo['tel'];
        $data['name'] = $this->handlerMultiLang('name', $hotelInfo);
        $data['website'] = $hotelInfo['website'];
        $data['logo'] = Enum_Img::getPathByKeyAndType($hotelInfo['logo']);
        $data['indexBackground'] = Enum_Img::getPathByKeyAndType($hotelInfo['index_background']);
        $data['voice'] = Enum_Img::getPathByKeyAndType($this->handlerMultiLang('voice', $hotelInfo));
        $data['introduction'] = $this->handlerMultiLang('introduction', $hotelInfo);
        $data['address'] = $this->handlerMultiLang('address', $hotelInfo);
        $langList = array_filter(explode(',', $hotelInfo['lang_list']));
        $data['wetherInfo'] = $wetherInfo;
        $data['langList'] = array_intersect_key($langNameList, array_flip($langList));
        $data['shareList'] = array();
        foreach ($hotelShareIcon as $share) {
            $data['shareList'][] = array(
                'key' => $share['key']
            );
        }
        $data['shortcutList'] = array();
        foreach ($hotelShortCutIcon as $shortCut) {
            $data['shortcutList'][] = array(
                'key' => $shortCut['key'],
                'title' => $this->handlerMultiLang('title', $shortCut)
            );
        }
        
        return $data;
    }

    public function hotelDetailConvertor($hotel) {
        $data = array();
        $hotelInfo = $hotel['hotelInfo'];
        $data['id'] = $hotelInfo['id'];
        $data['groupid'] = $hotelInfo['groupid'];
        $data['propertyinterfid'] = $hotelInfo['propertyinterfid'];
        $data['lng'] = $hotelInfo['lng'];
        $data['lat'] = $hotelInfo['lat'];
        $data['tel'] = $hotelInfo['tel'];
        $data['name'] = $this->handlerMultiLang('name', $hotelInfo);
        $data['website'] = $hotelInfo['website'];
        $data['bookurl'] = $hotelInfo['bookurl'];
        $data['introduction'] = $this->handlerMultiLang('introduction', $hotelInfo);
        $data['pic'] = array();
        foreach ($hotel['picList'] as $pic) {
            $data['pic'][] = Enum_Img::getPathByKeyAndType($pic['pic']);
        }
        $data['roomTypeList'] = array();
        foreach ($hotel['roomTypeList'] as $roomType) {
            $roomTypeTemp = array();
            $roomTypeTemp['title'] = $this->handlerMultiLang('title', $roomType);
            $roomTypeTemp['size'] = $roomType['size'];
            $roomTypeTemp['detail'] = $this->handlerMultiLang('detail', $roomType);
            $roomTypeTemp['panoramic'] = $roomType['panoramic'];
            $roomTypeTemp['bedtype'] = $this->handlerMultiLang('bedtype', $roomType);
            $data['roomTypeList'][] = $roomTypeTemp;
        }
        $data['facilitiesList'] = array();
        foreach ($hotel['facilitiesList'] as $facilities) {
            $facilitiesTemp = array();
            $facilitiesTemp['name'] = $this->handlerMultiLang('name', $facilities);
            $facilitiesTemp['detail'] = $this->handlerMultiLang('detail', $facilities);
            $facilitiesTemp['introduct'] = $this->handlerMultiLang('introduct', $facilities);
            $data['facilitiesList'][] = $facilitiesTemp;
        }
        $data['floorList'] = array();
        foreach ($hotel['floorList'] as $floor) {
            $floorTemp = array();
            $floorTemp['floor'] = $floor['floor'];
            $floorTemp['detail'] = $this->handlerMultiLang('detail', $floor);
            $floorTemp['pic'] = Enum_Img::getPathByKeyAndType($floor['pic']);
            $data['floorList'][] = $floorTemp;
        }
        $data['trafficList'] = array();
        foreach ($hotel['trafficList'] as $traffic) {
            $trafficTemp = array();
            $trafficTemp['introduct'] = $this->handlerMultiLang('introduct', $traffic);
            $trafficTemp['detail'] = $this->handlerMultiLang('detail', $traffic);
            $data['trafficList'][] = $trafficTemp;
        }
        $data['panoramicList'] = array();
        foreach ($hotel['panoramicList'] as $panoramic) {
            $panoramicTemp = array();
            $panoramicTemp['panoramic'] = $panoramic['panoramic'];
            $panoramicTemp['pic'] = Enum_Img::getPathByKeyAndType($panoramic['pic']);
            $panoramicTemp['title'] = $this->handlerMultiLang('title', $panoramic);
            $data['panoramicList'][] = $panoramicTemp;
        }
        
        return $data;
    }
}