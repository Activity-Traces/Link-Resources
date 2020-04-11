<?php

require "../vendor/autoload.php";

use App\FrameworkManager\Frameworks;

    session_start();

    $Framework_Request = new Frameworks;

//*****************************************************************************************************************************

    if(isset($_GET["logout"])){
        session_unset();
        session_destroy ();
        header('Location: ../templates/login.php');

        exit;
    }

//*****************************************************************************************************************************

    if (isset($_SESSION['session'])) {
        
        $Framework_Request->setIdSession($_SESSION['session']);
        $Framework_Request->setFrameworkId($_SESSION['frameworkId']);

    }
    else
    {
        echo 'Session fermée avec le serveur comper/frameworks';
    }

//*****************************************************************************************************************************
// informations envoyées par la plateforme d'aspprentissage (un boutton dans le module qui crée un m-exercice dans ASKER)

    if (isset($_POST["fromPlatform"])) {

        $Framework_Request->setUrl("https://traffic.irit.fr/comper/repository/framework-management-api/login");
        $Framework_Request->setData('{"email" : "'.$_POST["username"].'" , "password" : "'.$_POST["password"].'"}');

        $Framework_Request->connect(false, "POST");

        $result=json_decode($Framework_Request->getResult(), true);

        if (isset($result['id-session']))  {

            $_SESSION['session'] = $result['id-session'];           
            $_SESSION['username'] =  $_POST["username"];
            $_SESSION['password'] =  $_POST["password"];
            $_SESSION['activityid']= $_POST["activityid"];
            $_SESSION['activityname']= $_POST["activityname"];
            $_SESSION['author']= $_POST["author"];
            $_SESSION['resourcetype']= $_POST["type"];
            $_SESSION['urlresource']= $_POST["urlresource"];
            
            header('Location: ../home.php');
    
        }
        else

        {
            echo "Impssible de se connecter au serveur du Framework: erreur /<br>".$result;
            exit;
        }

    }

//*****************************************************************************************************************************
// Lier une resource à un K/S

    if (isset($_POST["LinkResource"])) {

        // récupérer les paramètres d'insertion envoyées par la page d'acceuil

        $objects=$_POST["KStargets"];

        $object='[';
        foreach ($objects as $value)
            $object=$object.'"'.$value.'",';
            $object=rtrim($object, ',');
            $object=$object.']';
        
        $relationmode=$_POST["relationmode"];
    
        if ($relationmode=="Is Training Of")
            $relation="hasTraining";

        if ($relationmode=="Is Learning Of")
            $relation="hasLearning";

        
        // récupérer les données à insérer depuis le formulaire de connexion: ces infos sont enregistrées dans la session de l'application

        $idsession=$_SESSION['session'];
        $author =$_SESSION['username'];
        $resourceid=$_SESSION['activityid'];
        $resourcename=$_SESSION['activityname'];
        $author =$_SESSION['author'];
        $urlResource=$_SESSION['urlresource'];
            
        $resourceType=$_SESSION['resourcetype'];
        
        // ajouter la resource

        $Framework_Request->addresource($resourceid, $resourcename, $resourceType, $object, $author, $urlResource, $relation);
    
        header('Location: ../home.php?frameworkId='.$_SESSION['frameworkId']);

    }

/*************************************************************************************************************************/

    // supprimer un lien entre une resource et un K/s
   
    if(isset($_GET["deletelink"])){

            $frameworkId=$_GET["frameworkId"];
            $resource=$_GET["resource"];
            $relation=$_GET["relation"];
            $object=$_GET["object"];

            $Framework_Request->deleteLinkresource($resource, $object, $relation);
            header('Location: ../home.php?frameworkId='.$_SESSION['frameworkId']);

    }

/*************************************************************************************************************************/

    // supprimer la ressource avec tous les liens K/S

    if ((isset($_POST["deleteresource"]))) {
        if (!empty($_POST["ChoixAjouter"])) {
    
            $liste=$_POST["ChoixAjouter"];
            foreach ($liste as $identifiant) {

                $Framework_Request->deleteresource($identifiant);
            // echo $request->result;
            }
        }
        header('Location: ../templates/resources.php');

    }
     

 /*************************************************************************************************************************/   

    unset($Framework_Request);
?>