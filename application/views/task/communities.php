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
        </div>
        <form id="postForm" method="POST">
            <input type="text" id="title" name="title" placeholder="Title" class="form-control mb-3" required><br>
            <textarea name="description" id="description" rows="8" cols="80" placeholder="Description" class="form-control mb-3" required></textarea><br>
            <button type="submit" class="btn btn-primary">Post it</button>
        </form>

        <h2 class="mt-5">All posts</h2>
        <table class="table table-bordered mt-2" id="resultsTable">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Likes</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody data-role="tbody"></tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            const getList = () => {
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
                                    <td>${post.like_count}</td>
                                    <td>
                                        <button class="like-btn btn btn-sm ${post.is_liked ? 'btn-danger' : 'btn-success'}"
                                                data-postid="${post.id}">
                                            ${post.is_liked ? 'Unlike' : 'Like'}
                                        </button>
                                    </td>
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

            // Handle form submission for posting
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
                                <td>0</td>
                                <td>
                                    <button class="like-btn btn btn-sm btn-success" data-postid="${newPost.id}">Like</button>
                                </td>
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

            // Handle like/unlike button click
            $(document).on('click', '.like-btn', function() {
      const postId = $(this).data('postid');
       // Fetch the post ID
      const isLiked = $(this).hasClass('btn-danger');
      const url = isLiked ? '<?= base_url("unlike-post/") ?>' + postId : '<?= base_url("like-post/") ?>' + postId;
      console.log('Post ID:', postId);  // Debugging: Log the post_id to ensure it's correct

      $.ajax({
          url: url,
          method: 'POST',
          data: { post_id: postId },  // Pass post ID as POST data
          success: function(response) {
              const result = JSON.parse(response);
              if (result.success) {
                  getList();  // Refresh the post list with updated likes
              } else {
                  alert(result.message);
              }
          },
          error: function() {
              alert('Error processing like/unlike action!');
          }
      });
  });

        });
    </script>
</body>
</html>
