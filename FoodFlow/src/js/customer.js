import { showToast, request } from "./functions";
showToast("Welcome");

const itemButton = document.querySelectorAll(".item-button");
const order = [];

// ==========================
// GET PRODUCT INFO
// ==========================
itemButton.forEach((button) => {
  button.addEventListener("click", () => {
    const card = button.closest(".item");

    const id = card.querySelector(".item-id").textContent.trim();
    const status = card.querySelector(".item-status").textContent.trim();
    const name = card.querySelector(".item-name").textContent.trim();
    const flavor = card.querySelector(".item-flavor").textContent.trim();
    const description = card
      .querySelector(".item-description")
      .textContent.trim();
    const size = card.querySelector(".size strong").textContent.trim();

    const price = parseFloat(
      card.querySelector(".price strong").textContent.replace("U$", "").trim(),
    );

    order.push({
      id: id,
      status: status,
      name: name,
      flavor: flavor,
      description: description,
      size: size,
      price: price,
    });
  });
});

// ==========================
// SEND TO DATABASE
// ==========================
const headerButton = document.getElementById("header-button");
headerButton.addEventListener("click", async () => {
  if (order.length < 1) {
    return showToast("No orders", "warning");
  }

  try {
    await request("createOrder", "POST", order);
    showToast("Success", "success");
  } catch (err) {
    showToast("Failed do send order", "error");
    console.error(err.message);
  }
});