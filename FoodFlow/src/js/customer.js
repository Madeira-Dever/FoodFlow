import { showToast, request } from "./functions.js";

const itemButton = document.querySelectorAll(".item-button");
const orders = [];

// =========================================================
// GET PRODUCT INFO
// =========================================================
itemButton.forEach((button) => {
  button.addEventListener("click", () => {
    const card = button.closest(".item");

    const id = card.querySelector(".item-id").textContent.trim();
    const status = card.querySelector(".item-status").textContent.trim();
    const name = card.querySelector(".item-name").textContent.trim();
    const flavor = card.querySelector(".item-flavor").textContent.trim();
    const description = card.querySelector(".item-description").textContent.trim();
    const size = card.querySelector(".size strong").textContent.trim();
    const price = parseFloat(card.querySelector(".price strong").textContent.replace("U$", "").replace(",", ".").trim());

    orders.push({
      id: id,
      status: status,
      name: name,
      flavor: flavor,
      description: description,
      size: size,
      price: price,
    });

    showToast("Produto selecionado", "info");
  });
});

// =========================================================
// SEND PRODUCT TO PHP
// =========================================================
const headerButton = document.getElementById("header-button");
headerButton.addEventListener("click", async () => {
  if (orders.length < 1) {
    return showToast("Nenhum pedido selecionado", "warning");
  }

  try {
    await request("createOrder", "POST", orders);
    showToast("Sucesso", "success");
    setTimeout(() => {
      location.href = "../../src/pages/selection.html";
    }, 3000);
  } catch (err) {
    console.error(err.message);
    showToast("Ocorreu algum erro", "error");
  }
});