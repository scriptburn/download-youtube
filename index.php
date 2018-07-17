<?php
ob_start();
include_once "init.php";

if (!empty($_POST['url']))
{
	try
	{
		$data = ['status' => 0, 'data' => 'Unknown error', 'action' => 'fetch'];
		$wrapper = new \ScriptBurn\YoutubeDL\YoutubeDLWrapper(@file_get_contents(__DIR__."/.env"));
		$result = $wrapper->getInfo($_POST['url']);
		 
		if ($result[0])
		{
			$data['raw'] = $result;
			throw new \Exception('Failed to parse video info');
		}
		elseif(empty($result[1][0]))
		{
			$data['raw'] = $result;
			throw new \Exception('Invalid response');
		}
		elseif(count($result[1])>1)
		{
			$data['raw'] = $result;
			throw new \Exception('Failed to receive video info');
		}
		
		$data['status'] = 1;
		$data['data'] = json_decode(@$result[1][0], true);
		$data['raw']=$result;
		$data['url']=$_POST['url'];

		
	}
	catch (\Exception $e)
	{
		$data['status'] = 0;
		$data['data'] = $e->getMessage();
	}
	header('Content-Type: application/json');
	echo json_encode($data);
	exit();
}

include_once "template.html";