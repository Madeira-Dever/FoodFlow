import { showToast, request } from "../js/functions.js";

const orderList = document.getElementById("order-list");
orderList.innerHTML = "";

// =========================================================
// GET PRODUCT
// =========================================================
const getProduct = async () => {
  try {
    const data = await request("getProduct");
    data.order.forEach((item) => createCard(item));
  } catch (err) {
    console.error(err.message);
    showToast(err.message, "error");
  }
};

// =========================================================
// CREATE PRODUCT CARD
// =========================================================
const createCard = (item) => {
  const card = document.createElement("li");
  card.className = "order-card";
  card.innerHTML = `
    <article class="item">
      <header class="item-header">
        <span class="item-id">Cliente - ${item.id_request}</span>
        <span class="item-status">Pronto para entregar</span>
      </header>

      <div class="item-info">
        <h3 class="item-name">${item.name}</h3>
        <p class="item-flavor">${item.flavor}</p>
        <p class="item-description">
          ${item.description}
        </p>
      </div>

      <div class="recipient">
        <span class="size">
          Size:&#x20;
          <strong> ${item.size} </strong>
        </span>

        <span class="price">
          Price:
          <strong> U$ ${item.price} </strong>
        </span>
      </div>

      <footer class="item-footer">
        <button type="button" class="item-button">Entregar pedido</button>
      </footer>
    </article>
  `;

  orderList.append(card);

  const itemButton = card.querySelector(".item-button");
  itemButton.addEventListener("click", () => deliver(item, card));
};

// =========================================================
// DELIVER PRODUCT
// =========================================================
const deliver = async (item, card) => {
  try {
    await request("deliver", "POST", item);
    card.remove();
    showToast("Produto entregue", "success");

    if (orderList.children.length < 1) {
      showToast("Todos os produtos foram entregues", "info");
      setTimeout(() => {
        location.href = "../../src/pages/selection.html";
      }, 3000);
    }
  } catch (err) {
    console.error(err.message);
    showToast(err.message, "error");
  }
};

getProduct();