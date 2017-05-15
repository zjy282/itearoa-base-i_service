<?php
/**
 * 酒店问卷调查回答转换器类
 *
 */
class Convertor_FeedbackResult extends Convertor_Base {

	public function __construct() {
		parent::__construct ();
	}

	/**
	 * 酒店问卷调查回答列表
	 *
	 * @param array $list
	 *        	酒店问卷调查回答列表
	 * @param int $count
	 *        	酒店问卷调查回答总数
	 * @param array $param
	 *        	扩展参数
	 * @return array
	 */
	public function getFeedbackResultListConvertor($list, $count, $param) {
		$data = array ('list' => array () );
		$answerList = array_column ( $list, 'answer' );
		$questionIdList = array ();
		foreach ( $answerList as $answer ) {
			$answerInfo = json_decode ( $answer, true );
			$questionIdList = array_merge ( $questionIdList, array_keys ( $answerInfo ) );
		}
		$questionIdList = array_unique ( $questionIdList );
		if ($questionIdList) {
			$feedbackModel = new FeedbackModel ();
			$questionInfoList = $feedbackModel->getFeedbackList ( array ('id' => $questionIdList ) );
			$questionTitleList = array_column ( $questionInfoList, 'question', 'id' );
		}
		$userIdList = array_column ( $list, 'userid' );
		$userIdList = array_unique ( array_filter ( $userIdList ) );
		if ($userIdList) {
			$userModel = new UserModel ();
			$userInfoList = $userModel->getUserList ( array ('id' => $userIdList ) );
			$userNameList = array_column ( $userInfoList, 'fullname', 'id' );
		}
		foreach ( $list as $key => $value ) {
			$value ['answer'] = json_decode ( $value ['answer'], true );
			$answerInfoNew = array ();
			foreach ( $value ['answer'] as $quertionId => $answer ) {
				$answerInfoNew [] = array ('question' => $questionTitleList [$quertionId],'answer' => $answer );
			}
			$oneTemp = array ();
			$oneTemp ['id'] = $value ['id'];
			$oneTemp ['answer'] = json_encode ( $answerInfoNew );
			$oneTemp ['hotelid'] = $value ['hotelid'];
			$oneTemp ['userid'] = $value ['userid'];
			$oneTemp ['username'] = $userNameList [$value ['userid']];
			$oneTemp ['createtime'] = $value ['createtime'];
			$data ['list'] [] = $oneTemp;
		}
		$data ['total'] = $count;
		$data ['page'] = $param ['page'];
		$data ['limit'] = $param ['limit'];
		$data ['nextPage'] = Util_Tools::getNextPage ( $data ['page'], $data ['limit'], $data ['total'] );
		return $data;
	}
}
