#ifndef GLUE_VECTOR_HPP
#define GLUE_VECTOR_HPP

#include "types.hpp"

#if !defined(GLUE_DONT_USE_GLM) && __has_include(<glm/glm.hpp>)
	#define GLUE_USES_GLM 1
	#include <glm/glm.hpp>
	#include <glm/gtc/type_ptr.hpp>
#else
	#define GLUE_USES_GLM 0
#endif

namespace glue
{

#if GLUE_USES_GLM
	using namespace glm;
#else
	template <typename T, std::size_t N>
	struct vector_impl;

	template <typename T> struct vector_impl<T, 1u> { T x; };
	template <typename T> struct vector_impl<T, 2u>: vector_impl<T, 1u> { T y; };
	template <typename T> struct vector_impl<T, 3u>: vector_impl<T, 2u> { T z; };
	template <typename T> struct vector_impl<T, 4u>: vector_impl<T, 3u> { T w; };

	template <typename T, std::size_t N>
	struct vector_impl<T, N>:
		vector_impl<T, 4u>
	{
		auto&& operator [] (std::size_t i) noexcept { return ((T*)this)[i] ; } ;
		auto&& operator [] (std::size_t i) noexcept const { return ((const T*)this)[i] ; } ;
		T _[N-4u];
	};

	template <typename T, std::size_t M, std::size_t N>
	using matrix_impl = vector_impl<T, N>[M];

	template <typename T> using tvec2 = vector_impl<T, 2u>;
	template <typename T> using tvec3 = vector_impl<T, 3u>;
	template <typename T> using tvec4 = vector_impl<T, 4u>;

	template <typename T> using tmat2x2 = matrix_impl<T, 2u, 2u>;
	template <typename T> using tmat2x3 = matrix_impl<T, 2u, 3u>;
	template <typename T> using tmat2x4 = matrix_impl<T, 2u, 4u>;
	template <typename T> using tmat3x2 = matrix_impl<T, 3u, 2u>;
	template <typename T> using tmat3x3 = matrix_impl<T, 3u, 3u>;
	template <typename T> using tmat3x4 = matrix_impl<T, 3u, 4u>;
	template <typename T> using tmat4x2 = matrix_impl<T, 4u, 2u>;
	template <typename T> using tmat4x3 = matrix_impl<T, 4u, 3u>;
	template <typename T> using tmat4x4 = matrix_impl<T, 4u, 4u>;

	template <typename T> using tmat2 = tmat2x2<T>;
	template <typename T> using tmat3 = tmat3x3<T>;
	template <typename T> using tmat4 = tmat4x4<T>;

#define GLUE_DEFINE_STRUCTS(_Prefix, _Type)\
	using _Prefix##vec2 = tvec2<_Type>;\
	using _Prefix##vec3 = tvec3<_Type>;\
	using _Prefix##vec4 = tvec4<_Type>;\
	using _Prefix##mat2x2 = tmat2x2<_Type>;\
	using _Prefix##mat2x3 = tmat2x3<_Type>;\
	using _Prefix##mat2x4 = tmat2x4<_Type>;\
	using _Prefix##mat3x2 = tmat3x2<_Type>;\
	using _Prefix##mat3x3 = tmat3x3<_Type>;\
	using _Prefix##mat3x4 = tmat3x4<_Type>;\
	using _Prefix##mat4x2 = tmat4x2<_Type>;\
	using _Prefix##mat4x3 = tmat4x3<_Type>;\
	using _Prefix##mat4x4 = tmat4x4<_Type>;\
	using _Prefix##mat2 = tmat2<_Type>;\
	using _Prefix##mat3 = tmat3<_Type>;\
	using _Prefix##mat4 = tmat4<_Type>;

	GLUE_DEFINE_STRUCTS(,float);
	GLUE_DEFINE_STRUCTS(f,float);
	GLUE_DEFINE_STRUCTS(d,double);
	GLUE_DEFINE_STRUCTS(s,short);
	GLUE_DEFINE_STRUCTS(i,int);
	GLUE_DEFINE_STRUCTS(u,unsigned);
	GLUE_DEFINE_STRUCTS(b,bool);

	template <typename T, std::size_t M>
	const T* value_ptr(const vector_impl<T, M>& vec) { return &vec[0]; }
	template <typename T, std::size_t M, std::size_t N>
	const T* value_ptr(const matrix_impl<T, M, N>& mat) { return &mat[0][0]; }
	template <typename T, std::size_t M>
	T* value_ptr(vector_impl<T, M>& vec) { return &vec[0]; }
	template <typename T, std::size_t M, std::size_t N>
	T* value_ptr(matrix_impl<T, M, N>& mat) { return &mat[0][0]; }

#endif

}

#endif