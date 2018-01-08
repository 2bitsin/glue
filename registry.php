<?php

@define ('BASE_NAME', 'base');

class Registry
{
	protected static function attr_to_array($attr)
	{
		$arr = [];
		foreach($attr as $k => $v)
			$arr[$k] = (string)$v;
		return $arr;
	}
	protected function feature_add_type($root, &$dest, $name)
	{
		$dest['types'][$name] = true;
	}

	protected function parse_enums($root)
	{
		$this->enums = [];
		foreach ($root->xpath('/registry/enums') as $_group)
		{
			extract(Registry::attr_to_array($_group->attributes()), EXTR_OVERWRITE);
			foreach ($_group->xpath('enum') as $enum)
			{
				extract(Registry::attr_to_array($enum->attributes()), EXTR_OVERWRITE);
				$this->enums[$name] = [
					'value' 		=> $value,
					'namespace' => $namespace,
					'type'		  => $type,
					'group' 		=> $group];
			}
		}
	}

	protected function parse_protos($root)
	{
		$value_or = function($v, $d) { return count($v) > 0 ? (string)$v[0] : $d; };

		$this->protos = [];
		foreach ($root->xpath('/registry/commands/command') as $_command)
		{
			extract(Registry::attr_to_array($_command->attributes()), EXTR_OVERWRITE);
			$_proto = $_command->xpath('proto')[0];
			$_proto_full_type = dom_import_simplexml($_proto)->textContent;
			$_proto_name = (string)$_proto->xpath('name')[0];
			$_proto_full_type = str_replace($_proto_name, '', $_proto_full_type);
			$_proto_base_type = $value_or($_proto->xpath('ptype'), 'void');
			$_proto_arguments = [];
			$_proto_types = [];
			$_proto_names = [];

			$group = '';
			extract(Registry::attr_to_array($_proto->attributes()), EXTR_OVERWRITE);

			foreach ($_command->xpath('param') as $_param)
			{
				$length = '';
				extract(Registry::attr_to_array($_param->attributes()), EXTR_OVERWRITE);

				$_param_full_type = (string)dom_import_simplexml($_param)->textContent;
				$_param_name = (string)$_param->xpath('name')[0];
				$_param_base_type = $value_or($_param->xpath('ptype'), 'void');
				$_param_full_type = str_replace($_param_name, '', $_param_full_type);

				$_proto_types [] = $_param_full_type;
				$_proto_names [] = $_param_name;
				$_proto_arguments[] = [
					'name' 			 => trim($_param_name),
					'full_type'  => trim($_param_full_type),
					'base_type'  => trim($_param_base_type),
					'length' 		 => trim($length),
					'is_const'	 => strstr($_param_full_type, 'const') !== FALSE,
					'is_pointer' => strstr($_param_full_type, '*') !== FALSE
				];
			}
			$this->protos[$_proto_name] = [
				'group' 		 => trim($group),
				'name'  		 => trim($_proto_name),
				'full_type'  => trim($_proto_full_type),
				'base_type'  => trim($_proto_base_type),
				'is_const'	 => strstr($_proto_full_type, 'const') !== FALSE,
				'is_pointer' => strstr($_proto_full_type, '*') !== FALSE,
				'arguments'  => $_proto_arguments,
				'arg_names'  => $_proto_names,
				'arg_types'  => $_proto_types
			];
		}
	}

	protected function parse_types($root)
	{
		$value_or = function($v, $d) { return count($v) > 0 ? (string)$v[0] : $d; };
		$this->types = [];
		foreach($root->xpath('/registry/types/type') as $_type)
		{
			$requires = null;
			$name = '';
			$api = 'gl';
			extract(Registry::attr_to_array($_type->attributes()), EXTR_OVERWRITE);
			$_type_define = dom_import_simplexml($_type)->textContent;
			$_type_name = $value_or($_type->xpath('name'), $name);
			$this->types[$api][$_type_name] = [
				'definition' 	=> $_type_define,
				'api' 				=> $api,
				'name' 				=> $_type_name,
				'requires' 		=> $requires
			];
		}
	}

	protected function parse_features($root)
	{
		$feature_add_enum 	= function (&$dest, $name) { $dest['enums'  ][$name] = $this->enums  [$name]; };
		$feature_add_proto 	= function (&$dest, $name) { $dest['protos' ][$name] = $this->protos [$name]; };

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
								$feature_add_enum($profiles[$profile_idx], (string)$enum->attributes()['name']);
							foreach ($oper->xpath('command') as $proto)
								$feature_add_proto($profiles[$profile_idx], (string)$proto->attributes()['name']);
							foreach ($oper->xpath('type') as $type)
								$this->feature_add_type($root, $profiles[$profile_idx], (string)$type->attributes()['name']);
						}
					}
					else
					{
						foreach ($oper->xpath('enum') as $enum)
							$feature_add_enum($profiles[$profile], (string)$enum->attributes()['name']);
						foreach ($oper->xpath('command') as $proto)
							$feature_add_proto($profiles[$profile], (string)$proto->attributes()['name']);
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
		$this->parse_enums($root);
		$this->parse_types($root);
		$this->parse_protos($root);
		$this->parse_features($root);
	}

	public $features;
	public $types;
	public $enums;
	public $protos;
};
