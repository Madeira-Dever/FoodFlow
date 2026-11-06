import { showToast, request } from "../js/functions.js";

const form = document.getElementById("login-form");
form.addEventListener("submit", async (event) => {
  event.preventDefault();

  const user = {
    email: document.getElementById("email").value.trim(),
    password: document.getElementById("password").value.trim(),
  };

  try {
    const data = await request(
      "createUser",
      "POST",
      user,
      "../../FoodFlow/src/php/",
    );
    showToast(data.message, "success");
    setTimeout(() => {
      location.href = "../../FoodFlow/src/pages/selection.html";
    }, 3000);
  } catch (err) {
    console.error(err);
    showToast(err.message, "error");
  }
});