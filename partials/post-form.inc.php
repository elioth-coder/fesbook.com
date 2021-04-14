<form id="postForm" class="text-right rounded-xl bg-white border-gray-400 border-2 px-10 py-8">
  <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
  <textarea name="content" class="text-lg rounded-xl w-full mb-5 border-gray-300 border-2 px-8 py-5" placeholder="What's on your mind?" rows="4"></textarea>
  <button type="submit" class="hover:border-gray-600 hover:bg-gray-100 hover:text-gray-600 tracking-wide text-lg text-white bg-blue-400 px-8 py-2 rounded-xl border-blue-500 border-2">Post</button>
</form>
