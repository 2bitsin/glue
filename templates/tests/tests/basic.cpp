#include <glue/lvl1/gl/4.5.core.hpp>
#include <glue/lvl2/gl/4.5.core.hpp>
#include <glue/lvl1/gl/4.6.core.hpp>
#include <glue/lvl2/gl/4.6.core.hpp>
#include <glue/meta.hpp>
#include <iostream>

int main()
{
	glue::core_4_6::api ifc;

	glue::load(ifc, [](auto c) {return (void*)nullptr;});

	return 0;
}