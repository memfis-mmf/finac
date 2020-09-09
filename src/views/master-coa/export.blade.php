<table cellpadding="6">
  <thead>
    <tr style="background:#f7dd16;">
      <th valign="top" align="center">Account Code</th>
      <th valign="top" align="center">Account Name</th>
      <th valign="top" align="center">Account Type</th>
      <th valign="top" align="center">Account Group</th>
      <th valign="top" align="center">Status</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($datas as $data)
      <tr>
        <td valign="top" align="center">{{ $data->code }}</td>
        <td valign="top" align="center">{{ $data->name }}</td>
        <td valign="top" align="center">{{ $data->type->name }}</td>
        <td valign="top" align="center">{{ $data->description }}</td>
        <td valign="top" align="center">{{ ($data->active)? 'Active': 'Inactive' }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
