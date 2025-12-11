<div class="card">
    <div class="card-block p-t-10 p-b-10">
        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sequi, odio. Accusantium impedit deleniti non in sed quis corporis. Harum, culpa.
        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sequi, odio. Accusantium impedit deleniti non in sed quis corporis. Harum, culpa.
    </div>
</div>

<div class="card">
    <div class="card-block">
        <div class="card-title m-t-0">
            <h4><i class="fa fa-chart-line fa-fw"></i> Pengajuan Realisasi 12 Bulan Terakhir</h4>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div>
                    <canvas id="chartJumlah" data-render="chartJumlah" style="height: 250px;"></canvas>
                </div>
            </div>

            <div class="col-md-4">
                <div style="max-height: 250px; overflow-y: auto; border: 1px solid #ddd; margin-bottom: 5px;">
                    <table class="table table-condensed table-striped sp7-table-xs text-nowrap" style="margin-bottom: 0;">
                        <thead>
                            <tr>
                                <th class="text-left" style="position: sticky; top: 0; background: white; z-index: 10;">Bulan Periode</th>
                                <th class="text-right" style="position: sticky; top: 0; background: white; z-index: 10;">Account</th>
                                <th class="text-right" style="position: sticky; top: 0; background: white; z-index: 10;">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data_total_pengajuan as $value) { ?>
                                <tr>
                                    <td class="text-left"><?= $value['bulan'] ?? $value['bulan'] ?></td>
                                    <td class="text-right"><?= $value['total_pengajuan'] ?> Account</td>
                                    <td class="text-right"><?= number_format($value['total_plafond'] ?? $value['total_plafond'], 2) ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div>Jumlah pengajuan yang sudah terealisasi</div>
            </div>
        </div>
    </div>
</div>

<script>
    const labels = <?= json_encode($labels) ?>;
    const totalPengajuan = <?= json_encode($total_pengajuan) ?>;

    // Chart Jumlah Pengajuan
    new Chart(document.getElementById('chartJumlah'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: ' Total Pengajuan',
                data: totalPengajuan,
                borderColor: '#36A2EB',
                backgroundColor: 'rgba(54, 163, 235, 0.41)',
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            layout: {
                padding: {
                    top: 20,
                    bottom: 10 // Memberi ruang di bagian bawah
                }
            }
        }
    });
</script>
