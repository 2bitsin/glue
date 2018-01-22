#include "strings.hpp"
#include <iterator>

namespace 
{
	const char* G_strings[] =
	{
<?php 
	foreach($registry->all_strings() as $string)
	{
		printf("\t\t".'"%s", '."\n", $string);
	}
?>
	};
}

namespace glue
{
	const char* enum_to_string(std::int64_t the_enum)
	{
		switch(the_enum)
		{
<?php 
	$G_enums = [];
	foreach($enums as $name => $_enum)
	{
		$x = $_enum['value'];
		$x = strstr($x, '0x') === FALSE ? intval($x) : hexdec($x);
		$G_enums[$x][] = $name;
	}
	foreach($G_enums as $id => $strings)
	{
		$strings = $registry->lookup_string(implode(", ", $strings));
		printf($id > 0 ? "\t\t\tcase 0x%08x: " : "\t\t\tcase %d: ", $id);
		printf("return impl::str_by_index(%u);\n", $strings);
	}
?>
		default:
			return nullptr;
		}
	}
	namespace impl
	{
		const char* str_by_index(std::size_t idx)
		{
			if (idx >= std::size(G_strings))
				return nullptr;
			return G_strings[idx];
		}
	}
}