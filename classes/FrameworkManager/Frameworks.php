<?php

namespace App\FrameworkManager;

//*****************************************************************************************************************************
//*****************************************************************************************************************************

class Frameworks {

    private $frameworkId;
    private $idsession;
    private $url;
    private $data;
    private $resources;

    private $result;
    private $frameworkList;
    private $FrameworkContent;
    

//*****************************************************************************************************************************

    public function __construct(){
        $this->frameworkId = -1;
        $this->resources=array();
    }

//*****************************************************************************************************************************

    public function setFrameworkId($frameworkId){
        $this->frameworkId=$frameworkId;

    }
//*****************************************************************************************************************************

    public function setIdSession($idsession){
        $this->idsession=$idsession;

    }

//*****************************************************************************************************************************

    public function setUrl($url){
        $this->url=$url;

    }
    
//*****************************************************************************************************************************

    public function setData($data){
        $this->data=$data;

    }

//*****************************************************************************************************************************
    public function getResources(){
        return $this->resources;
    }

//*****************************************************************************************************************************
    public function getResult(){
        return $this->result;
    }

//*****************************************************************************************************************************
    public function getFrameworksList(){
        return $this->frameworkList;
    }

//*****************************************************************************************************************************
    public function getFrameworksContent(){
        return $this->FrameworkContent;
    }

//*****************************************************************************************************************************

    public function Connect($withsession, $mode){

        if ($withsession != true)
            $header = array("Content-Type: application/json");
        else
            $header = array("Content-Type: application/json", "Cookie: JSESSIONID=" . $this->idsession);


        $curl = curl_init();

        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => $this->url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => $mode,
                CURLOPT_POSTFIELDS => $this->data,
                CURLOPT_HTTPHEADER => $header

            )
        );

        $this->result = curl_exec($curl);
       
    }

//*****************************************************************************************************************************

    public function getResourcesList($Source){

        foreach ($Source->resources as $node) {
        
            array_push($this->resources, $node->name);
        }

    }

//*****************************************************************************************************************************

    public function FrameworksList($mode){
        if ($mode==0) 
            $this->url = "https://traffic.irit.fr/comper/repository/framework-management-api/framework/list/Private";
        if ($mode==1) 
            $this->url = "https://traffic.irit.fr/comper/repository/framework-management-api/framework/list/Public";

        $this->data='';
        
        $this->Connect(true, "GET");
        $this->frameworkList = json_decode($this->result);

    }

//*****************************************************************************************************************************

    public function FrameworkContent(){

        $this->url = "https://traffic.irit.fr/comper/repository/framework-management-api/framework/" . $this->frameworkId . "/JSON";
        $this->data='';

        $this->Connect(true, "GET");
        $this->FrameworkContent = json_decode($this->result);
    }

//*****************************************************************************************************************************

    public function addresource($resourceid, $resourcename, $resourcetype, $objects, $author, $url, $relationmode){

            $this->url="https://traffic.irit.fr/comper/repository/framework-management-api/addresources";

        
        $this->data= '{"framework" : '.$this->frameworkId.' , 
                    "resources" :
                    [
                        {
                            "resource":{

                                "id":"'. $resourceid.'",
                                "name":"'. $resourcename.'",
                                "type":"'. $resourcetype.'", 
                                "author":"'. $author.'", 
                                "url":"'. $url.'"
                        }, 
                        
                        "objects":'. $objects.',
                        "relation":"'. $relationmode.'"}
                    ]

                }';
        
        $this->Connect(true, "POST");

    }

//*****************************************************************************************************************************

    public function deleteresource($resource){
        
        $this->url="https://traffic.irit.fr/comper/repository/framework-management-api/remove-resources/delete/". $this->frameworkId ."/".$resource;
        $this->Connect(true, "PUT");


    }

//*****************************************************************************************************************************

    public function deleteLinkresource($resource, $object, $relation ){

        $this->data='
        { "frameworkId" : '.$this->frameworkId .', "resources":
        [
            {
            "id":"'.$resource.'","relation":"'.$relation.'","object":"'.$object.'"
            }
            ]
        }';


        $this->url="https://traffic.irit.fr/comper/repository//framework-management-api/remove-resources/remove";
        $this->Connect(true, "PUT");

    }

//*****************************************************************************************************************************
//*****************************************************************************************************************************

}
