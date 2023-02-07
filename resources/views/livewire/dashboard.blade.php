<div class="m-5">
    <div class="py-4 space-y-4">
        <!-- Top Bar -->
        <div class="flex justify-between">
            <div class="w-2/4 flex space-x-4">
                <x-text-input wire:model="search" class="w-2/4" type="text"  placeholder="Search User Email or Name..." />
                <div class="flex flex-col mt-2">
                    <div class="flex ">
                        <x-checkbox-input class="rounded" wire:model="showArchivedOnly"></x-checkbox-input>
                        <x-input-label for="showArchivedOnly" class="pl-0.5" :value="'show archived only'"/>
                    </div>
                    <div class="flex ">
                        <x-checkbox-input class="rounded" wire:model="showActiveOnly"></x-checkbox-input>
                        <x-input-label for="showActiveOnly" class="pl-0.5" :value="'show active only'"/>
                    </div>
                </div>
            </div>
            <div class="flex">
                <x-primary-button wire:click="$set('showInviteModal', true)" type="submit">Invite</x-primary-button>
            </div>
        </div>
    </div>
    <div class="flex-col space-y-4">
        <x-table>
            <x-slot name="head">
                <x-table.heading wire:click="sortBy('name')" :sortable='true' :direction="$sortField === 'name' ? $sortDirection : null">Name</x-table.heading>
                <x-table.heading wire:click="sortBy('email')" sortable :direction="$sortField === 'email' ? $sortDirection : null">Email</x-table.heading>
                <x-table.heading wire:click="sortBy('last_login_at')" sortable :direction="$sortField === 'last_login_at' ? $sortDirection : null ">Last Login</x-table.heading>

                <x-table.heading>Status</x-table.heading>
                <x-table.heading>Actions</x-table.heading>

            </x-slot>
            <x-slot name="body">
                @forelse ($users as $user)
                <x-table.row>
                    <x-table.cell>{{$user->name}}</x-table.cell>
                    <x-table.cell>{{$user->email}}</x-table.cell>
                    <x-table.cell>{{optional($user->last_login_at)->diffForHumans()}}</x-table.cell>
                    <x-table.cell>
                        <span class="inline-flex items-center gap-1 rounded-full {{$user->status_color === 'red' ? 'bg-red-50 text-red-600' : 'bg-green-50 text-green-600'}} px-2 py-1 text-xs font-semibold">
                            <span class="h-1.5 w-1.5 rounded-full {{$user->status_color === 'red' ? 'bg-red-600' : 'bg-green-600'}}"></span>
                            {{$user->status}}
                        </span>
                    </x-table.cell>
                    <x-table.cell>
                        <a wire:click.prevent="edit({{$user->id}})" href="#">
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

    {{-- Edit Modal --}}
    <form wire:submit.prevent="save">
        <x-modals.edit wire:model="showEditModal" :name="'edit-user-'.$editingUser->id">
            <x-slot name="title">Edit User</x-slot>

            <x-slot name="content">
                <div>
                    <x-input-label for="name" :value="'name'"/>
                    <x-text-input wire:model="editingUser.name" id="name" @class(["block mt-1 w-full", "border-red-500" => $errors->has("editingUser.name")]) type="text" autofocus />
                    <x-input-error :messages="$errors->get('editingUser.name')" class="mt-2" />
                </div>
                <div class="mt-4">
                    <x-input-label for="email"  :value="'email'"/>
                    <x-text-input wire:model.lazy="editingUser.email" @class(["block mt-1 w-full", "border-red-500" => $errors->has("editingUser.email")]) type="text"/>
                    <x-input-error :messages="$errors->get('editingUser.email')" class="mt-2" />
                </div>
                <div class="mt-4">
                    <x-input-label for="status"  :value="'status'"/>
                    <x-select-input wire:model="editingStatus" id="status">
                        @foreach (App\Models\User::STATUSES as $status)
                            <option value="{{ $status }}">{{ $status }}</option>
                        @endforeach
                    </x-select-input>
                    <x-input-error :messages="$errors->get('editingStatus')" class="mt-2" />
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="$set('showEditModal', false)">Cancel</x-secondary-button>
                <x-primary-button type="submit">Save</x-primary-button>
            </x-slot>
        </x-modals.edit>
    </form>

    {{-- Invite Modal --}}
    <form wire:submit.prevent="invite">
        <x-modals.edit wire:model="showInviteModal" :name="'invite-user'">
            <x-slot name="title">Invite User</x-slot>

            <x-slot name="content">
                <div class="mt-4">
                    <x-input-label for="inviteeEmail"  :value="'email'"/>
                    <x-text-input wire:model.lazy="inviteeEmail" @class(["block mt-1 w-full", "border-red-500" => $errors->has("inviteeEmail")]) type="text"/>
                    <x-input-error :messages="$errors->get('inviteeEmail')" class="mt-2" />
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="$set('showInviteModal', false)">Cancel</x-secondary-button>
                <x-primary-button type="submit">Invite</x-primary-button>
            </x-slot>
        </x-modals.edit>
    </form>

    {{-- Success Modal --}}
    <x-modal wire:model="showSuccessfullEdit" :name="'invite-success-modal'">
        <div class=" bg-green-500 ">
            <p class="animate-pulse text-white text-9xl font-extrabold text-center">
                &check;
            </p>
            <p class="text-white text-5xl font-extrabold text-center mt-8">
                Great!
            </p>
            <p class="text-white text-3xl text-center ">
                Invitation has been sent successfully.
            </p>
            <div class="flex flex-row-reverse mt-2 pb-1 pr-1">
                <x-secondary-button class='opacity-60' wire:click="$set('showSuccessfullEdit', false)">Close</x-secondary-button>
            </div>
        </div>
    </x-modal>


</div>
