#include "strings.hpp"
#include <iterator>
<?php 
	$G_enums = [];
	foreach($enums as $name => $_enum)
	{
		$x = $_enum['value'];
		$x = strstr($x, '0x') === FALSE ? intval($x) : hexdec($x);
		$G_enums[$x][] = $registry->lookup_string($name);
	}
?>
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

	const char* G_string_groups[] =
	{
<?php 
	$G_lookup = [];
	$i = 0;
	printf("\t\t\t");
	foreach($G_enums as $key => $_egrp)
	{
		printf(implode(",\n\t\t\t", array_map(
			function ($x) { return sprintf('G_strings[%u]', $x); },
			$_egrp
		)));
		printf(",\n\t\t\tnullptr,\n\t\t\t");
		$G_lookup[$key] = $i;
		$i += count ($_egrp) + 1;
	}
?>
	};
}

namespace glue
{
	const char** enum_to_string(std::int64_t the_enum)
	{
		switch(the_enum)
		{
<?php 
	foreach($G_lookup as $key => $index)
	{
		printf("\t\t\tcase ".($key >= 0 ? "0x%08X" : "%d").": return &G_string_groups[%u];\n", $key, $index);
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