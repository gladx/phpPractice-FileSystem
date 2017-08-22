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
        if(SHOW_HIDE_FILE)
            return $list;
        $hideList = [];
        foreach ($list as $file) {
            if($file == '..')
                continue;
            if($file[0] == '.')
                $hideList[] = $file;
        }
        return array_diff($list, $hideList);
    }
    public function showList()
    {
        $list = $this->filterDir(scandir('.'));
        
        $cwd = getcwd();
        foreach ($list as $file) {
            echo "<a href=\"index.php?dir=$cwd/$file\" > $file </a>" . END_LINE;
        }
    }
}