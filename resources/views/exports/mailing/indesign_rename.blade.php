<table>
    <tbody>
    @foreach($names as $name)
      <tr>
          <td style="font-size: 12px">{{ $name }}</td>
      </tr>
    @endforeach
    </tbody>
</table>