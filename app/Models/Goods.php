<?php
/**
 * goods表的模型
 *
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Goods extends Model{
    use SoftDeletes;
    protected $table = 'goods';
    protected $primaryKey = 'id';
    public $timestamps = true;
    public $dateFormat = 'U';//设置保存的created_at updated_at为时间戳格式

    //和创建者account表多对一的关系
    public function create_account(){
        return $this->belongsto('App\Models\Account','created_by');
    }

    //和功能节点关系表，多对多
    public function nodes()
    {
        return $this->belongsToMany('App\Models\Node','role_node','role_id','node_id');
    }

    //获取单条信息
    public static function getOne($where){
        return self::with('nodes')->where($where)->first();
    }

    //获取列表
    public static function getList($where,$limit=0,$orderby,$sort='DESC'){
        $model = new Goods();
        if(!empty($limit)){
            $model = $model->limit($limit);
        }
        return $model->where($where)->orderBy($orderby,$sort)->get();
    }

    //添加组织栏目分类
    public static function addGoods($param){
        $model = new Goods();
        $model->program_id = $param['program_id'];
        $model->category_id = $param['category_id'];
        $model->organization_id = $param['organization_id'];
        $model->goods_sort = $param['goods_sort'];
        $model->goods_stock = $param['goods_stock'];
        $model->goods_details = $param['goods_details'];
        $model->goods_thumb = $param['goods_thumb'];
        $model->goods_price = $param['goods_price'];
        $model->goods_name = $param['goods_name'];
        $model->created_by = $param['created_by'];
        $model->goods_keywords = $param['goods_keywords'];
        $model->goods_max = $param['goods_max'];

        $model->goods_name = $param['goods_name'];
        $model->save();
        return $model->id;
    }
    
    //修改数据
    public static function editGoods($where,$param){
        if($model = self::where($where)->first()){
            foreach($param as $key=>$val){
                $model->$key=$val;
            }
            $model->save();
        }
    }

    //获取分页列表
    public static function getPaginage($where,$paginate,$orderby,$sort='DESC'){
        return self::with('create_account')->with('nodes')->where($where)->orderBy($orderby,$sort)->paginate($paginate);
    }
}
?>