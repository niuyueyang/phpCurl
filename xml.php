<?php

// 指定允许其他域名访问  
header('Access-Control-Allow-Origin:*');  
// 响应类型  
header('Access-Control-Allow-Methods:POST');  
// 响应头设置  
header('Access-Control-Allow-Headers:x-requested-with,content-type');  
function https_request($url,$data=null)
{
    $curl = curl_init();
    curl_setopt($curl,CURLOPT_URL,$url);
    curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,FALSE);
    curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,FALSE);
    if(!empty($data)){
        curl_setopt($curl,CURLOPT_POST,1);
        curl_setopt($curl,CURLOPT_POSTFIELDS,$data);
    }
    curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
    //Content-Type: application/json 修改  zsh
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json'
    ));
    $output = curl_exec($curl);
    curl_close($curl);
    return $output;
}
function xmlToArray($xml){
	 //禁止引用外部xml实体
	libxml_disable_entity_loader(true);
	$xmlstring = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
	$val = json_decode(json_encode($xmlstring),true);
	return $val;
}

$url = "http://agric.ydtcloud.com/cloud/company/bases";
$json = json_encode(array('uid'=>'U881560154649133056'));
$res = https_request($url,$json);
$result=xmlToArray($res);
echo json_encode(array('result'=>$result));
?>