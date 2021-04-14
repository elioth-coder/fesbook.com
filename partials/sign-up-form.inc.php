<form id="signUpForm" enctype="multipart/form-data" class="text-right rounded-xl bg-white border-gray-400 border-2 p-10">
  <div class="w-full pb-10">
    <div class="relative mx-auto w-40 h-40 rounded-full border-gray-600 border-4">
      <img id="avatar" class="w-full h-full rounded-full" 
        src="./assets/account.png"
      />
      <div id="camera" class="cursor-pointer absolute bottom-0 h-10 w-full bg-white p-1 opacity-25 hover:opacity-75">
        <img src="./assets/camera.png" class="h-8 w-8 mx-auto" />
      </div>
    </div>
    <div id="fileChooserContainer">
      <input  id="fileChooser" class="hidden" name="file" type="file" accept="image/*" />
    </div>
  </div>
  <input name="first_name" class="text-lg rounded-xl w-full mb-5 border-gray-500 border-2 px-8 py-5" type="text" placeholder="Enter first name" /><br>
  <input name="last_name" class="text-lg rounded-xl w-full mb-5 border-gray-500 border-2 px-8 py-5" type="text" placeholder="Enter last name" />
  <div class="flex space-x-2 md:flex md:space-x-2 xl:flex xl:space-x-2 lg:block lg:space-x-0">
    <div class="w-1/2 md:w-1/2 xl:w-1/2 lg:w-full text-left text-lg text-gray-400">
      <label class="pl-2">Birthdate</label>
      <input name="birthdate" class="text-lg rounded-xl w-full mb-5 border-gray-500 border-2 px-8 py-5" type="date" />
    </div>
    <div class="w-1/2 xl:w-1/2 md:w-1/2 lg:w-full text-left text-lg text-gray-400">
      <label class="pl-2">Gender</label>
      <select name="gender" class="rounded-xl w-full mb-5 border-gray-500 border-2 px-8 py-5">
        <option value="">Select a gender</option>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
      </select>
    </div>
  </div>
  <input name="email" class="text-lg rounded-xl w-full mb-5 border-gray-500 border-2 px-8 py-5" type="text" placeholder="Enter email" /><br>
  <input name="password" class="text-lg rounded-xl w-full mb-5 border-gray-500 border-2 px-8 py-5" type="password" placeholder="Enter password" />
  <hr class="mb-5">
  <div class="text-center flex">
    <input name="captcha" class="text-lg rounded-xl mb-5 border-gray-500 border-2 px-8 py-5" type="text" placeholder="Enter captcha" /><br>
    <img id="captchaImage" src="<?php echo $_SESSION['captcha']['image_src']; ?>" 
      style="height:72px; width:154px;"
      class="mx-5">
    <button type="button" 
      id="captchaButton"
      style="height:72px;"
      class="hover:border-gray-600 hover:bg-gray-100 hover:text-gray-600 tracking-wide text-lg text-white bg-green-400 px-8 py-2 rounded-xl border-green-500 border-2">
      Change
    </button>
  </div>
  <button type="submit" class="hover:border-gray-600 hover:bg-gray-100 hover:text-gray-600 tracking-wide text-lg text-white bg-blue-400 px-8 py-2 rounded-xl border-blue-500 border-2">Sign Up</button>
</form>
