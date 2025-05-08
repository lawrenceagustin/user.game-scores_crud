<?php require_once 'core/models.php'; ?>
<?php require_once 'core/dbConfig.php'; ?>

<?php  
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];
$userId = $_SESSION['user_id'];
$userReviews = getReviewsByUser($username, $pdo);
$editId = isset($_GET['edit_id']) ? $_GET['edit_id'] : null;
?>
<!-- first account
 suisei
 Lawrence
 Agustin
 hanekawa
-->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CritiCore</title>
  <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
	<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 text-gray-200 min-h-screen p-6">
<form action="core/handleForms.php" method="POST" class="space-y-4">	
<nav class="bg-white dark:bg-gray-900 fixed w-full z-20 top-0 start-0 border-b border-gray-200 dark:border-gray-600">
  <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
  <a href="" class="flex items-center space-x-3 rtl:space-x-reverse">
      <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">CritiCore</span>
  </a>
  <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
      <div class="flex items-center space-x-4 rtl:space-x-reverse">
        <h1 class="text-white text-l font-bold">Welcome, <?= htmlspecialchars($username) ?>!</h1>
        <input type="submit" name="logoutUserBtn" value="Logout" class="bg-blue-400 text-gray-900 font-bold py-2 px-4 rounded hover:bg-blue-300 transition">
      </div>
      <button data-collapse-toggle="navbar-sticky" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-sticky" aria-expanded="false">
        <span class="sr-only">Open main menu</span>
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
        </svg>
    </button>
  </div>
  </div>
</nav>
</form>

  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12 pt-[80px]">
    <?php $getRecentUsers = getRecentUsers($pdo); ?>
    <?php foreach ($getRecentUsers as $row) { ?>
      <div class="bg-gray-800 rounded-lg p-6 shadow-lg hover:scale-[1.02] transition-transform">
        <h1 class="text-yellow-400 text-2xl font-bold border-b border-gray-600 mb-2"><?php echo $row['username'] ?></h1>
        <h2 class="text-blue-300 text-lg mb-2 border-b border-gray-700"><?php echo $row['email'] ?></h2>
        <h4 class="italic text-gray-400 mb-1"><?php echo $row['gender'] ?></h4>
        <h4 class="font-semibold text-blue-400 mb-1"><?php echo $row['game'] ?></h4>
        <h4 class="italic text-gray-300 mb-1"><?php echo $row['user_review'] ?></h4>
        <h4 class="text-yellow-300 font-bold text-lg"><?php echo $row['rating'] ?>/10</h4>
        <h4 class="text-gray-500 text-sm">Created at: <?php echo $row['created_at'] ?></h4>
        <h4 class="text-gray-500 text-sm mt-2">Updated by: <?= $row['updated_by_username'] ?? 'N/A' ?></h4>
      </div>
    <?php } ?>
  </div>

  <form action="core/handleForms.php" method="POST" id="insertNewUser" class="bg-gray-800 p-6 rounded-lg shadow-md mb-10 max-w-3xl mx-auto space-y-4">
  <h2 class="text-xl font-semibold text-yellow-400 mb-4">Add New Review</h2>

  <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    <div>
      <label for="emailInput" class="block text-gray-300">Email</label>
      <input type="email" id="emailInput" name="email" class="w-full mt-1 p-2 bg-gray-900 border border-gray-700 rounded text-white" required />
    </div>
    <div>
      <label for="genderInput" class="block text-gray-300">Gender</label>
      <select id="genderInput" name="gender" class="w-full mt-1 p-2 bg-gray-900 border border-gray-700 rounded text-white" required>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
        <option value="Other">Other</option>
      </select>
    </div>
  </div>

  <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    <div>
      <label for="gameInput" class="block text-gray-300">Game</label>
      <input type="text" id="gameInput" name="game" class="w-full mt-1 p-2 bg-gray-900 border border-gray-700 rounded text-white" required />
    </div>
    <div>
      <label for="ratingInput" class="block text-gray-300">Rating (1-10)</label>
      <input type="number" id="ratingInput" name="rating" min="1" max="10" class="w-full mt-1 p-2 bg-gray-900 border border-gray-700 rounded text-white" required />
    </div>
  </div>

  <div>
    <label for="reviewInput" class="block text-gray-300">Review</label>
    <textarea id="reviewInput" name="user_review" rows="4" class="w-full mt-1 p-2 bg-gray-900 border border-gray-700 rounded text-white" required></textarea>
  </div>

  <div class="pt-4">
    <input type="submit" id="addReviewBtn" value="Submit" class="bg-yellow-400 text-gray-900 px-4 py-2 rounded font-bold hover:bg-yellow-300 transition" />
  </div>
</form>

<div class="max-w-3xl mx-auto bg-gray-800 p-6 rounded-lg shadow-md mb-10">
  <h2 class="text-xl font-bold text-yellow-400 mb-4">Your Reviews</h2>
  <?php if (count($userReviews) > 0): ?>
    <?php foreach ($userReviews as $review): ?>
      <div class="bg-gray-900 p-4 mb-4 rounded border border-gray-700 review-block" data-id="<?= $review['id'] ?>">
        <?php if ($editId == $review['id']): ?>
          <!-- Edit Form -->
          <form method="POST" id="updateReviewForm" class="space-y-2">
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="id" value="<?= $review['id'] ?>">

            <input type="email" name="email" value="<?= htmlspecialchars($review['email']) ?>" required>
            <select name="gender" required>
              <option value="Male" <?= $review['gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
              <option value="Female" <?= $review['gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
              <option value="Other" <?= $review['gender'] == 'Other' ? 'selected' : '' ?>>Other</option>
            </select>
            <input type="text" name="game" value="<?= htmlspecialchars($review['game']) ?>" required>
            <textarea name="user_review" required><?= htmlspecialchars($review['user_review']) ?></textarea>
            <input type="number" name="rating" min="1" max="10" value="<?= $review['rating'] ?>" required>

            <button type="submit" id="updateReviewBtn" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-400">Save</button>
            <a href="index.php" class="bg-gray-500 text-white px-3 py-1 rounded hover:bg-gray-400">Cancel</a>
          </form>
        <?php else: ?>
          <!-- Display Review -->
          <h3 class="text-lg font-bold text-blue-300"><?= htmlspecialchars($review['game']) ?> - <?= $review['rating'] ?>/10</h3>
          <p class="italic text-gray-400"><?= htmlspecialchars($review['user_review']) ?></p>
          <p class="text-sm text-gray-500">
            Created by: <?= htmlspecialchars($review['created_by_username']) ?> |
            Updated by: <?= htmlspecialchars($review['updated_by_username'] ?? 'N/A') ?> |
            Updated at: <?= htmlspecialchars($review['updated_at'] ?? 'N/A') ?>
          </p>
          <div class="mt-2 space-x-2">
            <a href="?edit_id=<?= $review['id'] ?>" class="bg-blue-400 text-gray-900 px-3 py-1 rounded hover:bg-blue-300 transition">Edit</a>
            <form method="POST" class="inline delete-form" data-review-id="<?= $review['id'] ?>">  
              <input type="hidden" name="action" value="delete">
              <input type="hidden" name="review_id" value="<?= $review['id'] ?>">
              <button type="button" class="delete-button bg-red-800 text-gray-900 px-4 py-2 rounded font-bold hover:bg-red-300 transition">Delete</button>
            </form>
          </div>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <p class="text-gray-400">You haven't posted any reviews yet.</p>
  <?php endif; ?>
</div>

<script src="core/script.js"></script>
</body>
</html>