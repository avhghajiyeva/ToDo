<?php
$lang=include('lang.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Tapşırıqlar</title>
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center"><?=$lang["tasks"]?></h1>
    <div class="mb-3">
        <a href="<?= base_url("show") ?>" title="<?=$lang["add"]?>" class="btn btn-success"><i class="fa-solid fa-plus fa-lg"></i></a>
    </div>

    <form id="searchForm" class="mb-4" action="<?= base_url('search') ?>">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Axtar..." required>
            <div class="input-group-append">
                <button type="submit" class="btn btn-primary">Axtar</button>
            </div>
        </div>
    </form>

    <div id="results">
<table class="table table-striped table-bordered" id="taskTable">
              <thead>
                <tr>
                    <th>Ad</th>
                    <th>Təsvir</th>
                    <th>Bitmə Tarixi</th>
                    <th>Əməliyyatlar</th>
                </tr>
            </thead>
            <tbody data-role="tbody">
                <?php foreach ($param as $list): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($list->name); ?></td>
                        <td><?php echo htmlspecialchars($list->description); ?></td>
                        <td><?php echo htmlspecialchars($list->deadline); ?></td>
                        <td>
                            <a href="<?= site_url('edit/' . $list->id); ?>" title="<?=$lang["edit"]?>" class="btn btn-warning btn-sm"><i class="fa-solid fa-pen fa-lg"></i></a>
                            <a href="<?= site_url('delete/' . $list->id); ?>" title="<?=$lang["delete"]?>" class="btn btn-danger btn-sm" onclick="return confirm('Silinməsini təsdiqləyirsinizmi?');"><i class="fa-solid fa-trash fa-lg"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
$(document).ready(function() {

  const trComponent = (v,i) => {
    return `<tr>
                <td>${v.name}</td>
                <td>${v.description}</td>
                <td>${v.deadline}</td>
                <td>
                    <a href="" class="btn btn-warning btn-sm"><i class="fa-solid fa-pen"></i></a>
                    <a href="" class="btn btn-danger btn-sm" onclick="return confirm('Silinməsini təsdiqləyirsinizmi?');"><i class="fa-solid fa-trash"></i></a>
                </td>
            </tr>`
  }

    $('#searchForm').on('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission
        let h = '';
        $.ajax({
            url: '/search',
            type: 'GET',
            data: $(this).serialize(), // Serialize the form data
            success: function(response) {
              let data = JSON.parse(response);
              h += data.map((v,i) => trComponent(v,i)).join('');
              $('#taskTable tbody').html(h);
            },
            error: function() {
                alert('Axtarış zamanı bir xəta baş verdi.');
            }
        });
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
