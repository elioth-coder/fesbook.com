captchaButton.onclick = async (e) => {
  let response = await fetch('./process/regenerate-captcha.php', {
    credentials: "same-origin",
  });
  let { image_src, status} = await response.json();
      
  if(status == 'success') {
    captchaImage.src = image_src;
  }
}

camera.onclick = (e) => {
  fileChooser.click();
}

fileChooser.onchange = (e) => {
  if (e.target.files && e.target.files[0]) {
    document.querySelector('#avatar').src = URL.createObjectURL(event.target.files[0]);
  }
}

signUpForm.onsubmit = async (e) => {
  e.preventDefault();

  let response = await fetch('./process/sign-up.php', {
    credentials: "same-origin",
    method: 'POST',
    body: new FormData(signUpForm)
  });
  let { message, status} = await response.json();
      
  if(status == 'success') {
    alert(message);
    let fields = document.querySelectorAll(`#${signUpForm.getAttribute('id')} [name]`);
    fields.forEach(field => {
      field.value = "";
    })
    avatar.src = './assets/account.png';
    fileChooserContainer.innerHTML = `<input  id="fileChooser" class="hidden" name="file" type="file" accept="image/*" />`;
    captchaButton.click();

    activatePanel('login');
  } else {
    alert(message);
  }
};

loginForm.onsubmit = async (e) => {
  e.preventDefault();

  let response = await fetch('./process/login.php', {
    credentials: "same-origin",
    method: 'POST',
    body: new FormData(loginForm)
  });
  let { message, status} = await response.json();
      
  if(status == 'success') {
    window.location = "./posts.php";
  } else {
    alert(message);
  }
};
