<?php
namespace V;

class Date
{

    private $date_int = '';
    private $date_str = '';
    private $date_arr = array("Y" => '', "m" => '', "d" => '', "H" => '', "i" => '', "s" => '');

    public function __construct($date)
    {
        $this->setTime($date);
    }

    /**
     * 设置时间
     * @param $date 时间，字符串形式或者时间戳
     * @return $this
     */
    public function setTime($date)
    {
        if (empty($date)) {
            $date = time();
        }
        if (is_int($date)) {
            $this->date_int = $date;
            $this->date_str = date("Y-m-d H:i:s", $date);
        } else {
            $this->date_int = strtotime($date);
            $this->date_str = $date;
        }
        $i = 0;
        foreach ($this->date_arr as $key => $val) {
            $this->date_arr[$key] = date($key, $this->date_int);
            $this->date_arr[$i] = $this->date_arr[$key];
            $i++;
        }
        return $this;
    }

    /**
     * 返回时间戳
     * @return int 时间戳
     */
    public function toInt()
    {
        return $this->date_int;
    }

    /**
     * 返回「Y-m-d H:i:s」字符串
     * @param $str
     * @return bool|string
     */
    public function toString($str = '')
    {
        if (empty($str)) {
            return $this->date_str;
        }
        $d = sprintf($str, 'Y', 'm', 'd', 'H', 'i', 's');;
        return date($d, $this->date_int);
    }

    /**
     * 返回时间
     * @param $i 按YmdHis排序
     * @return mixed
     */
    public function at($i)
    {
        return $this->date_arr[$i];
    }


    /**
     * 增加或者减少天数
     * @param $day 天数
     * @param bool|false $is_new 是否创建新的svdate对象
     * @return Svdate 当前对象或者新对象，取决于$is_new
     */
    public function addDay($day, $is_new = false)
    {
        if ($day < 0) {
            return $this->add("$day day", $is_new);
        }
        return $this->add("+$day day", $is_new);
    }


    /**
     * 增加或者减少月份
     * @param $month 月数
     * @param bool|false $is_new 是否创建新的svdate对象
     * @return Svdate 当前对象或者新对象，取决于$is_new
     */
    public function addMonth($month, $is_new = false)
    {
        if ($month < 0) {
            return $this->add("$month month", $is_new);
        }
        return $this->add("+$month month", $is_new);
    }


    /**
     * 相差月份
     * @param $date 目标时间
     * @return float 天数
     */
    public function distanceMonth($date)
    {
        $mdate = new Date($date);
        return abs(
            (intval($mdate->at("Y")) - intval($this->at("Y")) * 12) +
            (intval($mdate->at("m")) - intval($this->at("m")))
        );
    }

    /**
     * 相差天数
     * @param $date 目标时间
     * @return float 天数
     */
    public function distanceDay($date)
    {
        $mdate = new Date($date);
        return round(abs($mdate->toInt() - $this->toInt()) / 3600 / 24);
    }

    /**
     * 封装了「strtotime」方法
     * @param $add_str strtotime第一参数
     * @param $is_new 是否创建新的svdate
     * @return Svdate
     */
    private function add($add_str, $is_new)
    {
        $t = strtotime($add_str);
        if ($is_new) {
            $svdate = new \Svdate($t);
        } else {
            $this->setTime($t);
            $svdate = $this;
        }
        return $svdate;
    }

}

?>