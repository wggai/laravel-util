<?php
/**
 * Created by PhpStorm.
 * User: linzhencan
 * Date: 2019/8/27
 * Time: 18:49
 */

namespace Wggai\LaravelUtil\Logic;

/**
 * 分页逻辑
 * Class Controller
 * @package JiaLeo\Core
 */
trait PaginateLogic
{
    /**
     * 分页标准
     * @param int $page
     * @param int $limit
     * @param array $data
     * @return array
     */
    public static function paginate($Model, $page = 1, $per_page = 10)
    {
        $page --;

        $total = $Model
            ->groupBy()
            ->count();

        $list = $Model->where('is_on', 1)
            ->groupBy()
            ->skip($page * $per_page)
            ->take($per_page)
            ->get();

        $res_data = [
            'current_page' => ++ $page,
            'data' => $list,
            'per_page' => $per_page,
            'last_page' => count($list) ? ceil($total * 1.0 / $per_page) : 1,
            'first_page' => 1,
            'total' => $total,
        ];
        return $res_data;
    }


}



