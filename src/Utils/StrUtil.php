<?php


class StrUtil
{
    /**
     * 生成Token
     * @return string
     * @author wangxiong
     */
    public static function token()
    {
        return md5(bin2hex(uniqid(rand(), true)));
    }

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
     * RSA密钥处理，拼接对应秘钥开始和结束的格式
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

    /**
     * 隐藏手机号中间4位数字
     * @param $mobile
     * @return mixed
     * @author wangxiong
     */
    public static function hideUserMobile($mobile)
    {
        if (empty($mobile)) {
            return '';
        }
        return substr_replace(trim($mobile), '****', 3, 4);
    }

    /**
     * 下划线转驼峰
     * @param $str
     * @return string|string[]|null
     * @author wangxiong
     */
    public static function underlineToHump($str)
    {
        $str = preg_replace_callback('/([-_]+([a-z]{1}))/i', function ($matches) {
            return strtoupper($matches[2]);
        }, $str);
        return $str;
    }

    /**
     * 驼峰转下划线
     * @param $str
     * @return string|string[]|null
     * @author wangxiong
     */
    public static function humpToUnderline($str)
    {
        $str = preg_replace_callback('/([A-Z]{1})/', function ($matches) {
            return '_' . strtolower($matches[0]);
        }, $str);
        return $str;
    }

    /**
     * [1,2,3] => '1','2','3'
     * 将数组转化为sql可以识别的语句
     * @param $array
     * @return bool|string
     * @throws \Exception
     * @author wangxiong
     */
    public static function buildSqlIn($array)
    {
        if (!is_array($array)) {
            throw new \Exception("params must be array");
        }
        if (count($array) == 0) {
            return '';
        }
        $s = '';
        foreach ($array as $a) {
            $s .= "'{$a}',";
        }

        return substr($s, 0, -1);
    }


}