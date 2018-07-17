<?php
namespace ScriptBurn\YoutubeDL;
class YoutubeDLWrapper
{
	private $dlPath;
	public function __construct($dlPath="")
	{
		$this->dlPath =$dlPath?$dlPath:"youtube-dl";
	}

	public function getInfo($url)
	{
		$cmd = $this->dlPath . ' "'.$url.'"'." --skip-download --prefer-ffmpeg --print-json --restrict-filenames  2>&1";
 		exec($cmd, $retArr, $retVal);

		return [$retVal, $retArr ];
	}
}