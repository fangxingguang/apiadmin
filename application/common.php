<?php
// 应用公共文件

//导出称word
function output_word($data,$fileName=''){
    if(empty($data)) return '';
    $data = '
        <html xmlns:v="urn:schemas-microsoft-com:vml"
        xmlns:o="urn:schemas-microsoft-com:office:office"
        xmlns:w="urn:schemas-microsoft-com:office:word"
        xmlns="http://www.w3.org/TR/REC-html40">
        <head><meta http-equiv=Content-Type content="text/html;
        charset=utf-8">
		<style type="text/css">
			table
			{
				border-collapse: collapse;
				border: none;
				width: 100%;
			}
			td
			{
				border: solid #CCC 1px;
			}
			.codestyle{
				word-break: break-all;
				background:silver;mso-highlight:silver;
			}
		</style>
        <meta name=ProgId content=Word.Document>
        <meta name=Generator content="Microsoft Word 11">
        <meta name=Originator content="Microsoft Word 11">
        <xml><w:WordDocument><w:View>Print</w:View></xml></head>
        <body>'.$data.'</body></html>';

    $filepath = tmpfile();
    $data = str_replace("<thead>\n<tr>","<thead><tr style='background-color: rgb(0, 136, 204); color: rgb(255, 255, 255);'>",$data);
    $data = str_replace("<pre><code>","<table width='100%' class='codestyle'><pre><code>",$data);
    $data = str_replace("</code></pre>","</code></pre></table>",$data);
    $len = strlen($data);
    fwrite($filepath, $data);
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename={$fileName}.doc");
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.$fileName.'.doc');
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . $len);
    rewind($filepath);
    echo fread($filepath,$len);
}