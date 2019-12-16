<table>
    <thead>
    <tr>
      @foreach($posters[0] as $column => $data)
        <th style="background-color:#873173; color:#FFFFFF; font-size: 16px">{{ $column }}</th>
      @endforeach 
    </tr>
    </thead>
    <tbody>
    @foreach($posters as $poster)
      <tr>
        @foreach($poster as $column => $data)
          <td style="font-size: 12px">{{ $data }}</td>
        @endforeach
      </tr>
    @endforeach
    </tbody>
</table>