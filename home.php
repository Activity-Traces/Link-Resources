<?php

require "vendor/autoload.php";


use App\Initialise\initHome;

session_start();

    $initdata = new initHome;



    // en cas où la session est ouverte avec le serveur comper/framework
    if (isset($_SESSION['session']))
        $initdata->idsession=$_SESSION['session'];
    else {
            header('Location: templates/login.php');
    }

    // en cas où on clique sur un référentiel pour le charger : la page home envoie à elle meme l'identifiant  du reférentiel 
                                // cause: architecture MVC simpifiée sans passer par un framework spécialité "ex: sympfony, laravel, etc.

    if (isset($_GET["frameworkId"])) 
        $initdata->frameworkId=$_GET["frameworkId"];
        
    $initdata->init();

    // Les frameworks privés
    $privateFrameworks = $initdata->privateFrameworks;

    // Les frameworks public
    $Publicframeworks = $initdata->publicFrameworks;

    // la structure du framework
    $Treeview = $initdata->treeview;

    // la structure du framework en format json simple pour les manpulations sur l'interface
    $Source=$initdata->Source;

    // mettre les variables d'enrivonnement dans la session pour les utiliser par le controlleur
    if (isset($_GET["frameworkId"])) {

        $_SESSION['Framework'] = $initdata->Source;
        $_SESSION['frameworkId'] = $initdata->frameworkId;
    }

    
    unset($initdata);


?>    

<html>

<head>
<title>Link Resource to framework objects</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" >
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.min.css" />
    <link rel="stylesheet" href="css/sidebar.css" />

</head>

<!--------------------------------------------------------------------------------------------------------------------------->

<body onLoad="keepopen()" >

<!--------------------------------------------------------------------------------------------------------------------------->


<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
  <li><a tabindex="-1" href="#">Action</a></li>
  <li><a tabindex="-1" href="#">Another action</a></li>
  <li><a tabindex="-1" href="#">Something else here</a></li>
  <li class="divider"></li>
  <li><a tabindex="-1" href="#">Separated link</a></li>
</ul>

<!--------------------------------------------------------------------------------------------------------------------------->
    <div id="mySidebar" class="sidebar">

        <li><a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
        <i class="fa fa-lock" aria-hidden="true"></i>
        My private Frameworks</a>
        </li>

            <ul id='pageSubmenu' class="list-group collapse off">
            
                <?php 
     
                    if (is_array($privateFrameworks)){
                                
                        foreach ($privateFrameworks as $node){ 
                         //   if ($node->status=='Private')
                                echo '<li style="background-color:#1E8449;"> <a  href="?frameworkId='.$node->Id.'"> <br>&nbsp;&nbsp;<i class="fas fa-book"></i>&nbsp;'.$node->name. '</a><br></li>';

                            }
                    }
                            
                ?>

            </ul>    
      
<!--------------------------------------------------------------------------------------------------------------------------->
        <li><a href="#pageSubmenu2" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
        <i class="fa fa-unlock" aria-hidden="true"></i>
        Public Frameworks</a>
        </li>

        <ul id='pageSubmenu2' class="list-group collapse off">
        
            <?php 
    
                if (is_array($Publicframeworks)){
                    
                            
                    foreach ($Publicframeworks as $node){ 
                      //  if ($node->status=='Public')
                        echo '<li style="background-color:#1E8449;"><a  href="?frameworkId='.$node->Id.'"><br>&nbsp;&nbsp;<i class="fas fa-book"></i>&nbsp;'.$node->name. ' <br></a></li>';
                    }
                }
                        
            ?>

        </ul>        


        <li><a href="templates/Resources.php"  >
        <i class="fas fa-sticky-note" aria-hidden="true"></i>

        
        Linked Resources</a>
        </li>


    </div>

<!--------------------------------------------------------------------------------------------------------------------------->

<div id="main">
    <div class="navbar">
        <div class="navbar-inner">
                
            <ul class="nav" id="topmenue">

            <a class="openbtn btn-primary pull-right" href="controller/controller.php?logout=true" role="button">Logout</a>

            
                <button class="openbtn pull-right" data-toggle="modal" data-target="#LeftMenu" >
                    <i class="fa fa-question-circle" aria-hidden="true"></i>
                </button>  

                <p id="click_advance"><i class="icon-circle-arrow-down"></i></p>
               
       

                <button class="openbtn" onclick="openNav()">☰</button>
                &nbsp;&nbsp;&nbsp;<label class="text-center" style="  text-align: center; color: #D5C193;"> The Resource you will link: <b>"ASKER/id:<?php echo $_SESSION['activityid'].'/'. $_SESSION['activityname']; ?></b>"</label>
                

            </ul>
        </div>
    </div>

<!--------------------------------------------------------------------------------------------------------------------------->

    <div class="row">
        <Framework class="col-sm-4">
            <h2></h2>
            <p></p>
            <search>    
            <div class="panel-group" id="draggable1">
                <div  class="panel panel-primary">
                    <div class="panel-heading" >
                        <h4 class="panel-title">
                        <a data-toggle="collapse" href="#collapse1">Search in my Framework</a>
                        </h4>
                    </div>
                    <div id="collapse1" class="panel-collapse collapse in">
            

                        <div class="panel-body">
                            <label for="input-select-node" class="sr-only">Search in Tree:</label>
                            <input type="text" class="form-control" id="Search" placeholder="Search  K/S" >  
                        </div>         
                    
                
                        <div class="panel-footer" style="background-color:white;"> 
                            <input type="checkbox" id="AutoAdd" name="AutoAdd"><label>Auto Insert into selected object list</label>
                        </div>
                
                    </div>
                    </div>
            </div>
                
            </search>    
           
            <Tree>
                <div class="panel-group" id="draggable2">
                    <div class="panel panel-primary">

                        <div class="panel-heading">
                            <h4 class="panel-title">
                            <a data-toggle="collapse" href="#collapse2">My Framework Objects</a>
                            </h4>
                        </div>
                    
                        <div id="collapse2" class="panel-collapse collapse in">
                

                            <div class="panel-body" style="word-break:break-all;">
                               
                                <framework id="Tree" >
        
                                </framework>
                               
                            </div>         
                    
                        </div>
                    </div>
                
                </div>    
            </Tree>     

        </Framework>
