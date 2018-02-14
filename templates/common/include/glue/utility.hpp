#ifndef GLUE_UTILITY_HPP
#define GLUE_UTILITY_HPP

#include <type_traits>
#include <iterator>

namespace glue::utility
{
	using std::data;
	using std::size;

	namespace detail
	{
		template <typename T, typename E>
		struct has_data_impl:
			std::integral_constant<bool, false>
		{};
		template <typename T>
		struct has_data_impl<T, std::void_t<decltype(data(std::declval<std::remove_reference_t<T>>()))>>:
			std::integral_constant<bool, true>
		{};

		template <typename T, typename E>
		struct has_size_impl:
			std::integral_constant<bool, false>
		{};
		template <typename T>
		struct has_size_impl<T, std::void_t<decltype(size(std::declval<std::remove_reference_t<T>>()))>>:
			std::integral_constant<bool, true>
		{};

		template <typename T, typename E>
		struct has_data_mem_impl:
			std::integral_constant<bool, false>
		{};
		template <typename T>
		struct has_data_mem_impl<T, std::void_t<decltype(std::declval<std::remove_reference_t<T>>().data())>>:
			std::integral_constant<bool, true>
		{};

		template <typename T, typename E>
		struct has_size_mem_impl:
			std::integral_constant<bool, false>
		{};
		template <typename T>
		struct has_size_mem_impl<T, std::void_t<decltype(std::declval<std::remove_reference_t<T>>().size())>>:
			std::integral_constant<bool, true>
		{};
	}

	template <typename T>
	using has_data = detail::has_data_impl<T, void>;
	template <typename T>
	using has_size = detail::has_data_impl<T, void>;
	template <typename T>
	using has_data_and_size = std::integral_constant<bool, has_data<T>::value && has_size<T>::value>;

	template <typename T>
	static constexpr auto has_data_v = has_data<T>::value;
	template <typename T>
	static constexpr auto has_size_v = has_size<T>::value;
	template <typename T>
	static constexpr auto has_data_and_size_v = has_data_and_size<T>::value;

	template <typename T>
	using has_data_mem = detail::has_data_mem_impl<T, void>;
	template <typename T>
	using has_size_mem = detail::has_size_mem_impl<T, void>;
	template <typename T>
	using has_data_and_size_mem = std::integral_constant<bool, has_data_mem<T>::value && has_size_mem<T>::value>;

	template <typename T>
	static constexpr auto has_data_mem_v = has_data_mem<T>::value;
	template <typename T>
	static constexpr auto has_size_mem_v = has_size_mem<T>::value;
	template <typename T>
	static constexpr auto has_data_and_size_mem_v = has_data_and_size_mem<T>::value;
}

#endif