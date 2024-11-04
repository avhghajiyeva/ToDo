<!DOCTYPE html>
<html>
<head>
    <title>Community Page</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-blue-grey.css">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        html, body, h1, h2, h3, h4, h5 { font-family: "Open Sans", sans-serif; }
    </style>
</head>
<body class="w3-theme-l5">

<!-- Navbar -->
<div class="w3-top">
    <div class="w3-bar w3-theme-d2 w3-left-align w3-large">
        <a class="w3-bar-item w3-button w3-right w3-padding-large w3-hover-white" href="<?= base_url("logout") ?>">Logout</a>
    </div>
</div>

<!-- Page Container -->
<div class="w3-container w3-content" style="max-width:1400px;margin-top:80px">
    <div class="w3-row">

        <!-- Left Column -->
        <div class="w3-col m3">
            <div class="w3-card w3-round w3-white">
                <div class="w3-container">
                    <h4 class="w3-center">My Profile</h4>
                    <hr>
                    <p><i class="fa fa-pencil fa-fw w3-margin-right w3-text-theme"></i> Adi</p>
                </div>
            </div>
            <br>
        </div>

        <!-- Middle Column -->
        <div class="w3-col m7">
            <div class="w3-row-padding">
                <div class="w3-col m12">
                    <div class="w3-card w3-round w3-white">
                        <div class="w3-container w3-padding">
                            <h6 class="w3-opacity">Create a Post</h6>
                            <form id="postForm" method="POST">
                                <input type="text" id="title" name="title" placeholder="Title" class="form-control mb-3" required><br>
                                <textarea name="description" id="description" rows="8" cols="80" placeholder="Description" class="form-control mb-3" required></textarea><br>
                                <button type="submit" class="btn btn-primary">Post it</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Posts Container -->
            <div id="postsContainer"></div>
        </div>

        <!-- Right Column -->
        <div class="w3-col m2">
            <div class="w3-card w3-round w3-white w3-center">
                <div class="w3-container"></div>
            </div>
            <br>
        </div>
    </div>
</div>
<br>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

const fetchPosts = () => {

}
    function fetchPosts() {
        $.ajax({
            type: 'GET',
            url: '<?= base_url("community") ?>',
            dataType: 'json',
            success: function(response) {
                $('#postsContainer').empty();
                $.each(response, function(index, post) {
                    $('#postsContainer').prepend(`
                      <div class="w3-container w3-card w3-white w3-round w3-margin" data-id="${post.id}">
                        <h4>${post.title}</h4>
                        <hr class="w3-clear">
                        <p>${post.description}</p>
                        <p><strong>Likes: <span class="likeCount" data-role="like-count">${post.like_count}</span></strong></p>
                        <button type="button" class="btn w3-margin-bottom likeBtn ${post.is_liked ? 'w3-theme-d1' : 'w3-grey'}" data-role="btn-like" onclick="likePost(this)">
                            <i class="fa fa-thumbs-up"></i> &nbsp;Like
                        </button>
                      </div>

                    `);
                });
            },
            error: function() {
                alert('Error fetching posts');
            }
        });
    }

    fetchPosts();

    $('#postForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: '<?= base_url("submit-post") ?>',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.error) {
                    alert(response.error);
                } else {
                    $('#postForm')[0].reset();
                    fetchPosts();
                }
            },
            error: function() {
                alert('Error submitting post');
            }
        });
    });

function likePost(button) {
    let parent =  $(button).parents("div");
    let post_id = parent.data("id");
    let currentCount = +parent.find(`[data-role="like-count"]`).html() ;
    $.ajax({
        type: 'POST',
        url: '<?= base_url("toggle-like") ?>',
        data: { post_id: post_id },
        dataType: 'json',
        success: function(response) {
            if (response.error) {
                alert(response.error);
            } else {
                if (response.liked) {
                    $(button).removeClass('w3-grey').addClass('w3-theme-d1');
                    parent.find(`[data-role="like-count"]`).html(currentCount + 1);
                } else {
                    $(button).removeClass('w3-theme-d1').addClass('w3-grey');
                    parent.find(`[data-role="like-count"]`).html(currentCount - 1);
                }
            }
        },
        error: function() {
            alert('Error toggling like');
        }
    });
}
</script>

</body>
</html>
