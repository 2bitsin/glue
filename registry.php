<?php

@define ('BASE_NAME', '@base');

class Registry
{
	protected static function attr_to_array($attr)
	{
		$arr = [];
		foreach($attr as $k => $v)
			$arr[$k] = (string)$v;
		return $arr;
	}

	protected function feature_add_enum($root, &$dest, $name)
	{
		$enum = $root->xpath("/registry/enums/enum[@name='$name']")[0];
		$type = null;
		$group = null;
		extract(Registry::attr_to_array($enum->xpath('..')[0]->attributes()), EXTR_OVERWRITE);
		extract(Registry::attr_to_array($enum->attributes()), EXTR_OVERWRITE);
		$dest['enums'][$name] = ['value' => $value, 'namespace' => $namespace, 'type' => $type, 'group' => $group];
	}
	protected function feature_add_proto($root, &$dest, $name)
	{
		$dest['protos'][$name] = true;
	}
	protected function feature_add_type($root, &$dest, $name)
	{
		$dest['types'][$name] = true;
	}

	protected function parse_features($root)
	{
		$this->features = [];

		$api_profiles = [];
		foreach ($root->xpath('/registry/feature') as $feature_node)
		{
			extract(Registry::attr_to_array($feature_node->attributes()), EXTR_OVERWRITE);
			if (!isset($api_profiles[$api]))
				$api_profiles[$api] = [BASE_NAME => ['protos' => [], 'enums' => [], 'types' => []]];
			$profiles = &$api_profiles[$api];

			foreach ($feature_node->xpath('require|remove') as $oper)
			{
				$profile = BASE_NAME;
				extract(Registry::attr_to_array($oper->attributes()), EXTR_OVERWRITE);
				if (!isset($profiles[$profile]))
					$profiles[$profile] = $profiles[BASE_NAME];

				if ($oper->getName() == 'require')
				{
					if ($profile == BASE_NAME)
					{
						foreach ($profiles as $profile_idx => $_)
						{
							foreach ($oper->xpath('enum') as $enum)
								$this->feature_add_enum($root, $profiles[$profile_idx], (string)$enum->attributes()['name']);
							foreach ($oper->xpath('command') as $proto)
								$this->feature_add_proto($root, $profiles[$profile_idx], (string)$proto->attributes()['name']);
							foreach ($oper->xpath('type') as $type)
								$this->feature_add_type($root, $profiles[$profile_idx], (string)$type->attributes()['name']);
						}
					}
					else
					{
						foreach ($oper->xpath('enum') as $enum)
							$this->feature_add_enum($root, $profiles[$profile], (string)$enum->attributes()['name']);
						foreach ($oper->xpath('command') as $proto)
							$this->feature_add_proto($root, $profiles[$profile], (string)$proto->attributes()['name']);
						foreach ($oper->xpath('type') as $type)
							$this->feature_add_type($root, $profiles[$profile], (string)$type->attributes()['name']);
					}
				}
				else if($oper->getName() == 'remove')
				{
					if ($profile == BASE_NAME)
					{
						foreach ($profiles as $profile_idx => $_)
						{
							foreach ($oper->xpath('enum') as $enum)
								unset($profiles[$profile_idx]['enums' ][(string)$enum->attributes()['name']]);
							foreach ($oper->xpath('command') as $proto)
								unset($profiles[$profile_idx]['protos'][(string)$proto->attributes()['name']]);
							foreach ($oper->xpath('type') as $type)
								unset($profiles[$profile_idx]['types' ][(string)$type->attributes()['name']]);
						}
					}
					else
					{
						foreach ($oper->xpath('enum') as $enum)
							unset($profiles[$profile]['enums' ][(string)$enum->attributes()['name']]);
						foreach ($oper->xpath('command') as $proto)
							unset($profiles[$profile]['protos'][(string)$proto->attributes()['name']]);
						foreach ($oper->xpath('type') as $type)
							unset($profiles[$profile]['types' ][(string)$type->attributes()['name']]);
					}
				}
			}
			foreach ($profiles as $profile_name => $profile_content)
			{
				$profile_content['version'] = $number;
				$profile_content['api'] = $api;
				$profile_content['name'] = $name;
				$profile_content['profile'] = $profile_name;
				$this->features[] = $profile_content;
			}
		}
	}

	function __construct($url)
	{
		$root = new SimpleXMLElement(file_get_contents($url));
		$this->parse_features($root);
	}

	public $features;
};
