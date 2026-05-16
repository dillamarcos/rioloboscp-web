@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge([
    'class' => '
            w-full
            px-3 py-2
            text-sm
            leading-5
            bg-white dark:bg-gray-900
            text-gray-900 dark:text-gray-100
            border border-gray-300 dark:border-gray-700
            rounded-md
            shadow-sm
            focus:border-indigo-500 dark:focus:border-indigo-400
            focus:ring-indigo-500 dark:focus:ring-indigo-400
            transition
        '
]) }}>