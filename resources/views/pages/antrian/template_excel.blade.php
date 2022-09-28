<table border="1">
  <thead>
    <tr>
      <th style="background-color: lightblue; font-weight: bold; text-align: center;">No</th>
      <th style="background-color: lightblue; font-weight: bold; text-align: center;">Cabang</th>
      @foreach ($tanggals as $item)
        <th style="background-color: lightblue; font-weight: bold; text-align: center;">Tanggal {{ $item }}</th>          
      @endforeach
    </tr>
  </thead>
  <tbody>
    @foreach ($antrians as $key => $item)
      <tr>
        <td>{{ $key + 1 }}</td>
        <td>
          @if ($item->master_cabang != null)
            @foreach ($cabangs as $item_cabang)
              @if ($item_cabang->id == $item->master_cabang)
                {{ $item_cabang->nama_cabang }}</td>                            
              @endif              
            @endforeach
          @endif
        <td>tes</td>
      </tr>
    @endforeach
  </tbody>
</table>
