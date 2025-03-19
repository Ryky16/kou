<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Gestion des Utilisateurs
        </h2>
    </x-slot>

    
  <!--lien vers l'interface d'administration pour les administrateurs -->
  @if (Auth::user()->hasRole('Administrateur'))
    <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.index')">
        Gestion des Utilisateurs
    </x-nav-link>
@endif


    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="min-w-full">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left">Nom</th>
                                <th class="px-4 py-2 text-left">Email</th>
                                <th class="px-4 py-2 text-left">Rôle</th>
                                <th class="px-4 py-2 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td class="px-4 py-2">{{ $user->name }}</td>
                                    <td class="px-4 py-2">{{ $user->email }}</td>
                                    <td class="px-4 py-2">{{ $user->role->name }}</td>
                                    <td class="px-4 py-2">
                                        <form action="{{ route('admin.users.updateRole', $user) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <select name="role_id" onchange="this.form.submit()" class="px-2 py-1 border rounded">
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                                        {{ $role->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>