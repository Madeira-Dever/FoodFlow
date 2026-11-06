import { showToast, request } from "./functions.js";

const orderList = document.getElementById("order-list");
orderList.innerHTML = "";

// =========================================================
// GET ORDERS
// =========================================================
const getOrders = async () => {
  try {
    const data = await request("receive");
    data.orders.forEach((item) => createCard(item));
    console.log(data.orders);
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
        <span class="item-id">Cliente - ${item.id_user}</span>
        <span class="item-status">Entregue</span>
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
    </article>
  `;

  orderList.append(card);
};

getOrders();