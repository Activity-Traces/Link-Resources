<?php


namespace  App\TreeView;

class Tree

{
    private $treeview;

    //*****************************************************************************************************************************

    public function __construct(){
        $this->treeview ='[{ "id" : "none", "parent" : "#", "text" : "/" }]';
        $this->answers=array();
        $this->marks=array();
        $this->simpleTreeview=array();
        
    }

    //*****************************************************************************************************************************

    public function getTreeView()
    {
        return $this->treeview;

    }
 
    //*****************************************************************************************************************************

    public function createnode($id, $text, $parent, $icon, &$Tree, $mode, $countResources){
        if ($mode==1)
            $id=rand() . ':' .$id;

        $MyNode = array(
            'id' => $id,
            'parent' => $parent,
            'text' => $text.'&nbsp;<b>('.$countResources.')<b>',
            'icon' => $icon
        );
        array_push($Tree, $MyNode);
        
    }
    
    //*****************************************************************************************************************************/

    public function findNode($Name, $X)
    {

        foreach ($X as $XNode) {
            if ($Name == $XNode['Id'])
                return ($XNode);
        }
    }

    //*****************************************************************************************************************************

    public function filter($str, $charset='utf-8')
	{
	    $str = htmlentities($str, ENT_NOQUOTES, $charset);
	    
	    $str = preg_replace('#\&([A-za-z])(?:acute|cedil|circ|grave|ring|tilde|uml)\;#', '\1', $str);
	    $str = preg_replace('#\&([A-za-z]{2})(?:lig)\;#', '\1', $str); // pour les ligatures e.g. '&oelig;'
	    $str = preg_replace('#\&[^;]+\;#', '', $str); // supprime les autres caractères
	    $str = preg_replace('@[^a-zA-Z0-9_]@','',$str);
	    return $str;
    }
    
    //*****************************************************************************************************************************
    
    public function createTree($node, $relation, &$Destination, &$SimpleTree, $icon, $mode){

        $countResources=sizeof($node->relations->hasTraining);

        if (isset($relation)) {
            foreach ($relation as $RelationEelement) {
                $this->createnode($node->name, $node->name, $RelationEelement, $icon, $Destination, $mode, $countResources);
            }
        }

    }

    //*****************************************************************************************************************************
    
    public function frameworkToTreeView($Source){

        if ($Source != Null) {

            $Destination = array();            

            $this->createnode($Source->frameworkName, $Source->frameworkName, "#", $icon= 'fas fa-book text-danger', $Destination, 0, "");

            foreach ($Source->objects as $node) {
          
                if ($node->type == 'Competency')
                    $icon = 'fab fa-cuttlefish text-warning';

                if ($node->type == 'Skills')
                    $icon = 'fab fa-stripe-s text-primary';

                if ($node->type == 'Knowledge')
                    $icon = 'fab fa-kickstarter-k text-success';
                

                 $this->createTree($node, $node->relations->composes, $Destination, $SimpleTree,  $icon, 0);
                 $this->createTree($node, $node->relations->isKnowledgeOf, $Destination, $SimpleTree, $icon, 0);
                 $this->createTree($node, $node->relations->isSkillOf, $Destination, $SimpleTree, $icon, 0);
                 $this->createTree($node, $node->relations->isComprisedIn, $Destination, $SimpleTree, $icon, 0);

            }

            return (json_encode($Destination));
        }
    }

     //*****************************************************************************************************************************

}
