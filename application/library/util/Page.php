<?php

class Util_Page {

    public static function getPageHtml($total, $limit, $page = 1) {
        $html = array();
        $page = $page > 0 ? $page : 1;
        if ($total > 0 && $limit > 0) {
            $pageTotal = ceil($total / $limit);
            if ($pageTotal > 15) {
                $first = 1;
                if (($page - $first) > 3) {
                    $html[] = "<li><a>{$first}</a></li>";
                    $html[] = "<li><a op='no'>...</a></li>";
                    $pageRight = ($pageTotal - $page > 3) ? ($page + 2) : $pageTotal;
                    for ($i = $page - 2; $i <= $pageRight; $i ++) {
                        $class = ($i == $page) ? ' class="active"' : '';
                        $html[] = "<li{$class}><a>{$i}</a></li>";
                    }
                    if ($pageTotal - $page > 3) {
                        $html[] = "<li><a op='no'>...</a></li>";
                    }
                    if ($pageRight < $pageTotal) {
                        $html[] = "<li{$class}><a>{$pageTotal}</a></li>";
                    }
                } else {
                    for ($i = 1; $i <= 5; $i ++) {
                        $class = ($i == $page) ? ' class="active"' : '';
                        $html[] = "<li{$class}><a>{$i}</a></li>";
                    }
                    if ($pageTotal - $page > 1) {
                        $html[] = "<li><a op='no'>...</a></li>";
                    }
                    $html[] = "<li{$class}><a>{$pageTotal}</a></li>";
                }
            } else {
                for ($i = 1; $i <= $pageTotal; $i ++) {
                    $class = ($i == $page) ? ' class="active"' : '';
                    $html[] = "<li{$class}><a>{$i}</a></li>";
                }
            }
        }
        return implode('', $html);
    }
}
?>