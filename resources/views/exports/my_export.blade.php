<table>
    <thead>
        <tr>
            <th>id</th>
            <th>World</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $row)
        <tr>
            <td>{{ $row }}</td>
            <td>{{ $row }}</td>
        </tr>
        @endforeach
    </tbody>
</table>