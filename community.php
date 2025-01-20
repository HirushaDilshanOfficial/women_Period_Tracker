<!-- Community Page -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FemCare Community</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-pink-50 min-h-screen">
    <!-- Reuse existing navigation -->
    <?php include 'nav.php'; ?>

    <main class="pt-24 pb-16 px-4">
        <div class="max-w-7xl mx-auto">
            <!-- Community Header -->
            <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                <h1 class="text-3xl font-bold mb-4">FemCare Community</h1>
                <p class="text-gray-600 mb-6">Connect, share, and support each other on your health journey.</p>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <button onclick="toggleModal('createPostModal')" 
                        class="bg-gradient-to-r from-pink-600 to-purple-600 text-white px-6 py-3 rounded-full hover:opacity-90">
                        Create New Post
                    </button>
                <?php else: ?>
                    <div class="bg-pink-50 p-4 rounded-lg">
                        <p class="text-gray-700">Please <a href="#" onclick="toggleModal('loginModal')" class="text-pink-600 hover:underline">login</a> to participate in the community.</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Categories -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div class="col-span-1">
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h2 class="text-xl font-bold mb-4">Categories</h2>
                        <ul class="space-y-2">
                            <li><a href="?category=general" class="text-gray-600 hover:text-pink-600">General Discussion</a></li>
                            <li><a href="?category=health" class="text-gray-600 hover:text-pink-600">Health Tips</a></li>
                            <li><a href="?category=questions" class="text-gray-600 hover:text-pink-600">Questions</a></li>
                            <li><a href="?category=support" class="text-gray-600 hover:text-pink-600">Support</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Posts List -->
                <div class="col-span-3">
                    <?php
                    $category = isset($_GET['category']) ? $_GET['category'] : 'all';
                    $query = "SELECT posts.*, users.username, 
                             (SELECT COUNT(*) FROM comments WHERE post_id = posts.id) as comment_count 
                             FROM posts 
                             JOIN users ON posts.user_id = users.id";
                    if($category !== 'all') {
                        $query .= " WHERE category = ?";
                    }
                    $query .= " ORDER BY created_at DESC";
                    
                    $stmt = $conn->prepare($query);
                    if($category !== 'all') {
                        $stmt->bind_param('s', $category);
                    }
                    $stmt->execute();
                    $result = $stmt->get_result();
                    
                    while($post = $result->fetch_assoc()):
                    ?>
                    <div class="bg-white rounded-xl shadow-lg p-6 mb-4 hover:shadow-xl transition-shadow">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-xl font-bold mb-2">
                                    <a href="post.php?id=<?= $post['id'] ?>" class="hover:text-pink-600">
                                        <?= htmlspecialchars($post['title']) ?>
                                    </a>
                                </h3>
                                <p class="text-gray-600 text-sm">
                                    Posted by <?= htmlspecialchars($post['username']) ?> · 
                                    <?= timeAgo($post['created_at']) ?> · 
                                    <?= $post['comment_count'] ?> comments
                                </p>
                            </div>
                            <span class="px-3 py-1 bg-pink-100 text-pink-600 rounded-full text-sm">
                                <?= htmlspecialchars($post['category']) ?>
                            </span>
                        </div>
                        <p class="text-gray-700 mb-4"><?= nl2br(htmlspecialchars(substr($post['content'], 0, 200))) ?>...</p>
                        <div class="flex items-center space-x-4">
                            <button onclick="likePost(<?= $post['id'] ?>)" class="text-gray-500 hover:text-pink-600">
                                <i class="far fa-heart"></i> <?= $post['likes'] ?>
                            </button>
                            <a href="post.php?id=<?= $post['id'] ?>" class="text-gray-500 hover:text-pink-600">
                                <i class="far fa-comment"></i> <?= $post['comment_count'] ?>
                            </a>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </main>

    <!-- Create Post Modal -->
    <div id="createPostModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="min-h-screen flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl p-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">Create New Post</h2>
                    <button onclick="toggleModal('createPostModal')" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <form action="create_post.php" method="POST" class="space-y-6">
                    <div>
                        <label class="block text-gray-700 mb-2">Title</label>
                        <input type="text" name="title" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600">
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-2">Category</label>
                        <select name="category" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600">
                            <option value="general">General Discussion</option>
                            <option value="health">Health Tips</option>
                            <option value="questions">Questions</option>
                            <option value="support">Support</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-2">Content</label>
                        <textarea name="content" rows="6" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-600"></textarea>
                    </div>
                    <button type="submit" 
                        class="w-full bg-gradient-to-r from-pink-600 to-purple-600 text-white py-2 rounded-lg hover:opacity-90">
                        Create Post
                    </button>
                </form>
            </div>
        </div>
    </div>

    <?php
    function timeAgo($timestamp) {
        $time = strtotime($timestamp);
        $diff = time() - $time;
        
        if ($diff < 60) {
            return "just now";
        } elseif ($diff < 3600) {
            return floor($diff/60) . "m ago";
        } elseif ($diff < 86400) {
            return floor($diff/3600) . "h ago";
        } else {
            return floor($diff/86400) . "d ago";
        }
    }
    ?>

    <script>
    function likePost(postId) {
        if(!<?= isset($_SESSION['user_id']) ? 'true' : 'false' ?>) {
            toggleModal('loginModal');
            return;
        }
        
        fetch('like_post.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                post_id: postId
            })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                // Update like count and toggle icon
                const likeButton = event.target.closest('button');
                const icon = likeButton.querySelector('i');
                icon.classList.toggle('far');
                icon.classList.toggle('fas');
                likeButton.querySelector('span').textContent = data.likes;
            }
        });
    }
    </script>
</body>
</html>