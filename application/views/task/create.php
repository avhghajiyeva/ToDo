<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Yeni Tapşırıq Yarat</title>
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center">Yeni Tapşırıq Yarat</h1>
    <div class="mb-3">
        <a href="<?= base_url("logout") ?>" data-toggle="tooltip" data-placement="top" class="btn btn-success">Logout</a>
    </div>
    <form method="post" action="<?= base_url("create") ?>" class="mt-4">
        <div class="form-group">
            <label for="name">Ad:</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="description">Təsvir:</label>
            <textarea name="description" class="form-control" rows="4"></textarea>
        </div>

        <div class="form-group">
            <label for="deadline">Bitmə Tarixi:</label>
            <input type="date" name="deadline" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Yarat</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
