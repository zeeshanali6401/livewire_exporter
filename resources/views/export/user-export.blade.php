<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Auth key</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
            <tr>

                <td>
                    {{ $user->id }}
                </td>
                <td>

                    {{ $user->name }}
                </td>
                <td>
                    {{ $user->email }}

                </td>
                <td>{{ $user->auth_key }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
