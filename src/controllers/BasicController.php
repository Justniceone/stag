<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Collection;
use Illuminate\Validation\Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * 用于返回常规数据
     *
     * @param array $data
     * @param bool $success
     * @param string $errors
     * @return array
     */
    protected function respondWithJson($data = [], $extra = [], $success = true, $errors = '')
    {
        if ($data instanceof Collection) {
            $data = $data->toArray();
        }

        return response()->json(array_merge([
            'success' => $success,
            'data' => $data,
            'errors' => $errors,
        ], $extra));
    }

    /**
     * 用于返回表单验证后的错误（validator）
     * @param $validator
     * @return array
     */
    protected function responseValidateError(Validator $validator)
    {
        return $this->respondWithJson($validator->errors()->toArray(), false, "表单参数错误");
    }

    /**
     * @param Model $query
     * @param $page
     * @param int $limit
     * @return array
     */
    protected function responseWithPagination(Builder $query, $page, $limit = 20, $extra = [],
                                              $orderBy = ['created_at', 'desc'])
    {
        $total = $query->count();
        $totalPage = ceil($query->count() / $limit);
        $data = [
            'rows' => $query->skip(($page - 1) * $limit)->take($limit)->orderBy($orderBy[0], $orderBy[1])->get(),
            'pagenation' => [
                'total' => $total,
                'totalPage' => $totalPage,
                'current' => (int)$page,
            ],
        ];
        $data = array_merge($data, $extra);
        return $this->respondWithJson($data);
    }

    /**
     * @param string $url 请求网址
     * @param bool $params 请求参数
     * @param int $ispost 请求方式
     * @param int $https https协议
     * @return bool|mixed
     */
    protected function curl($url, $params = false, $ispost = 0, $https = 0)
    {
        $httpInfo = [];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36');
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($https) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在
        }
        if ($ispost) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch, CURLOPT_URL, $url);
        } else {
            if ($params) {
                if (is_array($params)) {
                    $params = http_build_query($params);
                }
                curl_setopt($ch, CURLOPT_URL, $url . '?' . $params);
            } else {
                curl_setopt($ch, CURLOPT_URL, $url);
            }
        }

        $response = curl_exec($ch);

        if ($response === FALSE) {
            //echo "cURL Error: " . curl_error($ch);
            return false;
        }
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $httpInfo = array_merge($httpInfo, curl_getinfo($ch));
        curl_close($ch);
        return $response;
    }


    protected function responseWithError($errors = 'error', $data = [], $success = false)
    {
        return $this->respondWithJson($data, $success, $errors);
    }

    protected function responseWithSystemError($errors = '系统错误，请重试', $data = [], $success = false)
    {
        return $this->respondWithJson($data, $success, $errors);
    }
}