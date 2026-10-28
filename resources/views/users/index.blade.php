<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Gebruikers</title>
        @vite(['resources/css/app.css'])
    </head>
    <body class="bg-gray-100 p-8 font-sans text-gray-900">
        <main class="mx-auto max-w-4xl">
            <h1 class="mb-6 text-2xl font-semibold">Gebruikers ({{ $users->count() }})</h1>

            <table class="w-full overflow-hidden rounded-lg bg-white text-left shadow">
                <thead class="bg-gray-200 text-sm uppercase">
                    <tr>
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Naam</th>
                        <th class="px-4 py-2">E-mail</th>
                        <th class="px-4 py-2">Aangemaakt</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $user->id }}</td>
                            <td class="px-4 py-2">{{ $user->name }}</td>
                            <td class="px-4 py-2">{{ $user->email }}</td>
                            <td class="px-4 py-2">{{ $user->created_at?->format('d-m-Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-2 text-gray-500">Geen gebruikers gevonden.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </main>
    </body>
</html>
