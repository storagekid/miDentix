<table>
    <thead>
    <tr>
      @foreach($columns as $column)
        <th style="background-color:#873173; color:#FFFFFF; font-size: 16px">{{ucfirst($column)}}</th>
      @endforeach
    </tr>
    </thead>
    <tbody>
      @foreach($models as $model)
      <tr>
        @foreach($columns as $column)
        <td>{{ $model[$column] }}</td>
        @endforeach
      </tr>
      @endforeach
    </tbody>
</table>