<?php

class Template
{
	function __construct($dir)
	{
		$this->basedir = $dir;
		$this->entries = Template::reccursive_scandir($dir);
	}

	protected static function reccursive_scandir_ ($dir)
	{
		$dirlist = [];
		foreach(scandir($dir) as $dirent)
		{
			if ($dirent == "." || $dirent == "..")
				continue;
			$dirent = "$dir/$dirent";
			if (is_dir($dirent))
				$dirlist = array_merge($dirlist, Template::reccursive_scandir_($dirent));
			else
				$dirlist[] = $dirent;
		}
		return $dirlist;
	}

	protected static function reccursive_scandir($dir)
	{
		$rebase_ = function ($curr) use ($dir)
		{
			$i = strstr($curr, $dir);
			if ($i >= 0)
				return substr($curr, strlen($dir) + 1);
			return null;
		};

		return array_map($rebase_, Template::reccursive_scandir_($dir));
	}

	protected function put_file($_destination, $_contents)
	{
		$the_dir = dirname($_destination);
		if (!file_exists($the_dir))
			mkdir($the_dir, 0777, true);
		file_put_contents($_destination, $_contents);
	}

	protected function instantiate_template($_destination, $_source, $_data)
	{
		foreach ($_data as $_one)
			extract($_one, EXTR_OVERWRITE);
		ob_start();
		include ("{$this->basedir}/$_source");
		$this->put_file($_destination, ob_get_clean());
	}

	public function instantiate($_build_dir = "./build", ...$_data)
	{
		foreach($this->entries as $_source)
		{
			$_callback = function ($_var) use ($_data)
			{
				if (isset($_data[0][$_var[1]]))
					return $_data[0][$_var[1]];
				return $_var[0];
			};
			$_destination = preg_replace_callback('/\{(.*?)\}/', $_callback, $_source);
			$this->instantiate_template("$_build_dir/$_destination", $_source, $_data);
		}
	}

	private $basedir = './';
	private $entries = [];
};