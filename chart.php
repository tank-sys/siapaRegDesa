<div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 py-0 my-0">
<div class="col">
            <div class="card card-info">
              <div class="card-header">
                <span>Agama</span>
                 <button type="button" class="btn btn-tool float-end" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool float-end" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
              </div>
              <div class="card-body content-fluid">
<canvas id="agama"></canvas>
            </div>
	</div>
</div>


<div class="col">
            <div class="card card-info">
              <div class="card-header">
                <span>Jenis Kelamin</span>
                 <button type="button" class="btn btn-tool float-end" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool float-end" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
              </div>
              <div class="card-body">
<canvas id="jenis"></canvas>
            </div>
	</div>
</div>


<div class="col">
            <div class="card card-info">
              <div class="card-header">
                <span>Pendidikan</span>
                 <button type="button" class="btn btn-tool float-end" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool float-end" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
              </div>
              <div class="card-body">
<canvas id="sekolah" width="200" height="100"></canvas>
            </div>
	</div>
</div>




</div>
        <!-- /.row -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
<script>
var ctx = document.getElementById("agama").getContext('2d');
var agama = new Chart(ctx, {
  type: 'pie',
  data: {
      labels: [<?php foreach ($conn->query("SELECT agama,COUNT(*) FROM biodata_wni WHERE flag_status='0' GROUP BY agama") as $r) {echo "'".agama($r['agama'])."', ";}?>],
      datasets: [{
          label: '# of Votes',
          data: [<?php foreach ($conn->query("SELECT agama,COUNT(*) FROM biodata_wni WHERE flag_status='0' GROUP BY agama") as $r) {echo $r['COUNT(*)'].", ";}?>],
          backgroundColor: [
              'rgba(54, 162, 235)',
              'rgba(255, 206, 86)',
              'rgba(75, 192, 192)',
              'rgba(153, 102, 255)',
              'rgba(255, 159, 64)'
          ],
          borderColor: [
              'rgba(54, 162, 235, 1)',
              'rgba(255, 206, 86, 1)',
              'rgba(75, 192, 192, 1)',
              'rgba(153, 102, 255, 1)',
              'rgba(255, 159, 64, 1)'
          ],
          borderWidth: 1
      }]
  },
options: {
    responsive: true,
    plugins: {
      legend: {
        position: 'top',
      },
    }
  },
});

var ctx = document.getElementById("jenis").getContext('2d');
var jenis = new Chart(ctx, {
  type: 'pie',
  data: {
      labels: [<?php foreach ($conn->query("SELECT jenis_klmin,COUNT(*) FROM biodata_wni WHERE flag_status='0' GROUP BY jenis_klmin") as $r) {echo "'".$jeniskelamin[$r['jenis_klmin']]."', ";}?>],
      datasets: [{
          label: '# of Votes',
          data: [<?php foreach ($conn->query("SELECT jenis_klmin,COUNT(*) FROM biodata_wni WHERE flag_status='0' GROUP BY jenis_klmin") as $r) {echo $r['COUNT(*)'].", ";}?>],
          backgroundColor: [
              'rgba(255, 206, 86)',
              'rgba(75, 192, 192)',
              'rgba(153, 102, 255)',
              'rgba(255, 159, 64)'
          ],
          borderColor: [
              'rgba(54, 162, 235, 1)',
              'rgba(255, 206, 86, 1)',
              'rgba(75, 192, 192, 1)',
              'rgba(153, 102, 255, 1)',
              'rgba(255, 159, 64, 1)'
          ],
          borderWidth: 1
      }]
  },
options: {
    responsive: true,
    plugins: {
      legend: {
        position: 'bottom',
      },
    }
  },
});

var ctx = document.getElementById("sekolah").getContext('2d');
var sekolah = new Chart(ctx, {
  type: 'doughnut',
  data: {
      labels: [<?php global $conn; foreach (mysqli_fetch_array($conn->query("SELECT COUNT(IF(umur < 2,1,NULL)) AS 'hingga 2',
COUNT(IF(umur BETWEEN 2 and 4,1,NULL)) AS '2 - 4',
COUNT(IF(umur BETWEEN 4 and 5,1,NULL)) AS '4 - 5',
COUNT(IF(umur BETWEEN 5 and 12,1,NULL)) AS '4 - 12',
COUNT(IF(umur BETWEEN 12 and 18,1,NULL)) AS '12 - 18',
COUNT(IF(umur BETWEEN 18 and 64,1,NULL)) AS '18 - 64',
COUNT(IF(umur >= 65,1,NULL)) AS '65 ke-atas', count(*) as total
FROM (select nik, tgl_lhr, TIMESTAMPDIFF(YEAR, tgl_lhr,
CURDATE()) AS umur FROM biodata_wni WHERE flag_status='0') as dummy_table")) as $key => $value)
{echo "'".$key."', ";}?>],
      datasets: [{
          data: [<?php global $conn; foreach (mysqli_fetch_array($conn->query("SELECT COUNT(IF(umur < 2,1,NULL)) AS 'hingga 2',
COUNT(IF(umur BETWEEN 2 and 4,1,NULL)) AS '2 - 4',
COUNT(IF(umur BETWEEN 4 and 5,1,NULL)) AS '4 - 5',
COUNT(IF(umur BETWEEN 5 and 12,1,NULL)) AS '4 - 12',
COUNT(IF(umur BETWEEN 12 and 18,1,NULL)) AS '12 - 18',
COUNT(IF(umur BETWEEN 18 and 64,1,NULL)) AS '18 - 64',
COUNT(IF(umur >= 65,1,NULL)) AS '65 ke-atas'
FROM (select nik, tgl_lhr, TIMESTAMPDIFF(YEAR, tgl_lhr,
CURDATE()) AS umur FROM biodata_wni WHERE flag_status='0') as dummy_table")) as $key => $value)
{echo "'".$value."', ";}
?>],
          backgroundColor: [
              'rgba(255, 206, 86)',
              'rgba(75, 192, 192)',
              'rgba(153, 102, 255)',
              'rgba(255, 159, 64)'
          ],
          borderColor: [
              'rgba(54, 162, 235, 1)',
              'rgba(255, 206, 86, 1)',
              'rgba(75, 192, 192, 1)',
              'rgba(153, 102, 255, 1)',
              'rgba(255, 159, 64, 1)'
          ],
          borderWidth: 1
      }]
  },
options: {
    responsive: true,
    plugins: {
      legend: {
        position: 'top',
      },
    }
  },
});
</script>