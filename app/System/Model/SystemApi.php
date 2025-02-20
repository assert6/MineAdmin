<?php

declare(strict_types=1);
/**
 * This file is part of MineAdmin.
 *
 * @link     https://www.mineadmin.com
 * @document https://doc.mineadmin.com
 * @contact  root@imoi.cn
 * @license  https://github.com/mineadmin/MineAdmin/blob/master/LICENSE
 */

namespace App\System\Model;

use Carbon\Carbon;
use Hyperf\Database\Model\Relations\BelongsToMany;
use Hyperf\Database\Model\Relations\HasMany;
use Hyperf\Database\Model\Relations\HasOne;
use Hyperf\Database\Model\SoftDeletes;
use Mine\MineModel;

/**
 * @property int $id 主键
 * @property int $group_id 接口组ID
 * @property string $name 接口名称
 * @property string $access_name 接口访问名称
 * @property string $class_name 类命名空间
 * @property string $method_name 方法名
 * @property int $auth_mode 认证模式 (1简易 2复杂)
 * @property string $request_mode 请求模式 (A 所有 P POST G GET)
 * @property string $description 接口说明介绍
 * @property string $response 返回内容示例
 * @property int $status 状态 (1正常 2停用)
 * @property int $created_by 创建者
 * @property int $updated_by 更新者
 * @property Carbon $created_at 创建时间
 * @property Carbon $updated_at 更新时间
 * @property string $deleted_at 删除时间
 * @property string $remark 备注
 * @property \Hyperf\Database\Model\Collection|SystemApiColumn[] $apiColumn
 * @property SystemApiGroup $apiGroup
 * @property \Hyperf\Database\Model\Collection|SystemApp[] $apps
 */
class SystemApi extends MineModel
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     */
    protected ?string $table = 'system_api';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['id', 'group_id', 'name', 'access_name', 'class_name', 'method_name', 'auth_mode', 'request_mode', 'description', 'response', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_at', 'remark'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'group_id' => 'integer', 'auth_mode' => 'integer', 'status' => 'integer', 'created_by' => 'integer', 'updated_by' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

    /**
     * 通过中间表关联APP.
     */
    public function apps(): BelongsToMany
    {
        return $this->belongsToMany(SystemApp::class, 'system_app_api', 'api_id', 'app_id');
    }

    /**
     * 关联API分组.
     */
    public function apiGroup(): HasOne
    {
        return $this->hasOne(SystemApiGroup::class, 'id', 'group_id');
    }

    /**
     * 关联API字段.
     */
    public function apiColumn(): HasMany
    {
        return $this->hasMany(SystemApiColumn::class, 'api_id', 'id');
    }
}