<!--------------------------------------------------------------------------------------------------------------------------->
        <Node class="col-sm-3">
            <h2></h2><p></p>
<!--------------------------------------------------------------------------------------------------------------------------->
        
            <NodeDetails>    

                <div class="panel-group" id="draggable3">
                    <div class="panel panel-primary">
                        
                        <div class="panel-heading" style="background-color: #709C66">
                            <h4 class="panel-title">
                            <a data-toggle="collapse" href="#collapse3">Object details</a>
                            </h4>
                        </div>

                        <div id="collapse3" class="panel-collapse collapse in">
                
                        <div class="row">
                            <div class="panel-body" >
                                <table id="resourceslinks2" class="table" style=" font-size: 14px; background-color:white  ">
                                    <thead class="thead-dark">

                                    </thead>
                                    <tbody>

                                        <tr><td><b>Node Name: </b></td><td></td><tr>
                                        <tr><td><b>Node Type: </b></td><td></td><tr>
                                        <tr><td><b>Require: </b></td><td></td><tr>
                                        <tr><td><b>Is Complexification of: </b></td><td></td><tr>
                                        
                                    </tbody>
                                </table>    
                            </div>         
                        </div>     
                        </div>
                    </div>
            
                </div>

            </NodeDetails>
       
<!--------------------------------------------------------------------------------------------------------------------------->
            <Resources>

                <div class="panel-group" id="draggable4">
                    <div class="panel panel-primary">
                        
                        <div class="panel-heading" style="background-color:#C17039">
                            <h4 class="panel-title">
                            <a data-toggle="collapse" href="#collapse4">Resources related to Object</a> 
                            <a href="templates/Resources.php" class="pull-right" title="view all resources" target='_blank'
                            ><i class="fas fa-eye"></i></a>
                            </h4>
                        </div>

                        <div id="collapse4" class="panel-collapse collapse in">
                

                            <div class="panel-body">
                                <div class="row">
                                    <table id="resourceslinks" class="table" style=" font-size: 14px; background-color:#F3F7F1  ">
                                                <thead class="thead-dark">
                                                    
                                                </thead>
                                                <tbody>


                                                </tbody>
                                    </table> 
                                </div>           
                            </div>
                        </div>
                    </div>
                
                </div>
            </Resources>
        </Node>  
<!--------------------------------------------------------------------------------------------------------------------------->
        <Panel class="col-sm-5">
            <br>
            <LinkOneResource>
                <div class="panel-group" id="draggable5">
                    <div class="panel panel-primary">
                        
                        <div class="panel-heading" style="background-color: #478A9A">
                            <h4 class="panel-title">
                            <a data-toggle="collapse" href="#collapse5">Link one resource to many objects</a>
                            </h4>
                        </div>

                        <div id="collapse5" class="panel-collapse collapse in">
                

                            <div class="panel-body">
                                <label>selected object list: </label> &nbsp;
                                <button class="btn btn-primary pull-right" title="Remove from selected objects list" onClick="remove_selected_item(KStargets)">
                                    <i class="fas fa-minus"></i>
                                </button> &nbsp;

                                <button id='addToSelection' class="btn btn-primary pull-right" title="Add to selected objects list"><i class="fas fa-plus"></i></button>
                                &nbsp;
                                
                            
                                <div> &nbsp; </div>
                                <form action="controller/controller.php" method="post" onsubmit="return confirm('Do you want to link resource to selected objects?');">
                                    
                                    <select multiple class="form-control" id="KStargets" name= "KStargets[]" style="height: 150px;" required>
                                    </select> 

                                    <hr>
                                
                                    <label>Relation Type </label>
                                    <select class="form-control" name="relationmode">
                                        <option>Is Training Of</option>
                                        <option>Is Learning Of</option>
                                    </select>
                        
                                    <input id='LinkResource' type="submit" class="btn btn-primary" name='LinkResource' value="Link My resource">
                                </form>

            
                            </div>         
        
                        </div>
                    </div>
            
                </div>
            </LinkOneResource>

        </Panel>   
<!--------------------------------------------------------------------------------------------------------------------------->
       
    </div>
</div>

<!--------------------------------------------------------------------------------------------------------------------------->

<div class="modal fade" id="LeftMenu" tabindex="-1" role="dialog" aria-labelledby="Title" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="Title">Help</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p><b> You can: </b></p> 
        <p>Select your framework from the left sidebar </p>
        <p>Search an object (K/S/C) from your framework</p>
        <p>Select an object from  framework box</p>
        <p>Add an object (with option: auto insert) to the selected object list</p>
        <p>Link one selected resource to many selected objects</p>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!--------------------------------------------------------------------------------------------------------------------------->
</body>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>        

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="js/jstree.min.js"></script>
	

<script type="text/javascript">

// variables globales utilisés pour l'affichage des données sur l'interface. utilisés par manip.js

var openside =false;
var NodeType='';
var treeview= <?php echo  $Treeview; ?>;
var source= <?php echo  json_encode($Source); ?>;

/***********************************************************************************************************************/
</script>
<script src="js/manip.js"></script>

</html>
