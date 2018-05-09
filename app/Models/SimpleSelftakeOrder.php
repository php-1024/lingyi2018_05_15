<?php
/**
 * simple_order表的模型
 *
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SimpleSelftakeOrder extends Model
{
    use SoftDeletes;
    protected $table = 'simple_selftake_order';
    protected $primaryKey = 'id';
    public $timestamps = true;
    public $dateFormat = 'U';//设置保存的created_at updated_at为时间戳格式
    public $guarded = [];


    //获取列表
    public static function getListPaginate($where, $paginate, $orderby, $sort = 'DESC', $select = [])
    {
        $model = new SimpleSelftakeOrder();
        if (!empty($select)) {
            $model = $model->select($select);
        }
        return $model->where($where)->orderBy($orderby, $sort)->paginate($paginate);
    }

    //获取单条数据
    public static function getOne($where)
    {
        return  self::where($where)->first();
    }

    //修改订单信息
    public static function editSimpleSelftakeOrder($where, $param)
    {
        $model = self::where($where)->first();
        foreach ($param as $key => $val) {
            $model->$key = $val;
        }
        $model->save();
    }


    //添加数据
    public static function addSimpleSelftakeOrder($param)
    {
        $model = new SimpleSelftakeOrder();//实例化程序模型
        $model->fansmanage_id = $param['fansmanage_id'];//联盟id
        $model->simple_id = $param['simple_id'];//店铺id
        $model->ordersn = $param['ordersn'];//订单编号
        $model->order_price = $param['order_price'];//订单价格
        if (!empty($param['remarks'])) {
            $model->remarks = $param['remarks'];//备注信息
        }
        if (!empty($param['payment_company'])) {
            $model->payment_company = $param['payment_company'];//支付公司
        }
        $model->user_id = $param['user_id'];//订单人id
        $model->status = $param['status'];//订单状态
        if (!empty($param['operator_id'])) {
            $model->operator_id = $param['operator_id'];//操作人员id
        }
        if (!empty($param['paytype'])) {
            $model->paytype = $param['paytype'];//付款方式
        }
        $model->selftake_mobile = $param['selftake_mobile'];//提取人电话
        $model->selftake_code = $param['selftake_code'];//提取码
        $model->save();
        return $model->id;
    }

    //获取分页列表
    public static function getPaginage($where, $paginate, $orderby, $sort = 'DESC')
    {
        return self::where($where)->orderBy($orderby, $sort)->paginate($paginate);
    }

    //获取单行数据的其中一列
    public static function getPluck($where, $pluck)
    {
        return self::where($where)->value($pluck);
    }
}

?>