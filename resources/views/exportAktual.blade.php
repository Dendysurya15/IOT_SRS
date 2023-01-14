@include('layout.header')

<div class="content-wrapper" style="background: white">
    <section class="content">
        <div class="card-body">
            <table id="aktualTemp" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th style="text-align: center">ID</th>
                        <th style="text-align: center">Lokasi</th>
                        <th style="text-align: center">Tanggal</th>
                        <th style="text-align: center">Jam</th>
                        <th style="text-align: center">Temperatur</th>
                        <th style="text-align: center">Curah Hujan</th>
                        <th style="text-align: center">Kelembaban Udara</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($historyData as $data)
                    <tr>
                        <td style="text-align: center">{{ $data['idws'] }}</td>
                        <td style="text-align: center">{{ $data['loc'] }}</td>
                        <td style="text-align: center">{{ $data['tgl'] }}</td>
                        <td style="text-align: center">{{ $data['jam'] }}</td>
                        @if (!empty($data['temp_real']))
                        <td style="text-align: center">{{ $data['temp_real'] }}</td>
                        @else
                        <td style="text-align: center">0</td>
                        @endif
                        @if (!empty($data['rain_fall_real']))
                        <td style="text-align: center">{{ $data['rain_fall_real'] }}</td>
                        @else
                        <td style="text-align: center">0</td>
                        @endif
                        @if (!empty($data['hum_real']))
                        <td style="text-align: center">{{ $data['hum_real'] }}</td>
                        @else
                        <td style="text-align: center">0</td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
</div>

@include('layout.footer')

<script>
    $(document).ready(function() {
        $('#aktualTemp').DataTable({
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'excelHtml5',
                    title: 'Data Weather'
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Data Weather'
                }
            ]
        });
    });
</script>