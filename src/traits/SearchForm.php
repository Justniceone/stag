<?php

namespace Gyf\Traits;

use Illuminate\Http\Request;

trait SearchForm
{
    /**
     * @var int 页数
     */
    protected $page;
    /**
     * @var int 每页显示条数
     */
    protected $limit;
    /**
     * @var null|string 模糊搜索关键字
     */
    protected $title;
    /**
     * @var array 模糊搜索条件
     */
    protected $where = [];
    /**
     * @var string 查询开始日期
     */
    protected $start_at;
    /**
     * @var string 查询结束日期
     */
    protected $end_at;
    /**
     * @var int|null 查询状态
     */
    protected $status;

    public function __construct(Request $request)
    {
        $this->page = (int)$request->input('page') ?: 1;
        $this->limit = (int)$request->input('limit') ?: 20;
        $this->title = $request->input('title');
        $this->title && $this->where[] = ['title', 'like', '%' . $request->input('title') . '%'];
        $this->start_at = strtotime($request->input('start_at'));
        $this->end_at = strtotime($request->input('end_at'));
        if ($this->start_at && $this->end_at) {
            $this->where[] = ['created_at', '>=', $this->start_at];
            $this->where[] = ['created_at', '<=', $this->end_at];
        }
        $this->status = $request->input('status');
        $this->status && $this->where[] = ['status', $this->status];
    }
}