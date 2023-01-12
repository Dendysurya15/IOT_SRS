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
                        <th style="text-align: center">Aktual Temperatur</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($historyData as $data)
                    @if (!empty($data['tgl']) && !empty($data['temp_real']))
                    <tr>
                        <td style="text-align: center">{{ $data['idws'] }}</td>
                        <td style="text-align: center">{{ $data['loc'] }}</td>
                        <td style="text-align: center">{{ $data['tgl'] }}</td>
                        <td style="text-align: center">{{ $data['jam'] }}</td>
                        <td style="text-align: center">{{ $data['temp_real'] }}</td>
                    </tr>
                    @endif
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
                    title: 'Data Aktual'
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Data Aktual'
                }
            ]
        });
    });
</script>