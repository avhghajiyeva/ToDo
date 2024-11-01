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
        <h1 class="text-center">Simple Calculator</h1>
        <div class="mb-3 text-center">
            <a href="<?= base_url("calculations") ?>" data-toggle="tooltip" data-placement="top" title="Cedvel" class="btn btn-success">
                <i class="fa-solid fa-border-all fa-lg"></i>
            </a>
        </div>

        <div id="resultContainer">
        </div>

        <form id="calculatorForm" class="mt-4">
            <div class="form-row align-items-center">
                <div class="col-auto">
                    <input type="number" id="num1" name="num1" class="form-control mb-2" placeholder="First Number" required>
                </div>
                <div class="col-auto">
                    <select class="custom-select mb-2" id="operator" name="operator" required>
                        <option value="+" selected>+</option>
                        <option value="-">-</option>
                        <option value="*">*</option>
                        <option value="/">/</option>
                        <option value="pow">Power(x^y)</option>
                        <option value="root">√</option>
                    </select>
                </div>
                <div class="col-auto">
                    <input type="number" id="num2" name="num2" class="form-control mb-2" placeholder="Second Number" required>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary mb-2">Calculate</button>
                </div>
            </div>
        </form>

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
            <tbody>
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            $("#calculatorForm").on("submit", function(event) {
                event.preventDefault();

                const formData = {
                    num1: $("#num1").val(),
                    operator: $("#operator").val(),
                    num2: $("#num2").val()
                };

                $.ajax({
                    url: "<?= base_url('calculate') ?>",
                    method: "POST",
                    data: formData,
                    success: function(response) {
                        const result = JSON.parse(response);

                        $("#resultsTable tbody").html(`
                            <tr>
                                <td>${result.num1}</td>
                                <td>${result.num2}</td>
                                <td>${result.operation}</td>
                                <td>${result.result}</td>
                            </tr>
                        `);
                    },
                    error: function() {
                        consol.log('Veri gönderme hatası!');
                    }
                });
            });
        });
    </script>
</body>
</html>
