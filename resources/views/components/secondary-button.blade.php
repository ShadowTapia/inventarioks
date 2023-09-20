<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 dark:bg-blue-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs bg-blue-800 text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-blue-700 dark:hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:bg-blue-700 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
