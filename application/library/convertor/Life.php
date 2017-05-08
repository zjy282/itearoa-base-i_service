<?php

/**
 * 雅士阁生活convertor
 * @author ZXM
 */
class Convertor_Life extends Convertor_Base {

    public function __construct() {
        parent::__construct();
    }

    public function getLifeListConvertor($lifeList, $lifeCount, $param) {
        $data = array(
            'list' => array()
        );
        foreach ($lifeList as $lifes) {
            $lifeTemp = array();
            $lifeTemp['id'] = $lifes['id'];
            $lifeTemp['name'] = $this->handlerMultiLang('name', $lifes);
            $lifeTemp['address'] = $this->handlerMultiLang('address', $lifes);
            $lifeTemp['tel'] = $lifes['tel'];
            $lifeTemp['introduct'] = $this->handlerMultiLang('introduct', $lifes);
            $lifeTemp['detail'] = Enum_Img::getPathByKeyAndType($this->handlerMultiLang('detail', $lifes));
            $lifeTemp['lat'] = $lifes['lat'];
            $lifeTemp['lng'] = $lifes['lng'];
            $data['list'][] = $lifeTemp;
        }
        $data['total'] = $lifeCount;
        $data['page'] = $param['page'];
        $data['limit'] = $param['limit'];
        $data['nextPage'] = Util_Tools::getNextPage($data['page'], $data['limit'], $data['total']);
        return $data;
    }
    
    public function getAdminLifeListConvertor($lifeList, $lifeCount, $param) {
    	$data = array(
    			'list' => array()
    	);
    	foreach ($lifeList as $lifes) {
    		$lifeTemp = array();
    		$lifeTemp['id'] = $lifes['id'];
    		$lifeTemp['nameLang1'] = $lifes['name_lang1'];
    		$lifeTemp['nameLang2'] = $lifes['name_lang2'];
    		$lifeTemp['nameLang3'] = $lifes['name_lang3'];
    		$lifeTemp['addressLang1'] = $lifes['address_lang1'];
    		$lifeTemp['addressLang2'] = $lifes['address_lang2'];
    		$lifeTemp['addressLang3'] = $lifes['address_lang3'];
    		$lifeTemp['tel'] = $lifes['tel'];
    		$lifeTemp['introductLang1'] = $lifes['introduct_lang1'];
    		$lifeTemp['introductLang2'] = $lifes['introduct_lang2'];
    		$lifeTemp['introductLang3'] = $lifes['introduct_lang3'];
    		$lifeTemp['detailLang1'] = Enum_Img::getPathByKeyAndType($lifes['detail_lang1']);
    		$lifeTemp['detailLang2'] = Enum_Img::getPathByKeyAndType($lifes['detail_lang2']);
    		$lifeTemp['detailLang3'] = Enum_Img::getPathByKeyAndType($lifes['detail_lang3']);
    		$lifeTemp['lat'] = $lifes['lat'];
    		$lifeTemp['lng'] = $lifes['lng'];
    		$data['list'][] = $lifeTemp;
    	}
    	$data['total'] = $lifeCount;
    	$data['page'] = $param['page'];
    	$data['limit'] = $param['limit'];
    	$data['nextPage'] = Util_Tools::getNextPage($data['page'], $data['limit'], $data['total']);
    	return $data;
    }

	public function getLifeDetailConvertor($lifes) {
		$data = array ();
		$data ['id'] = $lifes ['id'];
		$data ['name'] = $this->handlerMultiLang ( 'name', $lifes );
		$data ['address'] = $this->handlerMultiLang ( 'address', $lifes );
		$data ['tel'] = $lifes ['tel'];
		$data ['introduct'] = $this->handlerMultiLang ( 'introduct', $lifes );
		$data ['detail'] = Enum_Img::getPathByKeyAndType ( $this->handlerMultiLang ( 'detail', $lifes ) );
		$data ['lat'] = $lifes ['lat'];
		$data ['lng'] = $lifes ['lng'];
		$data ['createTime'] = $lifes ['createtime'];
		$data ['updateTime'] = $lifes ['updatetime'];
		$data ['status'] = $lifes ['status'];
		return $data;
	}
	
	public function getAdminLifeDetailConvertor($lifes) {
		$data = array ();
		$data ['id'] = $lifes ['id'];
		$data['nameLang1'] = $lifes['name_lang1'];
		$data['nameLang2'] = $lifes['name_lang2'];
		$data['nameLang3'] = $lifes['name_lang3'];
		$data['addressLang1'] = $lifes['address_lang1'];
		$data['addressLang2'] = $lifes['address_lang2'];
		$data['addressLang3'] = $lifes['address_lang3'];
		$data ['tel'] = $lifes ['tel'];
		$data['introductLang1'] = $lifes['introduct_lang1'];
		$data['introductLang2'] = $lifes['introduct_lang2'];
		$data['introductLang3'] = $lifes['introduct_lang3'];
		$data['detailLang1'] = Enum_Img::getPathByKeyAndType ( $lifes['detail_lang1'] );
		$data['detailLang2'] = Enum_Img::getPathByKeyAndType ( $lifes['detail_lang2'] );
		$data['detailLang3'] = Enum_Img::getPathByKeyAndType ( $lifes['detail_lang3'] );
		$data ['lng'] = $lifes ['lng'];
		$data ['createTime'] = $lifes ['createtime'];
		$data ['updateTime'] = $lifes ['updatetime'];
		$data ['status'] = $lifes ['status'];
		return $data;
	}
}