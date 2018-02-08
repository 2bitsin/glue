#ifndef GLUE_TYPES_HPP
#define GLUE_TYPES_HPP

#include <cstddef>
#include <cstdint>

#ifdef _WIN32
	#ifdef _MSC_VER
		#define GLUE_APIENTRY __stdcall
	#else
		#define GLUE_APIENTRY __attribute__((stdcall))
	#endif
#else
	#define GLUE_APIENTRY
#endif

namespace glue
{
	struct __GLsync;
	struct _cl_event;
	struct _cl_context;

	using GLeglClientBufferEXT = void*;
	using GLeglImageEOS = void*;
	using GLvdpauSurfaceNV = std::ptrdiff_t;
	using GLsync = __GLsync*;
	using GLhandleARB =
		#ifdef __APPLE__
			void*
		#else
			std::uint32_t
		#endif
	;
	using enum_t = std::uint32_t;
	using boolean_t = std::uint8_t;
	using bitfield_t = std::uint32_t;
	using float16_t = std::uint16_t;
	using float32_t = float;
	using float64_t = double;
	using uniform_location_t = std::int32_t;
	using program_name_t = std::uint32_t;

  using debug_proc_t = void (GLUE_APIENTRY *)(enum_t, enum_t, std::uint32_t, enum_t, std::int32_t,const char *, const void *);
	using amd_debug_proc_t = void (GLUE_APIENTRY *)(std::uint32_t, enum_t, enum_t, std::int32_t, const char *, void *);
	using nv_vulkan_proc_t = void (GLUE_APIENTRY *)(void);

}
#endif