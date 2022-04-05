<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    
    <div id="create" class="absolute z-50 hidden w-screen h-screen overflow-hidden -mt-36 bg-gray-600/75 scrollbar-hide">
        <div class="flex flex-col items-center justify-center min-h-screen">
            <div class="w-full px-6 py-4 mt-6 overflow-hidden bg-white border-4 border-teal-600 shadow-md sm:max-w-md sm:rounded-lg">
                <x-jet-validation-errors class="mb-4" />

                @if (session('status'))
                    <div class="mb-4 text-sm font-medium text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('users.store') }}">
                    @csrf

                    <div>
                        <x-jet-label for="name" value="{{ __('Fullname') }}" />
                        <x-jet-input id="name" class="block w-full mt-1" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    </div>
        
                    <div class="mt-4">
                        <x-jet-label for="email" value="{{ __('Email Address') }}" />
                        <x-jet-input id="email" class="block w-full mt-1" type="email" name="email" :value="old('email')" required />
                    </div>

                    <div class="mt-4">
                        <x-jet-label for="role" value="{{ __('Role') }}" />
                        <select id="role" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50" name="role" required>
                            <option value="0">Administrator</option>
                            <option value="1">Office Staff</option>
                            <option value="2">Field Staff</option>
                            <option value="3">Client</option>
                        </select>
                    </div>

                    <div class="mt-4">
                        <x-jet-label for="password" value="{{ __('Password') }}" />
                        <x-jet-input id="password" class="block w-full mt-1" type="password" name="password" required />
                    </div>

                    <div class="flex items-center justify-end mt-4 space-x-2">
                        <button type="button" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-gray-800 uppercase transition bg-white border border-gray-900 rounded-md hover:bg-gray-300 active:bg-gray-300 focus:outline-none focus:border-gray-300 focus:ring focus:ring-gray-900 disabled:opacity-25"  onclick="toggleElement('create')">
                            CANCEL
                        </button>
                        <x-jet-button class="ml-4">
                            CREATE
                        </x-jet-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if(!is_null($selectedData))
    <div class="absolute z-50 w-screen h-screen overflow-hidden -mt-36 bg-gray-600/75 scrollbar-hide {{$editModal == false ? 'hidden' : ''}}">
        <div class="flex flex-col items-center justify-center min-h-screen">
            <div class="w-full px-6 py-4 mt-6 overflow-hidden bg-white border-4 border-teal-600 shadow-md sm:max-w-md sm:rounded-lg">
                <x-jet-validation-errors class="mb-4" />

                @if (session('status'))
                    <div class="mb-4 text-sm font-medium text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('users.update',$selectedData['id']) }}">
                    @method('patch')
                    @csrf

                    <div>
                        <x-jet-label for="name" value="{{ __('Fullname') }}" />
                        <x-jet-input id="name" class="block w-full mt-1" type="text" name="name" value="{{$selectedData['name']}}" required autofocus autocomplete="name" />
                    </div>
        
                    <div class="mt-4">
                        <x-jet-label for="email" value="{{ __('Email Address') }}" />
                        <x-jet-input id="email" class="block w-full mt-1" type="email" name="email" value="{{$selectedData['email']}}" required />
                    </div>

                    <div class="mt-4">
                        <x-jet-label for="role" value="{{ __('Role') }}" />
                        <select id="role" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50" name="role" required>
                            <option value="0" {{$selectedData['role'] == 0 ? 'selected' : ''}}>Administrator</option>
                            <option value="1" {{$selectedData['role'] == 1 ? 'selected' : ''}}>Office Staff</option>
                            <option value="2" {{$selectedData['role'] == 2 ? 'selected' : ''}}>Field Staff</option>
                            <option value="3" {{$selectedData['role'] == 3 ? 'selected' : ''}}>Client</option>
                        </select>
                    </div>

                    <div class="mt-4">
                        <x-jet-label for="password" value="{{ __('Password') }}" />
                        <x-jet-input id="password" class="block w-full mt-1" type="password" name="password" value="{{$selectedData['password']}}" required />
                    </div>

                    <div class="flex items-center justify-end mt-4 space-x-2">
                        <button type="button" wire:click="toggleModal(false)" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-gray-800 uppercase transition bg-white border border-gray-900 rounded-md hover:bg-gray-300 active:bg-gray-300 focus:outline-none focus:border-gray-300 focus:ring focus:ring-gray-900 disabled:opacity-25">
                            CANCEL
                        </button>
                        <x-jet-button class="ml-4">
                            UPDATE
                        </x-jet-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <div class="relative z-0 py-12 md:py-24">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-4 border-teal-600">
                    <div class="flex flex-col items-center justify-center w-full h-full">
                        <div class="flex w-full py-2 border-b border-gray-500 shadow-sm">
                            <span class="inline-flex items-center px-3 text-sm text-gray-500 border border-r-0 border-gray-300 rounded-l-xl bg-gray-50">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </span>
                            <input wire:model="search" type="text" class="flex-1 block w-full border-gray-300 rounded-none focus:ring-teal-500 focus:border-teal-500 rounded-r-xl sm:text-sm" placeholder="Search something here...">
                        </div>

                        <div class="relative z-0 w-full my-6 overflow-x-auto shadow-md">
                            <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    @foreach($headers as $content)
                                        <th scope="col" class="px-6 py-3">
                                            {{$content}}
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($response as $data)
                                    <tr class="bg-white border-b hover:bg-teal-100">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                            {{$data->name}}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{$data->email}}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{$this->renderRole($data->role)}}
                                        </td>
                                        <td class="flex flex-row px-6 py-4 space-x-2 text-center">
                                            <button wire:click="selectedUser({{$data->id}})">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                            <form method="POST" action="{{ route('users.destroy',$data->id) }}">
                                                @method('delete')
                                                @csrf
                                                <button type="submit">
                                                    <i class="text-red-700 fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            </table>
                        </div>

                        <div class="w-full h-auto py-2 border-t-2 border-gray-300">
                            {{$response->links()}}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="fixed bottom-0 right-0 z-30 flex items-center justify-center w-auto h-auto px-4 py-2 m-6 bg-white border-4 border-gray-600 rounded-full cursor-pointer hover:border-teal-600 md:m-10" onclick="toggleElement('create')">
        <button class="flex flex-row items-center justify-center text-gray-600 hover:text-teal-600 focos:outline-none">
            <i class="px-2 fa-solid fa-plus"></i> CREATE USER
        </button>
    </div>
</div>