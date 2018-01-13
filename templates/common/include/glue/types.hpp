#pragma once

#include <cstddef>
#include <cstdint>

#ifdef _WIN32
	#define GLUE_APIENTRY __stdcall
#else
	#define GLUE_APIENTRY
#endif

namespace glue
{
	using enum_t = std::uint32_t;

  using debug_proc_t = void (GLUE_APIENTRY *)(enum_t source, enum_t type, std::uint32_t id, enum_t severity, std::int32_t length,const char *message, const void *userParam);
	using amd_debug_proc_t = void (GLUE_APIENTRY *)(std::uint32_t id, enum_t category, enum_t severity, std::int32_t length, const char *message, void *userParam);
	using nv_vulkan_proc_t = void (GLUE_APIENTRY *)(void);

}