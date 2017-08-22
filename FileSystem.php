<?php
class FileSystem
{
    public function __construct($path = '.')
    {
        chdir($path);
    }

    /*
     * function for filter directory start with .
     */
    public function filterDir($list)
    {
        if (SHOW_HIDE_FILE) {
            return $list;
        }
        $hideList = [];
        foreach ($list as $file) {
            if ($file == '..') {
                continue;
            }
            if ($file[0] == '.') {
                $hideList[] = $file;
            }
        }
        return array_diff($list, $hideList);
    }
    public function showList()
    {
        $list = $this->filterDir(scandir('.'));
        
        $cwd = getcwd();
        foreach ($list as $file) {
            $ext = '';
            $info = '';
            $path = $name = $file;
            if ($file == '..') {
                $name = '<-- Parent Directory';
            }
            if (is_dir($file) && $file != '..') {
                $name .= '/';
            }

            if (is_file($file)) {
                $info = 'size: ' . $this->human_filesize(filesize($file));
            }

            echo "<a href=\"index.php?dir=$cwd/$path\" > $name </a>\t" ;
            echo $info;
            echo  END_LINE;
        }
    }
    
    /**
     *
     * Convert bytes to human readable
     */
    public function human_filesize($bytes, $decimals = 2)
    {
        $sz = 'BKMGTP';
        $factor = floor((strlen($bytes) - 1) / 3);
        if ($bytes < 1024 || ($bytes%1024 == 0)) {
            return sprintf("%ld", $bytes / pow(1024, $factor)) . @$sz[$factor];
        }
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
    }

    public function copy($src, $dest)
    {
        if(file_exists($dest)){
            echo 'File: ' .$dest .' before exists, choose another name'. END_LINE;
            return;
        }
        
        if(copy($src, $dest))
        {
            echo "Successful copy $src to $dest " . END_LINE;
        }
        else
        {
            echo "Faild Copy $src \n" . END_LINE; 
        }
    }
}