<?php require_once 'core/models.php'; ?>
<?php require_once 'core/dbConfig.php'; ?>

<?php  
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
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
	<!-- <link rel="stylesheet" href="styles.css"> -->
</head>


<body class="bg-gray-900 text-gray-200 min-h-screen p-6">
	
<nav class="bg-white dark:bg-gray-900 fixed w-full z-20 top-0 start-0 border-b border-gray-200 dark:border-gray-600">
  <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
  <a href="" class="flex items-center space-x-3 rtl:space-x-reverse">
      <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">CritiCore</span>
  </a>
  <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
			<input type="submit" name="logoutUserBtn" value="Logout" class="w-full bg-blue-400 text-gray-900 font-bold py-2 px-4 rounded hover:bg-blue-300 transition">
      <button data-collapse-toggle="navbar-sticky" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-sticky" aria-expanded="false">
        <span class="sr-only">Open main menu</span>
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
        </svg>
    </button>
  </div>
  </div>
</nav>


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
      </div>
    <?php } ?>
  </div>

  <form action="controller.php" id="insertNewUser" class="bg-gray-800 p-6 rounded-lg shadow-md mb-10 max-w-3xl mx-auto space-y-4">
    <h2 class="text-xl font-semibold text-yellow-400 mb-4">Add New Review</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
      <div>
        <label for="firstNameInput" class="block text-gray-300">First Name</label>
        <input type="text" id="firstNameInput" class="w-full mt-1 p-2 bg-gray-900 border border-gray-700 rounded text-white" />
      </div>
      <div>
        <label for="lastNameInput" class="block text-gray-300">Last Name</label>
        <input type="text" id="lastNameInput" class="w-full mt-1 p-2 bg-gray-900 border border-gray-700 rounded text-white" />
      </div>
      <div>
        <label for="emailInput" class="block text-gray-300">Email</label>
        <input type="text" id="emailInput" class="w-full mt-1 p-2 bg-gray-900 border border-gray-700 rounded text-white" />
      </div>
      <div>
        <label for="genderInput" class="block text-gray-300">Gender</label>
        <input type="text" id="genderInput" class="w-full mt-1 p-2 bg-gray-900 border border-gray-700 rounded text-white" />
      </div>
    </div>
    <div class="pt-4">
      <input type="submit" value="Submit" class="bg-yellow-400 text-gray-900 px-4 py-2 rounded font-bold hover:bg-yellow-300 transition" />
    </div>
  </form>

  <div class="max-w-3xl mx-auto bg-gray-800 p-6 rounded-lg shadow-md">
    <label for="inputFieldNameSearch" class="block text-gray-300 mb-2">Search by Name</label>
    <input type="text" id="inputFieldNameSearch" class="w-full p-2 bg-gray-900 border border-gray-700 rounded text-white mb-4" />
    <div id="loadData" class="bg-gray-900 p-4 rounded border border-gray-700">
      <h2 class="text-blue-300 text-lg">Search results will be displayed here</h2>
    </div>
  </div>
</body>

</html>