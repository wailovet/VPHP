<?php
namespace V;

class Net
{
    /**
     * 返回客户端MAC地址
     * @return string mac
     */
    public static function mac()
    {
        $ipAddress = $_SERVER['REMOTE_ADDR'];
        $macAddr = false;

        #run the external command, break output into lines
        $arp = `arp -a $ipAddress`;
        $arp = system($arp);
        $lines = explode("\n", $arp);

        #look for the output line describing our IP address
        foreach ($lines as $line) {
            $cols = preg_split('/\s+/', trim($line));
            if ($cols[0] == $ipAddress) {
                $macAddr = $cols[1];
            }
        }
        return $macAddr;
    }

    /**
     * 返回客户端IP地址
     * @return string ip
     */
    public static function ip()
    {
        return $_SERVER['REMOTE_ADDR'];
    }

}


?>