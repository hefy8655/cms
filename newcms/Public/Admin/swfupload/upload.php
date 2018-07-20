<?php
$file_path = "/Public/Uploads";
if (isset($_FILES["Filedata"]) || !is_uploaded_file($_FILES["Filedata"]["tmp_name"]) || $_FILES["Filedata"]["error"] != 0) {
    $upload_file = $_FILES['Filedata'];
    $file_info = pathinfo($upload_file['name']);
    $file_type = $file_info['extension'];

    $targetPath = $_SERVER['DOCUMENT_ROOT'].$file_path.'/Topiclbum';
    // $targetFile = rtrim($targetPath,'/') . '/' . date('Y-m-d',time()) .'/'. $_FILES['Filedata']['name'];
    $targetFile = rtrim($targetPath,'/').'/'.date('Y-m-d',time()).'/';


    if(!file_exists($targetFile)){
        mkdir($targetFile,0777,true);
    }


    $targetName = md5(uniqid($_FILES["Filedata"]['name'])).'.'.$file_info['extension'];
    $save = $targetFile.$targetName;
    $name = $_FILES['Filedata']['tmp_name'];
    echo date('Y-m-d',time()).'/'.$targetName;
    if (!move_uploaded_file($name, $save)) {
        exit;
    }
    //将数组的输出存起来以供查看
//    $fileName = 'test.txt';
//    $postData = var_export($file_info, true);
//    $file     = fopen('' . $fileName, "w");
//    fwrite($file,$postData);
//    fclose($file);
}
exit;
?>