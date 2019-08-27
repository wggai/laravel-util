<?php
/**
 * Created by PhpStorm.
 * User: linzhencan
 * Date: 2019/8/27
 * Time: 18:49
 */

namespace Wggai\LaravelUtil\Controller;

use Wggai\LaravelUtil\Exception\ApiException;


/**
 * 自定义控制器基类
 * Class Controller
 * @package JiaLeo\Core
 */
trait Controller
{
    public $verifyObj;   //验证类
    public $verifyData;    //验证成功后的数据

    public $helperObj = array();  //helper类

    /**
     * 应答数据api
     * @param array $data
     * @param string $code
     * @return mixed
     */
    function response($data = array(), $code = '200')
    {
        $data = [
            'status' => true,
            'error_msg' => 'SUCCESS',
            'error_code' => '',
            'data' => empty($data) ? null : $data,
            'debug' => [],
            'list' => null
        ];
        return response($data, $code)
            ->header('Content-Type', 'application/json');
    }

    /**
     * List应答数据api
     * @param array $data
     * @param string $code
     * @return mixed
     */
    function responseList($list = array(), $code = '200')
    {
        $data = [
            'status' => true,
            'error_msg' => 'SUCCESS',
            'error_code' => '',
            'data' => null,
            'debug' => [],
            'list' => empty($list) ? null : $list,
        ];
        return response($data, $code)
            ->header('Content-Type', 'application/json');
    }

    /**
     * 验证
     * @param array $rule
     * @param string $data
     * @return bool
     * @throws ApiException
     */
    public function verify(array $rule, $data = 'GET', $exclusive = true)
    {
        if (empty($verifyObj)) {
            $this->verifyObj = new \App\Packages\Verify\Verify();
        }

        $result = $this->verifyObj->check($rule, $data, $exclusive);
        $this->verifyData = $this->verifyObj->data;

        return $result;
    }

    /**
     * 验证ID
     * @param $id
     * @return bool
     * @throws ApiException
     */
    public function verifyId($id)
    {
        if (empty($verifyObj)) {
            $this->verifyObj = new \App\Packages\Verify\Verify();
        }

        $result = $this->verifyObj->egnum($id);
        if (!$result) {
            throw new ApiException('id验证错误', 'id_ERROR', 422);
        }

        return true;
    }
}



