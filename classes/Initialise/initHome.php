<?php

namespace App\Initialise;

//*****************************************************************************************************************************
//*****************************************************************************************************************************

use App\TreeView\Tree;
use App\FrameworkManager\Frameworks;
   
class initHome
{
    public $idsession;
    public $frameworkId;
    
    public $privateFrameworks;
    public $publicFrameworks;
    public $treeview;
    public $Source;

    //*****************************************************************************************************************************
    public function __construct(){

        $this->Source='[{}]';
        $this->treeview='[{ "id" : "none", "parent" : "#", "text" : "/" }]';

    }
    
    /*********************************************************************************************************************** */

    public function init()
    {

        $Tree_Request = new Tree;
        $Framework_Request = new Frameworks;

        $Framework_Request->setIdSession($this->idsession);

        //* récupérer les frameworks public
        $Framework_Request->FrameworksList(0);
        $this->privateFrameworks = $Framework_Request->getFrameworksList();

        //* récupérer les frameworks Private
        $Framework_Request->FrameworksList(1);
        $this->publicFrameworks = $Framework_Request->getFrameworksList();


        if (isset($this->frameworkId)) {
            
            $Framework_Request->setFrameworkId($this->frameworkId);
            $Framework_Request->FrameworkContent();

            $this->Source =  $Framework_Request->getFrameworksContent();

            $Framework_Request->getResourcesList($this->Source);

            $this->resources =   $Framework_Request->getResources();
            
            $this->treeview = $Tree_Request->frameworkToTreeView($this->Source);
            
        }

        unset($Framework_Request, $Tree);
        
    }

//*****************************************************************************************************************************
//*****************************************************************************************************************************

}

?>
