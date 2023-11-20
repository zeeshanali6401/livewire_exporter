<table>
    <thead>
        <tr>
            <th>S/N</th>
            <th>Name</th>
            <th>Division</th>
            <th>Email</th>
            <th>Assigned Table</th>
            <th>Lucky Draw Blaklist</th>
            <th>Lucky Draw Number</th>
            <th>Auth Key</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->division }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->assigned_table }}</td>
                <td>{{ $user->lucky_draw_blacklist }}</td>
                <td>{{ $user->lucky_draw_number }}</td>
                <td>{{ $user->auth_key }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
