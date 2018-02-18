<?php

class Template
{
	function __construct($dir)
	{
		$this->basedir = $dir;
		$this->entries = [];
		foreach (Template::reccursive_scandir($dir) as $file)
		{
			if (stripos($file, '.fragments') === 0)
			{
				$name = explode('/', $file)[1];
				$name = explode('.', $name);
				array_pop($name);
				$name = implode('.', $name);
				$this->fragments[$name] = $file;
				continue;
			}
			$this->entries[] = $file;
		}
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

	protected function put_file($_build_dir, $_destination, $_contents)
	{
		$the_dir = dirname("$_build_dir/$_destination");
		if (!file_exists($the_dir))
			mkdir($the_dir, 0777, true);
		file_put_contents("$_build_dir/$_destination", $_contents);
		$this->generated [] = $_destination;
	}


	protected function instantiate_template($_source, $_data)
	{
		foreach ($_data as $_one)
			extract($_one, EXTR_OVERWRITE);
		ob_start();
		include ("{$this->basedir}/$_source");
		return ob_get_clean();
	}

	public function instantiate_fragment($name, ...$_data)
	{
		echo $this->instantiate_template($this->fragments[$name], $_data);
	}

	public function instantiate($_build_dir = "./build", ...$_data)
	{
		$_all_args = array_merge(...$_data);
		foreach($this->entries as $_source)
		{
			$_callback = function ($_var) use ($_all_args)
			{
				if (isset($_all_args[$_var[1]]))
					return $_all_args[$_var[1]];
				return $_var[0];
			};
			$_destination = preg_replace_callback('/\{(.*?)\}/', $_callback, $_source);
			$this->put_file($_build_dir, $_destination, $this->instantiate_template($_source, $_data));
		}
	}

	public function files_produced() { return $this->generated; }

	private $basedir = './';
	private $entries = [];
	private $fragments = [];
	private $generated = [];
};