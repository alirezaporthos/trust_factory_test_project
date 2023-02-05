<div class="m-5">
    <div class="py-4 space-y-4">
        <!-- Top Bar -->
        <div class="flex justify-between">
            <div class="w-2/4 flex space-x-4">
                <x-text-input wire:model="search" type="text"  placeholder="Search Users..." />
            </div>
        </div>
    </div>
    <div class="flex-col space-y-4">
        <x-table>
            <x-slot name="head">
                <x-table.heading sortable>Name</x-table.heading>
                <x-table.heading sortable>Email</x-table.heading>
                <x-table.heading sortable>Status</x-table.heading>
                <x-table.heading sortable>Last Login</x-table.heading>
                <x-table.heading sortable>Actions</x-table.heading>

            </x-slot>
            <x-slot name="body">
                @forelse ($users as $user)
                <x-table.row>
                    <x-table.cell>{{$user->name}}</x-table.cell>
                    <x-table.cell>{{$user->email}}</x-table.cell>
                    <x-table.cell>
                        <span class="inline-flex items-center gap-1 rounded-full bg-{{$user->status_color}}-50 px-2 py-1 text-xs font-semibold text-green-600">
                            <span class="h-1.5 w-1.5 rounded-full bg-{{$user->status_color}}-600"></span>
                            {{$user->status}}
                        </span>
                    </x-table.cell>
                    <x-table.cell>{{optional($user->last_login_at)->diffForHumans()}}</x-table.cell>
                    <x-table.cell>
                        <a wire:click.prevent="edit" href="#">
                            <x-icons.edit></x-icons.edit>
                        </a>
                    </x-table.cell>
                </x-table.row>
                @empty
                <x-table.row>
                    <x-table.cell colspan='3'>
                        No user found...
                    </x-table.cell>
                </x-table.row>

                @endforelse
            </x-slot>
        </x-table>
        <div class="">
            {{ $users->links() }}
        </div>
    </div>
    <form >
        <x-modals.edit wire:model="showEditModal" :name="'edit-user-'.$user->id">
            <x-slot name="title">Edit User</x-slot>

            <x-slot name="content">
                <div>
                    <x-input-label for="name" :value="'name'"/>
                    <x-text-input  id="name" @class(["block mt-1 w-full", "border-red-500" => $errors->has("name")]) type="text" autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <div class="mt-4">
                    <x-input-label for="email"  :value="'email'"/>
                    <x-text-input  @class(["block mt-1 w-full", "border-red-500" => $errors->has("email")]) type="email" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                <div class="mt-4">
                    <x-input-label for="status"  :value="'status'"/>
                    <x-select-input  id="status">
                        @foreach (App\Models\User::STATUSES as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-select-input>
                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="$set('showEditModal', false)">Cancel</x-secondary-button>
                <x-primary-button type="submit">Save</x-primary-button>
            </x-slot>
        </x-modals.edit>
    </form>

</div>
