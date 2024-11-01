<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Community</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h1>Community</h1>
        <div class="mb-3">
            <a href="<?= base_url("logout") ?>" data-toggle="tooltip" data-placement="top" class="btn btn-success">Logout</a>
        </div>
        <form id="postForm" method="POST">
            <input type="text" id="title" name="title" placeholder="Title" class="form-control mb-3" required><br>
            <textarea name="description" id="description" rows="8" cols="80" placeholder="Description" class="form-control mb-3" required></textarea><br>
            <button type="submit" class="btn btn-primary">Post it</button>
        </form>

        <h2 class="mt-5">Your posts</h2>
        <table class="table table-bordered mt-2" id="resultsTable">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody data-role="tbody"></tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            const getList =  () => {
              $.ajax({
                  url: "<?= base_url('community') ?>",
                  method: "GET",
                  success: function(response) {
                      const posts = JSON.parse(response);
                      let postRows = '';
                      posts.forEach(post => {
                          postRows += `
                              <tr>
                                  <td>${post.title}</td>
                                  <td>${post.description}</td>
                              </tr>`;
                      });
                      $("#resultsTable tbody").html(postRows);
                  },
                  error: function() {
                      alert('Error loading posts!');
                  }
              });

            }

            getList();

            $("#postForm").on("submit", function(event) {
                event.preventDefault();

                const formData = {
                    title: $("#title").val(),
                    description: $("#description").val(),
                };

                $.ajax({
                      url: "<?= base_url('submit-post') ?>",
                      method: "POST",
                      data: formData,
                      success: function(response) {
                          const newPost = JSON.parse(response);
                          if (newPost.error) {
                              alert(newPost.error);
                              return;
                          }

                          const newRow = `
                              <tr>
                                  <td>${newPost.title}</td>
                                  <td>${newPost.description}</td>
                              </tr>`;
                          $("#resultsTable tbody").prepend(newRow);
                          $("#title").val('');
                          $("#description").val('');
                      },
                      error: function() {
                          alert('Error submitting the post!');
                      }
                  });

            });
        });
    </script>
</body>
</html>
