<?php


class StrUtil
{
    /**
     * 产生随机字符串，不长于32位
     * @param int $length
     * @return string 产生的随机字符串
     * @author wangxiong
     */
    public static function getNonceStr($length = 32)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    /**
     * 转码字符集转码，仅支持转码到 UTF-8
     * @param string $str
     * @param string $targetCharset
     * @return mixed|string
     * @author wangxiong
     */
    public static function charSet($str, $targetCharset)
    {
        if (empty($str)) {
            return $str;
        }

        if (strcasecmp('UTF-8', $targetCharset) != 0) {
            $str = mb_convert_encoding($str, $targetCharset, 'UTF-8');
        }

        return $str;
    }

    /**
     * 字符串转成16进制
     * @param string $string
     * @return string
     * @author wangxiong
     */
    public static function String2Hex($string)
    {
        $hex = '';
        $len = strlen($string);
        for ($i = 0; $i < $len; $i++) {
            $hex .= dechex(ord($string[$i]));
        }
        return $hex;
    }


}