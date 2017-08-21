<?php
class FileSystem
{
    public $path;
    public $cwd;

    public function __construct($path = '.')
    {
        //$this->setPath($path);
        $this->setPath('.');
        chdir($path);
    }
    public function setPath($path)
    {
        $this->path = $path;
       // $this->cwd  = chdir($path);
    }

    public function getPath()
    {
        return $this->path;
    }
    public function showList()
    {
        $list = scandir($this->getPath());
        $cwd = getcwd();
        foreach($list as $file)
        {
            
            echo "<a href=\"index.php?dir=$cwd/$file\" > $file </a>" . END_LINE;
        }
    }


}

