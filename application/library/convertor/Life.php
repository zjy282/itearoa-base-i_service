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

	public function getLifeDetailConvertor($lifes, $lifeCount, $param) {
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
}