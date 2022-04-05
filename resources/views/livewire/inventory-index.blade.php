<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Inventory') }}
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

                <form method="POST" action="{{ route('inventories.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div>
                        <x-jet-label for="name" value="{{ __('Package Name') }}" />
                        <x-jet-input id="name" class="block w-full mt-1" type="text" name="name" required autofocus autocomplete="name" />
                    </div>
        
                    <div class="mt-4">
                        <x-jet-label for="quantity" value="{{ __('No. of Items') }}" />
                        <x-jet-input id="quantity" class="block w-full mt-1" type="number" name="quantity" min="0" />
                    </div>

                    <div class="mt-4">
                        <x-jet-label for="weight" value="{{ __('Total Weight (KG)') }}" />
                        <x-jet-input id="weight" class="block w-full mt-1" type="number" name="weight" min="0" />
                    </div>

                    <div class="mt-4">
                        <x-jet-label for="address_from" value="{{ __('Package From') }}" />
                        <x-jet-input id="address_from" class="block w-full mt-1" type="text" name="address_from" required />
                    </div>

                    <div class="mt-4">
                        <x-jet-label for="address_to" value="{{ __('Package To') }}" />
                        <x-jet-input id="address_to" class="block w-full mt-1" type="text" name="address_to" required />
                    </div>

                    <div class="mt-4">
                        <x-jet-label for="description" value="{{ __('Description of Package') }}" />
                        <textarea id="description" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50" name="description" required ></textarea>
                    </div>

                    <div class="mt-4">
                        <x-jet-label for="attachment" value="{{ __('Attachments') }}" />
                        <input id="attachments" class="block w-full mt-1 border-gray-300 shadow-sm focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50" type="file" name="attachments[]" multiple required />
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
    {{-- EDIT --}}
    <div class="absolute z-50 w-screen h-screen overflow-hidden -mt-36 bg-gray-600/75 scrollbar-hide {{$editModal == false ? 'hidden' : ''}}">
        <div class="flex flex-col items-center justify-center min-h-screen">
            <div class="w-full px-6 py-4 mt-6 overflow-hidden bg-white border-4 border-teal-600 shadow-md sm:max-w-md sm:rounded-lg">
                <x-jet-validation-errors class="mb-4" />

                @if (session('status'))
                    <div class="mb-4 text-sm font-medium text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('inventories.update',$selectedData['id']) }}">
                    @method('patch')
                    @csrf

                    <div>
                        <x-jet-label for="code" value="{{ __('Reference ID') }}" />
                        <x-jet-input id="code" class="block w-full mt-1 select-all" type="text" name="code" value="{{$selectedData['code']}}" readonly />
                    </div>

                    <div class="mt-4">
                        <x-jet-label for="name" value="{{ __('Package Name') }}" />
                        <x-jet-input id="name" class="block w-full mt-1 uppercase" type="text" name="name" value="{{$selectedData['name']}}" required />
                    </div>

                    <div class="mt-4">
                        <x-jet-label for="created_by" value="{{ __('Created By') }}" />
                        <select id="created_by" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50" name="created_by" required>
                            @foreach($clientList as $client)
                                <option value="{{$client->id}}" {{$client->id == $selectedData['created_by'] ? 'selected' : ''}}>{{$client->name.' - '.$client->email}}</option>
                            @endforeach
                        </select>
                    </div>
        
                    <div class="grid grid-cols-3 gap-2 mt-4">
                        <div>
                            <x-jet-label for="quantity" value="{{ __('No. of Items') }}" />
                            <x-jet-input id="quantity" class="block w-full mt-1" type="number" name="quantity" value="{{$selectedData['quantity']}}" min="0" />
                        </div>
                        <div>
                            <x-jet-label for="weight" value="{{ __('Total Weight') }}" />
                            <x-jet-input id="weight" class="block w-full mt-1" type="number" name="weight" value="{{$selectedData['weight']}}" min="0" />
                        </div>
                        <div>
                            <x-jet-label for="cost" value="{{ __('Total Cost') }}" />
                            <x-jet-input id="cost" class="block w-full mt-1" type="number" name="cost" value="{{$selectedData['cost']}}" min="0" required/>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-2 mt-4">
                        <div>
                            <x-jet-label for="address_from" value="{{ __('Package From') }}" />
                            <x-jet-input id="address_from" class="block w-full mt-1" type="text" name="address_from" value="{{$selectedData['address_from']}}" required />
                        </div>
                        <div>
                            <x-jet-label for="address_to" value="{{ __('Package To') }}" />
                            <x-jet-input id="address_to" class="block w-full mt-1" type="text" name="address_to" value="{{$selectedData['address_to']}}" required />
                        </div>
                    </div>

                    @if(!is_null($selectedData['processed_by']))
                    <div class="mt-4">
                        <x-jet-label for="processed_by" value="{{ __('Processed By') }}" />
                        <select id="processed_by" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50" name="processed_by" required>
                            @foreach($fieldStaff as $staff)
                                <option value="{{$staff->id}}" {{$staff->id == $selectedData['processed_by'] ? 'selected' : ''}}>{{$staff->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    <div class="mt-4">
                        <x-jet-label for="status" value="{{ __('Status') }}" />
                        <select id="status" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50" name="status" required>
                            <option value="0" {{$selectedData['status'] == 0 ? 'selected' : ''}}>Pending</option>
                            <option value="1" {{$selectedData['status'] == 1 ? 'selected' : ''}}>Verification</option>
                            <option value="2" {{$selectedData['status'] == 2 ? 'selected' : ''}}>Approved</option>
                            <option value="3" {{$selectedData['status'] == 3 ? 'selected' : ''}}>Rejected</option>
                            <option value="4" {{$selectedData['status'] == 4 ? 'selected' : ''}}>Started</option>
                            <option value="5" {{$selectedData['status'] == 5 ? 'selected' : ''}}>Cancelled</option>
                            <option value="6" {{$selectedData['status'] == 6 ? 'selected' : ''}}>Completed</option>
                        </select>
                    </div>

                    <div class="mt-4">
                        <x-jet-label for="description" value="{{ __('Description of Package') }}" />
                        <textarea id="description" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50" name="description" required >{{$selectedData['description']}}</textarea>
                    </div>

                    <div class="mt-4">
                        <x-jet-label for="remarks" value="{{ __('Remarks') }}" />
                        <textarea id="remarks" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50" name="remarks" required >{{$selectedData['remarks']}}</textarea>
                    </div>

                    <div class="flex items-center justify-end mt-4 space-x-2">
                        <button type="button" wire:click="toggleModal(false,'edit')" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-gray-800 uppercase transition bg-white border border-gray-900 rounded-md hover:bg-gray-300 active:bg-gray-300 focus:outline-none focus:border-gray-300 focus:ring focus:ring-gray-900 disabled:opacity-25">
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
    {{-- VERIFY --}}
    <div class="absolute z-50 w-screen h-screen overflow-hidden -mt-36 bg-gray-600/75 scrollbar-hide {{$verifyModal == false ? 'hidden' : ''}}">
        <div class="flex flex-col items-center justify-center min-h-screen">
            <div class="w-full px-6 py-4 mt-6 overflow-hidden bg-white border-4 border-teal-600 shadow-md sm:max-w-md sm:rounded-lg">
                <x-jet-validation-errors class="mb-4" />

                @if (session('status'))
                    <div class="mb-4 text-sm font-medium text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('inventories.update',$selectedData['id']) }}">
                    @method('patch')
                    @csrf

                    <div>
                        <x-jet-label for="code" value="{{ __('Reference ID') }}" />
                        <x-jet-input id="code" class="block w-full mt-1 select-all" type="text" name="code" value="{{$selectedData['code']}}" readonly />
                    </div>

                    <div class="mt-4">
                        <x-jet-label for="name" value="{{ __('Package Name') }}" />
                        <x-jet-input id="name" class="block w-full mt-1 uppercase" type="text" name="name" value="{{$selectedData['name']}}" readonly />
                    </div>
                    @if(auth()->user()->role != 3)
                    <div class="mt-4">
                        <x-jet-label for="quantity" value="{{ __('No. of Items') }}" />
                        <x-jet-input id="quantity" class="block w-full mt-1" type="number" name="quantity" value="{{$selectedData['quantity']}}" min="0" required />
                    </div>

                    <div class="mt-4">
                        <x-jet-label for="weight" value="{{ __('Total Weight (KG)') }}" />
                        <x-jet-input id="weight" class="block w-full mt-1" type="number" name="weight" value="{{$selectedData['weight']}}" min="0" required />
                    </div>

                    <div class="mt-4">
                        <x-jet-label for="cost" value="{{ __('Total Cost') }}" />
                        <x-jet-input id="cost" class="block w-full mt-1" type="number" name="cost" value="{{$selectedData['cost']}}" min="0" />
                    </div>
                    @endif

                    @if(auth()->user()->role == 3 && $selectedData['status'] == 1)
                    <div class="mt-4">
                        <x-jet-label for="attachment" value="{{ __('Attachments') }}" />
                        <input id="attachments" class="block w-full mt-1 border-gray-300 shadow-sm focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50" type="file" name="attachments[]" multiple required />
                    </div>
                    @endif

                    @if(auth()->user()->role != 3)
                    <div class="mt-4">
                        <x-jet-label for="status" value="{{ __('Status') }}" />
                        <select id="status" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50" name="status" required>
                            <option value="1" {{$selectedData['status'] == 1 ? 'selected' : ''}}>Verification</option>
                            <option value="2" {{$selectedData['status'] == 2 ? 'selected' : ''}}>Approved</option>
                            <option value="3" {{$selectedData['status'] == 3 ? 'selected' : ''}}>Rejected</option>
                        </select>
                    </div>

                    <div class="mt-4">
                        <x-jet-label for="remarks" value="{{ __('Remarks') }}" />
                        <textarea id="remarks" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50" name="remarks" required >{{$selectedData['remarks']}}</textarea>
                    </div>
                    @endif

                    <div class="flex items-center justify-end mt-4 space-x-2">
                        <button type="button" wire:click="toggleModal(false,'verify')" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-gray-800 uppercase transition bg-white border border-gray-900 rounded-md hover:bg-gray-300 active:bg-gray-300 focus:outline-none focus:border-gray-300 focus:ring focus:ring-gray-900 disabled:opacity-25">
                            CANCEL
                        </button>
                        @if($selectedData['cost'] > 0 || auth()->user()->role <= 1)
                        <x-jet-button class="ml-4">
                            UPDATE
                        </x-jet-button>
                        @else
                        <x-jet-button class="ml-4" disabled>
                            UPDATE
                        </x-jet-button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- APPROVED --}}
    <div class="absolute z-50 w-screen h-screen overflow-hidden -mt-36 bg-gray-600/75 scrollbar-hide {{$approveModal == false ? 'hidden' : ''}}">
        <div class="flex flex-col items-center justify-center min-h-screen">
            <div class="w-full px-6 py-4 mt-6 overflow-hidden bg-white border-4 border-teal-600 shadow-md sm:max-w-md sm:rounded-lg">
                <x-jet-validation-errors class="mb-4" />

                @if (session('status'))
                    <div class="mb-4 text-sm font-medium text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('inventories.update',$selectedData['id']) }}">
                    @method('patch')
                    @csrf

                    <div>
                        <x-jet-label for="code" value="{{ __('Reference ID') }}" />
                        <x-jet-input id="code" class="block w-full mt-1 select-all" type="text" name="code" value="{{$selectedData['code']}}" readonly />
                    </div>

                    <div class="mt-4">
                        <x-jet-label for="name" value="{{ __('Package Name') }}" />
                        <x-jet-input id="name" class="block w-full mt-1 uppercase" type="text" name="name" value="{{$selectedData['name']}}" readonly />
                    </div>

                    <div class="mt-4">
                        <x-jet-label for="processed_by" value="{{ __('Processed By') }}" />
                        <select id="processed_by" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50" name="processed_by" required>
                            @foreach($fieldStaff as $staff)
                                <option value="{{$staff->id}}">{{$staff->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <input id="status" type="hidden" name="status" value="4">

                    <div class="flex items-center justify-end mt-4 space-x-2">
                        <button type="button" wire:click="toggleModal(false,'approved')" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-gray-800 uppercase transition bg-white border border-gray-900 rounded-md hover:bg-gray-300 active:bg-gray-300 focus:outline-none focus:border-gray-300 focus:ring focus:ring-gray-900 disabled:opacity-25">
                            CANCEL
                        </button>
                        <x-jet-button class="ml-4">
                            START
                        </x-jet-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- FINAL --}}
    <div class="absolute z-50 w-screen h-screen overflow-hidden -mt-36 bg-gray-600/75 scrollbar-hide {{$finalModal == false ? 'hidden' : ''}}">
        <div class="flex flex-col items-center justify-center min-h-screen">
            <div class="w-full px-6 py-4 mt-6 overflow-hidden bg-white border-4 border-teal-600 shadow-md sm:max-w-md sm:rounded-lg">
                <x-jet-validation-errors class="mb-4" />

                @if (session('status'))
                    <div class="mb-4 text-sm font-medium text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('inventories.update',$selectedData['id']) }}">
                    @method('patch')
                    @csrf

                    <div>
                        <x-jet-label for="code" value="{{ __('Reference ID') }}" />
                        <x-jet-input id="code" class="block w-full mt-1 select-all" type="text" name="code" value="{{$selectedData['code']}}" readonly />
                    </div>

                    <div class="mt-4">
                        <x-jet-label for="name" value="{{ __('Package Name') }}" />
                        <x-jet-input id="name" class="block w-full mt-1 uppercase" type="text" name="name" value="{{$selectedData['name']}}" readonly />
                    </div>

                    <div class="mt-4">
                        <x-jet-label for="processed_by" value="{{ __('Processed By') }}" />
                        <select id="processed_by" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50" name="processed_by" required>
                            @foreach($fieldStaff as $staff)
                                <option value="{{$staff->id}}">{{$staff->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mt-4">
                        <x-jet-label for="status" value="{{ __('Status') }}" />
                        <select id="status" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50" name="status" required>
                            <option value="5" {{$selectedData['status'] == 5 ? 'selected' : ''}}>Cancelled</option>
                            <option value="6" {{$selectedData['status'] == 6 ? 'selected' : ''}}>Completed</option>
                        </select>
                    </div>

                    <div class="mt-4">
                        <x-jet-label for="remarks" value="{{ __('Remarks') }}" />
                        <textarea id="remarks" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50" name="remarks" required >{{$selectedData['remarks']}}</textarea>
                    </div>

                    <div class="flex items-center justify-end mt-4 space-x-2">
                        <button type="button" wire:click="toggleModal(false,'final')" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-gray-800 uppercase transition bg-white border border-gray-900 rounded-md hover:bg-gray-300 active:bg-gray-300 focus:outline-none focus:border-gray-300 focus:ring focus:ring-gray-900 disabled:opacity-25">
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
                                                {{$data->code}}
                                            </th>
                                            <td class="px-6 py-4 uppercase">
                                                {{$data->name}}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{$data->quantity}}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{$data->weight}}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{$data->cost}}
                                            </td>
                                            <td class="px-6 py-4 uppercase">
                                                <p class="{{$this->renderColor($data->status)}}">
                                                    {{$this->renderStatus($data->status)}}
                                                </p>
                                            </td>
                                            <td class="flex flex-row px-6 py-4 space-x-2 text-center">
                                                @if(auth()->user()->role != 2)
                                                <button wire:click="itemAttachments({{$data->id}})">
                                                    <i class="fa-solid fa-download"></i>
                                                </button>
                                                @endif
                                                @if(auth()->user()->role != 2 && $data->status <= 1)
                                                <button wire:click="selectedItem({{$data->id}},'verify')">
                                                    <i class="fa-solid fa-clipboard-check"></i>
                                                </button>
                                                @endif
                                                @if(auth()->user()->role <=1 && $data->status == 2)
                                                <button wire:click="selectedItem({{$data->id}},'approved')">
                                                    <i class="fa-solid fa-circle-play"></i>
                                                </button>
                                                @endif
                                                @if(auth()->user()->role <= 1 && $data->status == 4)
                                                <button wire:click="selectedItem({{$data->id}},'final')">
                                                    <i class="fa-solid fa-truck"></i>
                                                </button>
                                                @endif
                                                @if(auth()->user()->role == 2 && $data->status == 4)
                                                <button wire:click="finalStatus({{$data->id}},5)">
                                                    <i class="fa-solid fa-ban"></i>
                                                </button>
                                                <button wire:click="finalStatus({{$data->id}},6)">
                                                    <i class="fa-solid fa-circle-check"></i>
                                                </button>
                                                @endif
                                                @if(auth()->user()->role == 0)
                                                <button wire:click="selectedItem({{$data->id}},'edit')">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </button>
                                                <form method="POST" action="{{ route('inventories.destroy',$data->id) }}">
                                                    @method('delete')
                                                    @csrf
                                                    <button type="submit">
                                                        <i class="text-red-700 fa-solid fa-trash"></i>
                                                    </button>
                                                </form>
                                                @endif
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

    @if(auth()->user()->role != 2)
    <div class="fixed bottom-0 right-0 z-30 flex items-center justify-center w-auto h-auto px-4 py-2 m-6 bg-white border-4 border-gray-600 rounded-full cursor-pointer hover:border-teal-600 md:m-10" onclick="toggleElement('create')">
        <button class="flex flex-row items-center justify-center text-gray-600 hover:text-teal-600 focos:outline-none">
            <i class="px-2 fa-solid fa-plus"></i> ADD PACKAGE
        </button>
    </div>
    @endif
</div>