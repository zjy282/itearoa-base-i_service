<?php
use Frankli\Itearoa\Models\ShoppingCategory;

/**
 * Class ShoppingTagModel
 * 购物信息标签管理
 */
class ShoppingTagModel extends \BaseModel {

    private $dao;

    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_ShoppingTag();
    }

    /**
     * 获取ShoppingTag列表信息
     *
     * @param array $param
     * @return array
     */
    public function getShoppingTagList(array $param)
    {
        $paramList = array();
        $param['id'] ? $paramList['id'] = $param['id'] : false;
        $param['hotelid'] ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        !is_null($param['parentid']) ? $paramList['parentid'] = intval($param['parentid']) : false;
        !is_null($param['status']) ? $paramList['status'] = intval($param['status']) : false;

        $query = ShoppingCategory::where($paramList);
        if ($param['withChild']) {
            $query = $query->with('children');
        }
        if ($param['limit']) {
            return $query->paginate($param['limit'], ['*'], 'page', $param['page'])->toArray();
        } else {
            return $query->get()->toArray();
        }
    }

    /**
     * Get count of ShoppingTag
     *
     * @param array $param
     * @return int
     */
    public function getShoppingTagCount(array $param) {
        $param['id'] ? $paramList['id'] = intval($param['id']) : false;
        $param['hotelid'] ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        return ShoppingCategory::where($paramList)->count();
    }

    /**
     * 根据id查询ShoppingTag信息
     *
     * @param
     *            int id 查询的主键
     * @return array
     */
    public function getShoppingTagDetail($id) {
        $result = array();
        if ($id) {
            $result = ShoppingCategory::with('children')->findOrFail($id)->toArray();
        }
        return $result;
    }

    /**
     * 根据id更新ShoppingTag信息
     *
     * @param
     *            array param 需要更新的信息
     * @param
     *            int id 主键
     * @return array
     */
    public function updateShoppingTagById($param, $id)
    {
        $result = false;
        if ($id) {
            $shoppingTag = ShoppingCategory::find($id);
            if (!is_null($shoppingTag)) {
                !is_null($param['title_lang1']) ? $shoppingTag->title_lang1 = trim($param['title_lang1']) : false;
                !is_null($param['title_lang2']) ? $shoppingTag->title_lang2 = trim($param['title_lang2']) : false;
                !is_null($param['title_lang3']) ? $shoppingTag->title_lang3 = trim($param['title_lang3']) : false;
                !is_null($param['pic']) ? $shoppingTag->pic = trim($param['pic']) : false;
                !is_null($param['parentid']) ? $shoppingTag->parentid = intval($param['parentid']) : false;
                !is_null($param['status']) ? $shoppingTag->status = intval($param['status']) : false;
                !is_null($param['is_robot']) ? $shoppingTag->is_robot = intval($param['is_robot']) : false;
                !is_null($param['staff_list']) ? $shoppingTag->staff_list = trim($param['staff_list']) : false;
                $result = $shoppingTag->save();
            }
        }
        return $result;
    }

    /**
     * @param array $params
     */
    public function addShoppingTag(array $params) {
        $shoppingTag = ShoppingCategory::create($params);
        return $shoppingTag->id;
    }
}
