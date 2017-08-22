<?php
class FileSystem
{
    public function __construct($path = '.')
    {
        chdir($path);
    }

    public function showList()
    {
        $list = scandir('.');
        $cwd = getcwd();
        foreach($list as $file)
        {
            echo "<a href=\"index.php?dir=$cwd/$file\" > $file </a>" . END_LINE;
        }
    }


}

