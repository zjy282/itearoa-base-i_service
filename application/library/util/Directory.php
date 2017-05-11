<?php
/**
 * 文件目录类。
 * 当传入的路径包含多层目录且不存在时，可逐级创建这些目录。
 * 全部创建成功返回true，否则返回false
 */
class Util_Directory {
    /**
     * 获取父级目录
     * @param <string> $folderPath 目录路径
     * @return <string> 父级目录路径
     */
    public static function GetParentFolder( $folderPath ) {
        $sPattern = "-[/\\\\][^/\\\\]+[/\\\\]?$-" ;
        return preg_replace( $sPattern, '', $folderPath ) ;
    }

    /**
     * 根据路径创建各级目录
     * @param <string> $folderPath 目录路径
     * @param <string> $lastFolder 最后一级目录，在程序递归时自动赋值，平时调用时不应赋值。
     * @return <bool> 创建成功返回true，否则返回false
     */
    public static function CreateServerFolder( $folderPath, $lastFolder = null ) {
        $sParent = self::GetParentFolder( $folderPath ) ;
        $sErrorMsg = '';

        //去掉路径中的双斜线，否则在特定的系统上会造成mkdir失败
        while ( strpos($folderPath, '//') !== false ) {
            //$folderPath = strtr($folderPath, '//', '/');
            $folderPath = str_replace('//', '/', $folderPath);
        }

        //检查上级目录是否存在，如果不存在则主动创建
        if ( !file_exists( $sParent ) ) {
            //避免在无法创建根目录时发生无限循环
            if ( !is_null( $lastFolder ) && $lastFolder === $sParent) {
                //return "Can't create $folderPath directory" ;
                return false;
            }

            $sErrorMsg = self::CreateServerFolder( $sParent, $folderPath ) ;
            if( !$sErrorMsg ){
                return false;
            }
        }

        if ( !file_exists( $folderPath ) ) {
            //关闭错误报告
            error_reporting( 0 ) ;
            $php_errormsg = '' ;
            //开启错误跟踪以便记录错误
            ini_set( 'track_errors', '1' ) ;

            $permissions = 0777 ;
            $oldumask = umask(0) ;
            $result = mkdir( $folderPath, $permissions ) ;
            umask( $oldumask ) ;

            //充值系统设置
            ini_restore( 'track_errors' ) ;
            ini_restore( 'error_reporting' ) ;

            return $result;
        }
        else {
            return true ;
        }
    }

    /**
     * 删除指定的目录
     * @return 删除成功返回true，否则返回false
     * @param string 目录路径
     */
    public static function RemoveDir($dirName) {
        $result = false;
        if(!is_dir($dirName)) {
            return false;
        }

        $handle = opendir($dirName);
        while(($file = readdir($handle)) !== false) {
            if($file != '.' && $file != '..') {
                $dir = $dirName . DIRECTORY_SEPARATOR . $file;
                is_dir($dir) ? rmdir($dir) : unlink($dir);
            }
        }

        closedir($handle);
        $result = rmdir($dirName) ? true : false;
        return $result;
    }

    /**
     * 删除指定目录下的所有文件
     * @return 删除成功返回true，否则返回false
     * @param string 目录路径
     */
    public function RemoveFiles($dirName) {
        $result = false;
        if(!is_dir($dirName)) {
            return false;
        }

        $handle = opendir($dirName);
        while(($file = readdir($handle)) !== false) {
            if($file != '.' && $file != '..') {
                $dir = $dirName . DIRECTORY_SEPARATOR . $file;
                if(!is_dir($dir)) {
                    unlink($dir);
                }
            }
        }

        closedir($handle);
        return $result;
    }
}
?>