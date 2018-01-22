#include <glue/<?= $api ?>/<?= $version ?>.<?= $profile ?>.hpp>
#include "../common/strings.hpp"

namespace glue
{
	namespace 
	{
		template <typename T, typename P>
		void assign(T& target, P fptr)
		{ target = (T)fptr; }
	}
	inline namespace <?= strtolower($name) ?>_<?= $profile ?> 
 	{
		void load(Interface& target, std::function<void*(const char*)> lfn)
		{
<?php 
	foreach($protos as $_proto)
	{
		$fmt = "\t\t\t\tassign(target.%s, lfn(impl::str_by_index(%u)));\n";
		$name = CppHelper::camel_skip_prefix($_proto['name']);
		printf ($fmt, $name, $registry->lookup_string($_proto['name']));
	}
?>
		}
 	}
}