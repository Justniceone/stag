<?php

namespace Gyf\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

/**
 * App\Models\BasicModel
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Gyf\Models\BasicModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Gyf\Models\BasicModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Gyf\Models\BasicModel query()
 * @mixin \Eloquent
 */
class BasicModel extends Model
{
    //自动转换为日期格式的时间戳字段
    protected $dates = [self::CREATED_AT, self::UPDATED_AT];

    //禁止被赋值的属性
    protected $guarded = [];

    //分页默认显示条数
    protected $perPage = 20;

    /** 自动填充创建时间与更新时间为时间戳格式
     * @param \DateTime|int $value
     * @return false|int|string
     */
    public function fromDateTime($value)
    {
        return strtotime(parent::fromDateTime($value));
    }

    /**
     * @param array $except 不期望被返回的数据库表字段
     * @return array
     */
    public function getColumns($except = ['id', 'created_at', 'updated_at'])
    {
        $columns = Schema::getColumnListing($this->table);
        return array_values(array_diff($columns, $except));
    }

    /** 模型属性批量赋值
     * @param array $data $request->all()
     * @return $this
     */
    public function loadAttributes($data = [])
    {
        if (!$data) return $this;
        $attributes = $this->getColumns();
        $attributes = array_flip($attributes);
        foreach ($data as $k => $v) {
            if (isset($attributes[$k])) {
                $this->$k = $v;
            }
        }
        return $this;
    }
}