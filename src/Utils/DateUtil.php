<?php


class DateUtil
{
    /**
     * 根据日期获取星期几
     * @param $time @时间戳
     * @return mixed
     * @author wangxiong
     */
    public static function getWeekName($time)
    {
        $weekArray = ["星期一", "星期二", "星期三", "星期四", "星期五", "星期六", "星期日"];
        return $weekArray[date("N", $time) - 1];
    }
}