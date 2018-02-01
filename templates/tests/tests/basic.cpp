#include <glue/lvl1/gl/4.6.core.hpp>
#include <glue/meta.hpp>
#include <iostream>

int main()
{
	glue::Interface ifc;

	glue::load(ifc, [](auto c) {return (void*)nullptr;});

	return 0;
}