<?php


class ValidUtil
{
    /**
     * 身份证格式检查
     * @param $vStr
     * @return bool|array
     * @author wangxiong
     */
    public static function isIdNumber($vStr)
    {
        $vCity = array(
            '11', '12', '13', '14', '15', '21', '22',
            '23', '31', '32', '33', '34', '35', '36',
            '37', '41', '42', '43', '44', '45', '46',
            '50', '51', '52', '53', '54', '61', '62',
            '63', '64', '65', '71', '81', '82', '91'
        );

        if (!preg_match('/^([\d]{17}[xX\d]|[\d]{15})$/', $vStr))
            return false;

        if (!in_array(substr($vStr, 0, 2), $vCity))
            return false;

        $vStr = preg_replace('/[xX]$/i', 'a', $vStr);
        $vLength = strlen($vStr);

        if ($vLength == 18) {
            $vBirthday = substr($vStr, 6, 4) . '-' . substr($vStr, 10, 2) .
                '-' . substr($vStr, 12, 2);

        } else {
            $vBirthday = '19' . substr($vStr, 6, 2) . '-' . substr($vStr, 8, 2) .
                '-' . substr($vStr, 10, 2);
        }

        if (date('Y-m-d', strtotime($vBirthday)) != $vBirthday)
            return false;

        if ($vLength == 18) {
            $vSum = 0;

            for ($i = 17; $i >= 0; $i--) {
                $vSubStr = substr($vStr, 17 - $i, 1);
                $vSum += (pow(2, $i) % 11) * (($vSubStr == 'a') ? 10 : intval($vSubStr, 11));
            }

            if ($vSum % 11 != 1)
                return false;
        }

        // 1男, 2女
        $gender = 2;
        if (intval(substr($vStr, 16, 1)) % 2 == 1) {
            $gender = 1;
        }

        return [$vBirthday, $gender];
    }

    /**
     * 校验 IP 是否在白名单
     *
     * @param string $ip
     * @param array $whiteList
     * @return bool
     * @author wangxiong
     */
    public static function ipWhite($ip, $whiteList)
    {
        foreach ($whiteList as $item) {
            if ($item == $ip) {
                return true;
            } else {
                $itemArr = explode(".", $item);
                $ipArr = explode(".", $ip);
                $flag = true;
                foreach ($ipArr as $k => $v) {
                    if ($itemArr[$k] != "*" && $itemArr[$k] != $ipArr[$k]) {
                        $flag = false;
                        break;
                    }
                }
                if ($flag)
                    return true;
                else continue;
            }
        }
        return false;
    }

    /**
     * 手机号格式检查
     * @param $mobile
     * @return int
     * @author wangxiong
     */
    public static function isMobile($mobile)
    {
        return preg_match("/^[0-9]{1,14}$/", $mobile);
    }

    /**
     * 是否为整型
     * @param $num
     * @return bool
     * @author wangxiong
     */
    public static function isInt($num)
    {
        if (is_numeric($num) && strpos($num, '.') === false) {
            return true;
        }
        return false;
    }

    /**
     * 校验日期格式是否合法
     * @param string $date
     * @param array $formats
     * @return bool
     * @author wangxiong
     */
    public static function isDate($date, $formats = ['Y-m-d', 'Y/m/d', 'Y/n/j'])
    {
        $unixTime = strtotime($date);
        // 无法转换，说明日期格式非法
        if (!$unixTime) {
            return false;
        }
        // 校验日期合法性，只要满足其中一个格式就可以
        foreach ($formats as $format) {
            if (date($format, $unixTime) == $date) {
                return true;
            }
        }
        return false;
    }


}