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

    /**
     * 处理RSA密钥内容，拼接对应秘钥开始和结束的格式
     * @param string $key 传入的密钥信息， 可能是文件或者字符串
     * @param string $type
     * @return string
     * @author wangxiong
     */
    public static function getRsaKeyValue($key, $type = 'private')
    {
        // 传入文件
        if (is_file($key)) {
            $keyStr = @file_get_contents($key);
        } else {
            $keyStr = $key;
        }
        if (empty($keyStr)) {
            return null;
        }

        $keyStr = str_replace(PHP_EOL, '', $keyStr);
        // 处理秘钥格式
        if ($type === 'private') {
            $beginStr = '-----BEGIN RSA PRIVATE KEY-----';
            $endStr = '-----END RSA PRIVATE KEY-----';
        } else {
            $beginStr = '-----BEGIN PUBLIC KEY-----';
            $endStr = '-----END PUBLIC KEY-----';
        }
        $keyStr = str_replace($beginStr, '', $keyStr);
        $keyStr = str_replace($endStr, '', $keyStr);

        $rsaKey = chunk_split($keyStr, 64, PHP_EOL);
        $rsaKey = $beginStr . PHP_EOL . $rsaKey . $endStr;

        return $rsaKey;
    }


}