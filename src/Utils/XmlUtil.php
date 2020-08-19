<?php


class XmlUtil
{
    /**
     * 处理成xml字符
     * @param array $values
     * @return string|bool
     * @author wangxiong
     **/
    public static function arrToXml($values)
    {
        if (!is_array($values) || count($values) <= 0) {
            return false;
        }

        $xml = "<xml>";
        foreach ($values as $key => $val) {
            if (is_numeric($val)) {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            } else {
                $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
            }
        }
        $xml .= "</xml>";
        return $xml;
    }

    /**
     * 将xml转为 array
     * @param string $xml
     * @return array|false
     * @author wangxiong
     */
    public static function xmlToArr($xml)
    {
        $data = [];
        if (!$xml) {
            return false;
        }

        // 检查xml是否合法
        $xml_parser = xml_parser_create();
        if (!xml_parse($xml_parser, $xml, true)) {
            xml_parser_free($xml_parser);
            return false;
        }

        // 禁止引用外部xml实体
        libxml_disable_entity_loader(true);

        // 将xml转为array
        $data = json_decode(json_encode(simplexml_load_string(
            $xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);

        return $data;
    }

}