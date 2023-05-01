<div class="mb-6">
    <label for="user_type" class="block mb-2 text-sm font-medium text-slate-500 dark:text-white">Login as</label>
    <select id="user_type" class="user_type-options bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="user_type" required>
        <option value="" selected disabled class="user_type-options">Customer/Client</option>
        <option value="Customer" {{ old('user_type') === 'Customer' ? 'selected' : '' }}>Customer</option>
        <option value="Client" {{ old('user_type') === 'Client' ? 'selected' : '' }}>Client</option>
    </select>
</div>
