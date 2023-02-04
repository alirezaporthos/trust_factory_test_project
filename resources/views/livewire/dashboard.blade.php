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
                <x-table.heading>Name</x-table.heading>
                <x-table.heading>Email</x-table.heading>
                <x-table.heading>Status</x-table.heading>
                <x-table.heading>Actions</x-table.heading>

            </x-slot>
            <x-slot name="body">
                @forelse ($users as $user)
                <x-table.row>
                    <x-table.cell>{{$user->name}}</x-table.cell>
                    <x-table.cell>{{$user->email}}</x-table.cell>
                    <x-table.cell>
                        <span class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2 py-1 text-xs font-semibold text-green-600">
                            <span class="h-1.5 w-1.5 rounded-full bg-green-600"></span>
                            Active
                        </span>
                    </x-table.cell>
                    <x-table.cell>
                        <a href="#">
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
</div>
