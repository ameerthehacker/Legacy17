<ul class="collection with-header">
    <li class="collection-item">
        <table>
            <tbody>
                <tr>
                    <th>Legacy ID</th>
                    <td>{{ $user->LGId() }}</td>
                </tr>
                <tr>
                    <th>Name</th>
                    <td>{{ $user->full_name }}</td>
                </tr>
            </tbody>
        </table>
    </li>
</ul>