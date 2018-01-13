<?php
/**
 * program表的模型
 *
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Warzone extends Model{
    use SoftDeletes;
    protected $table = 'warzone';
    protected $primaryKey = 'id';
    public $timestamps = true;
    public $dateFormat = 'U';//设置保存的created_at updated_at为时间戳格式

    //和proxyappy表一对多的关系
    public function proxyapply(){
        return $this->hasMany('App\Models\ProxyApply', 'zone_id');
    }

    //和战区表一对一的关系
    public function warzoneprovince(){
        return $this->belongsTo('App\Models\WarzoneProvince', 'zone_id');
    }

}
?>