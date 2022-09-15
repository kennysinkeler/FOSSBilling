<x-admin-layout>
    <x-slot name="header">

        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-xl font-semibold text-gray-900">Clients</h1>
                <p class="mt-2 text-sm text-gray-700">Create a client</p>
            </div>
            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                <a href="{{route("admin.clients.create")}}" type="button"
                   class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">
                    Add client
                </a>
            </div>
        </div>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form class="space-y-6" action="{{route("admin.clients.store")}}" method="POST">
                @csrf
                <div class="bg-white px-4 py-5 shadow sm:rounded-lg sm:p-6">
                    <div class="space-y-6 sm:space-y-5">
                        <div>
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Client Information</h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">Use a permanent address where you can
                                receive mail.</p>
                        </div>
                        <div class="space-y-6 sm:space-y-5">
                            <div
                                class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                                <label for="status" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Status</label>
                                <fieldset class="mt-4">
                                    <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                                        <div class="flex items-center">
                                            <input id="status-active" name="status" type="radio" checked
                                                   class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                            <label for="email" class="ml-3 block text-sm font-medium text-gray-700">Active</label>
                                        </div>

                                        <div class="flex items-center">
                                            <input id="status-canceled" name="status" type="radio"
                                                   class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                            <label for="status-canceled"
                                                   class="ml-3 block text-sm font-medium text-gray-700">Canceled</label>
                                        </div>

                                    </div>
                                </fieldset>
                            </div>
                            <div
                                class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4">
                                <label for="group" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Group</label>
                                <div class="mt-1 sm:col-span-2 sm:mt-0">
                                    <select id="group" name="group" autocomplete="group"
                                            class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:max-w-xs sm:text-sm">
                                        <option disabled selected>-- select group --</option>
                                        @foreach(\App\Models\ClientGroup::all() as $group)
                                            <option value="{{$group->id}}">{{$group->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div
                                class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4">
                                <label for="email"
                                       class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Email</label>
                                <div class="mt-1 sm:col-span-2 sm:mt-0">
                                    <input type="email" name="email" id="email" autocomplete="email"
                                           class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:max-w-xs sm:text-sm">
                                </div>
                            </div>
                            <div
                                class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4">
                                <label for="first_name"
                                       class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">First
                                    name</label>
                                <div class="mt-1 sm:col-span-2 sm:mt-0">
                                    <input type="text" name="first_name" id="first_name" autocomplete="given-name"
                                           class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:max-w-xs sm:text-sm">
                                </div>
                            </div>
                            <div
                                class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4">
                                <label for="last_name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Last
                                    name</label>
                                <div class="mt-1 sm:col-span-2 sm:mt-0">
                                    <input type="text" name="last_name" id="last_name" autocomplete="family-name"
                                           class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:max-w-xs sm:text-sm">
                                </div>
                            </div>

                            <div
                                class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4">
                                <label for="company" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Company</label>
                                <div class="mt-1 sm:col-span-2 sm:mt-0">
                                    <input id="company" name="company" type="text"
                                           class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                            </div>
                            <div
                                class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4">
                                <label for="street-address"
                                       class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Address Line
                                    1</label>
                                <div class="mt-1 sm:col-span-2 sm:mt-0">
                                    <input type="text" name="street-address" id="street-address"
                                           autocomplete="street-address"
                                           class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                            </div>
                            <div
                                class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4">
                                <label for="street-address"
                                       class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Address Line
                                    2</label>
                                <div class="mt-1 sm:col-span-2 sm:mt-0">
                                    <input type="text" name="street-address" id="street-address"
                                           autocomplete="street-address"
                                           class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                            </div>
                            <div
                                class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4">
                                <label for="street-address"
                                       class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">City</label>
                                <div class="mt-1 sm:col-span-2 sm:mt-0">
                                    <input type="text" name="street-address" id="street-address"
                                           autocomplete="street-address"
                                           class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                            </div>
                            <div
                                class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4">
                                <label for="street-address"
                                       class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">State</label>
                                <div class="mt-1 sm:col-span-2 sm:mt-0">
                                    <input type="text" name="street-address" id="street-address"
                                           autocomplete="street-address"
                                           class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                            </div>
                            <div
                                class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4">
                                <label for="country" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Country</label>
                                <div class="mt-1 sm:col-span-2 sm:mt-0">
                                    <select id="country" name="country" autocomplete="country-name"
                                            class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:max-w-xs sm:text-sm">
                                        @foreach(\App\Models\Country::select("country_code","name")->get() as $country)
                                            <option value="{{$country->country_code}}">{{$country->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div
                                class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4">
                                <label for="postal-code"
                                       class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">ZIP / Postal
                                    code</label>
                                <div class="mt-1 sm:col-span-2 sm:mt-0">
                                    <input type="text" name="postal-code" id="postal-code" autocomplete="postal-code"
                                           class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:max-w-xs sm:text-sm">
                                </div>
                            </div>
                            <div
                                class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4">
                                <label for="currency" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Currency</label>
                                <div class="mt-1 sm:col-span-2 sm:mt-0">
                                    <select id="currency" name="currency" autocomplete="currency"
                                            class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:max-w-xs sm:text-sm">
                                        @foreach(\App\Models\Currency::all() as $currency)
                                            @if($currency->is_default)
                                                <option selected value="{{$currency->id}}">{{$currency->title}}
                                                    - {{$currency->code}} </option>
                                            @else
                                                <option value="{{$currency->id}}">{{$currency->title}}
                                                    - {{$currency->code}} </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="button"
                                class="rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Cancel
                        </button>
                        <button type="submit"
                                class="ml-3 inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Save
                        </button>
                    </div>
                </div>


            </form>
        </div>
    </div>
</x-admin-layout>
