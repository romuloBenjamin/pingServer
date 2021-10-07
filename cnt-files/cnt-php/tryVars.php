<?php
class TryVars
{
    var $module;
    var $file;
    var $build;
    var $changes;

    public function __construct()
    {
        $this->build = array();
    }

    /*CARREGA CONEXOES*/
    public function loudConections()
    {
        $loud = DIR_PATH . "cnt-modules/" . trim($this->module) . "-module/loudMods.json";
        $loud = json_decode(file_get_contents($loud))->conexoes;
        include DIR_PATH . "cnt-sql/" . LOCAL . "/" . trim($loud[0]->file) . ".php";
        include DIR_PATH . "cnt-sql/" . trim($loud[1]->file) . ".php";
    }
    /*CARREGA LISTAS*/
    public function loudListas()
    {
        $loud = DIR_PATH . "cnt-modules/" . trim($this->module) . "-module/loudMods.json";
        $loud = json_decode(file_get_contents($loud))->listas;
        for ($i = 0; $i < count($loud); $i++) {
            $this->build["listarIPS"][$loud[$i]->file] = file_get_contents(DIR_PATH . "cnt-modules/" . $loud[$i]->module . "-module/" . $loud[$i]->folder . "/" . trim($loud[$i]->file) . ".json");
        }
        return $this->build["listarIPS"];
    }
    /*CARREGA MODULES*/
    public function loudMods()
    {
        $loud = DIR_PATH . "cnt-modules/" . trim($this->module) . "-module/loudMods.json";
        $loud = json_decode(file_get_contents($loud))->modules;
        for ($i = 0; $i < count($loud); $i++) {
            include DIR_PATH . "cnt-modules/" . trim($loud[$i]->module) . "-module/" . trim($loud[$i]->folder) . "/" . trim($loud[$i]->file) . ".php";
        }
    }
    /*BUILD HTML -> header*/
    public function loudHeader()
    {
        /*GET PARTS -> HEADER*/
        $pBuild = new PageBuilder();
        $pBuild->module = "html";
        $pBuild->file = "header";
        $this->build["header"] = $pBuild->loudHTML();

        /*GET PARTS -> META*/
        $pBuild2 = new PageBuilder();
        $pBuild2->module = "html";
        $pBuild2->file = "meta";
        $this->build["meta"] = $pBuild2->loudHTML();

        /*GET PARTS -> LINKS*/
        $pBuild3 = new PageBuilder();
        $pBuild3->module = "html";
        $pBuild3->file = "links";
        $this->build["links"] = $pBuild3->loudHTML();

        /*GET PARTS -> SCRIPTS*/
        $pBuild4 = new PageBuilder();
        $pBuild4->module = "html";
        $pBuild4->file = "scripts";
        $this->build["scripts"] = $pBuild4->loudHTML();

        /*BUILD PAGE*/
        $getBuild = new Pagebuilder();
        $getBuild->build = $this->build;
        $this->build["header"] = $getBuild->buildHeader();
        echo $this->build["header"];
    }
    /*BUILD HTML -> body*/
    public function loudBody()
    {
        return include DIR_PATH . "cnt-html/body.php";
    }
}
