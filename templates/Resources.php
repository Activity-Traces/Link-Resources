<?php

use App\FrameworkManager\Frameworks;

require "../vendor/autoload.php";
    
    session_start();

    $Framework_Request = new Frameworks;
  
    if(!empty($_SESSION['frameworkId'])){
        $Framework_Request->setIdSession($_SESSION['session']);            
        $Framework_Request->setFrameworkId($_SESSION['frameworkId']);
        $Framework_Request->FrameworkContent();
        $sourceTree = $Framework_Request->getFrameworksContent();
        
    }
?>

<head>

    <title>List of resources</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</head>

<div class="row bg-primary" >
</div>


<div class="row">

    <div class="panel-body">

        <form action='../controller/controller.php' method='post'>        
        <body>
        <table class="table table-striped" >
            <thead class="thead-white">
                <tr>
                    <th scope="col">identifier</th>
                    <th scope="col">Name</th>
                    <th scope="col">Type</th>
                    <th scope="col">Author</th>
                    <th scope="col">Url</th>
                    <th scope="col">Is Training Of</th>
                    <th scope="col">Is Learning Of</th>
                    <th scope="col">Delete Resource</th>
                </tr>
            </thead>

            <tbody>
                <?php

                   

                  
                    /********************************************************************************************************************************* */
                    if (isset($sourceTree)&&($sourceTree!="Expired session, Pleased login again !")){
                        
                        foreach ($sourceTree->resources as $node){ 
                                                                   
                                    $val1="";
                                    $val2="";

                                    if (isset($node->relations->isLearningOf))
                                        foreach($node->relations->isLearningOf as $islearning)
                                                $val2=$val2. $islearning."<br> ";

                                    if (isset($node->relations->isTrainingOf))
                                        foreach($node->relations->isTrainingOf as $islearning)
                                                $val1=$val1. $islearning."<br> ";
                                
                                    echo "<tr>
                                    <td>". $node->id ."</td>
                                    <td>".$node->name."</td>
                                    <td>".$node->type."</td>
                                    <td>".$node->author."</td>
                                    <td>".$node->url."</td>
                                    <td>".$val1."</td>
                                    <td>".$val2."</td>

                                    <td>
                                        <input class='form-check-input' type='checkbox' name='ChoixAjouter[]' value='".$node->id."'>
                                    </td>
                                </tr>";
                        }


                    }

                ?>
            </tbody>
        </table>
        <button type="submit" class="btn btn-info"  name='deleteresource'>Delete selected resources</button>
        </form>
    </div>
</div>    