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
        if ($bytes < 1024) {
            return $bytes . ' B';
        }
     
        $factor = floor(log($bytes, 1024));
        return sprintf("%.{$decimals}f ", $bytes / pow(1024, $factor)) . ['B', 'KB', 'MB', 'GB', 'TB', 'PB'][$factor];
    }

    public function copy($src, $dest)
    {
        if (file_exists($dest)) {
            echo 'File: ' .$dest .' before exists, choose another name'. END_LINE;
            return;
        }
        
        if (copy($src, $dest)) {
            echo "Successful copy $src to $dest " . END_LINE;
        } else {
            echo "Faild Copy $src " . END_LINE;
        }
    }

    public function delete($src, $confirm = 'N')
    {
        // if (is_file($src)) {
        if (!file_exists($src)) {
            echo 'File: ' .$src .' Not Found .'. END_LINE;
            return;
        } elseif (!$confirm) {
            echo "Notice : Are you sure delete $src? [Y/N]" . END_LINE;
            return;
        }
        
        if (strtolower($confirm) == 'y') {
            if (is_file($src)) {
                if (unlink($src)) {
                    echo "Successful Delete $src " . END_LINE;
                } else {
                    echo "Faild delete $src " . END_LINE;
                }
            } elseif (is_dir($src)) {
                $this->deleteDir($src); 
                // TODO Show Message for delete
            }
        } else {
            echo "Canceled  delete $src " . END_LINE;
        }
    }

    public function mkdir($path, $mode = 0777, $recursive = true)
    {
        if (mkdir($path, $mode, $recursive)) {
            echo "Successful Create path $path " . END_LINE;
        } else {
            echo "Failed to create path $path " . END_LINE;
        }
    }

    // https://stackoverflow.com/a/3349792
    public function deleteDir($dirPath) {
        if (! is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }
}