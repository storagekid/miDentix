<head>
  <meta charset="UTF-8">
</head>
<table>
    <thead>
    <tr>
      @foreach($columns as $column => $label)
        <th style="background-color:#873173; color:#FFFFFF; font-size: 16px">{{ $label }}</th>
      @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($clinics as $clinic)
      <tr>
        @foreach($columns as $column => $label)
          <td style="font-size: 12px">{{ $clinic[$column] }}</td>
        @endforeach
      </tr>
    @endforeach
    </tbody>
</table>