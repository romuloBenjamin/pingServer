<?php
class PageBuilder
{
    var $module;
    var $folder;
    var $file;
    var $build;
    var $xplit;

    public function __construct()
    {
        $this->build = array();
    }

    /*---------------------------------------->* LOUD HTML DATA *<----------------------------------------*/
    public function loudHTML()
    {
        $path = DIR_PATH . "cnt-" . trim($this->module) . "/" . trim($this->file) . ".html";
        return file_get_contents($path);
    }
    /*-----------------------> BUILD HEADER*/
    public function buildHeader()
    {
        /*REMOVE DATA*/
        $remove = array("[META]", "[LINKS]", "[SCRIPTS]");
        /*HEADER BASE DATA*/
        $base = $this->build["header"];
        /*REPLACE PARTS*/
        $base = str_replace($remove[0], $this->build["meta"], $base);
        $base = str_replace($remove[1], $this->build["links"], $base);
        $base = str_replace($remove[2], $this->build["scripts"], $base);
        return $base;
    }
    /*-----------------------> LOUD TEMPLATE*/
    public function loudHTMLTemplate()
    {
        $path = DIR_PATH . "cnt-modules/" . trim($this->module) . "-module/" . trim($this->folder) . "/" . trim($this->file) . ".html";
        return file_get_contents($path);
    }
    /*---------------------------------------->* LOUD PHP DATA *<----------------------------------------*/
    public function loudPHP()
    {
        $path = DIR_PATH . "cnt-" . trim($this->module) . "/" . trim($this->file) . ".php";
        return file_get_contents($path, true);
    }
}
