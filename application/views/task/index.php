<?php
$lang = include('lang.php');
 // Make sure lang.php returns an array
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <title>Tapşırıqlar</title>
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center"><?=$lang["tasks"]?></h1>
    <div class="mb-3">
        <a href="<?= base_url("show") ?>" data-toggle="tooltip" data-placement="top" title="Yarat" class="btn btn-success"><i class="fa-solid fa-plus fa-lg"></i></a>
    </div>
    <div class="mb-3">
        <a href="<?= base_url("community-page") ?>" data-toggle="tooltip" data-placement="top" title="community" class="btn btn-success"><i class="fa-solid fa-bullhorn"></i></a>
    </div>
    <form id="searchForm" class="mb-4" action="<?= base_url('search') ?>">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Axtar...">
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
                            <a href="<?= site_url('edit/' . $list->id); ?>" data-toggle="tooltip" data-placement="top" title="Duzelis et" class="btn btn-warning btn-sm"><i class="fa-solid fa-pen fa-lg"></i></a>
                            <a href="<?= site_url('delete/' . $list->id); ?>" data-toggle="tooltip" data-placement="top" title="Sil" class="btn btn-danger btn-sm" onclick="return confirm('Silinməsini təsdiqləyirsinizmi?');"><i class="fa-solid fa-trash fa-lg"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
// $(document).ready(function() {
//
//   const trComponent = (v, i) => {
//     return `<tr>
//                 <td>${v.name}</td>
//                 <td>${v.description}</td>
//                 <td>${v.deadline}</td>
//                 <td>
//                     <a href="" class="btn btn-warning btn-sm"><i class="fa-solid fa-pen"></i></a>
//                     <a href="" class="btn btn-danger btn-sm" onclick="return confirm('Silinməsini təsdiqləyirsinizmi?');"><i class="fa-solid fa-trash"></i></a>
//                 </td>
//             </tr>`;
//   }
//
//   $('#searchForm').on('submit', function(e) {
//     e.preventDefault(); // Prevent the default form submission
//     let h = '';
//
//     $.ajax({
//       url: '/search',
//       type: 'GET',
//       data: $(this).serialize(), // Serialize the form data
//       success: function(response) {
//         let data = JSON.parse(response);
//
//         // Check if data is empty and fetch the entire list if it is
//         if (data.length === 0) {
//           $.ajax({
//             url: '/search', // Re-use the same endpoint to get all data
//             type: 'GET',
//             data: {}, // Send an empty data object to get all items
//             success: function(allDataResponse) {
//               let allData = JSON.parse(allDataResponse);
//               h += allData.map((v, i) => trComponent(v, i)).join('');
//               $('#taskTable tbody').html(h);
//             },
//             error: function() {
//               alert('Bütün məlumatları yükləyərkən bir xəta baş verdi.');
//             }
//           });
//         } else {
//           // If there are results, map and display them
//           h += data.map((v, i) => trComponent(v, i)).join('');
//           $('#taskTable tbody').html(h);
//         }
//       },
//       error: function() {
//         alert('Axtarış zamanı bir xəta baş verdi.');
//       }
//     });
//   });
// });
</script>
<script>
$(document).ready(function() {

  const trComponent = (v, i) => {
    return `<tr>
                <td>${v.name}</td>
                <td>${v.description}</td>
                <td>${v.deadline}</td>
                <td>
                    <a href="" class="btn btn-warning btn-sm"><i class="fa-solid fa-pen"></i></a>
                    <a href="" class="btn btn-danger btn-sm" onclick="return confirm('Silinməsini təsdiqləyirsinizmi?');"><i class="fa-solid fa-trash"></i></a>
                </td>
            </tr>`;
  }

  $('#searchForm').on('submit', function(e) {
    e.preventDefault(); // Prevent the default form submission
    let h = '';

    $.get({
      url: '/search',
      data: $(this).serialize(), // Serialize the form data
      success: function(response) {
        let data = JSON.parse(response);

        if (data.length) {
          h += data.map((v, i) => trComponent(v, i)).join('');
        } else {
          h = '<tr><td colspan="4">Heç bir nəticə tapılmadı.</td></tr>';
        }
        $('#taskTable tbody').html(h);
      },
      error: function() {
        alert('Axtarış zamanı bir xəta baş verdi.');
      }
    });
  });
});
</script>

<script>
  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
  });
</script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
