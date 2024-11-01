<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Calculator</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mt-5">Sonuçlar</h2>
        <table class="table table-bordered mt-2" id="resultsTable">
            <thead>
                <tr>
                    <th>Birinci Sayı</th>
                    <th>İkinci Sayı</th>
                    <th>İşlem</th>
                    <th>Sonuç</th>
                </tr>
            </thead>
            <tbody data-role="tbody">
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {

          const trComponent = (v, i) => {
            return `
                      <tr>
                          <td>${v.num1}</td>
                          <td>${v.num2}</td>
                          <td>${v.operation}</td>
                          <td>${v.result}</td>
                      </tr>
            `;
          }
            // Fetch data when the page loads
            let h = ``;

            $.ajax({
                url: "<?= base_url('all') ?>", // Adjust to your endpoint URL
                method: "GET",
                success: function(response) {
                    const results = JSON.parse(response); // Changed 'result' to 'results'

                    h += results.map((v, i) => trComponent(v, i));

                    $(`[data-role="tbody"]`).html(h);

                },
                error: function() {
                    alert('Veri yüklenemedi!'); // Improved the error message
                }
            });
        });
    </script>
</body>
</html>
